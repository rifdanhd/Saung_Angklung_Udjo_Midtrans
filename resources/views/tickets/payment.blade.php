<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Tiket – Saung Angklung Udjo</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --coklat:    #4A2C0A;
            --emas:      #C9922A;
            --emas-muda: #F0C060;
            --hijau:     #2D5016;
            --krem:      #F5EDD8;
            --krem-tua:  #E8D8B8;
            --putih:     #FDFAF4;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--putih);
            font-family: 'DM Sans', sans-serif;
            color: var(--coklat);
            min-height: 100vh;
        }

        .header {
            background: var(--coklat);
            padding: 24px;
            text-align: center;
        }
        .header h1 {
            font-family: 'Playfair Display', serif;
            color: var(--krem);
            font-size: 22px;
        }
        .header p { color: var(--krem-tua); font-size: 13px; margin-top: 4px; }

        .steps {
            display: flex;
            justify-content: center;
            background: var(--krem-tua);
        }
        .step {
            flex: 1;
            max-width: 200px;
            text-align: center;
            padding: 12px 8px;
            font-size: 12px;
            color: #9A7A50;
        }
        .step.active { background: var(--emas); color: var(--coklat); font-weight: 700; }
        .step-num { display: block; font-size: 18px; font-weight: 700; }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
        }
        @media (max-width: 640px) { .container { grid-template-columns: 1fr; } }

        .card {
            background: #fff;
            border: 1px solid var(--krem-tua);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(74,44,10,.07);
        }
        .card-header {
            background: var(--krem);
            border-bottom: 1px solid var(--krem-tua);
            padding: 16px 22px;
        }
        .card-header h2 { font-family: 'Playfair Display', serif; font-size: 18px; }
        .card-body { padding: 22px; }

        .order-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed var(--krem-tua);
            font-size: 14px;
        }
        .order-row:last-child { border: none; }
        .label { color: #7A5C30; }
        .val { font-weight: 600; }

        .total-box {
            background: var(--krem);
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            text-align: center;
        }
        .total-label { font-size: 12px; color: #7A5C30; text-transform: uppercase; }
        .total-amount { 
            display: block; 
            font-family: 'Playfair Display', serif; 
            font-size: 24px; 
            color: var(--emas); 
            margin-top: 5px;
        }

        .payment-info {
            text-align: center;
            padding: 20px 0;
        }
        .midtrans-logo {
            width: 120px;
            margin-bottom: 15px;
            opacity: 0.8;
        }
        .instruction {
            font-size: 13px;
            color: #8A6830;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .btn-bayar {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--emas) 0%, #B87820 100%);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-family: 'DM Sans', sans-serif;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            box-shadow: 0 4px 15px rgba(201, 146, 42, 0.3);
        }
        .btn-bayar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(201, 146, 42, 0.4);
        }

        /* Snap Embed */
        #snap-embed-wrapper {
            margin-top: 20px;
            animation: fadeIn 0.5s ease;
        }
        #snap-embed-wrapper .snap-hdr {
            background: var(--coklat);
            padding: 14px 18px;
            border-radius: 12px 12px 0 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        #snap-embed-wrapper .snap-hdr svg {
            width: 18px;
            height: 18px;
            color: var(--emas);
            flex-shrink: 0;
        }
        #snap-embed-wrapper .snap-hdr h4 {
            font-family: 'Playfair Display', serif;
            font-size: 15px;
            color: var(--krem);
            margin: 0;
        }
        #snap-embed-wrapper .snap-hdr span {
            font-size: 10px;
            color: var(--krem-tua);
            display: block;
            margin-top: 2px;
        }
        #snap-container-pay {
            min-height: 380px;
            border: 1px solid var(--krem-tua);
            border-top: none;
            border-radius: 0 0 12px 12px;
            background: #fff;
            overflow: hidden;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .footer { text-align: center; padding: 24px; background: var(--coklat); color: var(--krem-tua); font-size: 12px; margin-top: 40px; }
    </style>
</head>
<body>

<header class="header">
    <h1>Saung Angklung Udjo</h1>
    <p>Gerbang Budaya Bambu Jawa Barat</p>
</header>

<div class="steps">
    <div class="step"><span class="step-num">✓</span>Pesan</div>
    <div class="step active"><span class="step-num">2</span>Bayar</div>
    <div class="step"><span class="step-num">3</span>Selesai</div>
</div>

<main class="container">
    <div class="card">
        <div class="card-header"><h2>Ringkasan Pesanan</h2></div>
        <div class="card-body">
            <div class="order-row">
                <span class="label">Nama</span>
                <span class="val">{{ $order->name }}</span>
            </div>
            <div class="order-row">
                <span class="label">Email</span>
                <span class="val">{{ $order->email }}</span>
            </div>
            <div class="order-row">
                <span class="label">Jumlah Tiket</span>
                <span class="val">{{ $order->qty }} Tiket</span>
            </div>
            
            <div class="total-box">
                <span class="total-label">Total Pembayaran</span>
                <span class="total-amount">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header"><h2>Metode Pembayaran</h2></div>
        <div class="card-body">
            <div class="payment-info">
                <img src="https://midtrans.com/assets/img/logo-midtrans.svg" alt="Midtrans" class="midtrans-logo">
                <p class="instruction">
                    Pembayaran aman dan otomatis menggunakan Midtrans.<br>
                    Tersedia pilihan <strong>QRIS, GoPay, ShopeePay, Virtual Account,</strong> dan lainnya.
                </p>
            </div>

            {{-- Snap Embed Container --}}
            <div id="snap-embed-wrapper">
                <div class="snap-hdr">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                    <div>
                        <h4>Pilih Metode Pembayaran</h4>
                        <span>Transaksi aman & terenkripsi</span>
                    </div>
                </div>
                <div id="snap-container-pay"></div>
            </div>
        </div>
    </div>
</main>

<footer class="footer">
    © {{ date('Y') }} Saung Angklung Udjo — Jl. Padasuka No.118, Bandung
</footer>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-trigger Midtrans Snap Embed
        window.snap.embed('{{ $order->snap_token }}', {
            embedId: 'snap-container-pay',
            onSuccess: function(result){
                window.location.href = "/tiket/sukses/{{ $order->id }}";
            },
            onPending: function(result){
                alert("Menunggu pembayaran Anda. Silakan selesaikan transaksi.");
                console.log(result);
            },
            onError: function(result){
                alert("Pembayaran gagal, silakan coba lagi.");
                console.log(result);
            },
            onClose: function(){
                alert('Anda menutup jendela pembayaran sebelum selesai.');
            }
        });
    });
</script>

</body>
</html>