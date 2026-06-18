<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">

<head>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
     <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <!-- Alpine.js Core -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        /* --- FIX WHATSAPP FLASH (FOUC) --- */
        /* Dipasang di sini agar browser langsung menyembunyikan kotak putih saat refresh */
        #wa-float,
        #wa-popup {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        /* Class pemicu saat di-scroll */
        #wa-float.wa-muncul {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translateY(0) !important;
        }

        /* Class pemicu saat popup dibuka */
        #wa-popup.wa-terbuka {
            opacity: 1 !important;
            visibility: visible !important;
            pointer-events: auto !important;
            transform: translateY(0) scale(1) !important;
        }
    </style>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.analytics')
    <title>@yield('title', 'Authentic Experience') - Saung Angklung Udjo</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon">

    {{-- Fonts Premium --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Spirax&family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
    
    
        #mobile-nav {
            display: none;
            transform: translateX(100%);
        }

        :root {
            --v-indigo: #1a1445;
            --v-gold: #c4a47c;
            --v-maroon: #7d002a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            overflow-x: hidden;
            background-color: #fff;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--v-indigo);
            -webkit-font-smoothing: antialiased;
        }

        .font-editorial {
            font-family: 'Libre Baskerville', serif;
        }

        .font-spirax {
            font-family: 'Spirax', cursive;
        }

        #navbar {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            width: 100%;
            z-index: 100;
        }

        .nav-transparent {
            background: transparent;
            padding: 30px 0;
        }

     .nav-solid {
    background: rgba(255, 255, 255, 0.98);
    padding: 15px 0;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
}
        .mega-menu {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100vw;
            background: white;
            color: var(--v-indigo);
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s ease;
            transform: translateY(5px);
            border-top: 1px solid #f1f1f1;
            box-shadow: 0 40px 80px rgba(0, 0, 0, 0.1);
            pointer-events: none;
        }

        .mega-menu.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        .nav-link-main {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            padding: 10px 0;
            cursor: pointer;
            transition: color 0.3s;
            position: relative;
        }

        .nav-link-main.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--v-gold);
        }

        .nav-link-sub {
            font-size: 13px;
            font-weight: 400;
            color: rgba(26, 20, 69, 0.6);
            transition: all 0.3s ease;
            display: block;
        }

        .nav-link-sub:hover {
            color: var(--v-gold);
            transform: translateX(5px);
        }

        .mega-title {
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: var(--v-gold);
            margin-bottom: 1.5rem;
            display: block;
        }

        .nav-solid .lang-dropdown-btn {
            background: rgba(26, 20, 69, 0.1);
            border-color: rgba(26, 20, 69, 0.2);
            color: #1a1445;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--v-indigo);
        }

        /* Social Media Icons Hover Effect */
        .social-icon {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .social-icon:hover {
            transform: translateY(-3px) scale(1.1);
        }

        .social-icon:hover svg {
            filter: drop-shadow(0 4px 8px rgba(196, 164, 124, 0.4));
        }
    </style>
    @stack('styles')


</head>

<body class="antialiased">
    @php $currentLocale = app()->getLocale(); @endphp
    
    

    <nav id="navbar" class="fixed top-0 w-full {{ request()->routeIs('visitor.login') ? 'nav-solid' : 'nav-transparent' }}">
        <div class="max-w-[1500px] mx-auto px-8 md:px-12 flex lg:grid lg:grid-cols-3 justify-between items-center">
            
            {{-- LOGO - Kolom Kiri --}}
            <a href="{{ route('home', $currentLocale) }}" class="flex items-center gap-5 group shrink-0">
                <div class="w-12 h-12 overflow-hidden group-hover:scale-105 transition-transform duration-500">
                    <img src="{{ asset('images/UdjoFullColor.webp') }}" alt="Logo"
                        class="w-full h-full object-contain drop-shadow-xl">
                </div>
                <div class="flex flex-col">
                    <span class="font-spirax font-bold text-xl transition-colors duration-500 text-white"
                        id="brand-name">Saung Angklung Udjo</span>
                    <span class="text-[9px] uppercase tracking-[0.4em] font-bold text-white"
                        id="brand-sub">{{ t('tagline') }}</span>
                </div>
            </a>

            {{-- DESKTOP NAVIGATION - Kolom Tengah (Heritage, Experience, Visit Us, Stories ONLY) --}}
            <div class="hidden lg:flex items-center gap-6 justify-center">

                {{-- HERITAGE --}}
                <div class="nav-group">
                    <div class="nav-link-main text-white" id="l1">{{ t('heritage') }}</div>
                    <div class="mega-menu">
                        <div class="max-w-[1300px] mx-auto grid grid-cols-4 p-16 gap-12 text-left">
                            <div>
                                <span class="mega-title font-editorial text-amber-600">{{ t('the_legend') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('heritage.history') }}"
                                            class="nav-link-sub font-medium">{{ t('sejarah_profile') }}</a></li>
                                    <li><a href="{{ route('heritage.vision-mission') }}"
                                            class="nav-link-sub font-medium">{{ t('vision_mission') }}</a></li>
                                </ul>
                            </div>
                            <div>
                                <span class="mega-title font-editorial text-amber-600">{{ t('angklung') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('heritage.angklung') }}"
                                            class="nav-link-sub">{{ t('angklung_history') }}</a></li>
                                    <li><a href="{{ route('heritage.jenis-angklung') }}"
                                            class="nav-link-sub font-medium">{{ t('angklung_types') }}</a></li>
                                    <li><a href="{{ route('heritage.craftsmanship') }}" class="nav-link-sub">{{ t('how_to_make') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- EXPERIENCE --}}
                <div class="nav-group">
                    <div class="nav-link-main text-white" id="l2">{{ t('experience') }}</div>
                    <div class="mega-menu">
                        <div class="max-w-[1300px] mx-auto grid grid-cols-4 p-16 gap-12 text-left">
                            <div>
                                <span class="mega-title font-editorial">{{ t('attractions') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('experience.performances', $currentLocale) }}"
                                            class="nav-link-sub">{{ t('indoor_performance') }}</a></li>
                                                  <li><a href="{{ route('experience.performancesoutdoor') }}"
                                            class="nav-link-sub">{{ t('outdoor_performance') }}</a></li>
                                    <li><a href="{{ route('heritage.achievements') }}"
                                            class="nav-link-sub">{{ t('achievements') }}</a></li>
                                </ul>
                            </div>
                            <div>
                                <span class="mega-title font-editorial">{{ t('craftsmanship') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('experience.souvenir') }}"
                                            class="nav-link-sub">{{ t('souvenir_shop') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- VISIT US --}}
                <div class="nav-group">
                    <div class="nav-link-main text-white" id="l3">{{ t('visit_us') }}</div>
                    <div class="mega-menu">
                        <div class="max-w-[1300px] mx-auto grid grid-cols-4 p-16 gap-12 text-left">
                            <div>
                                <span class="mega-title font-editorial">{{ t('booking') }}</span>
                                <ul class="space-y-4 font-bold">
                                    <li><a href="{{ route('contact') }}"
                                            class="nav-link-sub">{{ t('reservation_info') }}</a></li>
                                    <li><a href="{{ route('heritage.venue') }}"
                                            class="nav-link-sub">{{ t('venue_site') }}</a></li>
                                    <li><a href="{{ route('experience.banguet') }}"
                                            class="nav-link-sub">{{ t('banquet') }}</a></li>
                                </ul>
                            </div>
                            <div>
                                <span class="mega-title font-editorial">{{ t('city_guide') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('Visitus.hotel') }}"
                                            class="nav-link-sub">{{ t('hotels') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- STORIES --}}
                <div class="nav-group">
                    <div class="nav-link-main text-white" id="l4">{{ t('stories') }}</div>
                    <div class="mega-menu">
                        <div class="max-w-[1300px] mx-auto grid grid-cols-4 p-16 gap-12 text-left">
                            <div>
                                <span class="mega-title font-editorial">{{ t('media_center') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('articles.index', $currentLocale) }}"
                                            class="nav-link-sub">{{ t('news_events') }}</a></li>
                                </ul>
                            </div>
                            <div>
                                <span class="mega-title font-editorial">{{ t('creative') }}</span>
                                <ul class="space-y-4">
                                    <li><a href="{{ route('gallery.index', $currentLocale) }}"
                                            class="nav-link-sub">Gallery</a></li>
                                </ul>
                            </div>
                            <div>
                                <span class="mega-title font-editorial">{{ t('assets') }}</span>
                                <ul class="space-y-4 font-medium">
                                    <li><a href="https://drive.google.com/file/d/1A579hR3y0xP5yEW-r78hEDXFW26BQsG1/view?usp=sharing"
                                            class="nav-link-sub">{{ t('ebrochure') }}</a></li>
                                    <li><a href="https://drive.google.com/file/d/1RGZKVynjb8PKu7kaQRYtFMnXImc0eOph/view?usp=sharing"
                                            class="nav-link-sub">{{ t('downloads_hub') }}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- LANGUAGE & CTA - Kolom Kanan --}}
            <div class="hidden lg:flex items-center gap-4 justify-end">
                {{-- LANGUAGE --}}
                <div class="relative inline-block" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="lang-dropdown-btn flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-blur-sm border border-white/20 transition-all text-white"
                        id="lang-dropdown-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                        </svg>
                        <span class="font-medium">{{ strtoupper(app()->getLocale()) }}</span>
                        <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" x-transition x-cloak
                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl overflow-hidden z-50">
                        <a href="{{ route('language.switch', 'id') }}"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-amber-50 {{ app()->getLocale() === 'id' ? 'bg-amber-100 text-amber-800' : 'text-gray-700' }}"><span
                                class="text-2xl">🇮🇩</span>Bahasa Indonesia</a>
                        <a href="{{ route('language.switch', 'en') }}"
                            class="flex items-center gap-3 px-4 py-3 hover:bg-amber-50 {{ app()->getLocale() === 'en' ? 'bg-amber-100 text-amber-800' : 'text-gray-700' }}"><span
                                class="text-2xl">🇬🇧</span>English</a>
                    </div>
                </div>

{{-- 
    Ganti bagian @auth di layouts.app 
    (cari: @auth ... @else ... @endauth di navbar)
    dengan kode di bawah ini:
--}}

@auth
    @if(auth()->user()->role === 'visitor')
    <div class="relative" x-data="{ open: false }">

        {{-- Trigger button --}}
        <button @click="open = !open" @click.away="open = false"
            class="flex items-center gap-2.5 px-3 py-1.5 rounded-full border transition-all duration-300"
            :class="open
                ? 'bg-white/15 border-white/30'
                : 'bg-white/10 hover:bg-white/15 border-white/20'"
            id="user-dropdown-btn">

            {{-- Avatar --}}
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" alt="avatar"
                    class="w-7 h-7 rounded-full border border-white/30 object-cover">
            @else
                <div class="w-7 h-7 rounded-full border border-amber-400/40 bg-indigo-900 flex items-center justify-center text-[11px] font-bold text-amber-400">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif

            {{-- Name --}}
            <span class="text-white text-[11px] font-semibold tracking-wide max-w-[90px] truncate" id="user-nav-name">
                {{ explode(' ', auth()->user()->name)[0] }}
            </span>

           {{-- Chevron --}}
<svg id="user-chevron" class="w-3.5 h-3.5 transition-transform duration-300"
    :class="{ 'rotate-180': open }"
    style="stroke: rgba(255,255,255,0.5)"
    fill="none" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
</svg>
        </button>

        {{-- Dropdown --}}
        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
            class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-50"
            style="top: 100%;">

            {{-- Profile header --}}
            <div class="px-4 py-4 bg-gradient-to-br from-[#1a1445] to-[#22185d] relative overflow-hidden">
                <div class="absolute inset-0 opacity-20"
                    style="background-image: repeating-linear-gradient(45deg, transparent 0, transparent 10px, rgba(196,164,124,.15) 10px, rgba(196,164,124,.15) 11px);">
                </div>
                <div class="relative flex items-center gap-3">
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="avatar"
                            class="w-11 h-11 rounded-full border-2 border-amber-400/40 object-cover">
                    @else
                        <div class="w-11 h-11 rounded-full border-2 border-amber-400/40 bg-indigo-800 flex items-center justify-center text-base font-bold text-amber-400">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                        @php
                            $emailRaw = auth()->user()->email ?? '';
                            $showEmail = str_contains($emailRaw, '@wa.local') ? null : $emailRaw;
                            $phone = auth()->user()->phone ?? null;
                        @endphp
                        <p class="text-white/40 text-[10px] truncate mt-0.5">
                            {{ $showEmail ?? ($phone ? $phone : 'Pengunjung') }}
                        </p>
                        {{-- Login via badge --}}
                        @if(auth()->user()->google_id)
                            <span class="inline-flex items-center gap-1 mt-1.5 text-[9px] font-bold tracking-wider uppercase px-2 py-0.5 rounded-full bg-blue-500/20 text-blue-300">
                                <svg class="w-2.5 h-2.5" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                                Google
                            </span>
                        @elseif(auth()->user()->phone)
                            <span class="inline-flex items-center gap-1 mt-1.5 text-[9px] font-bold tracking-wider uppercase px-2 py-0.5 rounded-full bg-green-500/20 text-green-300">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/></svg>
                                WhatsApp
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 mt-1.5 text-[9px] font-bold tracking-wider uppercase px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300">
                                Email
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Menu items --}}
            <div class="py-2">
                <a href="/dashboard"
                    class="flex items-center gap-3 px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-amber-100 flex items-center justify-center transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-500 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </div>
                    Dashboard
                </a>

                <a href="/tiket-b1g1"
                    class="flex items-center gap-3 px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-amber-100 flex items-center justify-center transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-500 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                        </svg>
                    </div>
                    Beli Tiket
                </a>

                <a href="/#jadwal-pertunjukan"
                    class="flex items-center gap-3 px-4 py-2.5 text-[13px] font-medium text-gray-700 hover:bg-amber-50 hover:text-amber-700 transition-colors group">
                    <div class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-amber-100 flex items-center justify-center transition-colors">
                        <svg class="w-3.5 h-3.5 text-gray-500 group-hover:text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    Jadwal Pertunjukan
                </a>
            </div>

            {{-- Divider + Logout --}}
            <div class="border-t border-gray-100 py-2">
                <form method="POST" action="/logout-visitor">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-[13px] font-medium text-red-500 hover:bg-red-50 transition-colors group text-left">
                        <div class="w-7 h-7 rounded-lg bg-gray-100 group-hover:bg-red-100 flex items-center justify-center transition-colors">
                            <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </div>
                        Keluar dari Akun
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif
@else
<a href="/visitor/login" id="login-nav-btn"
   class="flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 backdrop-filter backdrop-blur border border-white/20 transition-all text-white font-medium text-sm">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
    </svg>
    Login
</a>
@endauth
                
                 <a href="{{ route('tickets.buy') }}" id="nav-cta"
                    class="bg-white text-indigo-900 px-8 py-3 text-[10px] font-bold uppercase tracking-widest hover:bg-[var(--v-gold)] hover:text-white transition-all shadow-xl shrink-0">Book Now</a>
            </div>

            {{-- MOBILE BUTTON --}}
            <button onclick="toggleMobileNav(true)" class="lg:hidden text-white justify-self-end" id="mobile-btn">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M4 8h16M4 16h16" stroke-width="2" />
                </svg>
            </button>
        </div>
    </nav>

    <main class="w-full">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer class="bg-[#1a1445] text-white pt-32 pb-16 w-full">
        <div class="max-w-[1400px] mx-auto px-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-16 mb-24">
                <div class="md:col-span-4 space-y-8">
                    <a href="{{ route('home', $currentLocale) }}" class="flex items-center gap-5 group shrink-0">
                        <div class="w-12 h-12 overflow-hidden group-hover:scale-105 transition-transform duration-500">
                            <img src="{{ asset('images/UdjoFullColor.webp') }}" alt="Logo"
                                class="w-full h-full object-contain drop-shadow-xl">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-spirax font-bold text-xl text-white">Saung Angklung Udjo</span>
                            <span
                                class="text-[8px] text-white/60 uppercase tracking-[0.4em]">{{ t('tagline') }}</span>
                        </div>
                    </a>
                    <p class="text-sm text-white/40 leading-loose max-w-sm font-light">{{ t('description') }}</p>
                </div>
                <div class="md:col-span-2">
                    <h4 class="text-[10px] font-bold tracking-[0.4em] uppercase text-amber-500 mb-10">WISATA BUDAYA
                    </h4>
                    <ul class="space-y-5 text-sm text-white/60">
                        <li><a href="#" class="hover:text-white transition">{{ t('heritage') }}</a></li>
                        <li><a href="#" class="hover:text-white transition">{{ t('experience') }}</a></li>
                    </ul>
                </div>
                <div class="md:col-span-3">
                    <h4 class="text-[10px] font-bold tracking-[0.4em] uppercase text-amber-500 mb-10">
                        {{ t('connect') }}</h4>
                    <ul class="space-y-5 text-sm text-white/60 italic font-light">
                        <li>{{ t('address') }}</li>
                        <li>+62 821 8282 1200</li>
                        <li>info@angklung-udjo.co.id</li>
                    </ul>
                </div>
                <div class="md:col-span-3">
                    <h4 class="text-[10px] font-bold tracking-[0.4em] uppercase text-amber-500 mb-10">
                        {{ t('follow') }}</h4>
                    <div class="flex gap-6">
                        {{-- Instagram --}}
                        <a href="https://www.instagram.com/angklungudjo/" target="_blank" rel="noopener noreferrer"
                            class="social-icon w-10 h-10 flex items-center justify-center rounded-full bg-white/5 hover:bg-amber-500/20 border border-white/10 hover:border-amber-500/50"
                            aria-label="Instagram">
                            <svg class="w-5 h-5 text-white/60 hover:text-amber-500 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>

                        {{-- TikTok --}}
                        <a href="https://www.tiktok.com/@saungangklungudjo" target="_blank" rel="noopener noreferrer"
                            class="social-icon w-10 h-10 flex items-center justify-center rounded-full bg-white/5 hover:bg-amber-500/20 border border-white/10 hover:border-amber-500/50"
                            aria-label="TikTok">
                            <svg class="w-5 h-5 text-white/60 hover:text-amber-500 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                            </svg>
                        </a>

                        {{-- YouTube --}}
                        <a href="https://www.youtube.com/@saungangklungudjo" target="_blank" rel="noopener noreferrer"
                            class="social-icon w-10 h-10 flex items-center justify-center rounded-full bg-white/5 hover:bg-amber-500/20 border border-white/10 hover:border-amber-500/50"
                            aria-label="YouTube">
                            <svg class="w-5 h-5 text-white/60 hover:text-amber-500 transition-colors" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="pt-12 border-t border-white/5">
                <p class="text-[9px] tracking-[0.4em] uppercase opacity-20">&copy; {{ date('Y') }}
                    {{ t('rights') }}</p>
            </div>
        </div>
    </footer>

{{-- MOBILE NAVIGATION (LENGKAP SEPERTI DESKTOP) --}}
<div id="mobile-nav"
    class="fixed inset-0 bg-[#1a1445] z-[200] translate-x-full flex flex-col transition-transform duration-700 overflow-hidden">
    
    {{-- Header with Language & Close --}}
    <div class="flex justify-between items-center p-6 border-b border-white/10 flex-shrink-0">
        <div class="flex items-center gap-4 text-[10px] font-bold tracking-[0.3em] text-white">
            <a href="{{ route('language.switch', 'id') }}"
                class="transition-opacity {{ $currentLocale == 'id' ? 'text-amber-500' : 'opacity-40 hover:opacity-100' }}">ID</a>
            <span class="opacity-10 text-xs">|</span>
            <a href="{{ route('language.switch', 'en') }}"
                class="transition-opacity {{ $currentLocale == 'en' ? 'text-amber-500' : 'opacity-40 hover:opacity-100' }}">EN</a>
        </div>
        <button onclick="toggleMobileNav(false)"
            class="text-white p-2 hover:rotate-90 transition-transform duration-500">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M6 18L18 6M6 6l12 12" stroke-width="1.5" stroke-linecap="round" />
            </svg>
        </button>
    </div>

    {{-- Main Navigation - Scrollable --}}
    <div class="flex-1 overflow-y-auto px-6 py-8">
        
        {{-- Heritage Section --}}
        <div class="mb-8" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center justify-between w-full text-left mb-4">
                <span class="text-[11px] font-bold tracking-[0.3em] text-amber-500 uppercase">{{ t('heritage') }}</span>
               <svg class="w-5 h-5 text-white transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" x-collapse class="space-y-4 pl-4 mb-6">
                <a href="{{ route('heritage.history') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">Sejarah & Profile</a>
                <a href="{{ route('heritage.vision-mission') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">{{ t('vision_mission') }}</a>
                <a href="{{ route('heritage.angklung') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">{{ t('angklung_history') }}</a>
                <a href="{{ route('heritage.jenis-angklung') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">Jenis-Jenis Angklung</a>
                <a href="{{ route('heritage.craftsmanship') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">Cara Membuat</a>
            </div>
        </div>

        {{-- Experience Section --}}
        <div class="mb-8" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center justify-between w-full text-left mb-4">
                <span class="text-[11px] font-bold tracking-[0.3em] text-amber-500 uppercase">{{ t('experience') }}</span>
                <svg class="w-5 h-5 text-white transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
           <div x-show="open" x-collapse class="space-y-4 pl-4 mb-6">
                <a href="{{ route('experience.performances', $currentLocale) }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">Pertunjukan Dalam</a>
                <a href="{{ route('experience.performancesoutdoor') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">Pertunjukan Luar</a>
                <a href="{{ route('heritage.achievements') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">Pencapaian</a>
                <a href="{{ route('experience.souvenir') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">{{ t('souvenir_shop') }}</a>
            </div>
        </div>

        {{-- Visit Us Section --}}
        <div class="mb-8" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center justify-between w-full text-left mb-4">
                <span class="text-[11px] font-bold tracking-[0.3em] text-amber-500 uppercase">{{ t('visit_us') }}</span>
                <svg class="w-5 h-5 text-white transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" x-collapse class="space-y-4 pl-4 mb-6">
                <a href="{{ route('contact') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">{{ t('reservation_info') }}</a>
                <a href="{{ route('heritage.venue') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">{{ t('venue_site') }}</a>
                <a href="{{ route('experience.banguet') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">{{ t('banquet') }}</a>
                <a href="{{ route('Visitus.hotel') }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">{{ t('hotels') }}</a>
            </div>
        </div>

        {{-- Stories Section --}}
        <div class="mb-8" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center justify-between w-full text-left mb-4">
                <span class="text-[11px] font-bold tracking-[0.3em] text-amber-500 uppercase">{{ t('stories') }}</span>
                <svg class="w-5 h-5 text-white transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open" x-collapse class="space-y-4 pl-4 mb-6">
                <a href="{{ route('articles.index', $currentLocale) }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">{{ t('news_events') }}</a>
                <a href="{{ route('gallery.index', $currentLocale) }}" class="block text-white/70 hover:text-white text-sm transition-colors py-2">Gallery</a>
                <a href="https://drive.google.com/file/d/1A579hR3y0xP5yEW-r78hEDXFW26BQsG1/view?usp=sharing" target="_blank" class="block text-white/70 hover:text-white text-sm transition-colors py-2">{{ t('ebrochure') }}</a>
                <a href="https://drive.google.com/file/d/1RGZKVynjb8PKu7kaQRYtFMnXImc0eOph/view?usp=sharing" target="_blank" class="block text-white/70 hover:text-white text-sm transition-colors py-2">{{ t('downloads_hub') }}</a>
            </div>
        </div>

    </div>

    {{-- Footer CTA --}}
    <div class="p-6 border-t border-white/10 bg-black/10 flex-shrink-0">
        <a href="{{ route('contact', $currentLocale) }}"
            class="block w-full text-center py-4 bg-white text-indigo-950 font-bold text-[11px] tracking-[0.3em] uppercase transition-transform active:scale-95 rounded-lg">
            {{ t('Contact Now') }}
        </a>
    </div>
</div>

    {{-- WHATSAPP POPUP (3 ADMIN UTUH) --}}
    <div id="wa-popup" style="opacity: 0; visibility: hidden;"
        class="fixed bottom-32 right-10 z-[99] transform translate-y-4 scale-95">
        <div class="bg-white rounded-2xl shadow-2xl p-4 w-72">
            <div class="flex justify-between items-center mb-4 pb-3 border-b">
                <h3 class="font-bold text-gray-800 text-sm">{{ t('title') }}</h3>
                <button id="close-popup" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <a href="https://wa.me/6282182821200" target="_blank"
                class="flex items-center gap-3 p-3 rounded-xl hover:bg-green-50 transition-all duration-200 group mb-2">
                <div
                    class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 text-sm">{{ t('admin_1_name') }}</p>
                    <p class="text-xs text-gray-500">{{ t('admin_1_desc') }}</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-[#25D366] group-hover:translate-x-1 transition-all"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            <a href="https://wa.me/628112124050" target="_blank"
                class="flex items-center gap-3 p-3 rounded-xl hover:bg-green-50 transition-all duration-200 group mb-2">
                <div
                    class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 text-sm">{{ t('admin_2_name') }}</p>
                    <p class="text-xs text-gray-500">{{ t('admin_2_desc') }}</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-[#25D366] group-hover:translate-x-1 transition-all"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            <a href="https://wa.me/6289665285200" target="_blank"
                class="flex items-center gap-3 p-3 rounded-xl hover:bg-green-50 transition-all duration-200 group">
                <div
                    class="w-12 h-12 bg-[#25D366] rounded-full flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-800 text-sm">{{ t('souvenir_name') }}</p>
                    <p class="text-xs text-gray-500">{{ t('souvenir_desc') }}</p>
                </div>
                <svg class="w-5 h-5 text-gray-400 group-hover:text-[#25D366] group-hover:translate-x-1 transition-all"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>
    </div>

    {{-- WA FLOAT BUTTON --}}
    <button id="wa-float" style="opacity: 0; visibility: hidden;"
        class="fixed bottom-10 right-10 z-[100] group flex items-center gap-4 translate-y-6">
        <span
            class="bg-white text-indigo-950 px-6 py-3 text-[10px] font-bold tracking-widest uppercase shadow-2xl hidden md:block">{{ t('admin_wa') }}</span>
        <div
            class="w-16 h-16 bg-[#25D366] text-white rounded-full flex items-center justify-center shadow-[0_15px_30px_rgba(37,211,102,0.3)] transition-transform group-hover:scale-110 cursor-pointer">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.335-1.662c1.72.937 3.659 1.432 5.631 1.433h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
            </svg>
        </div>
    </button>

   <script>
    const navbar = document.getElementById('navbar');
    const navGroups = document.querySelectorAll('.nav-group');
    const brand = document.getElementById('brand-name');
    const sub = document.getElementById('brand-sub');
    const cta = document.getElementById('nav-cta');
    const mob = document.getElementById('mobile-btn');
    const links = ['l1', 'l2', 'l3', 'l4'].map(id => document.getElementById(id));
    const waFloat = document.getElementById('wa-float');
    const waPopup = document.getElementById('wa-popup');

    const isAuthPage = {{ request()->routeIs('visitor.login') ? 'true' : 'false' }};
    let isScrolled = false;
    let activeMegaMenu = null;

    function updateNavbar() {
        const shouldBeSolid = isScrolled || activeMegaMenu !== null;
        
        if (shouldBeSolid) {
            navbar.classList.remove('nav-transparent');
            navbar.classList.add('nav-solid');
            updateNavColors('solid');
        } else {
            navbar.classList.remove('nav-solid');
            navbar.classList.add('nav-transparent');
            updateNavColors('transparent');
        }
    }

  
    function updateNavColors(state) {
    const chevron = document.getElementById('user-chevron');
    const userBtn = document.getElementById('user-dropdown-btn');
    const userName = document.getElementById('user-nav-name');
    const loginBtn = document.getElementById('login-nav-btn');

    if (state === 'solid') {
        brand.style.color = '#1a1445';
        sub.style.color = 'rgba(26, 20, 69, 0.4)';
        if (mob) mob.style.color = '#1a1445';
        cta.classList.add('bg-[#1a1445]', 'text-white');
        cta.classList.remove('bg-white', 'text-indigo-900');
        links.forEach(l => { if (l) l.style.color = '#1a1445'; });

        if (loginBtn) {
            loginBtn.style.background = 'rgba(26,20,69,0.08)';
            loginBtn.style.borderColor = 'rgba(26,20,69,0.2)';
            loginBtn.style.color = '#1a1445';
        }
        if (userBtn) {
            userBtn.style.background = 'rgba(26,20,69,0.08)';
            userBtn.style.borderColor = 'rgba(26,20,69,0.2)';
        }
        if (userName) userName.style.color = '#1a1445';
        if (chevron) chevron.style.stroke = 'rgba(26,20,69,0.4)';

    } else {
        brand.style.color = 'white';
        sub.style.color = 'rgba(255, 255, 255, 0.6)';
        if (mob) mob.style.color = 'white';
        cta.classList.remove('bg-[#1a1445]', 'text-white');
        cta.classList.add('bg-white', 'text-indigo-900');
        links.forEach(l => { if (l) l.style.color = 'white'; });

        if (loginBtn) {
            loginBtn.style.background = 'rgba(255,255,255,0.1)';
            loginBtn.style.borderColor = 'rgba(255,255,255,0.2)';
            loginBtn.style.color = 'white';
        }
        if (userBtn) {
            userBtn.style.background = 'rgba(255,255,255,0.1)';
            userBtn.style.borderColor = 'rgba(255,255,255,0.2)';
        }
        if (userName) userName.style.color = 'white';
        if (chevron) chevron.style.stroke = 'rgba(255,255,255,0.5)';
    }
}


    function handleScroll() {
        isScrolled = isAuthPage || window.scrollY > 80;
        updateNavbar();
        
        if (waFloat) {
            if (window.scrollY > 80) {
                waFloat.classList.add('wa-muncul');
            } else {
                waFloat.classList.remove('wa-muncul');
                if (waPopup) waPopup.classList.remove('wa-terbuka');
            }
        }
    }

    function closeMegaMenu() {
        if (activeMegaMenu) {
            const megaMenu = activeMegaMenu.querySelector('.mega-menu');
            const navLink = activeMegaMenu.querySelector('.nav-link-main');
            if (megaMenu) megaMenu.classList.remove('active');
            if (navLink) navLink.classList.remove('active');
            activeMegaMenu = null;
            updateNavbar();
        }
    }

    navGroups.forEach(group => {
        const navLink = group.querySelector('.nav-link-main');
        const megaMenu = group.querySelector('.mega-menu');

        navLink.addEventListener('click', (e) => {
            e.stopPropagation();
            
            if (activeMegaMenu === group) {
                closeMegaMenu();
            } else {
                closeMegaMenu();
                megaMenu.classList.add('active');
                navLink.classList.add('active');
                activeMegaMenu = group;
                updateNavbar();
            }
        });

        megaMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                closeMegaMenu();
            });
        });
    });

    document.addEventListener('click', (e) => {
        if (activeMegaMenu && !e.target.closest('.nav-group')) {
            closeMegaMenu();
        }
    });

    function toggleMobileNav(open) {
        const mobileNav = document.getElementById('mobile-nav');
        if (!mobileNav) return;
        if (open) {
            mobileNav.style.display = 'flex';
            setTimeout(() => mobileNav.style.transform = 'translateX(0)', 10);
        } else {
            mobileNav.style.transform = 'translateX(100%)';
            setTimeout(() => mobileNav.style.display = 'none', 700);
        }
    }

    window.addEventListener('scroll', handleScroll);
    window.addEventListener('load', handleScroll);
    handleScroll();
    if (isAuthPage) updateNavColors('solid');

    if (waFloat) {
        waFloat.addEventListener('click', (e) => {
            e.preventDefault();
            waPopup.classList.toggle('wa-terbuka');
        });
    }
    document.getElementById('close-popup')?.addEventListener('click', () => {
        waPopup.classList.remove('wa-terbuka');
    });
    document.addEventListener('click', (e) => {
        if (waFloat && waPopup && !waFloat.contains(e.target) && !waPopup.contains(e.target)) {
            waPopup.classList.remove('wa-terbuka');
        }
    });
</script>
    @stack('scripts')
    @include('partials.cookie-consent')
    
</body>

</html>