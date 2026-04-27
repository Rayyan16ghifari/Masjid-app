<?php

namespace App\Services;

use App\Models\User;
use App\Models\Kajian;
use App\Models\Rating;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CollaborativeFilteringService
{
    /**
     * Implementasi User-Based Collaborative Filtering
     * Menggunakan Cosine Similarity untuk menghitung kesamaan antar user
     */
    public function getUserBasedRecommendations(int $userId, int $limit = 10): array
    {
        // 1. Dapatkan rating user target
        $userRatings = $this->getUserRatings($userId);
        
        if ($userRatings->isEmpty()) {
            return $this->getPopularKajian($limit);
        }

        // 2. Hitung similarity dengan user lain
        $similarities = $this->calculateUserSimilarities($userId, $userRatings);
        
        // 3. Dapatkan kajian yang belum dirating user
        $unratedKajian = $this->getUnratedKajian($userId);
        
        // 4. Hitung prediksi rating untuk kajian yang belum dirating
        $predictions = $this->predictRatings($userId, $similarities, $unratedKajian);
        
        // 5. Sort dan limit
        arsort($predictions);
        
        return array_slice($predictions, 0, $limit, true);
    }

    /**
     * Implementasi Item-Based Collaborative Filtering
     * Menggunakan kesamaan antar item (kajian) berdasarkan rating user
     */
    public function getItemBasedRecommendations(int $userId, int $limit = 10): array
    {
        // 1. Dapatkan rating user
        $userRatings = $this->getUserRatings($userId);
        
        if ($userRatings->isEmpty()) {
            return $this->getPopularKajian($limit);
        }

        // 2. Hitung item similarity matrix
        $itemSimilarities = $this->calculateItemSimilarities($userRatings->keys()->toArray());
        
        // 3. Dapatkan kajian yang belum dirating
        $unratedKajian = $this->getUnratedKajian($userId);
        
        // 4. Hitung prediksi berdasarkan item similarity
        $predictions = $this->predictItemBasedRatings($userId, $userRatings, $itemSimilarities, $unratedKajian);
        
        // 5. Sort dan limit
        arsort($predictions);
        
        return array_slice($predictions, 0, $limit, true);
    }

    /**
     * Hybrid approach: Gabungan User-Based dan Item-Based
     */
    public function getHybridRecommendations(int $userId, int $limit = 10): array
    {
        $userBased = $this->getUserBasedRecommendations($userId, $limit * 2);
        $itemBased = $this->getItemBasedRecommendations($userId, $limit * 2);
        
        // Weighted combination (70% user-based, 30% item-based)
        $hybrid = [];
        
        // Combine predictions dengan weighted average
        foreach ($userBased as $kajianId => $rating) {
            $hybrid[$kajianId] = $rating * 0.7;
        }
        
        foreach ($itemBased as $kajianId => $rating) {
            if (isset($hybrid[$kajianId])) {
                $hybrid[$kajianId] = ($hybrid[$kajianId] + $rating * 0.3) / 2;
            } else {
                $hybrid[$kajianId] = $rating * 0.3;
            }
        }
        
        arsort($hybrid);
        
        return array_slice($hybrid, 0, $limit, true);
    }

    /**
     * Cosine Similarity antar user
     */
    private function calculateUserSimilarities(int $targetUserId, Collection $targetUserRatings): array
    {
        // Dapatkan semua user yang memiliki rating overlap
        $overlappingUsers = Rating::select('user_id')
            ->whereIn('kajian_id', $targetUserRatings->keys())
            ->where('user_id', '!=', $targetUserId)
            ->distinct()
            ->pluck('user_id');

        $similarities = [];

        foreach ($overlappingUsers as $otherUserId) {
            $otherUserRatings = $this->getUserRatings($otherUserId);
            
            // Cari kajian yang dirating oleh kedua user
            $commonKajian = $targetUserRatings->intersectByKeys($otherUserRatings);
            
            if ($commonKajian->count() < 2) {
                continue; // Minimal 2 overlap untuk similarity yang meaningful
            }

            // Hitung Cosine Similarity
            $similarity = $this->cosineSimilarity($targetUserRatings, $otherUserRatings, $commonKajian->keys()->toArray());
            
            if ($similarity > 0.1) { // Threshold untuk similarity
                $similarities[$otherUserId] = $similarity;
            }
        }

        // Sort by similarity (descending)
        arsort($similarities);
        
        // Ambil top 20 similar users
        return array_slice($similarities, 0, 20, true);
    }

    /**
     * Hitung Cosine Similarity
     */
    private function cosineSimilarity(Collection $vectorA, Collection $vectorB, array $commonKeys): float
    {
        $dotProduct = 0;
        $normA = 0;
        $normB = 0;

        foreach ($commonKeys as $kajianId) {
            $ratingA = $vectorA[$kajianId];
            $ratingB = $vectorB[$kajianId];
            
            $dotProduct += $ratingA * $ratingB;
            $normA += $ratingA * $ratingA;
            $normB += $ratingB * $ratingB;
        }

        if ($normA == 0 || $normB == 0) {
            return 0;
        }

        return $dotProduct / (sqrt($normA) * sqrt($normB));
    }

    /**
     * Hitung item similarity matrix
     */
    private function calculateItemSimilarities(array $kajianIds): array
    {
        $similarities = [];
        
        foreach ($kajianIds as $kajianId1) {
            foreach ($kajianIds as $kajianId2) {
                if ($kajianId1 >= $kajianId2) {
                    continue; // Avoid duplicate calculations
                }
                
                $similarity = $this->calculateItemSimilarity($kajianId1, $kajianId2);
                
                if ($similarity > 0) {
                    $similarities[$kajianId1][$kajianId2] = $similarity;
                    $similarities[$kajianId2][$kajianId1] = $similarity;
                }
            }
        }
        
        return $similarities;
    }

    /**
     * Hitung similarity antar item (kajian)
     */
    private function calculateItemSimilarity(int $kajianId1, int $kajianId2): float
    {
        // Dapatkan user yang merating kedua kajian
        $ratings1 = Rating::where('kajian_id', $kajianId1)->pluck('rating', 'user_id');
        $ratings2 = Rating::where('kajian_id', $kajianId2)->pluck('rating', 'user_id');
        
        $commonUsers = array_intersect($ratings1->keys()->toArray(), $ratings2->keys()->toArray());
        
        if (count($commonUsers) < 2) {
            return 0;
        }
        
        return $this->cosineSimilarity($ratings1, $ratings2, $commonUsers);
    }

    /**
     * Prediksi rating untuk User-Based CF
     */
    private function predictRatings(int $userId, array $similarities, Collection $unratedKajian): array
    {
        $predictions = [];
        
        foreach ($unratedKajian as $kajian) {
            $numerator = 0;
            $denominator = 0;
            
            foreach ($similarities as $otherUserId => $similarity) {
                $rating = Rating::where('user_id', $otherUserId)
                    ->where('kajian_id', $kajian->id)
                    ->value('rating');
                
                if ($rating !== null) {
                    $numerator += $similarity * $rating;
                    $denominator += abs($similarity);
                }
            }
            
            if ($denominator > 0) {
                $predictions[$kajian->id] = $numerator / $denominator;
            }
        }
        
        return $predictions;
    }

    /**
     * Prediksi rating untuk Item-Based CF
     */
    private function predictItemBasedRatings(int $userId, Collection $userRatings, array $itemSimilarities, Collection $unratedKajian): array
    {
        $predictions = [];
        
        foreach ($unratedKajian as $kajian) {
            $numerator = 0;
            $denominator = 0;
            
            // Cari similar items yang sudah dirating user
            foreach ($userRatings as $ratedKajianId => $rating) {
                if (isset($itemSimilarities[$kajian->id][$ratedKajianId])) {
                    $similarity = $itemSimilarities[$kajian->id][$ratedKajianId];
                    $numerator += $similarity * $rating;
                    $denominator += abs($similarity);
                }
            }
            
            if ($denominator > 0) {
                $predictions[$kajian->id] = $numerator / $denominator;
            }
        }
        
        return $predictions;
    }

    /**
     * Dapatkan rating user
     */
    private function getUserRatings(int $userId): Collection
    {
        return Rating::where('user_id', $userId)
            ->pluck('rating', 'kajian_id');
    }

    /**
     * Dapatkan kajian yang belum dirating user
     */
    private function getUnratedKajian(int $userId): Collection
    {
        $ratedKajianIds = Rating::where('user_id', $userId)->pluck('kajian_id');
        
        return Kajian::with(['ustadz', 'kitab'])
            ->whereNotIn('id', $ratedKajianIds)
            ->get();
    }

    /**
     * Dapatkan kajian populer (fallback untuk new user)
     */
    private function getPopularKajian(int $limit): array
    {
        return Kajian::withAvg('ratings', 'rating')
            ->withCount('ratings')
            ->having('ratings_count', '>=', 3)
            ->orderByDesc('ratings_avg_rating')
            ->orderByDesc('ratings_count')
            ->limit($limit)
            ->get()
            ->mapWithKeys(function ($kajian) {
                return [$kajian->id => $kajian->ratings_avg_rating ?? 0];
            })
            ->toArray();
    }

    /**
     * Evaluasi sistem rekomendasi
     * Menghitung RMSE (Root Mean Square Error) dan MAE (Mean Absolute Error)
     */
    public function evaluateRecommendations(int $userId): array
    {
        // Split data user menjadi training (80%) dan testing (20%)
        $userRatings = $this->getUserRatings($userId);
        
        if ($userRatings->count() < 5) {
            return ['rmse' => 0, 'mae' => 0, 'coverage' => 0];
        }

        $ratingsArray = $userRatings->toArray();
        $splitIndex = (int) (count($ratingsArray) * 0.8);
        
        $trainingRatings = array_slice($ratingsArray, 0, $splitIndex, true);
        $testRatings = array_slice($ratingsArray, $splitIndex, null, true);

        // Simulasi dengan training data
        $originalRatings = Rating::where('user_id', $userId)->get();
        
        // Hapus test ratings untuk simulasi
        Rating::where('user_id', $userId)
            ->whereIn('kajian_id', array_keys($testRatings))
            ->delete();

        // Dapatkan rekomendasi
        $recommendations = $this->getHybridRecommendations($userId, count($testRatings));

        // Restore original ratings
        foreach ($testRatings as $kajianId => $actualRating) {
            Rating::updateOrCreate(
                ['user_id' => $userId, 'kajian_id' => $kajianId],
                ['rating' => $actualRating]
            );
        }

        // Hitung RMSE dan MAE
        $rmse = $this->calculateRMSE($testRatings, $recommendations);
        $mae = $this->calculateMAE($testRatings, $recommendations);
        $coverage = count($recommendations) / count($testRatings);

        return [
            'rmse' => $rmse,
            'mae' => $mae,
            'coverage' => $coverage,
            'total_test_items' => count($testRatings),
            'recommended_items' => count($recommendations)
        ];
    }

    private function calculateRMSE(array $actual, array $predicted): float
    {
        $sumSquaredError = 0;
        $count = 0;

        foreach ($actual as $kajianId => $actualRating) {
            if (isset($predicted[$kajianId])) {
                $error = $actualRating - $predicted[$kajianId];
                $sumSquaredError += $error * $error;
                $count++;
            }
        }

        return $count > 0 ? sqrt($sumSquaredError / $count) : 0;
    }

    private function calculateMAE(array $actual, array $predicted): float
    {
        $sumAbsoluteError = 0;
        $count = 0;

        foreach ($actual as $kajianId => $actualRating) {
            if (isset($predicted[$kajianId])) {
                $sumAbsoluteError += abs($actualRating - $predicted[$kajianId]);
                $count++;
            }
        }

        return $count > 0 ? $sumAbsoluteError / $count : 0;
    }
}
