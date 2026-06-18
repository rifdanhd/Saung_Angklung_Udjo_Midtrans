{{-- resources/views/experience/outdoor-performances.blade.php --}}
@extends('layouts.app')

@section('title', 'Pertunjukan Luar & Kolaborasi - Saung Angklung Udjo')

@section('content')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,600;1,300;1,600&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Spirax&family=DM+Mono:wght@300;400&display=swap" rel="stylesheet">
{{-- GSAP digunakan penuh untuk animasi hero premium --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

<style>
/* ══════════════════════════════════════════════════
   TEMA: Selaras 100% dengan home.blade.php
   Palette : #1a1445 (indigo-deep) · #c4a47c (gold) · #F7F7F2 (bg)
   Fonts   : Libre Baskerville · Spirax · DM Mono · Inter
══════════════════════════════════════════════════ */
:root {
  --indigo:    #1a1445;
  --indigo-mid:#22185d;
  --gold:      #c4a47c;
  --gold-lt:   #e5d0a8;
  --cream:     #F7F7F2;
  --charcoal:  #3e3b56;
  --muted:     rgba(26,20,69,0.45);
  --serif:     'Libre Baskerville', serif;
  --display:   'Cormorant Garamond', serif;
  --spirax:    'Spirax', cursive;
  --mono:      'DM Mono', monospace;
  --inter:     'Inter', sans-serif;
}

#op-page * { box-sizing: border-box; }
#op-page {
  background: var(--cream);
  font-family: var(--inter);
  overflow-x: hidden;
  color: var(--indigo);
}

/* ═══ HERO — Premium Luxury Redesign ═══ */
#op-hero {
  position: relative;
  height: 100vh;
  min-height: 700px;
  display: flex;
  align-items: center;
  overflow: hidden;
  background: #08061a;
}

/* Noise texture overlay untuk kesan film grain / luxury */
#op-hero::after {
  content: '';
  position: absolute; inset: 0; z-index: 5; pointer-events: none;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
  opacity: 0.35;
  mix-blend-mode: overlay;
}

/* Gold vignette kiri — lebih dramatis dari sebelumnya */
#op-hero::before {
  content: '';
  position: absolute; inset: 0; z-index: 3; pointer-events: none;
  background: radial-gradient(ellipse 60% 120% at -5% 60%,
    rgba(196,164,124,0.06) 0%,
    transparent 70%
  );
}

.op-hero-slide {
  position: absolute; inset: 0;
  opacity: 0; z-index: 0;
  transform: scale(1.05);
  transition: opacity 2.2s cubic-bezier(0.4,0,0.2,1);
}
.op-hero-slide.active {
  opacity: 1;
  z-index: 1;
}
.op-hero-slide img {
  width:100%; height:100%; object-fit:cover;
  transform: scale(1.05);
  /* TERANG: brightness naik dari 0.38 → 0.62, saturasi normal */
  filter: brightness(0.62) saturate(0.85);
  transition: transform 10s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.op-hero-slide.active img {
  transform: scale(1);
}

/* Gradient bottom — lebih soft agar foto tetap terlihat */
.op-hero-grad-b {
  position:absolute; inset:0; z-index:2; pointer-events:none;
  background: linear-gradient(
    to top,
    rgba(8,6,26,0.88) 0%,
    rgba(8,6,26,0.45) 35%,
    rgba(8,6,26,0.05) 65%,
    transparent 100%
  );
}
/* Gradient kiri — cukup untuk readability teks, tidak terlalu pekat */
.op-hero-grad-l {
  position:absolute; inset:0; z-index:2; pointer-events:none;
  background: linear-gradient(
    105deg,
    rgba(8,6,26,0.78) 0%,
    rgba(8,6,26,0.4) 45%,
    transparent 75%
  );
}

/* Thin gold decorative line di kanan atas */
.op-hero-deco-line {
  position: absolute; top: 0; right: max(4rem,6vw); z-index: 10;
  width: 1px; height: 0;
  background: linear-gradient(to bottom, transparent, var(--gold), transparent);
  opacity: 0.3;
}

/* Hero Content */
.op-hero-content {
  position:relative; z-index:10;
  padding: 0 max(3rem,5vw);
  max-width: 780px;
  width: 100%;
}

/* Eyebrow — lebih tipis, lebih panjang garisnya */
.op-hero-eyebrow {
  font-family:var(--mono); font-size:8.5px; letter-spacing:0.55em;
  color:var(--gold); text-transform:uppercase;
  display:flex; align-items:center; gap:18px; margin-bottom:36px;
  opacity: 0; /* GSAP akan handle */
}
.op-hero-eyebrow-line {
  display: block; width: 48px; height: 1px;
  background: linear-gradient(to right, var(--gold), transparent);
  flex-shrink: 0;
}

/* Title — LEBIH BESAR, lebih dramatis */
.op-hero-title {
  font-family: var(--spirax);
  font-size: clamp(3rem, 6.5vw, 7.5rem);
  line-height: 0.95;
  color: #fff;
  letter-spacing: -0.02em;
  margin: 0;
  /* GSAP akan handle visibility */
  visibility: hidden;
}
/* "Pertunjukan" — putih bersih */
.op-hero-title .line-1 {
  display: block;
  color: rgba(255,255,255,0.92);
}
/* "Luar & Kolaborasi" — gold italic serif, bukan spirax */
.op-hero-title .line-2 {
  display: block;
  font-family: var(--display);
  font-style: italic;
  font-weight: 300;
  font-size: clamp(3rem, 7vw, 8.5rem);
  color: var(--gold);
  letter-spacing: -0.03em;
  line-height: 1;
  margin-top: 0.1em;
}

/* Desc */
.op-hero-desc {
  margin-top: 28px;
  font-size: 14px; line-height: 2;
  color: rgba(255,255,255,0.38);
  max-width: 420px;
  font-family: var(--serif);
  font-style: italic;
  letter-spacing: 0.02em;
  opacity: 0; /* GSAP */
}

/* Actions — tombol sleek, bukan boxy */
.op-hero-actions {
  display: flex; align-items: center; gap: 40px;
  margin-top: 52px;
  flex-wrap: wrap;
  opacity: 0; /* GSAP */
}

/* Tombol utama — pill style, lebih ringan dan elegan */
.op-btn-fill {
  display: inline-flex; align-items: center; gap: 16px;
  padding: 0.85rem 2.2rem;
  background: transparent;
  color: #fff;
  font-family: var(--mono); font-size: 8.5px; font-weight: 400;
  text-transform: uppercase; letter-spacing: 0.45em; text-decoration: none;
  border: 1px solid rgba(255,255,255,0.3);
  position: relative; overflow: hidden;
  transition: border-color 0.4s ease, color 0.4s ease;
}
.op-btn-fill::before {
  content: '';
  position: absolute; inset: 0;
  background: var(--gold);
  transform: translateX(-101%);
  transition: transform 0.5s cubic-bezier(0.76,0,0.24,1);
  z-index: 0;
}
.op-btn-fill:hover::before { transform: translateX(0); }
.op-btn-fill:hover { border-color: var(--gold); color: var(--indigo); }
.op-btn-fill span { position: relative; z-index: 1; }
.op-btn-fill-arrow {
  position: relative; z-index: 1;
  display: inline-block; width: 24px; height: 1px;
  background: currentColor; flex-shrink: 0;
  transition: width 0.4s ease;
}
.op-btn-fill:hover .op-btn-fill-arrow { width: 36px; }

/* Link sekunder — bare underline style */
.op-hero-link {
  font-family: var(--mono); font-size: 8px; letter-spacing: 0.5em;
  text-transform: uppercase; color: rgba(255,255,255,0.3);
  text-decoration: none;
  position: relative;
  transition: color 0.3s ease;
}
.op-hero-link::after {
  content: '';
  position: absolute; bottom: -3px; left: 0; right: 0;
  height: 1px; background: var(--gold);
  transform: scaleX(0); transform-origin: left;
  transition: transform 0.4s cubic-bezier(0.76,0,0.24,1);
}
.op-hero-link:hover { color: var(--gold); }
.op-hero-link:hover::after { transform: scaleX(1); }

/* Controls — minimalist */
.op-hero-controls {
  position:absolute; bottom:48px; left:max(3rem,5vw); z-index:10;
  display:flex; align-items:center; gap:20px;
  opacity: 0; /* GSAP */
}
.op-nav-btn {
  width: 40px; height: 40px;
  border: 1px solid rgba(255,255,255,0.15);
  background: transparent; color: rgba(255,255,255,0.5);
  cursor: pointer; display: flex; align-items: center; justify-content: center;
  transition: all 0.35s cubic-bezier(0.16,1,0.3,1);
  position: relative; overflow: hidden;
}
.op-nav-btn::before {
  content: '';
  position: absolute; inset: 0;
  background: var(--gold);
  transform: scale(0); border-radius: 50%;
  transition: transform 0.35s cubic-bezier(0.34,1.56,0.64,1);
}
.op-nav-btn:hover::before { transform: scale(1); border-radius: 0; }
.op-nav-btn:hover { color: var(--indigo); border-color: var(--gold); }
.op-nav-btn svg { width:14px; height:14px; position: relative; z-index: 1; }

/* Progress bar indicators — thin dan presisi */
.op-indicators { display:flex; gap:6px; align-items:center; }
.op-ind {
  width: 24px; height: 1px;
  background: rgba(255,255,255,0.2);
  transition: all 0.5s cubic-bezier(0.16,1,0.3,1);
  border: none; cursor: pointer; padding: 0;
  position: relative; overflow: hidden;
}
.op-ind::after {
  content: '';
  position: absolute; inset: 0;
  background: var(--gold);
  transform: scaleX(0); transform-origin: left;
  transition: transform 5.5s linear;
}
.op-ind.active { width: 56px; background: rgba(255,255,255,0.1); }
.op-ind.active::after { transform: scaleX(1); }

/* ═══ MARQUEE ═══ */
#op-marquee {
  background:var(--gold);
  padding:16px 0;
  overflow:hidden;
  position:relative;
}
/* FIX #2: Marquee wrapper perlu overflow hidden dan flex agar clone tampil inline */
.op-marquee-wrap {
  display:flex;
  overflow:hidden;
  width:100%;
}
.op-marquee-track {
  display:flex;
  width:max-content;
  flex-shrink:0;
  will-change: transform;
}
.op-marquee-item {
  font-family:var(--serif); font-size:1rem; font-style:italic;
  color:var(--indigo); padding:0 28px; white-space:nowrap; user-select:none;
}
.op-marquee-dot { font-style:normal; opacity:0.35; }

/* ═══ INTRO ═══ */
#op-intro {
  background:var(--cream);
  padding:120px max(3rem,7vw);
  position:relative;
  overflow:hidden;
}
.op-intro-inner {
  max-width:1200px; margin:0 auto;
  display:grid; grid-template-columns:1fr 1fr; gap:100px; align-items:center;
}
.op-intro-eyebrow {
  font-family:var(--mono); font-size:9px; letter-spacing:0.55em;
  color:var(--gold); text-transform:uppercase;
  display:flex; align-items:center; gap:14px; margin-bottom:24px;
}
.op-intro-eyebrow::before { content:''; width:32px; height:1px; background:var(--gold); }
.op-intro-heading {
  font-family:var(--serif); font-size:clamp(2.5rem,4vw,4.5rem);
  font-style:italic; font-weight:400; line-height:1.1; color:var(--indigo); margin-bottom:36px;
}
.op-intro-body {
  font-size:16px; line-height:1.95; color:rgba(26,20,69,0.65); margin-bottom:16px;
}
.op-intro-body strong { color:var(--indigo); }

/* FIX #3: Tambah overflow:hidden di wrapper agar parallax tidak meluap */
.op-intro-images {
  position:relative;
  height:580px;
  overflow:hidden;   /* ← kunci fix parallax overflow */
  border-top-right-radius:1.5rem;
  border-bottom-right-radius:1.5rem;
}
.op-intro-img-main {
  position:absolute; top:0; left:0;
  width:100%; height:115%;   /* lebih tinggi dari container agar parallax punya ruang */
  object-fit:cover;
  display:block; filter:grayscale(10%);
  will-change: transform;
}

/* ═══ PROGRAM CARDS — LV Style Full Width ═══ */
#op-programs { background:#0a081e; padding:120px 0 0; overflow:hidden; }
.op-programs-header {
  padding:0 max(4rem,8vw) 80px; max-width:1200px; margin:0 auto;
  display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:32px;
}
.op-programs-heading {
  font-family:var(--serif); font-size:clamp(2.5rem,5vw,4.5rem);
  font-style:italic; font-weight:400; color:#fff; line-height:1.1;
}
.op-programs-heading span { color:var(--gold); }
.op-programs-desc {
  font-size:15px; line-height:1.8; color:rgba(255,255,255,0.35); max-width:360px;
}

/* LV Scene Cards */
.op-lv-list { display:flex; flex-direction:column; }
.op-lv-card {
  position:relative; width:100%; height:90vh;
  overflow:hidden; cursor:pointer;
}
.op-lv-card img {
  width:100%; height:100%; object-fit:cover;
  transition:transform 1.8s cubic-bezier(0.25,1,0.3,1);
}
.op-lv-card:hover img { transform:scale(1.04); }
.op-lv-overlay {
  position:absolute; inset:0;
  background:linear-gradient(
    to right,
    rgba(10,8,30,0.78) 0%,
    rgba(10,8,30,0.35) 55%,
    transparent 100%
  );
  transition:background 0.6s ease;
}
.op-lv-card:hover .op-lv-overlay {
  background:linear-gradient(
    to right,
    rgba(10,8,30,0.88) 0%,
    rgba(10,8,30,0.5) 55%,
    transparent 100%
  );
}
.op-lv-content {
  position:absolute; bottom:0; left:0; right:0;
  padding:0 max(4rem,8vw) 72px;
  display:flex; align-items:flex-end; justify-content:space-between; gap:40px; flex-wrap:wrap;
}
.op-lv-left { max-width:620px; }
.op-lv-number {
  font-family:var(--mono); font-size:10px; letter-spacing:0.5em;
  color:rgba(255,255,255,0.2); text-transform:uppercase;
  margin-bottom:20px; display:block;
}
.op-lv-tag {
  font-family:var(--mono); font-size:9px; letter-spacing:0.5em;
  text-transform:uppercase; color:var(--gold); margin-bottom:16px;
  display:flex; align-items:center; gap:12px;
}
.op-lv-tag::before { content:''; width:24px; height:1px; background:var(--gold); }
.op-lv-title {
  font-family:var(--serif); font-style:italic; font-weight:400;
  font-size:clamp(3.5rem,7vw,7.5rem); line-height:0.92;
  color:#fff; margin-bottom:28px; letter-spacing:-0.02em;
}
.op-lv-desc {
  font-size:14px; line-height:1.9; color:rgba(255,255,255,0.4); max-width:460px;
}
.op-lv-right {
  display:flex; flex-direction:column; gap:10px; padding-bottom:4px;
  opacity:0; transform:translateX(20px);
  transition:all 0.6s cubic-bezier(0.16,1,0.3,1);
}
.op-lv-card:hover .op-lv-right { opacity:1; transform:translateX(0); }
.op-lv-pill {
  font-family:var(--mono); font-size:9px; letter-spacing:0.3em; text-transform:uppercase;
  color:rgba(255,255,255,0.3); border:1px solid rgba(255,255,255,0.1);
  padding:10px 20px; white-space:nowrap; transition:all 0.3s ease;
}
.op-lv-pill:hover { border-color:var(--gold); color:var(--gold); }

.op-lv-card + .op-lv-card {
  border-top:1px solid rgba(196,164,124,0.12);
}

/* ═══ ACHIEVEMENTS — Premium Card UI ═══ */
#op-achievements {
  background: var(--indigo);
  padding: 120px max(3rem,7vw) 100px;
  position: relative; overflow: hidden;
}
/* Subtle gold orbs background */
#op-achievements::before {
  content: ''; position: absolute; top: -15%; right: -8%;
  width: 700px; height: 700px;
  background: radial-gradient(circle, rgba(196,164,124,0.07) 0%, transparent 65%);
  border-radius: 50%; filter: blur(100px); pointer-events: none;
}
#op-achievements::after {
  content: ''; position: absolute; bottom: -10%; left: -5%;
  width: 500px; height: 500px;
  background: radial-gradient(circle, rgba(196,164,124,0.04) 0%, transparent 70%);
  border-radius: 50%; filter: blur(80px); pointer-events: none;
}

.op-ach-inner { max-width: 1200px; margin: 0 auto; position: relative; z-index: 1; }

/* Header */
.op-ach-header {
  display: flex; justify-content: space-between; align-items: flex-end;
  flex-wrap: wrap; gap: 32px; margin-bottom: 72px;
}
.op-ach-header-left {}
.op-ach-eyebrow {
  font-family: var(--mono); font-size: 9px; letter-spacing: 0.55em; text-transform: uppercase;
  color: var(--gold); display: flex; align-items: center; gap: 14px; margin-bottom: 20px;
}
.op-ach-eyebrow::before { content: ''; width: 32px; height: 1px; background: var(--gold); }
.op-ach-heading {
  font-family: var(--spirax); font-size: clamp(2.5rem,5vw,5rem); color: #fff; line-height: 1.05;
}
.op-ach-heading span { color: var(--gold); font-family: var(--serif); font-style: italic; }
.op-ach-header-stat {
  text-align: right;
}
.op-ach-stat-num {
  font-family: var(--display); font-size: clamp(3rem,5vw,5rem);
  font-style: italic; font-weight: 300; color: var(--gold);
  line-height: 1; display: block;
}
.op-ach-stat-label {
  font-family: var(--mono); font-size: 8px; letter-spacing: 0.5em;
  text-transform: uppercase; color: rgba(255,255,255,0.3);
  display: block; margin-top: 6px;
}

/* Grid layout — 3 kolom di desktop */
.op-journey {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 2px;
}

/* Card style — bukan timeline lagi */
.op-journey-step {
  background: rgba(255,255,255,0.03);
  border: 1px solid rgba(196,164,124,0.1);
  padding: 40px 36px;
  position: relative;
  overflow: hidden;
  transition: background 0.4s ease, border-color 0.4s ease;
  cursor: default;
}
.op-journey-step::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 2px;
  background: linear-gradient(to right, var(--gold), transparent);
  transform: scaleX(0); transform-origin: left;
  transition: transform 0.5s cubic-bezier(0.16,1,0.3,1);
}
.op-journey-step:hover { background: rgba(196,164,124,0.06); border-color: rgba(196,164,124,0.25); }
.op-journey-step:hover::before { transform: scaleX(1); }

/* Glow blob di pojok kanan atas card saat hover */
.op-journey-step::after {
  content: '';
  position: absolute; top: -30px; right: -30px;
  width: 120px; height: 120px;
  background: radial-gradient(circle, rgba(196,164,124,0.12), transparent 70%);
  border-radius: 50%;
  opacity: 0; transition: opacity 0.5s ease;
}
.op-journey-step:hover::after { opacity: 1; }

.op-journey-year {
  font-family: var(--display);
  font-size: 3.2rem; font-style: italic; font-weight: 300;
  color: var(--gold); line-height: 1;
  margin-bottom: 20px; display: block;
  opacity: 0.85;
}
.op-journey-title {
  font-family: var(--inter); font-size: 10px; font-weight: 800;
  letter-spacing: 0.22em; text-transform: uppercase;
  color: #fff; margin-bottom: 14px; line-height: 1.5;
}
.op-journey-body {
  font-size: 13px; line-height: 1.85;
  color: rgba(255,255,255,0.38);
  font-family: var(--serif); font-style: italic;
}

/* Card "Kini" — highlight khusus */
.op-journey-step.is-now {
  background: rgba(196,164,124,0.08);
  border-color: rgba(196,164,124,0.3);
}
.op-journey-step.is-now::before { transform: scaleX(1); }
.op-journey-step.is-now .op-journey-year { opacity: 1; }

/* ═══ QUOTE ═══ */
#op-quote {
  background:var(--cream); padding:120px max(3rem,7vw);
  text-align:center; position:relative; overflow:hidden;
}
.op-quote-ornament {
  font-family:var(--serif); font-size:8rem; line-height:0;
  color:rgba(196,164,124,0.15); display:block; margin-bottom:48px;
}
.op-quote-text {
  font-family:var(--serif); font-size:clamp(1.6rem,3vw,2.8rem);
  font-style:italic; font-weight:400; color:var(--indigo); line-height:1.5;
  max-width:860px; margin:0 auto 28px;
}
.op-quote-attr {
  font-family:var(--mono); font-size:9px; letter-spacing:0.5em;
  text-transform:uppercase; color:var(--gold);
}

/* ═══ CTA ═══ */
#op-cta {
  background:var(--indigo); padding:140px max(3rem,7vw);
  position:relative; overflow:hidden; text-align:center;
}
#op-cta::before {
  content:''; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);
  width:600px; height:600px;
  background:radial-gradient(circle, rgba(196,164,124,0.06) 0%, transparent 70%);
  border-radius:50%; filter:blur(100px); pointer-events:none;
}
.op-cta-inner { max-width:700px; margin:0 auto; position:relative; z-index:1; }
.op-cta-eyebrow {
  font-family:var(--mono); font-size:9px; letter-spacing:0.55em;
  text-transform:uppercase; color:var(--gold); margin-bottom:24px;
}
.op-cta-heading {
  font-family:var(--spirax); font-size:clamp(2.5rem,6vw,5.5rem);
  color:#fff; line-height:1.1; margin-bottom:20px;
}
.op-cta-sub { font-size:16px; line-height:1.8; color:rgba(255,255,255,0.45); margin-bottom:56px; }
.op-cta-actions { display:flex; align-items:center; justify-content:center; gap:36px; flex-wrap:wrap; }
.op-btn-unesco {
  position:relative; display:inline-flex; align-items:center; justify-content:center;
  padding:1.2rem 3rem; background:var(--gold); color:var(--indigo);
  text-decoration:none; overflow:hidden;
  transition:all 0.5s cubic-bezier(0.16,1,0.3,1);
  box-shadow:0 10px 30px rgba(196,164,124,0.2);
}
.op-btn-unesco:hover { background:#fff; color:var(--indigo); transform:translateY(-4px); }
.op-btn-unesco span {
  font-family:var(--inter); font-size:11px; font-weight:800;
  text-transform:uppercase; letter-spacing:0.3em;
}
.op-btn-line {
  font-family:var(--mono); font-size:9px; font-weight:700;
  letter-spacing:0.4em; text-transform:uppercase; color:rgba(255,255,255,0.5);
  text-decoration:none; padding-bottom:4px; border-bottom:1px solid rgba(255,255,255,0.2);
  transition:all 0.3s ease;
}
.op-btn-line:hover { color:var(--gold); border-color:var(--gold); }

/* Reveal — visibility hidden sebagai default, GSAP yang akan menganimasikan */
.op-reveal {
  opacity: 0;
  transform: translateY(32px);
  visibility: hidden;
}
/* Class .active tetap ada untuk fallback jika JS gagal */
.op-reveal.active {
  opacity: 1 !important;
  transform: translateY(0) !important;
  visibility: visible !important;
}

/* ═══ RESPONSIVE — Mobile First ═══ */

/* Tablet (≤900px) */
@media (max-width: 900px) {
  /* Hero */
  .op-hero-content { padding: 0 1.8rem; max-width: 100%; }
  .op-hero-title { font-size: clamp(2.4rem, 8vw, 4rem); }
  .op-hero-title .line-2 { font-size: clamp(2.6rem, 9vw, 4.5rem); }
  .op-hero-desc { font-size: 13px; max-width: 340px; }
  .op-hero-actions { margin-top: 36px; gap: 28px; }
  .op-hero-controls { left: 1.8rem; bottom: 36px; }
  .op-hero-deco-line { display: none; }

  /* Intro */
  .op-intro-inner { grid-template-columns: 1fr; gap: 48px; }
  .op-intro-images {
    height: 280px; order: -1;
    border-radius: 1rem; overflow: hidden;
  }
  .op-intro-img-main { position: relative; width: 100%; height: 100%; }

  /* Programs */
  .op-programs-header { flex-direction: column; align-items: flex-start; padding: 0 1.8rem 60px; }
  .op-lv-card { height: 65vh; }
  .op-lv-right { display: none; }
  .op-lv-title { font-size: clamp(2.2rem, 8vw, 3.5rem); }
  .op-lv-content { padding: 0 1.8rem 40px; }

  /* Achievements */
  .op-journey { grid-template-columns: repeat(2, 1fr); }
  .op-ach-header { flex-direction: column; align-items: flex-start; }
  .op-ach-header-stat { text-align: left; }
}

/* Mobile (≤640px) */
@media (max-width: 640px) {
  /* Hero */
  #op-hero { min-height: 100svh; }
  .op-hero-content { padding: 0 1.25rem; }
  .op-hero-title { font-size: clamp(2rem, 9.5vw, 3rem); line-height: 1.0; }
  .op-hero-title .line-2 { font-size: clamp(2.2rem, 10.5vw, 3.2rem); }
  .op-hero-eyebrow { font-size: 7.5px; letter-spacing: 0.4em; margin-bottom: 24px; }
  .op-hero-eyebrow-line { width: 28px; }
  .op-hero-desc { display: none; } /* Simpan ruang di mobile kecil */
  .op-hero-actions { margin-top: 28px; gap: 20px; flex-direction: column; align-items: flex-start; }
  .op-btn-fill { padding: 0.9rem 1.8rem; font-size: 8px; letter-spacing: 0.35em; }
  .op-hero-link { display: none; } /* Cukup 1 CTA di mobile */
  .op-hero-controls { left: 1.25rem; bottom: 28px; gap: 14px; }
  .op-nav-btn { width: 34px; height: 34px; }
  .op-ind { width: 18px; }
  .op-ind.active { width: 40px; }

  /* Marquee */
  .op-marquee-item { font-size: 0.85rem; padding: 0 18px; }

  /* Intro */
  #op-intro { padding: 72px 1.25rem; }
  .op-intro-images { height: 220px; }
  .op-intro-heading { font-size: clamp(1.8rem, 8vw, 2.5rem); }

  /* Programs */
  #op-programs { padding: 80px 0 0; }
  .op-programs-header { padding: 0 1.25rem 48px; }
  .op-programs-heading { font-size: clamp(1.8rem, 8vw, 2.8rem); }
  .op-lv-card { height: 80vw; min-height: 280px; }
  .op-lv-content { padding: 0 1.25rem 32px; }
  .op-lv-title { font-size: clamp(1.8rem, 9vw, 2.8rem); margin-bottom: 12px; }
  .op-lv-number { display: none; }
  .op-lv-desc { font-size: 12.5px; }

  /* Achievements */
  #op-achievements { padding: 72px 1.25rem 64px; }
  .op-journey { grid-template-columns: 1fr; gap: 2px; }
  .op-journey-step { padding: 28px 24px; }
  .op-journey-year { font-size: 2.4rem; }
  .op-ach-heading { font-size: clamp(2rem, 8vw, 3rem); }
  .op-ach-header { margin-bottom: 48px; }
  .op-ach-stat-num { font-size: 2.5rem; }

  /* Quote */
  #op-quote { padding: 72px 1.25rem; }
  .op-quote-ornament { font-size: 5rem; margin-bottom: 24px; }
  .op-quote-text { font-size: clamp(1.2rem, 5vw, 1.6rem); }

  /* CTA */
  #op-cta { padding: 80px 1.25rem; }
  .op-cta-heading { font-size: clamp(2rem, 8vw, 2.8rem); }
  .op-cta-actions { flex-direction: column; align-items: center; gap: 20px; }
  .op-btn-unesco { width: 100%; max-width: 320px; justify-content: center; }
}
</style>
@endpush

<div id="op-page">

{{-- HERO --}}
<section id="op-hero">
  {{-- Background slides --}}
  <div id="opSliderWrap" style="position:absolute;inset:0;z-index:0">
    <div class="op-hero-slide active"><img src="{{ asset('img/France.jpg') }}" alt="Pertunjukan Luar"></div>
    <div class="op-hero-slide"><img src="{{ asset('img/arumba222.webp') }}" alt="International Tour"></div>
    <div class="op-hero-slide"><img src="{{ asset('img/awildan.webp') }}" alt="Cultural Performance"></div>
    <div class="op-hero-slide"><img src="{{ asset('img/irfanhakim.webp') }}" alt="Outdoor Stage"></div>
  </div>

  <div class="op-hero-grad-b"></div>
  <div class="op-hero-grad-l"></div>

  {{-- Decorative vertical line --}}
  <div class="op-hero-deco-line" id="opDecoLine"></div>

  {{-- Content --}}
  <div class="op-hero-content">
    <p class="op-hero-eyebrow" id="opEyebrow">
      <span class="op-hero-eyebrow-line"></span>
      Beyond The Saung · Angklung for The World
    </p>

    <h1 class="op-hero-title" id="opTitle">
      <span class="line-1">Pertunjukan</span>
      <span class="line-2">Luar &amp; Kolaborasi</span>
    </h1>

    <p class="op-hero-desc" id="opDesc">
      Dari panggung lokal hingga lima benua — membawa harmoni angklung ke seluruh dunia.
    </p>

    <div class="op-hero-actions" id="opActions">
      <a href="#op-programs" class="op-btn-fill">
        <span>Temukan Pengalaman</span>
        <span class="op-btn-fill-arrow"></span>
      </a>
      <a href="{{ route('heritage.achievements') }}" class="op-hero-link">Jejak Kami</a>
    </div>
  </div>

  {{-- Controls --}}
  <div class="op-hero-controls" id="opControls">
    <div class="op-indicators" id="opIndicators">
      <button class="op-ind active" aria-label="Slide 1"></button>
      <button class="op-ind" aria-label="Slide 2"></button>
      <button class="op-ind" aria-label="Slide 3"></button>
      <button class="op-ind" aria-label="Slide 4"></button>
    </div>
    <button class="op-nav-btn" data-slider-action="prev" aria-label="Sebelumnya">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="1.5" stroke-linecap="round"/></svg>
    </button>
    <button class="op-nav-btn" data-slider-action="next" aria-label="Berikutnya">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7" stroke-width="1.5" stroke-linecap="round"/></svg>
    </button>
  </div>


</section>

{{-- INTRO --}}
<section id="op-intro">
  <div class="op-intro-inner">
    <div>
      <p class="op-intro-eyebrow op-reveal">Harmoni Tanpa Batas</p>
      <h2 class="op-intro-heading op-reveal">Angklung untuk Dunia</h2>
      <p class="op-intro-body op-reveal">
        Dari panggung lokal hingga orkestra internasional di lima benua — kami membawa keceriaan angklung ke khalayak yang lebih luas.
      </p>
      <div style="margin-top:48px" class="op-reveal">
        <a href="{{ route('heritage.achievements') }}"
           style="display:inline-flex;align-items:center;gap:20px;font-family:var(--inter);font-size:10px;font-weight:800;letter-spacing:0.4em;text-transform:uppercase;color:var(--indigo);text-decoration:none;transition:color 0.3s"
           onmouseover="this.style.color='#c4a47c'"
           onmouseout="this.style.color='var(--indigo)'">
          <span>Lihat Pencapaian</span>
          <div style="width:48px;height:1px;background:rgba(26,20,69,0.25)"></div>
        </a>
      </div>
    </div>
    {{-- FIX #3: overflow:hidden ditambahkan via CSS, parallax tidak meluap --}}
    <div class="op-intro-images op-reveal">
      <img src="{{ asset('img/jepanggg.webp') }}" alt="Outdoor Angklung" class="op-intro-img-main" id="opIntroImgMain">
    </div>
  </div>
</section>

{{-- PROGRAMS — LV Style Full Width --}}
<section id="op-programs">
  <div class="op-programs-header op-reveal">
    <div>
      <p style="font-family:var(--mono);font-size:9px;letter-spacing:0.5em;text-transform:uppercase;color:var(--gold);margin-bottom:16px;">Layanan Eksternal</p>
      <h2 class="op-programs-heading">Pertunjukan &amp;<br><span>Kolaborasi</span></h2>
    </div>
    <p class="op-programs-desc">
      Tiga layanan utama Pertunjukan Luar Saung Angklung Udjo — dari panggung domestik hingga diplomasi budaya dunia.
    </p>
  </div>

  <div class="op-lv-list">

    {{-- SCENE 1: Arumba --}}
    <div class="op-lv-card op-reveal">
      <img src="{{ asset('img/arumba222.webp') }}" alt="Arumba Performance">
      <div class="op-lv-overlay"></div>
      <div class="op-lv-content">
        <div class="op-lv-left">
          <span class="op-lv-number">01</span>
          <p class="op-lv-tag">Modern · Contemporary</p>
          <h3 class="op-lv-title">Arumba<br>Performance</h3>
          <p class="op-lv-desc">Musik bambu kontemporer yang memadukan warisan tradisional dengan sentuhan modern — tampil di panggung nasional dan internasional.</p>
        </div>
        <div class="op-lv-right">
          <span class="op-lv-pill">Modern Bamboo Ensemble</span>
          <span class="op-lv-pill">Contemporary Arrangement</span>
          <span class="op-lv-pill">International Stage</span>
          <span class="op-lv-pill">Cross-Cultural Fusion</span>
        </div>
      </div>
    </div>

    {{-- SCENE 2: Angklung Interaktif --}}
    <div class="op-lv-card op-reveal">
      <img src="{{ asset('img/Interaksi.webp') }}" alt="Angklung Interaktif">
      <div class="op-lv-overlay"></div>
      <div class="op-lv-content">
        <div class="op-lv-left">
          <span class="op-lv-number">02</span>
          <p class="op-lv-tag">Interaktif · Partisipatif</p>
          <h3 class="op-lv-title">Angklung<br>Interaktif</h3>
          <p class="op-lv-desc">Mengajak seluruh penonton bermain angklung bersama — pengalaman budaya yang telah dibawa ke berbagai penjuru dunia.</p>
        </div>
        <div class="op-lv-right">
          <span class="op-lv-pill">Gala Dinner &amp; Corporate Event</span>
          <span class="op-lv-pill">Festival Budaya</span>
          <span class="op-lv-pill">Team Building Interaktif</span>
          <span class="op-lv-pill">Embassy &amp; Consulate Events</span>
        </div>
      </div>
    </div>

    {{-- SCENE 3: Kolaborasi Orkestra --}}
    <div class="op-lv-card op-reveal">
      <img src="{{ asset('img/France.jpg') }}" alt="Kolaborasi Orkestra">
      <div class="op-lv-overlay"></div>
      <div class="op-lv-content">
        <div class="op-lv-left">
          <span class="op-lv-number">03</span>
          <p class="op-lv-tag">Cross-Genre · Global</p>
          <h3 class="op-lv-title">Kolaborasi<br>Orkestra</h3>
          <p class="op-lv-desc">Angklung bersanding dengan orkestra simfoni dan musisi dunia — memukau penonton di lima benua.</p>
        </div>
        <div class="op-lv-right">
          <span class="op-lv-pill">Symphony Orchestra Fusion</span>
          <span class="op-lv-pill">Contemporary Music Collab</span>
          <span class="op-lv-pill">World Music Festival</span>
          <span class="op-lv-pill">International Cultural Tour</span>
        </div>
      </div>
    </div>

  </div>
</section>


  
  </div>
</section>

{{-- QUOTE --}}
<section id="op-quote">
  <span class="op-quote-ornament op-reveal">&ldquo;</span>
  <p class="op-quote-text op-reveal">
    Angklung bukan sekadar instrumen — ia adalah bahasa perdamaian yang dimengerti seluruh dunia, tanpa penerjemah.
  </p>
  <p class="op-quote-attr op-reveal">Udjo Ngalagena · Pendiri Saung Angklung Udjo</p>
</section>

{{-- CTA --}}
<section id="op-cta">
  <div class="op-cta-inner">
    <p class="op-cta-eyebrow op-reveal">Hubungi Kami</p>
    <h2 class="op-cta-heading op-reveal">Hadirkan Harmoni<br>Udjo di Acara Anda</h2>
    <p class="op-cta-sub op-reveal">Kami siap membawa pengalaman angklung interaktif yang tak terlupakan ke acara Anda — di mana pun di Indonesia maupun dunia.</p>
    <div class="op-cta-actions op-reveal">
      <a href="#" class="op-btn-unesco"><span>Ajukan Reservasi Eksternal</span></a>
      <a href="{{ route('heritage.achievements') }}" class="op-btn-line">Lihat Pencapaian</a>
    </div>
  </div>
</section>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ══════════════════════════════════════════════
  // 1. HERO SLIDER — dengan GSAP crossfade
  // ══════════════════════════════════════════════
  let opCurrent = 0;
  const opSlides = document.querySelectorAll('.op-hero-slide');
  const opInds   = document.querySelectorAll('.op-ind');
  let opTimer;
  let isAnimating = false;

  function opShow(idx) {
    if (isAnimating) return;
    isAnimating = true;

    const prev = opCurrent;
    opCurrent = (idx + opSlides.length) % opSlides.length;
    if (prev === opCurrent) { isAnimating = false; return; }

    const prevSlide = opSlides[prev];
    const nextSlide = opSlides[opCurrent];

    // Update indicators
    opInds.forEach(i => i.classList.remove('active'));
    if (opInds[opCurrent]) {
      void opInds[opCurrent].offsetWidth;
      opInds[opCurrent].classList.add('active');
    }

    // GSAP crossfade antara slide
    gsap.to(prevSlide, { opacity: 0, duration: 1.6, ease: 'power2.inOut' });
    gsap.fromTo(nextSlide,
      { opacity: 0, zIndex: 2 },
      {
        opacity: 1, duration: 1.6, ease: 'power2.inOut',
        onStart: () => { nextSlide.classList.add('active'); prevSlide.classList.remove('active'); },
        onComplete: () => { isAnimating = false; }
      }
    );

    // Ken Burns pada gambar slide baru
    const nextImg = nextSlide.querySelector('img');
    if (nextImg) {
      gsap.fromTo(nextImg, { scale: 1.08 }, { scale: 1, duration: 10, ease: 'none' });
    }
  }

  // Listener tombol navigasi
  document.querySelectorAll('[data-slider-action]').forEach(btn => {
    btn.addEventListener('click', () => {
      opStopAuto();
      btn.dataset.sliderAction === 'next' ? opShow(opCurrent + 1) : opShow(opCurrent - 1);
      opStartAuto();
    });
  });
  opInds.forEach((btn, i) => btn.addEventListener('click', () => {
    opStopAuto(); opShow(i); opStartAuto();
  }));

  function opStartAuto() { opTimer = setInterval(() => opShow(opCurrent + 1), 5500); }
  function opStopAuto()  { clearInterval(opTimer); }

  const heroEl = document.getElementById('op-hero');
  heroEl?.addEventListener('mouseenter', opStopAuto);
  heroEl?.addEventListener('mouseleave', opStartAuto);

  // Inisialisasi slide pertama — Ken Burns langsung
  const firstImg = opSlides[0]?.querySelector('img');
  if (firstImg) {
    gsap.fromTo(firstImg, { scale: 1.08 }, { scale: 1, duration: 10, ease: 'none' });
  }
  if (opInds[0]) opInds[0].classList.add('active');
  opStartAuto();


  // ══════════════════════════════════════════════
  // 2. HERO ENTRANCE — GSAP Timeline premium
  // ══════════════════════════════════════════════
  const heroTl = gsap.timeline({ delay: 0.2 });

  // Decorative line tumbuh dari atas
  heroTl.to('#opDecoLine', {
    height: '60vh', duration: 1.4, ease: 'power3.out'
  }, 0);

  // Eyebrow slide dari kiri
  heroTl.fromTo('#opEyebrow',
    { opacity: 0, x: -20 },
    { opacity: 1, x: 0, duration: 0.9, ease: 'power3.out' },
    0.3
  );

  // Title — per-line stagger dari bawah, clip reveal effect
  const titleLines = document.querySelectorAll('.op-hero-title .line-1, .op-hero-title .line-2');
  gsap.set('.op-hero-title', { visibility: 'visible' });
  heroTl.fromTo(titleLines,
    { y: '110%', opacity: 0, rotateX: -15 },
    {
      y: '0%', opacity: 1, rotateX: 0,
      duration: 1.1, ease: 'expo.out',
      stagger: 0.18
    },
    0.45
  );

  // Desc fade up
  heroTl.fromTo('#opDesc',
    { opacity: 0, y: 18 },
    { opacity: 1, y: 0, duration: 0.9, ease: 'power3.out' },
    1.0
  );

  // Actions
  heroTl.fromTo('#opActions',
    { opacity: 0, y: 14 },
    { opacity: 1, y: 0, duration: 0.9, ease: 'power3.out' },
    1.2
  );

  // Controls masuk
  heroTl.fromTo('#opControls',
    { opacity: 0, y: 10 },
    { opacity: 1, y: 0, duration: 0.7, ease: 'power2.out' },
    1.5
  );


  // ══════════════════════════════════════════════
  // 3. MARQUEE — rAF (tidak perlu GSAP)
  // ══════════════════════════════════════════════
  const trackA = document.getElementById('opMarqueeA');
  const trackB = document.getElementById('opMarqueeB');
  if (trackA && trackB) {
    let pos = 0;
    const tw = trackA.scrollWidth;
    trackB.style.transform = `translateX(${tw}px)`;
    function animMarquee() {
      pos -= 0.7;
      if (pos <= -tw) pos = 0;
      trackA.style.transform = `translateX(${pos}px)`;
      trackB.style.transform = `translateX(${pos + tw}px)`;
      requestAnimationFrame(animMarquee);
    }
    requestAnimationFrame(animMarquee);
  }


  // ══════════════════════════════════════════════
  // 4. SCROLL REVEALS — GSAP + ScrollTrigger
  // ══════════════════════════════════════════════
  gsap.registerPlugin(ScrollTrigger);

  // Reveal elemen .op-reveal secara batch
  gsap.utils.toArray('.op-reveal').forEach((el) => {
    gsap.fromTo(el,
      { opacity: 0, y: 32, visibility: 'hidden' },
      {
        opacity: 1, y: 0, visibility: 'visible',
        duration: 1.1, ease: 'power3.out',
        scrollTrigger: {
          trigger: el,
          start: 'top 88%',
          toggleActions: 'play none none none'
        }
      }
    );
  });

  // Achievements cards — stagger per card dengan arah bergantian
  gsap.utils.toArray('.op-journey-step').forEach((card, i) => {
    gsap.fromTo(card,
      { opacity: 0, y: 28, scale: 0.97 },
      {
        opacity: 1, y: 0, scale: 1,
        duration: 0.75, ease: 'power3.out',
        delay: (i % 3) * 0.08,
        scrollTrigger: { trigger: card, start: 'top 87%' }
      }
    );
  });

  // LV cards — scale in
  gsap.utils.toArray('.op-lv-card').forEach((card, i) => {
    gsap.fromTo(card,
      { opacity: 0, scale: 0.97 },
      {
        opacity: 1, scale: 1, duration: 1.0, ease: 'power2.out',
        scrollTrigger: { trigger: card, start: 'top 80%' }
      }
    );
  });


  // ══════════════════════════════════════════════
  // 5. PARALLAX INTRO IMAGE — ScrollTrigger
  // ══════════════════════════════════════════════
  const introImg = document.getElementById('opIntroImgMain');
  if (introImg) {
    gsap.to(introImg, {
      y: 60,
      ease: 'none',
      scrollTrigger: {
        trigger: '#op-intro',
        start: 'top bottom',
        end: 'bottom top',
        scrub: 1.5
      }
    });
  }

  // Quote text — slight scale + fade
  gsap.fromTo('.op-quote-text',
    { scale: 0.97, opacity: 0 },
    {
      scale: 1, opacity: 1, duration: 1.2, ease: 'power2.out',
      scrollTrigger: { trigger: '.op-quote-text', start: 'top 80%' }
    }
  );

});
</script>
@endpush

@endsection