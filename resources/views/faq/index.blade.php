@extends('layouts.main')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

* { box-sizing: border-box; }

.fq-page {
    font-family: 'Plus Jakarta Sans', sans-serif;
    position: relative;
    overflow: hidden;
    border-radius: 28px;
    background:
        radial-gradient(circle at top left, rgba(29,158,117,0.12), transparent 24%),
        linear-gradient(180deg, #f6f9f7 0%, #eef4f1 100%);
    min-height: 100vh;
    padding: 34px 30px 48px;
}

.fq-shell {
    max-width: 1000px;
    margin: 0 auto;
}

.fq-hero {
    border-radius: 28px;
    padding: 32px;
    margin-bottom: 24px;
    background:
        radial-gradient(circle at 100% 0%, rgba(255,215,0,0.16), transparent 22%),
        linear-gradient(135deg, #0b4c3d 0%, #0f6e56 48%, #1d9e75 100%);
    color: white;
    box-shadow: 0 24px 58px rgba(8, 80, 65, 0.14);
}

.fq-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 7px 14px;
    border-radius: 999px;
    margin-bottom: 16px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.16);
}

.fq-kicker::before {
    content: '';
    width: 7px;
    height: 7px;
    border-radius: 999px;
    background: #ffd700;
}

.fq-title {
    margin: 0 0 12px;
    font-family: 'Playfair Display', serif;
    font-size: 38px;
    line-height: 1.15;
}

.fq-copy {
    margin: 0;
    max-width: 640px;
    font-size: 14px;
    line-height: 1.85;
    color: rgba(255,255,255,0.82);
}

.fq-list {
    display: grid;
    gap: 14px;
}

.fq-item {
    background: white;
    border: 1px solid #deebe5;
    border-radius: 22px;
    box-shadow: 0 18px 40px rgba(11, 76, 61, 0.05);
    overflow: hidden;
}

.fq-item summary {
    list-style: none;
    cursor: pointer;
    padding: 18px 20px;
    font-size: 15px;
    font-weight: 700;
    color: #12453b;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}

.fq-item summary::-webkit-details-marker {
    display: none;
}

.fq-item summary::after {
    content: '+';
    width: 28px;
    height: 28px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #e1f5ee;
    color: #0f6e56;
    flex-shrink: 0;
}

.fq-item[open] summary::after {
    content: '–';
}

.fq-answer {
    padding: 0 20px 20px;
    font-size: 13px;
    line-height: 1.9;
    color: #6a7d76;
}

@media (max-width: 640px) {
    .fq-page {
        padding: 20px 16px 36px;
    }

    .fq-hero {
        padding: 22px 18px;
    }

    .fq-title {
        font-size: 30px;
    }
}
</style>

<div class="fq-page">
    <div class="fq-shell">
        <section class="fq-hero">
            <div class="fq-kicker">FAQ Masjid</div>
            <h1 class="fq-title">Pertanyaan yang Sering Diajukan</h1>
            <p class="fq-copy">
                Ringkasan jawaban cepat untuk membantu jamaah menemukan informasi dasar
                tentang layanan masjid, jadwal kajian, donasi, dan penggunaan sistem.
            </p>
        </section>

        <div class="fq-list">
            @foreach($faqItems as $item)
                <details class="fq-item">
                    <summary>{{ $item['question'] }}</summary>
                    <div class="fq-answer">{{ $item['answer'] }}</div>
                </details>
            @endforeach
        </div>
    </div>
</div>
@endsection
