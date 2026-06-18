{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('title', $product->name . ' - Saung Angklung Udjo')

@section('content')

<!-- Breadcrumb -->
<div class="bg-amber-50 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex items-center gap-2 text-sm">
            <a href="{{ route('home') }}" class="text-amber-600 hover:text-amber-700">Home</a>
            <span class="text-gray-400">/</span>
            <a href="{{ route('products.index') }}" class="text-amber-600 hover:text-amber-700">Produk</a>
            <span class="text-gray-400">/</span>
            <span class="text-gray-600">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<!-- Product Detail Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-12 mb-16">
            
            <!-- Product Images -->
            <div>
                <div class="sticky top-24">
                    <!-- Main Image -->
                    <div class="bg-gradient-to-br from-amber-100 to-amber-200 rounded-2xl overflow-hidden mb-4 shadow-xl">
                        @if($product->images && count($product->images) > 0)
                            <img id="mainImage" 
                                 src="{{ asset('storage/' . $product->images[0]) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-[500px] object-cover">
                        @else
                            <div class="w-full h-[500px] flex items-center justify-center text-amber-700">
                                <span class="text-9xl">🎵</span>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Images -->
                    @if($product->images && count($product->images) > 1)
                        <div class="grid grid-cols-4 gap-3">
                            @foreach($product->images as $index => $image)
                                <button onclick="changeImage('{{ asset('storage/' . $image) }}')" 
                                        class="thumbnail-btn border-2 border-transparent hover:border-amber-500 rounded-lg overflow-hidden transition {{ $index === 0 ? 'border-amber-500' : '' }}">
                                    <img src="{{ asset('storage/' . $image) }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full h-24 object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div>
                <div class="mb-4">
                    <span class="inline-block px-4 py-1 rounded-full text-sm font-bold bg-amber-100 text-amber-800">
                        {{ ucfirst($product->category) }}
                    </span>
                </div>

                <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                
                <div class="flex items-baseline gap-4 mb-6">
                    <span class="text-4xl font-bold text-amber-600">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                </div>

                <!-- Stock Info -->
                <div class="mb-6 p-4 rounded-lg {{ $product->stock > 10 ? 'bg-green-50' : ($product->stock > 0 ? 'bg-yellow-50' : 'bg-red-50') }}">
                    <div class="flex items-center gap-2">
                        @if($product->stock > 10)
                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold text-green-700">Stok Tersedia ({{ $product->stock }} unit)</span>
                        @elseif($product->stock > 0)
                            <svg class="w-5 h-5 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold text-yellow-700">Stok Terbatas ({{ $product->stock }} unit)</span>
                        @else
                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold text-red-700">Stok Habis</span>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Deskripsi Produk</h3>
                    <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                </div>

                <!-- Add to Cart -->
                @if($product->stock > 0)
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <label class="font-semibold text-gray-700">Jumlah:</label>
                            <div class="flex items-center border-2 border-gray-300 rounded-lg">
                                <button class="px-4 py-2 hover:bg-gray-100 transition" onclick="decreaseQty()">-</button>
                                <input type="number" 
                                       id="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}"
                                       class="w-16 text-center border-x-2 border-gray-300 py-2 focus:outline-none">
                                <button class="px-4 py-2 hover:bg-gray-100 transition" onclick="increaseQty()">+</button>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button class="flex-1 bg-amber-600 hover:bg-amber-700 text-white py-4 rounded-xl font-bold text-lg transition transform hover:scale-105 shadow-lg">
                                <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                Tambah ke Keranjang
                            </button>
                            <button class="bg-white border-2 border-amber-600 text-amber-600 hover:bg-amber-50 px-6 py-4 rounded-xl transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @else
                    <div class="bg-gray-100 text-gray-600 text-center py-4 rounded-xl font-semibold">
                        Produk Saat Ini Tidak Tersedia
                    </div>
                @endif

                <!-- Contact Info -->
                <div class="mt-8 p-6 bg-amber-50 rounded-xl border border-amber-200">
                    <h4 class="font-bold text-amber-900 mb-3">Butuh Bantuan?</h4>
                    <p class="text-sm text-gray-600 mb-3">Hubungi kami untuk informasi lebih lanjut atau pemesanan khusus</p>
                    <div class="flex gap-3">
                        <a href="https://wa.me/62221234567" target="_blank" 
                           class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 rounded-lg font-semibold transition">
                            WhatsApp
                        </a>
                        <a href="tel:+62221234567" 
                           class="flex-1 bg-amber-600 hover:bg-amber-700 text-white text-center py-2 rounded-lg font-semibold transition">
                            Telepon
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts && $relatedProducts->count() > 0)
            <div class="border-t pt-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Produk Terkait</h2>
                <div class="grid md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <a href="{{ route('products.show', $related) }}" 
                           class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition group">
                            <div class="relative h-48 bg-gradient-to-br from-amber-200 to-amber-400 overflow-hidden">
                                @if($related->images && count($related->images) > 0)
                                    <img src="{{ asset('storage/' . $related->images[0]) }}" 
                                         alt="{{ $related->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-6xl">🎵</div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold mb-2 line-clamp-2">{{ $related->name }}</h3>
                                <span class="text-lg font-bold text-amber-600">
                                    Rp {{ number_format($related->price, 0, ',', '.') }}
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
    function changeImage(imageSrc) {
        document.getElementById('mainImage').src = imageSrc;
        
        // Update active thumbnail
        document.querySelectorAll('.thumbnail-btn').forEach(btn => {
            btn.classList.remove('border-amber-500');
            btn.classList.add('border-transparent');
        });
        event.currentTarget.classList.add('border-amber-500');
    }

    function increaseQty() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        const current = parseInt(input.value);
        if (current < max) {
            input.value = current + 1;
        }
    }

    function decreaseQty() {
        const input = document.getElementById('quantity');
        const min = parseInt(input.min);
        const current = parseInt(input.value);
        if (current > min) {
            input.value = current - 1;
        }
    }
</script>
@endpush