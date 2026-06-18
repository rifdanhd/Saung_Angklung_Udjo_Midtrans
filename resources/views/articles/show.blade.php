@extends('layouts.app')

@section('title', $article->title)

@push('styles')
<style>
    /* ===== READING PROGRESS BAR ===== */
    #reading-progress {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        width: 0%;
        background: linear-gradient(90deg, #B8972A, #E8C547, #B8972A);
        z-index: 9999;
        transition: width 0.1s linear;
        box-shadow: 0 0 8px rgba(184, 151, 42, 0.6);
    }

    /* ===== TYPOGRAPHY ===== */
    .article-body {
        font-family: 'Georgia', 'Times New Roman', serif;
        font-size: 1.125rem;
        line-height: 1.9;
        color: #1e1b4b;
        font-weight: 400;
    }

    /* Drop cap pada paragraf pertama */
    .article-body p:first-of-type::first-letter {
        font-size: 4.5rem;
        font-weight: 700;
        float: left;
        line-height: 0.8;
        margin-right: 0.12em;
        margin-top: 0.08em;
        color: #1e1b4b;
        font-family: 'Georgia', serif;
    }

    .article-body p {
        margin-bottom: 1.75rem;
        text-align: justify;
        hyphens: auto;
        -webkit-hyphens: auto;
    }

    .article-body p + p {
        text-indent: 0;
    }

    /* ===== SHARE SIDEBAR ===== */
    .share-sidebar {
        position: sticky;
        top: 6rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .share-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.25s ease;
        border: 1.5px solid #e5e7eb;
        background: white;
        color: #374151;
        cursor: pointer;
    }

    .share-btn:hover {
        border-color: #1e1b4b;
        background: #1e1b4b;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(30, 27, 75, 0.2);
    }

    .share-btn.copied {
        border-color: #059669;
        background: #059669;
        color: white;
    }

    .share-divider {
        width: 1px;
        height: 24px;
        background: #e5e7eb;
    }

    /* ===== RELATED ARTICLES ===== */
    .related-card {
        transition: all 0.3s ease;
    }

    .related-card:hover {
        transform: translateY(-4px);
    }

    .related-card:hover .related-img {
        transform: scale(1.05);
    }

    .related-img {
        transition: transform 0.5s ease;
    }

    /* ===== IMAGE CAPTION ===== */
    .img-caption {
        font-size: 0.8rem;
        color: #6b7280;
        text-align: center;
        font-style: italic;
        margin-top: 0.5rem;
        padding: 0 1rem;
    }

    /* Scrollbar hide utility */
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

    /* ===== MOBILE SHARE BAR ===== */
    .share-mobile {
        display: none;
    }

    @media (max-width: 768px) {
        .share-sidebar-wrapper { display: none; }
        .share-mobile { display: flex; }
        .article-body { font-size: 1rem; }
        .article-body p:first-of-type::first-letter {
            font-size: 3.5rem;
        }
    }
</style>
@endpush

@section('content')

{{-- Reading Progress Bar --}}
<div id="reading-progress"></div>

<article class="relative pt-40 pb-20 bg-[#F7F7F2]">

    {{-- Background layer untuk navbar --}}
    <div class="absolute top-0 left-0 w-full h-40 bg-gradient-to-b from-indigo-950 to-transparent"></div>

    <div class="relative max-w-6xl mx-auto px-6">

        {{-- Grid: sidebar kiri | konten | sidebar kanan --}}
        <div class="grid grid-cols-1 lg:grid-cols-[64px_1fr_64px] xl:grid-cols-[80px_1fr_80px] gap-6 xl:gap-10">

            {{-- ===== SHARE SIDEBAR KIRI ===== --}}
            <div class="share-sidebar-wrapper hidden lg:block">
                <div class="share-sidebar" style="margin-top: 12rem;">
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400 rotate-[-90deg] whitespace-nowrap mb-2" style="writing-mode: vertical-rl; transform: rotate(180deg); letter-spacing: 0.15em;">Share</span>
                    <div class="share-divider"></div>

                    {{-- Twitter/X --}}
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}"
                       target="_blank" rel="noopener"
                       class="share-btn" title="Share ke X / Twitter">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.74l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>

                    {{-- Facebook --}}
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                       target="_blank" rel="noopener"
                       class="share-btn" title="Share ke Facebook">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>

                    {{-- WhatsApp --}}
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}"
                       target="_blank" rel="noopener"
                       class="share-btn" title="Share via WhatsApp">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </a>

                    {{-- LinkedIn --}}
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                       target="_blank" rel="noopener"
                       class="share-btn" title="Share ke LinkedIn">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                    </a>

                    <div class="share-divider"></div>

                    {{-- Copy Link --}}
                    <button onclick="copyLink(this)"
                            class="share-btn" title="Salin link">
                        <svg class="w-4 h-4" id="copy-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- ===== KONTEN UTAMA ===== --}}
            <div class="min-w-0">

                {{-- Header --}}
                <header class="mb-12">
                    <p class="text-gold-premium text-xs font-bold uppercase tracking-widest mb-4">
                        {{ $article->category }}
                    </p>
                    <h1 class="font-editorial text-4xl md:text-5xl lg:text-6xl text-indigo-950 leading-tight mb-6">
                        {{ $article->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-6">
                        <span>{{ $article->published_at ? $article->published_at->format('d F Y') : 'Draft' }}</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span>{{ $article->user->name ?? 'Admin' }}</span>
                        @if(!$article->isExternal() && $article->content)
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $article->reading_time }}
                            </span>
                        @endif
                    </div>

                    {{-- Mobile Share Bar --}}
                    <div class="share-mobile flex items-center gap-3 py-3 border-y border-gray-200">
                        <span class="text-xs font-bold uppercase tracking-widest text-gray-400 mr-1">Share</span>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}"
                           target="_blank" class="share-btn w-9 h-9">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.74l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}"
                           target="_blank" class="share-btn w-9 h-9">
                            <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </a>
                        <button onclick="copyLink(this)" class="share-btn w-9 h-9">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </button>
                    </div>
                </header>

                {{-- ===== CAROUSEL / FEATURED IMAGE ===== --}}
                @if($article->images->count() > 1)
                <div class="mb-2 -mx-6 md:mx-0 md:rounded-2xl overflow-hidden shadow-lg"
                     x-data="{
                        active: 0,
                        total: {{ $article->images->count() }},
                        autoplay: null,
                        touchStartX: 0,
                        touchEndX: 0,
                        start() {
                            this.autoplay = setInterval(() => {
                                this.active = (this.active + 1) % this.total
                            }, 4000)
                        },
                        stop() { clearInterval(this.autoplay) },
                        handleSwipe() {
                            const diff = this.touchStartX - this.touchEndX
                            if (Math.abs(diff) > 50) {
                                if (diff > 0) { this.active = (this.active + 1) % this.total }
                                else { this.active = (this.active - 1 + this.total) % this.total }
                                this.stop(); this.start()
                            }
                        }
                     }"
                     x-init="start()"
                     @mouseenter="stop()"
                     @mouseleave="start()"
                     @touchstart="touchStartX = $event.changedTouches[0].screenX"
                     @touchend="touchEndX = $event.changedTouches[0].screenX; handleSwipe()">

                    <div class="relative">
                        @foreach($article->images as $i => $img)
                        <div x-show="active === {{ $i }}"
                             x-transition:enter="transition ease-out duration-700"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-cloak>
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                 alt="{{ $article->title }} - foto {{ $i + 1 }}"
                                 class="w-full h-auto block">
                        </div>
                        @endforeach

                        <div class="absolute top-3 right-3 bg-black/50 text-white text-xs px-3 py-1 rounded-full backdrop-blur-sm">
                            <span x-text="active + 1"></span> / {{ $article->images->count() }}
                        </div>

                        <button @click="active = (active - 1 + total) % total; stop(); start()"
                                class="hidden md:flex absolute left-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white rounded-full w-11 h-11 items-center justify-center transition-all backdrop-blur-sm hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="active = (active + 1) % total; stop(); start()"
                                class="hidden md:flex absolute right-4 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white rounded-full w-11 h-11 items-center justify-center transition-all backdrop-blur-sm hover:scale-110">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>

                    <div class="flex justify-center gap-2 py-3 md:py-4 bg-white/80 backdrop-blur-sm">
                        @foreach($article->images as $i => $img)
                        <button @click="active = {{ $i }}; stop(); start()"
                                :class="active === {{ $i }} ? 'w-6 bg-indigo-950' : 'w-3 bg-gray-300 hover:bg-gray-400'"
                                class="h-3 rounded-full transition-all duration-300 touch-manipulation">
                        </button>
                        @endforeach
                    </div>

                    @if($article->images->count() <= 8)
                    <div class="flex gap-2 px-3 pb-3 md:px-4 md:pb-4 bg-white/80 overflow-x-auto scrollbar-hide">
                        @foreach($article->images as $i => $img)
                        <button @click="active = {{ $i }}"
                                :class="active === {{ $i }} ? 'ring-2 ring-indigo-950 ring-offset-1' : 'opacity-60 hover:opacity-100'"
                                class="flex-shrink-0 rounded-lg overflow-hidden transition-all touch-manipulation">
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                 alt="Thumbnail {{ $i + 1 }}"
                                 class="w-14 h-14 md:w-16 md:h-16 object-cover">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Caption untuk carousel --}}
                @if($article->image_caption ?? false)
                <p class="img-caption mb-10">{{ $article->image_caption }}</p>
                @else
                <p class="img-caption mb-10">{{ $article->title }} — Dokumentasi</p>
                @endif

                @elseif($article->images->count() === 1)
                <figure class="mb-10 rounded-2xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $article->images->first()->image_path) }}"
                         alt="{{ $article->title }}"
                         class="w-full h-auto object-cover">
                    @if($article->image_caption ?? false)
                    <figcaption class="img-caption py-3 bg-white/60">{{ $article->image_caption }}</figcaption>
                    @else
                    <figcaption class="img-caption py-3 bg-white/60">{{ $article->title }} — Dokumentasi</figcaption>
                    @endif
                </figure>

                @elseif($article->featured_image)
                <figure class="mb-10 rounded-2xl overflow-hidden shadow-lg">
                    <img src="{{ asset('storage/' . $article->featured_image) }}"
                         alt="{{ $article->title }}"
                         class="w-full h-auto object-cover">
                    @if($article->image_caption ?? false)
                    <figcaption class="img-caption py-3 bg-white/60">{{ $article->image_caption }}</figcaption>
                    @else
                    <figcaption class="img-caption py-3 bg-white/60">{{ $article->title }} — Dokumentasi</figcaption>
                    @endif
                </figure>
                @endif
                {{-- ===== END CAROUSEL ===== --}}

                {{-- Excerpt --}}
                @if($article->excerpt)
                <div class="mb-10 text-xl text-indigo-950/70 font-light italic border-l-4 border-gold-premium pl-6 py-2 leading-relaxed">
                    {{ $article->excerpt }}
                </div>
                @endif

                {{-- ===== CONTENT ===== --}}
                @if($article->isExternal())
                    <div class="bg-white border-2 border-gold-premium rounded-2xl p-10 text-center my-12">
                        <svg class="w-16 h-16 mx-auto mb-6 text-gold-premium" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        <p class="text-gray-600 mb-8 text-lg">Artikel ini dipublikasikan di sumber eksternal</p>
                        <a href="{{ $article->external_url }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center gap-3 bg-indigo-950 text-white px-10 py-5 rounded-xl hover:bg-gold-premium hover:text-indigo-950 transition-all duration-300 font-bold uppercase text-sm tracking-wider shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <span>Baca Artikel Lengkap</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                    </div>
                @else
                    {{-- Article body dengan drop cap + tipografi premium --}}
                    <div id="article-body" class="article-body">
                        @php
                            $paragraphs = array_filter(explode("\n\n", $article->content), fn($p) => trim($p) !== '');
                        @endphp
                        @foreach($paragraphs as $para)
                            <p>{{ trim($para) }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- ===== TAG / KATEGORI ===== --}}
                <div class="mt-12 flex items-center gap-3 flex-wrap">
                    <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Topik</span>
                    <span class="px-4 py-1.5 bg-indigo-950 text-white text-xs font-bold uppercase tracking-wider rounded-full">
                        {{ $article->category }}
                    </span>
                </div>

                {{-- ===== MOBILE SHARE BOTTOM ===== --}}
                <div class="mt-10 flex items-center gap-3 p-4 bg-white rounded-2xl border border-gray-100 shadow-sm md:hidden">
                    <span class="text-sm font-semibold text-gray-600 mr-2">Bagikan artikel ini:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($article->title) }}"
                       target="_blank" class="share-btn">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.74l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' ' . request()->url()) }}"
                       target="_blank" class="share-btn">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    </a>
                    <button onclick="copyLink(this)" class="share-btn ml-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    </button>
                </div>

                {{-- Back Button --}}
                <div class="mt-10 pt-8 border-t border-gray-200">
                    <a href="{{ route('articles.index') }}"
                       class="inline-flex items-center gap-2 text-sm font-bold uppercase tracking-wider text-indigo-950 hover:text-gold-premium transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Kembali ke Semua Artikel</span>
                    </a>
                </div>

            </div>
            {{-- ===== END KONTEN UTAMA ===== --}}

            {{-- Kolom kanan (kosong, untuk balance grid) --}}
            <div class="hidden lg:block"></div>

        </div>
        {{-- End grid --}}

    </div>
</article>

{{-- ===== RELATED ARTICLES ===== --}}
@if(isset($relatedArticles) && $relatedArticles->count() > 0)
<section class="bg-white py-16 border-t border-gray-100">
    <div class="max-w-6xl mx-auto px-6">

        <div class="flex items-center gap-4 mb-10">
            <div class="w-8 h-0.5 bg-gold-premium"></div>
            <h2 class="font-editorial text-2xl md:text-3xl text-indigo-950">Artikel Terkait</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($relatedArticles->take(3) as $related)
            <a href="{{ route('articles.show', $related->slug) }}" class="related-card group block">
                <div class="rounded-2xl overflow-hidden shadow-md bg-[#F7F7F2]">

                    {{-- Gambar --}}
                    @php
                        $thumb = $related->images->first()?->image_path ?? $related->featured_image;
                    @endphp
                    @if($thumb)
                    <div class="overflow-hidden h-48">
                        <img src="{{ asset('storage/' . $thumb) }}"
                             alt="{{ $related->title }}"
                             class="related-img w-full h-full object-cover">
                    </div>
                    @else
                    <div class="h-48 bg-indigo-950/10 flex items-center justify-center">
                        <svg class="w-10 h-10 text-indigo-950/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    @endif

                    <div class="p-5">
                        <p class="text-gold-premium text-xs font-bold uppercase tracking-widest mb-2">{{ $related->category }}</p>
                        <h3 class="font-editorial text-lg text-indigo-950 leading-snug mb-3 group-hover:text-gold-premium transition-colors line-clamp-2">
                            {{ $related->title }}
                        </h3>
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            <span>{{ $related->published_at ? $related->published_at->format('d F Y') : '' }}</span>
                            @if($related->reading_time && !$related->isExternal())
                                <span>•</span>
                                <span>{{ $related->reading_time }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

    </div>
</section>
@endif
{{-- ===== END RELATED ARTICLES ===== --}}

@push('scripts')
<script>
    // ===== READING PROGRESS BAR =====
    const progressBar = document.getElementById('reading-progress');
    const articleBody = document.getElementById('article-body') || document.querySelector('article');

    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
        progressBar.style.width = Math.min(progress, 100) + '%';
    }, { passive: true });

    // ===== COPY LINK =====
    function copyLink(btn) {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const original = btn.innerHTML;
            btn.classList.add('copied');
            btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`;
            setTimeout(() => {
                btn.classList.remove('copied');
                btn.innerHTML = original;
            }, 2000);
        });
    }
</script>
@endpush

@endsection