@extends('layouts.app')

@section('title', 'Dashboard — Saung Angklung Udjo')

@push('styles')
<style>
:root {
    --indigo: #1a1445; --indigo-2: #22185d;
    --gold: #c4a47c; --gold-lt: rgba(196,164,124,.12);
    --bg: #F7F7F2; --white: #ffffff;
    --gray-soft: rgba(26,20,69,.06); --gray-mid: rgba(26,20,69,.12);
    --gray-text: rgba(26,20,69,.5);
    --success: #2d9f6a; --danger: #e05252;
    --r-sm: 6px; --r-md: 14px; --r-lg: 24px;
    --sh: 0 1px 3px rgba(26,20,69,.05), 0 8px 32px rgba(26,20,69,.07);
    --sh-hover: 0 24px 60px rgba(26,20,69,.12);
}

*, *::before, *::after { box-sizing: border-box; }
body { background: var(--bg); }

/* ── HERO ─────────────────────────────── */
.db-hero {
    position: relative;
    min-height: 520px;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
    padding: 0 clamp(1.5rem,5vw,5rem) 4rem;
    background-position: center 30%;
}
.db-hero-bg {
    position: absolute; inset: 0;
    background-image: url('{{ asset('img/Angklungmasal.webp') }}');
    background-size: cover;
    background-position: center 30%;
}
.db-hero-bg::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(
        135deg,
        rgba(13,11,46,.85) 0%,
        rgba(26,20,69,.75) 50%,
        rgba(34,24,93,.65) 100%
    );
}
/* Batik pattern */
.db-hero-pattern {
    position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(45deg, transparent 0, transparent 22px, rgba(196,164,124,.03) 22px, rgba(196,164,124,.03) 23px),
        repeating-linear-gradient(-45deg, transparent 0, transparent 22px, rgba(196,164,124,.03) 22px, rgba(196,164,124,.03) 23px);
}
/* Glow kanan */
.db-hero-glow {
    position: absolute; right: -100px; top: -100px;
    width: 500px; height: 500px; border-radius: 50%;
    background: radial-gradient(circle, rgba(196,164,124,.08) 0%, transparent 70%);
    pointer-events: none;
}
.db-hero-content {
    position: relative; z-index: 2;
    display: flex; align-items: flex-end; justify-content: space-between;
    width: 100%; gap: 2rem;
}
.db-hero-left { flex: 1; }
.db-eyebrow {
    font-size: 9px; font-weight: 800; letter-spacing: .55em; text-transform: uppercase;
    color: var(--gold); margin-bottom: 12px;
    display: flex; align-items: center; gap: 10px;
}
.db-eyebrow::before { content: ''; display: inline-block; width: 20px; height: 1px; background: var(--gold); }
.db-title {
    font-family: 'Libre Baskerville', serif;
    font-size: clamp(1.6rem, 3.5vw, 2.5rem);
    color: #fff; font-weight: 400; line-height: 1.25;
}
.db-title em { font-style: italic; color: var(--gold); }
.db-subtitle { font-size: 13px; color: rgba(255,255,255,.4); margin-top: 10px; font-weight: 400; }

/* Stats mini di hero */
.db-hero-stats {
    display: flex; gap: 1rem; flex-shrink: 0;
}
.db-hero-stat {
    text-align: center;
    padding: 1rem 1.4rem;
    background: rgba(255,255,255,.06);
    border: 1px solid rgba(196,164,124,.12);
    border-radius: var(--r-md);
    backdrop-filter: blur(10px);
    min-width: 90px;
}
.db-hero-stat-n {
    font-family: 'Libre Baskerville', serif;
    font-size: 1.9rem; color: #fff; line-height: 1;
}
.db-hero-stat-l {
    font-size: 9px; font-weight: 700; letter-spacing: .2em; text-transform: uppercase;
    color: rgba(255,255,255,.35); margin-top: 5px;
}

/* ── WRAP ─────────────────────────────── */
.db-wrap {
    max-width: 1200px; margin: 0 auto;
    padding: 2.5rem clamp(1.5rem,5vw,5rem) 6rem;
}

/* ── STAT CARDS ──────────────────────── */
.stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem; margin-bottom: 2rem;
}
.stat-card {
    background: var(--white); border: 1px solid var(--gray-soft);
    border-radius: var(--r-md); padding: 1.4rem 1.6rem;
    box-shadow: var(--sh);
    display: flex; align-items: center; gap: 1rem;
    transition: box-shadow .3s, transform .3s;
    animation: fadeUp .6s cubic-bezier(.16,1,.3,1) both;
}
.stat-card:nth-child(1) { animation-delay: .05s; }
.stat-card:nth-child(2) { animation-delay: .1s; }
.stat-card:nth-child(3) { animation-delay: .15s; }
.stat-card:hover { box-shadow: var(--sh-hover); transform: translateY(-2px); }
.stat-icon {
    width: 46px; height: 46px; border-radius: 12px;
    background: var(--gold-lt); display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.stat-icon svg { width: 20px; height: 20px; color: var(--gold); }
.stat-val { font-family: 'Libre Baskerville', serif; font-size: 1.7rem; color: var(--indigo); line-height: 1; }
.stat-lbl { font-size: 9px; font-weight: 800; letter-spacing: .22em; text-transform: uppercase; color: var(--gray-text); margin-top: 4px; }

/* ── GRID ─────────────────────────────── */
.grid-2 { display: grid; grid-template-columns: 1fr 340px; gap: 1.5rem; align-items: start; }

/* ── CARD ─────────────────────────────── */
.card {
    background: var(--white); border: 1px solid var(--gray-soft);
    border-radius: var(--r-lg); padding: 1.8rem 2rem;
    box-shadow: var(--sh); margin-bottom: 1.5rem;
    animation: fadeUp .7s cubic-bezier(.16,1,.3,1) .1s both;
}

/* ── SECTION HEADING ─────────────────── */
.sh { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 1.5rem; padding-bottom: 1.2rem; border-bottom: 1px solid var(--gray-soft); }
.sh-bar { width: 3px; height: 24px; background: linear-gradient(to bottom, var(--gold), rgba(196,164,124,.15)); border-radius: 2px; flex-shrink: 0; margin-top: 3px; }
.sh h3 { font-family: 'Libre Baskerville', serif; font-size: 1.05rem; font-weight: 400; color: var(--indigo); }
.sh p  { font-size: 9px; font-weight: 700; letter-spacing: .2em; text-transform: uppercase; color: var(--gray-text); margin-top: 3px; }

/* ── BOOKING LIST ─────────────────────── */
.bk-list { display: flex; flex-direction: column; gap: 10px; }
.bk-item {
    display: flex; align-items: center; gap: 14px;
    padding: 1rem 1.2rem; border: 1px solid var(--gray-mid);
    border-radius: var(--r-md); transition: all .22s;
    position: relative; overflow: hidden;
}
.bk-item:hover { border-color: rgba(196,164,124,.4); box-shadow: 0 4px 16px rgba(26,20,69,.06); }
.bk-item::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 3px; border-radius: 2px 0 0 2px; }
.bk-item.paid::before     { background: var(--success); }
.bk-item.pending::before  { background: #e08a2d; }
.bk-item.cancelled::before{ background: var(--danger); }
.bk-date { text-align: center; min-width: 44px; }
.bk-day { font-family: 'Libre Baskerville', serif; font-size: 1.4rem; color: var(--indigo); line-height: 1; }
.bk-mon { font-size: 9px; font-weight: 800; letter-spacing: .2em; text-transform: uppercase; color: var(--gray-text); }
.bk-info { flex: 1; }
.bk-title { font-size: 13px; font-weight: 700; color: var(--indigo); margin-bottom: 3px; }
.bk-meta  { font-size: 10px; color: var(--gray-text); }
.bk-right { text-align: right; }
.bk-price { font-family: 'Libre Baskerville', serif; font-size: .95rem; color: var(--indigo); }
.bk-badge {
    display: inline-block; font-size: 8px; font-weight: 800; letter-spacing: .15em;
    text-transform: uppercase; padding: 3px 8px; border-radius: 20px; margin-top: 4px;
}
.bk-badge.paid     { background: rgba(45,159,106,.1); color: var(--success); }
.bk-badge.pending  { background: rgba(224,138,45,.1); color: #c07a20; }
.bk-badge.cancelled{ background: rgba(224,82,82,.1); color: var(--danger); }

/* ── EMPTY STATE ─────────────────────── */
.es { display: flex; flex-direction: column; align-items: center; padding: 3rem 1rem; gap: 12px; text-align: center; }
.es-icon { width: 64px; height: 64px; border-radius: 18px; background: var(--gold-lt); display: flex; align-items: center; justify-content: center; }
.es-icon svg { width: 28px; height: 28px; color: var(--gold); opacity: .6; }
.es p     { font-size: 13px; font-weight: 600; color: var(--gray-text); }
.es small { font-size: 11px; color: rgba(26,20,69,.3); }
.es a {
    margin-top: 8px; padding: 10px 22px;
    background: var(--indigo); color: #fff; border-radius: 8px;
    font-size: 10px; font-weight: 800; letter-spacing: .22em;
    text-transform: uppercase; text-decoration: none; transition: background .2s;
}
.es a:hover { background: var(--indigo-2); }

/* ── PROFILE CARD ─────────────────────── */
.profile-card {
    background: var(--white); border: 1px solid var(--gray-soft);
    border-radius: var(--r-lg); overflow: hidden;
    box-shadow: var(--sh); margin-bottom: 1.5rem;
    animation: fadeUp .6s cubic-bezier(.16,1,.3,1) .05s both;
}
.profile-hdr {
    background: var(--indigo); padding: 1.8rem 1.6rem;
    text-align: center; position: relative; overflow: hidden;
}
.profile-hdr::before {
    content: ''; position: absolute; inset: 0;
    background-image:
        repeating-linear-gradient(60deg, transparent 0, transparent 14px, rgba(196,164,124,.04) 14px, rgba(196,164,124,.04) 15px),
        repeating-linear-gradient(-60deg, transparent 0, transparent 14px, rgba(196,164,124,.04) 14px, rgba(196,164,124,.04) 15px);
}
.p-avatar {
    width: 72px; height: 72px; border-radius: 50%;
    border: 3px solid rgba(196,164,124,.4);
    margin: 0 auto 12px; display: block;
    object-fit: cover; position: relative; z-index: 1;
}
.p-avatar-ph {
    width: 72px; height: 72px; border-radius: 50%;
    border: 3px solid rgba(196,164,124,.4);
    margin: 0 auto 12px;
    background: linear-gradient(135deg,#22185d,#1a1445);
    display: flex; align-items: center; justify-content: center;
    font-size: 24px; font-weight: 800; color: var(--gold);
    position: relative; z-index: 1;
}
.p-name  { position: relative; z-index:1; font-family:'Libre Baskerville',serif; font-size:1.05rem; color:#fff; font-weight:400; margin-bottom:4px; }
.p-email { position: relative; z-index:1; font-size:10px; color:rgba(255,255,255,.35); }
.p-role  { position: relative; z-index:1; display:inline-block; margin-top:10px; font-size:8px; font-weight:800; letter-spacing:.28em; text-transform:uppercase; background:rgba(196,164,124,.15); color:var(--gold); padding:4px 12px; border-radius:20px; border:1px solid rgba(196,164,124,.2); }
.profile-body { padding: 1.2rem 1.4rem; }
.p-row { display:flex; justify-content:space-between; align-items:center; padding:9px 0; border-bottom:1px solid var(--gray-soft); font-size:12px; }
.p-row:last-child { border-bottom:none; }
.p-row .lbl { color:var(--gray-text); font-weight:600; font-size:11px; }
.p-row .val { color:var(--indigo); font-weight:700; font-size:11px; }
.via-badge { display:inline-flex; align-items:center; gap:5px; font-size:10px; font-weight:700; padding:3px 9px; border-radius:20px; }
.via-google { background:rgba(66,133,244,.1); color:#2d6fd4; }
.via-wa     { background:rgba(37,211,102,.1); color:#1a9050; }
.via-email  { background:var(--gold-lt); color:#8a6a40; }

/* ── QUICK ACTIONS ─────────────────────── */
.qa-grid { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
.qa-btn {
    display:flex; flex-direction:column; align-items:center; gap:8px;
    padding:1rem .8rem; border:1px solid var(--gray-mid); border-radius:var(--r-md);
    text-decoration:none; transition:all .22s; text-align:center;
}
.qa-btn:hover { border-color:var(--gold); background:var(--gold-lt); transform:translateY(-2px); }
.qa-icon { width:34px; height:34px; border-radius:9px; background:var(--gold-lt); display:flex; align-items:center; justify-content:center; }
.qa-icon svg { width:16px; height:16px; color:var(--gold); }
.qa-label { font-size:9px; font-weight:800; letter-spacing:.16em; text-transform:uppercase; color:var(--indigo); }
.btn-logout {
    width:100%; padding:11px; margin-top:1rem;
    background:transparent; border:1px solid rgba(224,82,82,.25);
    border-radius:10px; color:#c94444; font-size:10px; font-weight:800;
    letter-spacing:.2em; text-transform:uppercase; cursor:pointer;
    display:flex; align-items:center; justify-content:center; gap:8px; transition:all .22s;
}
.btn-logout:hover { background:rgba(224,82,82,.06); border-color:rgba(224,82,82,.5); }
.btn-logout svg { width:13px; height:13px; }

@keyframes fadeUp {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:none; }
}

@media(max-width:900px) {
    .grid-2 { grid-template-columns:1fr; }
    .stats  { grid-template-columns:1fr 1fr; }
    .db-hero-stats { display:none; }
}
@media(max-width:520px) {
    .stats  { grid-template-columns:1fr; }
    .db-wrap{ padding:1.5rem 1rem 4rem; }
}
</style>
@endpush

@section('content')

{{-- HERO --}}
<div class="db-hero">
    <div class="db-hero-bg"></div>
    <div class="db-hero-pattern"></div>
    <div class="db-hero-glow"></div>
    <div class="db-hero-content">
        <div class="db-hero-left">
            <div class="db-eyebrow">Area Pengunjung</div>
            <h1 class="db-title">
                Halo, <em>{{ explode(' ', auth()->user()->name)[0] }}</em> 👋
            </h1>
            <p class="db-subtitle">Selamat datang kembali di Saung Angklung Udjo</p>
        </div>
        <div class="db-hero-stats">
            <div class="db-hero-stat">
                <div class="db-hero-stat-n">{{ $totalBookings ?? 0 }}</div>
                <div class="db-hero-stat-l">Pemesanan</div>
            </div>
            <div class="db-hero-stat">
                <div class="db-hero-stat-n">{{ $paidBookings ?? 0 }}</div>
                <div class="db-hero-stat-l">Lunas</div>
            </div>
            <div class="db-hero-stat">
                <div class="db-hero-stat-n">{{ $upcomingBookings ?? 0 }}</div>
                <div class="db-hero-stat-l">Mendatang</div>
            </div>
        </div>
    </div>
</div>

{{-- MAIN --}}
<div class="db-wrap">

    {{-- Stat cards --}}
    <div class="stats">
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
            <div>
                <div class="stat-val">{{ $totalBookings ?? 0 }}</div>
                <div class="stat-lbl">Total Pemesanan</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="stat-val">{{ $paidBookings ?? 0 }}</div>
                <div class="stat-lbl">Tiket Terbayar</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <div class="stat-val">{{ $upcomingBookings ?? 0 }}</div>
                <div class="stat-lbl">Kunjungan Mendatang</div>
            </div>
        </div>
    </div>

    {{-- Main grid --}}
    <div class="grid-2">

        {{-- LEFT: Booking history --}}
        <div>
            <div class="card">
                <div class="sh">
                    <div class="sh-bar"></div>
                    <div><h3>Riwayat Pemesanan</h3><p>Semua tiket kamu</p></div>
                </div>

                @if(isset($bookings) && $bookings->count() > 0)
                    <div class="bk-list">
                        @foreach($bookings as $b)
                        <div class="bk-item {{ $b->status }}">
                         <div class="bk-day">{{ \Carbon\Carbon::parse($b->tanggal_kunjungan)->format('d') }}</div>
                        <div class="bk-mon">{{ \Carbon\Carbon::parse($b->tanggal_kunjungan)->translatedFormat('M') }}

</div>
                            <div class="bk-info">
                                <div class="bk-title">Pertunjukan Angklung & Budaya Sunda</div>
                                <div class="bk-meta">Sesi {{ $b->sesi }} · {{ $b->order_code }}</div>
                            </div>
                            <div class="bk-right">
                              <div class="bk-price">Rp {{ number_format($b->total_bayar, 0, ',', '.') }}</div>
                                <span class="bk-badge {{ $b->status }}">
                                    {{ $b->status === 'paid' ? '✓ Lunas' : ($b->status === 'pending' ? '⏳ Pending' : '✕ Batal') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="es">
                        <div class="es-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        </div>
                        <p>Belum ada pemesanan tiket</p>
                        <small>Pesan tiket pertunjukan sekarang!</small>
                       <a href="{{ route('tickets.buy') }}">Pesan Tiket Sekarang</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- RIGHT: Profile + quick actions --}}
        <div>

            {{-- Profile --}}
            <div class="profile-card">
                <div class="profile-hdr">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="avatar" class="p-avatar">
                    @else
                        <div class="p-avatar-ph">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    @endif
                    <div class="p-name">{{ auth()->user()->name }}</div>
                    @php
                        $emailRaw = auth()->user()->email ?? '';
                        $showEmail = str_contains($emailRaw, '@wa.local') ? null : $emailRaw;
                        $phone = auth()->user()->phone ?? null;
                    @endphp
                    <div class="p-email">{{ $showEmail ?? ($phone ? $phone : '—') }}</div>
                    <div class="p-role">Pengunjung</div>
                </div>
                <div class="profile-body">
                    <div class="p-row">
                        <span class="lbl">Login via</span>
                        @if(auth()->user()->google_id)
                            <span class="via-badge via-google">Google</span>
                        @elseif(auth()->user()->phone)
                            <span class="via-badge via-wa">WhatsApp</span>
                        @else
                            <span class="via-badge via-email">Email</span>
                        @endif
                    </div>
                    <div class="p-row">
                        <span class="lbl">Bergabung</span>
                        <span class="val">{{ auth()->user()->created_at->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="p-row">
                        <span class="lbl">Total kunjungan</span>
                        <span class="val">{{ $totalBookings ?? 0 }}×</span>
                    </div>
                </div>
            </div>

            {{-- Quick actions --}}
            <div class="card">
                <div class="sh">
                    <div class="sh-bar"></div>
                    <div><h3>Aksi Cepat</h3></div>
                </div>
                <div class="qa-grid">
                   <a href="{{ route('tickets.buy') }}" class="qa-btn">
                        <div class="qa-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg></div>
                        <span class="qa-label">Beli Tiket</span>
                    </a>
                    <a href="/#jadwal-pertunjukan" class="qa-btn">
                        <div class="qa-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                        <span class="qa-label">Jadwal</span>
                    </a>
                    <a href="https://wa.me/6282182821200" target="_blank" class="qa-btn">
                        <div class="qa-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 3H3v13h5l4 4 4-4h5V3z"/></svg></div>
                        <span class="qa-label">Chat Kami</span>
                    </a>
                    <a href="/galeri" class="qa-btn">
                        <div class="qa-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>
                        <span class="qa-label">Galeri</span>
                    </a>
                </div>
                <form method="POST" action="/logout-visitor">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Keluar dari Akun
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection