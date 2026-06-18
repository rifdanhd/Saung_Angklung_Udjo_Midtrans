{{-- resources/views/articles/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Jurnal & Cerita - Saung Angklung Udjo')

@section('content')

    {{-- 1. STYLES KHUSUS ARTIKEL (Visit Qatar Style) --}}
    @push('styles')
        <style>
            :root {
                --indigo-deep: #1a1445;
                --gold-premium: #c4a47c;
                --v-gray: #f8f8f7;
            }

            body { font-family: 'Inter', sans-serif; color: var(--indigo-deep); background-color: #fff; }
            .font-editorial { font-family: 'Libre Baskerville', serif; }
            
            .text-spacing-sm { text-transform: uppercase; letter-spacing: 0.3em; font-size: 0.65rem; font-weight: 700; }
            .text-spacing-lg { text-transform: uppercase; letter-spacing: 0.5em; font-size: 0.75rem; font-weight: 800; }

            /* Reveal System */
            .reveal { opacity: 0; transform: translateY(20px); transition: all 1.2s cubic-bezier(0.16, 1, 0.3, 1); visibility: hidden; }
            .reveal.active { opacity: 1 !important; transform: translateY(0) !important; visibility: visible !important; }

            /* Modern Filter Pills */
            .filter-link {
                background: transparent;
                color: var(--indigo-deep);
                border-bottom: 2px solid transparent;
                padding: 0.5rem 0;
                font-size: 0.75rem;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.2em;
                transition: all 0.3s ease;
            }
            .filter-link.active {
                border-bottom-color: var(--gold-premium);
                color: var(--gold-premium);
            }
            .filter-link:hover { color: var(--gold-premium); }

            /* Search Input */
            .search-v-qatar {
                border: none;
                border-bottom: 1px solid rgba(26, 20, 69, 0.1);
                border-radius: 0;
                padding: 0.75rem 0 0.75rem 2.5rem;
                font-weight: 300;
                transition: all 0.3s;
            }
            .search-v-qatar:focus {
                outline: none;
                border-bottom-color: var(--gold-premium);
                box-shadow: none;
            }

            /* Article Card */
            .article-card-v {
                transition: all 0.5s ease;
            }
            .article-card-v .img-container {
                aspect-ratio: 16/10;
                overflow: hidden;
                background: #f0f0f0;
                margin-bottom: 2rem;
            }
            .article-card-v img {
                transition: transform 1.5s cubic-bezier(0.16, 1, 0.3, 1);
            }
            .article-card-v:hover img {
                transform: scale(1.05);
            }

            section { margin: 0 !important; }
        </style>
    @endpush

    <!-- 1. CINEMATIC HERO SECTION -->
    <section class="relative h-[45vh] md:h-[55vh] flex items-center bg-black overflow-hidden">
        <div class="absolute inset-0">
            <!-- Background Image -->
            <img src="{{ asset('img/performance.jpg') }}" class="w-full h-full object-cover opacity-50">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#1a1445]/80"></div>
        </div>
        
        <div class="container mx-auto px-10 md:px-20 relative z-10 text-white text-center">
            <div class="max-w-4xl mx-auto">
                <p class="reveal text-spacing-lg text-gold-premium mb-6">Jurnal & Cerita</p>
                <h1 class="reveal font-editorial text-5xl md:text-7xl leading-tight italic" style="transition-delay: 200ms;">
                    Beyond the <br> <span class="not-italic font-normal">Sound of Bamboo</span>
                </h1>
            </div>
        </div>
    </section>

    <!-- 2. NAVIGATION & SEARCH (CLEAN STYLE) -->
    <section class="py-12 bg-white sticky top-20 z-40 border-b border-gray-50">
        <div class="max-w-[1400px] mx-auto px-10">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-12">
                <!-- Links Filter -->
                <div class="flex flex-wrap gap-8 md:gap-12">
                    <button class="filter-link active" data-category="all">Semua</button>
                    <button class="filter-link" data-category="berita">Berita</button>
                    <button class="filter-link" data-category="event">Event</button>
                    <button class="filter-link" data-category="budaya">Budaya</button>
                    <button class="filter-link" data-category="tips">Tips & Tutorial</button>
                </div>
                
                <!-- Minimalist Search -->
                <div class="relative w-full lg:w-1/3">
                    <span class="absolute left-0 top-1/2 -translate-y-1/2 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="1.5"/></svg>
                    </span>
                    <input type="text" placeholder="Cari artikel..." class="w-full search-v-qatar bg-transparent text-lg font-light">
                </div>
            </div>
        </div>
    </section>

    <!-- 3. ARTICLES LISTING -->
    <section class="py-24 bg-white">
        <div class="max-w-[1400px] mx-auto px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-24" id="articles-grid">
                @forelse($articles as $article)
                    <article class="article-card-v reveal group" data-category="{{ strtolower($article->category) }}">
                        <a href="{{ route('articles.show', $article->slug) }}" class="block">
                            <!-- Cinematic Image -->
                            <div class="img-container">
                                @if($article->featured_image)
                                    <img src="{{ asset('storage/' . $article->featured_image) }}" 
                                         alt="{{ $article->title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-v-gray text-6xl opacity-20">📰</div>
                                @endif
                            </div>

                            <!-- Editorial Content -->
                            <div class="space-y-4">
                                <div class="flex items-center gap-4">
                                    <span class="text-spacing-sm text-gold-premium font-bold">
                                        {{ $article->category }}
                                    </span>
                                    <span class="w-6 h-px bg-gray-200"></span>
                                    <span class="text-[10px] text-gray-400 uppercase tracking-widest">
                                        {{ $article->published_at->format('d M Y') }}
                                    </span>
                                </div>

                                <h3 class="font-editorial text-2xl text-indigo-950 leading-snug group-hover:text-amber-600 transition-colors line-clamp-2">
                                    {{ $article->title }}
                                </h3>
                                
                                <p class="text-gray-500 font-light leading-relaxed line-clamp-3">
                                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                                </p>

                                <div class="pt-4 flex items-center gap-3 text-indigo-950 font-bold text-[9px] tracking-[0.2em] uppercase">
                                    Baca Selengkapnya 
                                    <svg class="w-4 h-4 transform group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2"/></svg>
                                </div>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="col-span-full text-center py-32 reveal">
                        <p class="font-editorial italic text-2xl text-gray-400 opacity-50">Belum ada cerita yang dapat dibagikan saat ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Custom Pagination -->
            @if($articles->hasPages())
                <div class="mt-32 pt-12 border-t border-gray-100 flex justify-center">
                    {{ $articles->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- 4. BOTTOM CALL TO ACTION -->
    <section class="relative h-[65vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('img/performance.jpg') }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-[#1a1445]/85 backdrop-blur-[1px]"></div>
        </div>
        
        <div class="relative z-10 text-center text-white px-10">
            <p class="reveal text-spacing-lg text-amber-500 mb-8 uppercase font-bold">Rencanakan Kunjungan</p>
            <h2 class="reveal font-editorial text-4xl md:text-6xl leading-tight mb-16 italic" style="transition-delay: 200ms;">
                Saksikan keajaiban <br> <span class="not-italic text-amber-400">harmoni dunia.</span>
            </h2>
            <div class="reveal" style="transition-delay: 400ms;">
                <a href="{{ route('shows.index') }}" class="inline-block bg-white text-indigo-950 px-16 py-6 text-[11px] font-bold uppercase tracking-[0.3em] hover:bg-gold-premium hover:text-white transition-all shadow-2xl">
                    Dapatkan Tiket Sekarang
                </a>
            </div>
        </div>
    </section>

    {{-- SCRIPTS --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Intersection Observer for Reveal
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

            // Category Filter Functionality
            const filterButtons = document.querySelectorAll('.filter-link');
            const articles = document.querySelectorAll('.article-card-v');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Update Active State
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    const category = this.dataset.category.toLowerCase();
                    
                    articles.forEach(article => {
                        const articleCat = article.dataset.category.toLowerCase();
                        if (category === 'all' || articleCat === category) {
                            article.style.display = 'block';
                            setTimeout(() => article.classList.add('active'), 10);
                        } else {
                            article.style.display = 'none';
                            article.classList.remove('active');
                        }
                    });
                });
            });
        });
    </script>
    @endpush

@endsection