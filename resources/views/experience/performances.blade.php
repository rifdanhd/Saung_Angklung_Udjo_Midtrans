{{-- resources/views/experience/performances.blade.php --}}
@extends('layouts.app')

@section('title', 'Rangkaian Pertunjukan Seni - Saung Angklung Udjo')

@section('content')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        :root {
            --indigo-deep: #1a1445;
            --gold-premium: #c4a47c;
            --bg-premium: #F7F7F2;
        }

        .font-editorial { font-family: 'Libre Baskerville', serif; }
        body { background-color: var(--bg-premium); color: var(--indigo-deep); }

        /* ── Reveal ── */
        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity 1.1s cubic-bezier(0.16,1,0.3,1),
                        transform 1.1s cubic-bezier(0.16,1,0.3,1);
        }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .reveal-delay-1 { transition-delay: 0.15s; }
        .reveal-delay-2 { transition-delay: 0.30s; }

        /* ══════════════════════════════════════════
           PERFORMANCE ROW — Visit Qatar editorial
        ══════════════════════════════════════════ */
        .perf-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 85vh;
            position: relative;
        }

        /* Alternate: odd rows → image left / even rows → image right */
        .perf-row.reverse .perf-image  { order: 2; }
        .perf-row.reverse .perf-text   { order: 1; }

        /* ── Hero bottom-left layout ── */
        @media (max-width: 640px) {
            .perf-hero-text { padding: 0 1.5rem; padding-bottom: 3.5rem; }
            .perf-hero-text h1 { font-size: 3rem; }
        }
        .perf-image {
            position: relative;
            overflow: hidden;
            background: var(--indigo-deep);
        }

        .perf-image .swiper,
        .perf-image .swiper-wrapper,
        .perf-image .swiper-slide { width: 100%; height: 100%; }

        .perf-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 7s ease;
            will-change: transform;
        }
        .perf-row:hover .perf-image img { transform: scale(1.07); }

        /* Subtle gold border accent on the inner edge */
        .perf-row:not(.reverse) .perf-image::after {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, transparent, rgba(196,164,124,0.4), transparent);
        }
        .perf-row.reverse .perf-image::after {
            left: 0; right: auto;
        }

        /* Index number watermark */
        .perf-image .perf-index {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            font-family: 'Libre Baskerville', serif;
            font-size: 5rem;
            font-weight: 700;
            color: rgba(255,255,255,0.06);
            line-height: 1;
            user-select: none;
            pointer-events: none;
        }
        .perf-row.reverse .perf-image .perf-index {
            left: auto;
            right: 2rem;
        }

        /* ── Text panel ── */
        .perf-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 6rem 7rem;
            position: relative;
            background: var(--bg-premium);
        }

        /* Corner dot accent */
        .perf-text::before {
            content: '';
            position: absolute;
            top: 3rem;
            left: 3rem;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold-premium);
            opacity: 0.5;
        }
        .perf-row.reverse .perf-text::before {
            left: auto;
            right: 3rem;
        }

        .perf-eyebrow {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.5em;
            text-transform: uppercase;
            color: var(--gold-premium);
            margin-bottom: 1.5rem;
        }

        .perf-title {
            font-family: 'Libre Baskerville', serif;
            font-size: clamp(2.2rem, 3.5vw, 3.5rem);
            line-height: 1.1;
            color: var(--indigo-deep);
            margin-bottom: 2rem;
            letter-spacing: -0.02em;
        }

        .perf-divider {
            width: 48px;
            height: 1px;
            background: var(--gold-premium);
            margin-bottom: 2rem;
            transition: width 0.6s ease;
        }
        .perf-row:hover .perf-divider { width: 80px; }

        .perf-desc {
            font-size: 1rem;
            font-weight: 300;
            line-height: 1.9;
            color: rgba(26,20,69,0.65);
            max-width: 44ch;
        }

        .perf-dur-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 2.5rem;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: rgba(26,20,69,0.4);
        }
        .perf-dur-badge::before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 1px;
            background: var(--gold-premium);
        }

        /* Swiper dots — override to match brand */
        .swiper-pagination-bullet {
            background: rgba(255,255,255,0.4) !important;
            opacity: 1 !important;
            width: 5px !important;
            height: 5px !important;
        }
        .swiper-pagination-bullet-active {
            background: var(--gold-premium) !important;
            width: 18px !important;
            border-radius: 3px !important;
        }

        /* ══════════════════════════════════════════
           RESPONSIVE
        ══════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .perf-row { grid-template-columns: 1fr; min-height: unset; }
            .perf-row.reverse .perf-image,
            .perf-row.reverse .perf-text { order: unset; }
            .perf-image { aspect-ratio: 16/9; min-height: 280px; }
            .perf-text { padding: 3.5rem 2.5rem; }
            .perf-text::before { display: none; }
            .perf-desc { max-width: 100%; }
        }

        @media (max-width: 640px) {
            .perf-text { padding: 2.5rem 1.5rem; }
            .perf-title { font-size: 2rem; }
        }

        /* ══════════════════════════════════════════
           SINOPSIS SECTION
        ══════════════════════════════════════════ */
        .sinopsis-section {
            padding: 8rem 0;
            border-bottom: 1px solid rgba(26,20,69,0.07);
        }

        /* ══════════════════════════════════════════
           CTA SECTION
        ══════════════════════════════════════════ */
        .perf-cta-section {
            position: relative;
            padding: 10rem 2rem;
            background: var(--indigo-deep);
            overflow: hidden;
            text-align: center;
        }
        .perf-cta-section .cta-bg {
            position: absolute;
            inset: 0;
        }
        .perf-cta-section .cta-bg img {
            width: 100%; height: 100%;
            object-fit: cover;
            opacity: 0.15;
        }
        .perf-cta-section .cta-content {
            position: relative;
            z-index: 10;
        }
        .perf-cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            padding: 1.1rem 3rem;
            border: 1px solid rgba(196,164,124,0.5);
            color: var(--gold-premium);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.35em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.5s cubic-bezier(0.16,1,0.3,1);
            border-radius: 0;
        }
        .perf-cta-btn:hover {
            background: var(--gold-premium);
            color: var(--indigo-deep);
            border-color: var(--gold-premium);
            letter-spacing: 0.45em;
        }

        /* Separator between rows */
        .row-separator {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(26,20,69,0.08), transparent);
        }
    </style>
@endpush


{{-- ══════════════════════════════════════════
     1. HERO
══════════════════════════════════════════ --}}
<section class="relative flex items-center justify-center overflow-hidden bg-black"
         style="height:100svh; min-height:600px;">

    <video id="heroVideo"
           class="absolute inset-0 w-full h-full object-cover"
           style="opacity:0.55;"
           autoplay muted loop playsinline preload="none">
        <source media="(max-width: 768px)"
                src="{{ asset('Video/output_mobile.mp4') }}" type="video/mp4">
        <source src="{{ asset('Video/HIGHLIGHT_no_cta.mp4') }}" type="video/mp4">
    </video>

    <!-- Gradient: kuat di bawah kiri untuk readability teks, gelap tipis di atas -->
    <div class="absolute inset-0" style="background: linear-gradient(
        to top,
        rgba(26,20,69,0.85) 0%,
        rgba(26,20,69,0.3) 35%,
        transparent 65%
    );"></div>
    <div class="absolute inset-0" style="background: linear-gradient(
        to right,
        rgba(26,20,69,0.4) 0%,
        transparent 50%
    );"></div>

    <!-- Hero text — pojok kiri bawah ala Visit Qatar -->
    <div class="absolute bottom-0 left-0 z-10 px-8 md:px-14 pb-12 md:pb-16">
        <p class="text-[9px] font-bold tracking-[0.5em] uppercase mb-4"
           style="color:rgba(196,164,124,0.8);">Discovery</p>
        <h1 class="font-editorial text-5xl md:text-6xl lg:text-7xl text-white leading-[1.05] italic">
            Rangkaian<br>Pertunjukan
        </h1>
        <!-- Garis dekoratif kecil -->
        <div class="mt-6 flex items-center gap-4">
            <div style="width:40px;height:1px;background:rgba(196,164,124,0.6);"></div>
            <span class="text-[8px] tracking-[0.35em] uppercase font-bold"
                  style="color:rgba(255,255,255,0.35);">Saung Angklung Udjo</span>
        </div>
    </div>

    <!-- Scroll cue — kanan bawah -->
    <div class="absolute bottom-10 right-20 z-20 hidden md:flex flex-col items-center gap-3"
         style="color:rgba(255,255,255,0.25);">
        <div style="width:1px;height:40px;background:linear-gradient(to bottom,rgba(255,255,255,0.25),transparent);"></div>
        <span class="text-[7px] tracking-[0.4em] uppercase font-bold"
              style="writing-mode:vertical-lr;letter-spacing:0.4em;">Scroll</span>
    </div>

    <!-- Unmute -->
    <button id="unmuteBtn"
            class="absolute bottom-8 right-8 z-20 text-white transition-all duration-300"
            style="width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,0.1);
                   border:1px solid rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;
                   backdrop-filter:blur(4px);">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
        </svg>
    </button>
</section>


{{-- ══════════════════════════════════════════
     2. SINOPSIS
══════════════════════════════════════════ --}}
<section class="sinopsis-section">
    <div class="max-w-6xl mx-auto px-8">

        <!-- Header -->
        <div class="reveal text-center mb-20">
            <p class="text-[9px] font-bold tracking-[0.5em] uppercase text-gold-premium mb-6">Pengantar</p>
            <h2 class="font-editorial text-4xl md:text-5xl text-indigo-950 leading-tight italic mb-8">
                Sinopsis Pertunjukan
            </h2>
            <div style="width:32px;height:1px;background:var(--gold-premium);margin:0 auto;"></div>
        </div>

        <!-- Content -->
        <div class="grid md:grid-cols-2 gap-20 items-center">
            <div class="reveal">
                <div style="border-radius:1.5rem;overflow:hidden;aspect-ratio:4/3;
                            box-shadow:0 30px 60px rgba(26,20,69,0.15);">
                    <img src="{{ asset('images/awal pertunjukan.jpg') }}"
                         class="w-full h-full object-cover" alt="Abah Udjo"
                         style="transition:transform 6s ease;"
                         onmouseover="this.style.transform='scale(1.05)'"
                         onmouseout="this.style.transform='scale(1)'">
                </div>
            </div>

            <div class="reveal reveal-delay-1 space-y-7"
                 style="color:rgba(26,20,69,0.65);font-weight:300;line-height:1.9;font-size:1.05rem;">
                <p>
                    Selamat datang di <strong style="color:var(--indigo-deep);font-weight:600;">Saung Angklung Udjo</strong>,
                    sebuah rumah seni yang mempersembahkan keindahan dan keharmonisan dari alunan musik Angklung.
                    Didirikan pada tahun 1966, tempat ini adalah buah cinta dari Bapak Udjo Ngalagena dan istrinya Bu Uum Sumiati.
                </p>
                <div style="width:32px;height:1px;background:var(--gold-premium);"></div>
                <p>
                    Abah Udjo, yang dijuluki sebagai Legenda Angklung, bercita-cita menjadikan angklung sebagai simbol
                    kebanggaan budaya Indonesia dan alat menyebarkan pesan damai ke seluruh penjuru dunia.
                </p>
            </div>
        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════
     3. PERFORMANCES — Visit Qatar editorial rows
══════════════════════════════════════════ --}}
@php
    $performances = [
        [
            'title'  => 'Wayang Golek',
            'anchor' => 'wayang-golek',
            'cat'    => 'Puppetry',
            'dur'    => '15 Menit',
            'imgs'   => ['Wayanggolek.webp', 'Wayang2.webp', 'wayang3.webp'],
            'desc'   => 'Wayang Golek adalah seni pertunjukan tradisional yang memperagakan boneka kayu yang dikenal dengan sebutan "wayang". Wayang ini dibuat dengan bentuk yang menyerupai manusia dan masing-masing bonekanya memiliki karakteristik tersendiri yang mencerminkan beragam sifat manusia. Pada pementasan Wayang Golek, peran penting dipegang oleh seorang Dalang yang memandu cerita dan menggerakkan boneka dengan keterampilan yang tinggi. Setiap adegan yang ditampilkan dalam pertunjukan ini bukan sekedar hiburan, melainkan juga berisi pesan moral yang mendalam.',
        ],
        [
            'title'  => 'Helaran',
            'anchor' => 'helaran',
            'cat'    => 'Parade',
            'dur'    => '8 Menit',
            'imgs'   => ['Helaran.webp', 'Helaran2.webp'],
            'desc'   => 'Helaran adalah tradisi arak-arakan penuh makna yang kerap mengiringi berbagai upacara adat, seperti khitanan dan upacara panen padi. Helaran dipentaskan dengan nada salendro atau pentatonis dan melodi yang riang dan gembira. Ini sejalan dengan tujuan utama Helaran, yaitu sebagai bentuk hiburan dan ungkapan rasa syukur kepada Tuhan Yang Maha Esa atas segala limpahan berkat-Nya.',
        ],
        [
            'title'  => 'Tari Tradisional',
            'anchor' => 'tari-topeng',
            'cat'    => 'Dance',
            'dur'    => '8 Menit',
            'imgs'   => ['TariTopeng1.webp', 'TariTopeng2.webp', 'taritopeng3.webp'],
            'desc'   => 'Tari Topeng yang dikreasikan oleh Saung Angklung Udjo merupakan persembahan tari tradisional dengan latar belakang cerita sebuah kisah klasik tentang Ratu Kencana Wungu. Penonton akan diajak merasakan transisi karakter melalui tarian. Para penari yang berperan sebagai Layang Kumintir memperagakan perubahan karakter yang dramatis — dari sosok wanita penuh keanggunan menjadi sosok pria yang gagah saat topeng dikenakan.',
        ],
        [
            'title'  => 'Angklung Mini',
            'anchor' => 'angklung-mini',
            'cat'    => 'Dance',
            'dur'    => '5 Menit',
            'imgs'   => ['Angklungmini1.webp', 'Angklungmini2.webp'],
            'desc'   => 'Beralih ke tangga nada diatonis/modern, di sesi Angklung Mini, murid-murid junior dari Saung Angklung Udjo menyuguhkan pertunjukan yang mengesankan dengan memainkan lagu anak-anak "Boneka Abdi". Alunan melodinya dipersembahkan dengan menggunakan Angklung berukuran mini yang hanya memiliki satu tangga nada diatonis — sederhana, namun tetap menyajikan harmoni dan melodi yang menarik dan indah.',
        ],
        [
            'title'  => 'Arumba',
            'anchor' => 'arumba',
            'cat'    => 'Modern',
            'dur'    => '5 Menit',
            'imgs'   => ['Arumbaa.webp', 'Arumba.webp', 'Arumba2.webp'],
            'desc'   => 'ARUMBA adalah singkatan dari "Alunan Rumpun Bambu" yang merupakan satu set alat musik tradisional yang terbuat dari bambu. ARUMBA memiliki tangga nada diatonis yang dapat memainkan berbagai genre musik, termasuk Dangdut — genre musik yang sangat populer di Indonesia. Penonton diajak untuk tidak hanya menikmati, namun juga bernyanyi bersama, menciptakan momen interaktif yang mengesankan.',
        ],
        [
            'title'  => 'Angklung Masal Nusantara',
            'anchor' => 'angklung-masal',
            'cat'    => 'Experience',
            'dur'    => '7 Menit',
            'imgs'   => ['Angklungmasal.webp', 'ANGKLUNGMASSAL.webp'],
            'desc'   => 'Angklung Massal Nusantara adalah representasi kecil dari keanekaragaman kebudayaan yang dimiliki Indonesia. Saung Angklung Udjo menghadirkan beragam tarian yang mencerminkan tradisi masing-masing daerah, dilengkapi dengan pakaian adat yang otentik, dan dipersembahkan dengan iringan alunan melodis dari angklung.',
        ],
        [
            'title'  => 'Angklung Interaktif',
            'anchor' => 'angklung-interaktif',
            'cat'    => 'Experience',
            'dur'    => '20 Menit',
            'imgs'   => ['Interaktif_Angklung.webp', 'Interaktifangklung2.jpg', 'Interaktifangklung3.jpg'],
            'desc'   => 'Bermain Angklung Bersama adalah sesi yang mengajak penonton untuk menyelami keajaiban dari memainkan angklung. Instruktur Angklung yang berpengalaman akan mengajarkan dasar-dasar cara bermain angklung, mulai dari mengenali nada-nada yang ada, cara menggoyangkan angklung untuk menghasilkan suara, hingga memainkan beberapa lagu, sehingga penonton dapat merasakan langsung keunikan dari alat musik tradisional ini.',
        ],
        [
            'title'  => 'Trio Angklung',
            'anchor' => 'trio-angklung',
            'cat'    => 'Modern',
            'dur'    => '5 Menit',
            'imgs'   => ['Trioangklung.webp', 'trioangklung2.webp', 'trioangklung3.webp', 'trioangklung4.webp'],
            'desc'   => 'Trio Angklung merupakan penampilan khusus yang dipersembahkan oleh murid-murid senior Saung Angklung Udjo. Trio Angklung menggabungkan Arumba dan inovasi instrumen "Angklung Toel" — set Angklung tepuk/pukul. Kolaborasi ini menciptakan aransemen musik yang indah, menonjolkan keunikan bunyi Angklung yang resonan dan harmonis.',
        ],
        [
            'title'  => 'Menari Bersama',
            'anchor' => 'menari-bersama',
            'cat'    => 'Experience',
            'dur'    => '7 Menit',
            'imgs'   => ['MenariBersama.webp'],
            'desc'   => 'Di akhir pertunjukan, murid-murid Saung Angklung Udjo tidak sekadar menampilkan kepiawaian mereka bermain angklung. Mereka juga akan membagi kebahagiaan dengan mengajak para penonton untuk berdiri dan menari bersama. Kehangatan dan keakraban dalam sesi ini menjadi penutup yang sempurna untuk petualangan budaya di Saung Angklung Udjo.',
        ],
    ];
@endphp

@foreach ($performances as $index => $item)
<div class="row-separator"></div>

<section id="{{ $item['anchor'] }}"
         class="perf-row {{ $index % 2 !== 0 ? 'reverse' : '' }}">

    {{-- ── Image Panel ── --}}
    <div class="perf-image reveal">
        <div class="swiper performanceSwiper" style="width:100%;height:100%;">
            <div class="swiper-wrapper">
                @foreach($item['imgs'] as $photo)
                <div class="swiper-slide">
                    <img src="{{ asset('img/' . $photo) }}"
                         onerror="this.src='https://images.unsplash.com/photo-1544967082-d9d25d867d66?q=80&w=1200'"
                         alt="{{ $item['title'] }}">
                </div>
                @endforeach
            </div>
            @if(count($item['imgs']) > 1)
            <div class="swiper-pagination" style="bottom:1.5rem;"></div>
            @endif
        </div>

        {{-- Big watermark index --}}
        <span class="perf-index">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
    </div>

    {{-- ── Text Panel ── --}}
    <div class="perf-text reveal reveal-delay-1">
        <p class="perf-eyebrow">{{ $item['cat'] }}</p>
        <h2 class="perf-title">{{ $item['title'] }}</h2>
        <div class="perf-divider"></div>
        <p class="perf-desc">{{ $item['desc'] }}</p>
        <span class="perf-dur-badge">{{ $item['dur'] }}</span>
    </div>

</section>
@endforeach

<div class="row-separator"></div>


{{-- ══════════════════════════════════════════
     4. CTA
══════════════════════════════════════════ --}}
<section class="perf-cta-section">
    <div class="cta-bg">
        <img src="{{ asset('img/performance.jpg') }}" alt="">
        <div class="absolute inset-0"
             style="background:linear-gradient(to bottom, rgba(26,20,69,0.7), rgba(26,20,69,0.5), rgba(26,20,69,0.8));"></div>
    </div>

    <div class="cta-content reveal">
        <p style="font-size:9px;font-weight:800;letter-spacing:0.5em;text-transform:uppercase;
                  color:rgba(196,164,124,0.7);margin-bottom:1.5rem;">Reservasi</p>
        <h2 class="font-editorial italic mb-4"
            style="font-size:clamp(2.5rem,6vw,5.5rem);color:white;line-height:1.1;
                   letter-spacing:-0.02em;">
            Siap merasakan<br>
            <span style="color:var(--gold-premium);">keharmonisan bambu?</span>
        </h2>
        <p style="color:rgba(255,255,255,0.5);font-weight:300;font-size:1rem;
                  margin-bottom:3rem;max-width:38ch;margin-left:auto;margin-right:auto;line-height:1.8;">
            Hubungi kami untuk informasi jadwal & reservasi pertunjukan eksklusif.
        </p>
        <a href="#" class="perf-cta-btn">
            <span>Hubungi Kami</span>
            <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>


{{-- ══════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════ --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ── Swiper for each performance ── */
    document.querySelectorAll('.performanceSwiper').forEach(el => {
        new Swiper(el, {
            loop: true,
            speed: 1200,
            autoplay: { delay: 3500, disableOnInteraction: false },
            effect: 'fade',
            fadeEffect: { crossFade: true },
            pagination: {
                el: el.querySelector('.swiper-pagination'),
                clickable: true,
            },
        });
    });

    /* ── Reveal on scroll ── */
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) entry.target.classList.add('active');
        });
    }, { threshold: 0.1 });
    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

    /* ── Auto-scroll to anchor ── */
    const hash = window.location.hash;
    if (hash) {
        setTimeout(() => {
            const target = document.querySelector(hash);
            if (target) target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 400);
    }

    /* ── Unmute toggle ── */
    const video = document.getElementById('heroVideo');
    const btn   = document.getElementById('unmuteBtn');
    let muted = true;

    const iconMuted = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2"/></svg>`;
    const iconUnmuted = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"/></svg>`;

    btn.addEventListener('click', () => {
        muted = !muted;
        video.muted = muted;
        btn.innerHTML = muted ? iconMuted : iconUnmuted;
    });
});
</script>
@endpush

@endsection