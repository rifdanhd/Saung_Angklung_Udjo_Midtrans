<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran Berhasil | Saung Angklung Udjo</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --gold: #c4a47c;
            --navy: #1a1445;
        }

        html, body {
            min-height: 100%;
        }

        /* ── Page ── */
        .success-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                url('https://www.transparenttextures.com/patterns/stardust.png'),
                linear-gradient(135deg, #1a1445 0%, #2d2470 100%);
            padding: 3rem 1.5rem;
            font-family: 'Inter', sans-serif;
        }

        /* ── Ticket container ── */
        .ticket-container {
            width: 100%;
            max-width: 420px;
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        /* ── Card ── */
        .ticket {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            overflow: hidden;
        }

        /* ── Header ── */
        .ticket-header {
            background: url('{{ asset('img/Angklungmasal.webp') }}') center/cover;
            position: relative;
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            color: #fff;
        }

        .ticket-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(26,20,69,0.8), rgba(26,20,69,0.95));
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .check-circle {
            width: 64px;
            height: 64px;
            background: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 0 0 8px rgba(196, 164, 124, 0.2);
            animation: scaleIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.5s forwards;
            opacity: 0;
            transform: scale(0.5);
        }

        .check-circle svg {
            width: 32px;
            height: 32px;
            color: #1a1445;
        }

        .success-title {
            font-family: 'Libre Baskerville', serif;
            font-size: 22px;
            margin-bottom: 5px;
        }

        .success-subtitle {
            font-size: 12px;
            color: var(--gold);
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-weight: 600;
        }

        /* ── Body ── */
        .ticket-body {
            padding: 2rem;
            background: #fff;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px dashed rgba(0, 0, 0, 0.08);
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 11px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .info-value {
            font-size: 14px;
            color: var(--navy);
            font-weight: 700;
            text-align: right;
        }

        .info-value.highlight {
            color: var(--gold);
            font-size: 18px;
        }

        /* ── Perforation ── */
        .ticket-divider {
            position: relative;
            height: 20px;
            background: #fff;
        }

        .ticket-divider::before,
        .ticket-divider::after {
            content: '';
            position: absolute;
            top: 0;
            width: 20px;
            height: 20px;
            background: #2d2470;
            border-radius: 50%;
        }

        .ticket-divider::before { left: -10px; }
        .ticket-divider::after  { right: -10px; }

        .ticket-divider .dash {
            position: absolute;
            top: 10px;
            left: 15px;
            right: 15px;
            border-top: 2px dashed rgba(0, 0, 0, 0.10);
        }

        /* ── Footer / QR ── */
        .ticket-footer {
            background: #f8f9fa;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .qr-box {
            background: #fff;
            padding: 6px;
            border-radius: 8px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* ── CTA Button ── */
        .btn-home {
            display: block;
            width: 100%;
            padding: 16px;
            background: var(--gold);
            color: var(--navy);
            text-align: center;
            border-radius: 12px;
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            text-decoration: none;
            margin-top: 1.5rem;
            transition: transform 0.3s, box-shadow 0.3s;
            box-shadow: 0 10px 20px rgba(196, 164, 124, 0.3);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 25px rgba(196, 164, 124, 0.4);
            color: var(--navy);
        }

        /* ── Animations ── */
        @keyframes slideUpFade {
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes scaleIn {
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>

<div class="success-wrap">
    <div class="ticket-container">

        <div class="ticket">

            {{-- Header --}}
            <div class="ticket-header">
                <div class="header-content">
                    <div class="check-circle">
                        <svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h1 class="success-title">Pembayaran Berhasil</h1>
                    <p class="success-subtitle">E-Ticket telah dikirim ke email Anda</p>
                </div>
            </div>

            {{-- Body --}}
            <div class="ticket-body">
                <div class="info-row">
                    <span class="info-label">Nama Pemesan</span>
                    <span class="info-value">{{ $order->nama_pemesan }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Kunjungan</span>
                    <span class="info-value">
                        {{ $order->tanggal_kunjungan
                            ? \Carbon\Carbon::parse($order->tanggal_kunjungan)->translatedFormat('d F Y')
                            : '-' }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Sesi Pertunjukan</span>
                    <span class="info-value">
                        {{ $order->sesi === 'pagi'  ? '10.00 - 11.30'  :
                          ($order->sesi === 'siang' ? '13.00 - 14.30'  : '15.30 - 17.00') }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jumlah Tiket</span>
                    <span class="info-value">{{ $order->jumlah_tiket }} Tiket</span>
                </div>
                <div class="info-row" style="margin-top: 8px;">
                    <span class="info-label" style="color: var(--navy);">Total Bayar</span>
                    <span class="info-value highlight">
                        Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Perforation --}}
            <div class="ticket-divider" aria-hidden="true">
                <div class="dash"></div>
            </div>

            {{-- QR Footer --}}
            <div class="ticket-footer">
                <div>
                    <span class="info-label">Kode Booking</span>
                    <div style="font-family: monospace; font-size: 20px; font-weight: 700; color: var(--navy); margin-top: 4px; letter-spacing: 1px;">
                        {{ $order->order_code }}
                    </div>
                </div>
                <div class="qr-box" aria-label="QR code tiket">
                    @if(class_exists('\SimpleSoftwareIO\QrCode\Facades\QrCode'))
                        {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(64)->generate($order->order_code) !!}
                    @else
                        <div style="width: 64px; height: 64px; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 10px;">QR</div>
                    @endif
                </div>
            </div>

        </div>{{-- /ticket --}}

        <a href="{{ route('home') }}" class="btn-home">Kembali ke Beranda</a>

    </div>
</div>

</body>
</html>