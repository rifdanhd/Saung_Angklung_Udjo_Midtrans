{{-- resources/views/admin/products/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Kelola Produk')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Kelola Produk</h1>
            <p class="text-gray-600 mt-1">Manage angklung, arumba, calung & souvenir</p>
        </div>
        <a href="{{ route('admin.products.create') }}" 
           class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Produk
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-gray-500 text-sm">Total Produk</p>
        <p class="text-2xl font-bold text-gray-800 mt-1">{{ $products->total() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-gray-500 text-sm">Angklung</p>
        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $products->where('category', 'angklung')->count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-gray-500 text-sm">Arumba</p>
        <p class="text-2xl font-bold text-green-600 mt-1">{{ $products->where('category', 'arumba')->count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-gray-500 text-sm">Calung</p>
        <p class="text-2xl font-bold text-purple-600 mt-1">{{ $products->where('category', 'calung')->count() }}</p>
    </div>
    <div class="bg-white rounded-lg shadow p-4">
        <p class="text-gray-500 text-sm">Souvenir</p>
        <p class="text-2xl font-bold text-amber-600 mt-1">{{ $products->where('category', 'souvenir')->count() }}</p>
    </div>
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-xl shadow p-4 mb-6">
    <form method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Cari produk..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
        </div>
        <select name="category" 
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            <option value="">Semua Kategori</option>
            <option value="angklung" {{ request('category') === 'angklung' ? 'selected' : '' }}>Angklung</option>
            <option value="arumba" {{ request('category') === 'arumba' ? 'selected' : '' }}>Arumba</option>
            <option value="calung" {{ request('category') === 'calung' ? 'selected' : '' }}>Calung</option>
            <option value="souvenir" {{ request('category') === 'souvenir' ? 'selected' : '' }}>Souvenir</option>
        </select>
        <select name="availability" 
                class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-transparent">
            <option value="">Semua Status</option>
            <option value="available" {{ request('availability') === 'available' ? 'selected' : '' }}>Tersedia</option>
            <option value="out_of_stock" {{ request('availability') === 'out_of_stock' ? 'selected' : '' }}>Habis</option>
        </select>
        <button type="submit" 
                class="bg-amber-600 hover:bg-amber-700 text-white px-6 py-2 rounded-lg transition">
            Filter
        </button>
        @if(request()->hasAny(['search', 'category', 'availability']))
        <a href="{{ route('admin.products.index') }}" 
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-lg transition">
            Reset
        </a>
        @endif
    </form>
</div>

<!-- Products Grid -->
<div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    @forelse($products as $product)
    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition group">
        <!-- Product Image -->
        <div class="relative h-48 bg-gray-200 overflow-hidden">
            @if($product->images && count($product->images) > 0)
                <img src="{{ asset('storage/' . $product->images[0]) }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            @endif

            <!-- Badges -->
            <div class="absolute top-3 left-3 flex flex-col gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-white/90 backdrop-blur-sm
                    {{ $product->category === 'angklung' ? 'text-blue-700' : '' }}
                    {{ $product->category === 'arumba' ? 'text-green-700' : '' }}
                    {{ $product->category === 'calung' ? 'text-purple-700' : '' }}
                    {{ $product->category === 'souvenir' ? 'text-amber-700' : '' }}">
                    {{ ucfirst($product->category) }}
                </span>
                @if($product->is_featured)
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    ⭐ Featured
                </span>
                @endif
            </div>

            @if(!$product->is_available || $product->stock <= 0)
            <div class="absolute inset-0 bg-black/50 flex items-center justify-center">
                <span class="bg-red-500 text-white px-4 py-2 rounded-lg font-semibold">Habis</span>
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div class="p-4">
            <h3 class="font-bold text-gray-800 text-lg mb-2 line-clamp-1">{{ $product->name }}</h3>
            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->description }}</p>
            
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-2xl font-bold text-amber-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
                <div class="text-right">
                    <p class="text-xs text-gray-500">Stock</p>
                    <p class="font-semibold {{ $product->stock > 10 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $product->stock }}
                    </p>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-2 pt-3 border-t">
                <a href="{{ route('admin.products.edit', $product) }}" 
                   class="flex-1 bg-blue-50 hover:bg-blue-100 text-blue-600 py-2 rounded-lg text-center transition font-medium">
                    Edit
                </a>
                <form action="{{ route('admin.products.destroy', $product) }}" 
                      method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                      class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="w-full bg-red-50 hover:bg-red-100 text-red-600 py-2 rounded-lg transition font-medium">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-4 text-center py-12 bg-white rounded-xl">
        <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
        </svg>
        <p class="text-lg font-medium text-gray-500">Belum ada produk</p>
        <p class="text-sm text-gray-400 mt-1">Tambahkan produk pertama Anda</p>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($products->hasPages())
<div class="mt-8">
    {{ $products->links() }}
</div>
@endif

@endsection

@push('styles')
<style>
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush