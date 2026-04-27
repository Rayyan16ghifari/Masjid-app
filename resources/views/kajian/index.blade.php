@extends('layouts.app')

@section('content')
<style>
@import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600&display=swap');

* { box-sizing: border-box; }

.kj-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    min-height: 100vh;
    position: relative;
    overflow: hidden;
    background: #0a2e1f;
}

.kj-bg {
    position: absolute; inset: 0; z-index: 0;
    background:
        radial-gradient(ellipse 80% 60% at 10% 0%,   rgba(29,158,117,0.18) 0%, transparent 60%),
        radial-gradient(ellipse 60% 50% at 90% 100%, rgba(8,80,65,0.30)    0%, transparent 55%),
        linear-gradient(160deg, #0d3322 0%, #0a2219 40%, #071a14 100%);
}

.kj-tex {
    position: absolute; inset: 0; z-index: 0;
    background-image:
        linear-gradient(rgba(29,158,117,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(29,158,117,0.04) 1px, transparent 1px);
    background-size: 48px 48px;
}

.orb { position: absolute; border-radius: 50%; filter: blur(80px); z-index: 0; pointer-events: none; }
.orb1 { width: 500px; height: 500px; background: rgba(29,158,117,0.12); top: -120px; left: -100px; }
.orb2 { width: 400px; height: 400px; background: rgba(8,80,65,0.20); bottom: -80px; right: -60px; }

.kj { position: relative; z-index: 1; padding: 36px 32px; }

/* ── TOPBAR ── */
.topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 32px;
    flex-wrap: wrap;
    gap: 16px;
}

.kj-eyebrow {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #5DCAA5;
    margin-bottom: 6px;
}

.kj-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: #9FE1CB;
}

.topbar-right { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

.search-wrap { position: relative; }

.search-wrap input {
    background: rgba(13,51,34,0.8);
    border: 1px solid rgba(29,158,117,0.3);
    border-radius: 20px;
    padding: 10px 16px 10px 38px;
    color: #9FE1CB;
    font-size: 13px;
    width: 240px;
    outline: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: border-color 0.2s;
}

.search-wrap input:focus { border-color: rgba(29,158,117,0.6); }
.search-wrap input::placeholder { color: rgba(159,225,203,0.35); }

.search-icon {
    position: absolute;
    left: 13px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 14px;
    pointer-events: none;
}

.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #FFD700;
    color: #0a2e1f;
    font-size: 13px;
    font-weight: 700;
    border-radius: 20px;
    text-decoration: none;
    transition: opacity 0.2s;
    white-space: nowrap;
}

.btn-add:hover { opacity: 0.85; text-decoration: none; color: #0a2e1f; }

/* ── STAT ROW ── */
.stat-row {
    display: flex;
    gap: 12px;
    margin-bottom: 32px;
    flex-wrap: wrap;
}

.s-pill {
    background: rgba(13,51,34,0.7);
    border: 1px solid rgba(29,158,117,0.2);
    border-radius: 12px;
    padding: 12px 20px;
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    gap: 12px;
}

.s-icon { font-size: 18px; }
.s-num { font-size: 20px; font-weight: 700; color: #FFD700; font-family: 'Playfair Display', serif; }
.s-lbl { font-size: 11px; color: rgba(159,225,203,0.5); margin-top: 2px; }

/* ── SEC HEAD ── */
.sec-head { display: flex; align-items: center; gap: 12px; margin-bottom: 20px; }
.sec-label { font-family: 'Playfair Display', serif; font-size: 17px; font-weight: 700; color: #9FE1CB; white-space: nowrap; }
.sec-badge { font-size: 10px; font-weight: 600; padding: 3px 10px; background: rgba(29,158,117,0.2); color: #5DCAA5; border-radius: 20px; border: 1px solid rgba(29,158,117,0.25); }
.sec-line { flex: 1; height: 1px; background: rgba(29,158,117,0.2); }

/* ── GRID ── */
.kj-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 18px;
}

.kj-card {
    background: rgba(13,51,34,0.7);
    backdrop-filter: blur(8px);
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid rgba(29,158,117,0.2);
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
}

.kj-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.3);
    border-color: rgba(29,158,117,0.45);
}

.kj-img {
    width: 100%;
    height: 140px;
    object-fit: cover;
    display: block;
}

.kj-img-ph {
    width: 100%;
    height: 140px;
    background: rgba(8,80,65,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    position: relative;
}

.kj-routine-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 10px;
    font-weight: 700;
    padding: 3px 10px;
    background: rgba(29,158,117,0.2);
    color: #5DCAA5;
    border-radius: 20px;
    border: 1px solid rgba(29,158,117,0.3);
}

.kj-body { padding: 14px; }

.kj-card-title {
    font-size: 14px;
    font-weight: 600;
    color: #9FE1CB;
    margin-bottom: 6px;
    line-height: 1.4;
}

.kj-meta {
    font-size: 11px;
    color: rgba(159,225,203,0.5);
    margin-top: 3px;
}

/* ── RATING ── */
.kj-rating {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid rgba(29,158,117,0.1);
}

.kj-avg {
    font-size: 12px;
    font-weight: 600;
    color: #FFD700;
    min-width: 36px;
}

.stars button {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
    color: rgba(255,255,255,0.18);
    padding: 0 1px;
    transition: color 0.15s;
}

.stars button.active { color: #FFD700; }
.stars button:hover { color: rgba(255,215,0,0.6); }

/* ── ACTIONS ── */
.kj-actions {
    display: flex;
    gap: 8px;
    margin-top: 12px;
}

.btn-edit {
    flex: 1;
    text-align: center;
    padding: 8px 0;
    background: rgba(29,158,117,0.15);
    color: #5DCAA5;
    font-size: 12px;
    font-weight: 600;
    border-radius: 10px;
    text-decoration: none;
    border: 1px solid rgba(29,158,117,0.2);
    transition: background 0.2s;
}

.btn-edit:hover { background: rgba(29,158,117,0.3); text-decoration: none; color: #5DCAA5; }

.btn-del {
    flex: 1;
    text-align: center;
    padding: 8px 0;
    background: rgba(226,75,74,0.12);
    color: #F09595;
    font-size: 12px;
    font-weight: 600;
    border-radius: 10px;
    border: 1px solid rgba(226,75,74,0.2);
    cursor: pointer;
    transition: background 0.2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.btn-del:hover { background: rgba(226,75,74,0.28); }

@media (max-width: 640px) {
    .kj { padding: 20px 16px; }
    .topbar { flex-direction: column; align-items: flex-start; }
    .search-wrap input { width: 100%; }
}
</style>

<div class="kj-wrap">
    <div class="kj-bg"></div>
    <div class="kj-tex"></div>
    <div class="orb orb1"></div>
    <div class="orb orb2"></div>

    <div class="kj">

        {{-- ══ TOPBAR ══ --}}
        <div class="topbar">
            <div>
                <div class="kj-eyebrow">Masjid Al-Hasanah</div>
                <div class="kj-title">Kajian Ilmiah Rutin</div>
            </div>
            <div class="topbar-right">
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input type="text" id="search" placeholder="Cari kajian atau ustadz...">
                </div>
                <a href="/kajian/create" class="btn-add">+ Tambah Kajian</a>
            </div>
        </div>

        {{-- ══ STAT ROW ══ --}}
        <div class="stat-row">
            <div class="s-pill">
                <span class="s-icon">📚</span>
                <div>
                    <div class="s-num">{{ $kajian->count() }}</div>
                    <div class="s-lbl">Total Kajian</div>
                </div>
            </div>
            <div class="s-pill">
                <span class="s-icon">👤</span>
                <div>
                    <div class="s-num">{{ \App\Models\Ustadz::count() }}</div>
                    <div class="s-lbl">Ustadz</div>
                </div>
            </div>
            <div class="s-pill">
                <span class="s-icon">⭐</span>
                <div>
                    <div class="s-num">{{ number_format($kajian->avg('ratings_avg_rating') ?? 0, 1) }}</div>
                    <div class="s-lbl">Avg Rating</div>
                </div>
            </div>
        </div>

        {{-- ══ GRID ══ --}}
        <div class="sec-head">
            <div class="sec-label">Semua Kajian</div>
            <span class="sec-badge">{{ $kajian->count() }} kajian</span>
            <div class="sec-line"></div>
        </div>

        <div class="kj-grid" id="grid">
            @foreach($kajian as $k)
            <div class="kj-card">

                @if($k->image)
                    <img src="{{ $k->image }}" class="kj-img" alt="{{ $k->judul }}">
                @else
                    <div class="kj-img-ph">
                        📖
                        <div class="kj-routine-badge">Rutin</div>
                    </div>
                @endif

                <div class="kj-body">
                    <div class="kj-card-title">{{ $k->judul }}</div>
                    <div class="kj-meta">👤 {{ $k->ustadz->nama }}</div>
                    <div class="kj-meta">📖 {{ $k->kitab->nama }}</div>

                    <div class="kj-rating">
                        <span class="kj-avg" id="avg-{{ $k->id }}">
                            ⭐ {{ number_format($k->ratings_avg_rating ?? 0, 1) }}
                        </span>
                        <div class="stars" data-id="{{ $k->id }}">
                            @for($i = 1; $i <= 5; $i++)
                                <button data-value="{{ $i }}">★</button>
                            @endfor
                        </div>
                    </div>

                    <div class="kj-actions">
                        <a href="/kajian/{{ $k->id }}/edit" class="btn-edit">Edit</a>
                        <form id="delete-form-{{ $k->id }}" action="/kajian/{{ $k->id }}" method="POST" style="flex:1;display:flex;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $k->id }})" class="btn-del" style="width:100%;">Hapus</button>
                        </form>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</div>

<script>
// RATING
document.querySelectorAll('.stars').forEach(container => {
    const stars = container.querySelectorAll('button');
    const id = container.dataset.id;
    stars.forEach(star => {
        star.addEventListener('click', async () => {
            let val = star.dataset.value;
            await fetch('/rating', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ kajian_id: id, rating: val })
            });
            stars.forEach(s => s.classList.remove('active'));
            for (let i = 0; i < val; i++) stars[i].classList.add('active');
        });
    });
});

// SEARCH
document.getElementById('search').addEventListener('keyup', function () {
    let q = this.value;
    fetch('/search?q=' + q)
        .then(res => res.json())
        .then(data => {
            let html = '';
            data.forEach(k => {
                html += `
                <div class="kj-card">
                    <div class="kj-img-ph">📖<div class="kj-routine-badge">Rutin</div></div>
                    <div class="kj-body">
                        <div class="kj-card-title">${k.judul}</div>
                        <div class="kj-meta">👤 ${k.ustadz?.nama ?? '-'}</div>
                        <div class="kj-meta">📖 ${k.kitab?.nama ?? '-'}</div>
                    </div>
                </div>`;
            });
            document.getElementById('grid').innerHTML = html || '<p style="color:rgba(159,225,203,0.4);padding:20px;">Tidak ada hasil.</p>';
        });
});

// DELETE
function confirmDelete(id) {
    if (confirm('Yakin ingin menghapus kajian ini?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection
