{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Produk Kami - Saung Angklung Udjo')

@section('content')

<!-- Hero Section -->
<section class="relative h-[50vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-amber-900/90 to-amber-700/90 z-10"></div>
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/products-hero.jpg');"></div>
    
    <div class="relative z-20 text-center text-white px-4 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-6xl font-bold mb-4">Produk Kami</h1>
        <p class="text-lg md:text-xl">Angklung berkualitas dan souvenir khas Sunda buatan tangan</p>
    </div>
</section>

<!-- Filter & Products Section -->
<section class="py-16 bg-gradient-to-b from-white to-amber-50">
    <div class="container mx-auto px-4">
        
        <!-- Filter Section -->
        <div class="mb-12 bg-white rounded-2xl shadow-lg p-6">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <div class="flex flex-wrap gap-3">
                    <button class="filter-btn active px-6 py-2 rounded-full font-semibold transition" data-category="all">
                        Semua Produk
                    </button>
                    <button class="filter-btn px-6 py-2 rounded-full font-semibold transition" data-category="angklung">
                        Angklung
                    </button>
                    <button class="filter-btn px-6 py-2 rounded-full font-semibold transition" data-category="souvenir">
                        Souvenir
                    </button>
                    <button class="filter-btn px-6 py-2 rounded-full font-semibold transition" data-category="kerajinan">
                        Kerajinan
                    </button>
                </div>
                
                <div class="flex items-center gap-2">
                    <label class="text-gray-600 font-medium">Urutkan:</label>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <option value="newest">Terbaru</option>
                        <option value="price-low">Harga: Rendah - Tinggi</option>
                        <option value="price-high">Harga: Tinggi - Rendah</option>
                        <option value="name">Nama A-Z</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6" id="products-grid">
            @forelse($products as $product)
                <div class="product-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group" 
                     data-category="{{ $product->category }}">
                    
                    <!-- Product Image -->
                    <a href="{{ route('products.show', $product) }}" class="block">
                        <div class="relative h-64 bg-gradient-to-br from-amber-200 to-amber-400 overflow-hidden">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" 
                                     alt="{{ $product->name }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-amber-700">
                                    <span class="text-8xl">🎵</span>
                                </div>
                            @endif
                            
                            <!-- Category Badge -->
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-sm text-amber-800 shadow-md">
                                    {{ ucfirst($product->category) }}
                                </span>
                            </div>

                            @if($product->stock < 5 && $product->stock > 0)
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white shadow-md">
                                        Stok Terbatas
                                    </span>
                                </div>
                            @elseif($product->stock == 0)
                                <div class="absolute top-4 right-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-500 text-white shadow-md">
                                        Habis
                                    </span>
                                </div>
                            @endif
                        </div>
                    </a>

                    <!-- Product Info -->
                    <div class="p-5">
                        <a href="{{ route('products.show', $product) }}">
                            <h3 class="font-bold text-lg mb-2 group-hover:text-amber-600 transition line-clamp-2 min-h-[56px]">
                                {{ $product->name }}
                            </h3>
                        </a>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2 min-h-[40px]">
                            {{ Str::limit($product->description, 80) }}
                        </p>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-2xl font-bold text-amber-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <span class="text-sm text-gray-500">
                                Stok: {{ $product->stock }}
                            </span>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('products.show', $product) }}" 
                               class="flex-1 bg-amber-600 hover:bg-amber-700 text-white text-center py-2.5 rounded-lg font-semibold transition">
                                Detail
                            </a>
                            @if($product->stock > 0)
                                <button class="bg-amber-100 hover:bg-amber-200 text-amber-700 px-4 py-2.5 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                              d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-4 text-center py-16">
                    <div class="text-6xl mb-4">📦</div>
                    <p class="text-gray-500 text-lg">Belum ada produk tersedia</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-amber-600 to-amber-800 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Butuh Bantuan Memilih Produk?</h2>
        <p class="text-lg mb-6 max-w-2xl mx-auto">
            Tim kami siap membantu Anda menemukan produk yang tepat
        </p>
        <a href="{{ route('contact') }}" 
           class="inline-block bg-white text-amber-600 hover:bg-amber-50 px-8 py-3 rounded-full font-bold transition transform hover:scale-105">
            Hubungi Kami
        </a>
    </div>
</section>

@endsection

@push('styles')
<style>
    .filter-btn {
        background-color: #f3f4f6;
        color: #6b7280;
    }
    
    .filter-btn:hover {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .filter-btn.active {
        background-color: #d97706;
        color: white;
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            const category = this.dataset.category;
            const products = document.querySelectorAll('.product-card');
            
            products.forEach(product => {
                if (category === 'all' || product.dataset.category === category) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush