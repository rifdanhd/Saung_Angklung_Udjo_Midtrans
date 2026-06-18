@extends('layouts.app')

@section('title', 'Pembayaran Berhasil | Saung Angklung Udjo')

@section('content')
<div style="min-height:70vh;display:flex;align-items:center;justify-content:center;background:#F7F7F2;padding:2rem">
    <div style="background:#fff;border-radius:24px;padding:3rem 2.5rem;max-width:480px;width:100%;text-align:center;box-shadow:0 12px 48px rgba(26,20,69,.08)">

        {{-- Icon --}}
        <div style="width:72px;height:72px;background:#f0faf5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem">
            <svg width="36" height="36" fill="none" stroke="#2d9f6a" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>

        <p style="font-size:10px;font-weight:800;letter-spacing:.35em;text-transform:uppercase;color:#c4a47c;margin-bottom:8px">Pembayaran Berhasil</p>
        <h1 style="font-family:'Libre Baskerville',serif;font-size:1.6rem;font-weight:400;color:#1a1445;margin-bottom:.5rem">Terima Kasih!</h1>
        <p style="font-size:13px;color:rgba(26,20,69,.5);margin-bottom:2rem">Tiket kamu sudah dikonfirmasi. Detail akan dikirim ke email.</p>

        {{-- Order Info --}}
        <div style="background:#F7F7F2;border-radius:14px;padding:1.25rem;text-align:left;margin-bottom:2rem">
            <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:12px">
                <span style="color:rgba(26,20,69,.5)">Kode Booking</span>
                <strong style="color:#1a1445">{{ $order->order_code }}</strong>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:12px">
                <span style="color:rgba(26,20,69,.5)">Nama</span>
                <strong style="color:#1a1445">{{ $order->nama_pemesan }}</strong>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:12px">
                <span style="color:rgba(26,20,69,.5)">Tanggal</span>
                <strong style="color:#1a1445">{{ $order->tanggal }}</strong>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:10px;font-size:12px">
                <span style="color:rgba(26,20,69,.5)">Sesi</span>
                <strong style="color:#1a1445">{{ $order->sesi }}</strong>
            </div>
            <div style="height:1px;background:rgba(26,20,69,.08);margin:12px 0"></div>
            <div style="display:flex;justify-content:space-between;font-size:14px">
                <span style="color:rgba(26,20,69,.5)">Total Bayar</span>
                <strong style="color:#1a1445">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</strong>
            </div>
        </div>

        <a href="{{ route('home') }}" style="display:block;width:100%;padding:14px;background:#c4a47c;color:#1a1445;border-radius:10px;font-size:11px;font-weight:900;letter-spacing:.28em;text-transform:uppercase;text-decoration:none">
            Kembali ke Beranda
        </a>

    </div>
</div>
@endsection