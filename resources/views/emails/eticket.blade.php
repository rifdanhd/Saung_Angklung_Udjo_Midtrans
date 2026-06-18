@component('mail::message')
# 🎵 E-Tiket Saung Angklung Udjo

Halo **{{ $order->nama_pemesan }}**,

Pembayaran kamu berhasil! Berikut detail tiket kunjungan kamu:

@component('mail::panel')
<div style="text-align: center; margin-bottom: 15px;">
    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode($order->order_code) }}" alt="QR Code" width="150" height="150">
    <br>
    <small>Tunjukkan QR ini saat kedatangan</small>
</div>

**Kode Order:** {{ $order->order_code }}  
**Tanggal Kunjungan:** {{ \Carbon\Carbon::parse($order->tanggal_kunjungan)->format('d M Y') }}  
**Sesi:** {{ $order->sesi }}  
**Jumlah Tiket:** {{ $order->total_tiket }} tiket  
**Total Bayar:** Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
@endcomponent

**Rincian Tiket:**

@if($order->items)
@foreach($order->items as $item)
- {{ $item['name'] }} x{{ $item['quantity'] ?? $item['qty'] ?? 1 }} = Rp {{ number_format($item['price'] * ($item['quantity'] ?? $item['qty'] ?? 1), 0, ',', '.') }}
@endforeach
@endif

Tunjukkan email ini atau kode order kamu di pintu masuk Saung Angklung Udjo.

**Alamat:** Jl. Padasuka No.118, Pasirlayung, Bandung

Sampai jumpa! 🎶

@component('mail::button', ['url' => config('app.url')])
Kunjungi Website
@endcomponent

Salam,  
**Saung Angklung Udjo**
@endcomponent