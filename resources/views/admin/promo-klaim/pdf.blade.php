<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Promo Klaim Ramadhan 2026</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #1a1a2e;
            background: #fff;
        }

        /* ── Header ── */
        .header {
            background: #4f46e5;
            color: #fff;
            padding: 18px 24px;
            margin-bottom: 16px;
        }
        .header h1 { font-size: 16px; font-weight: 700; margin-bottom: 3px; }
        .header .subtitle { font-size: 10px; opacity: .85; }
        .header .export-info { font-size: 9px; opacity: .7; margin-top: 8px; }

        /* ── Summary — pakai table supaya DomPDF support ── */
        .summary-wrap { padding: 0 24px; margin-bottom: 16px; }
        .summary-table { width: 100%; border-collapse: separate; border-spacing: 6px 0; }
        .summary-table td {
            width: 20%;
            background: #f5f3ff;
            border: 1px solid #ddd6fe;
            border-radius: 8px;
            padding: 10px 8px;
            text-align: center;
            vertical-align: middle;
        }
        .summary-table td.green { background: #f0fdf4; border-color: #bbf7d0; }
        .summary-table td.gold  { background: #fffbeb; border-color: #fde68a; }

        .stat-label { font-size: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #6b7280; margin-bottom: 4px; }
        .stat-value { font-size: 20px; font-weight: 800; color: #4f46e5; line-height: 1; }
        .stat-value.green { color: #16a34a; }
        .stat-value.gold  { color: #d97706; font-size: 12px; }
        .stat-sub { font-size: 8px; color: #9ca3af; margin-top: 3px; }

        /* ── Section title ── */
        .section-title {
            padding: 0 24px 6px;
            margin-bottom: 8px;
            font-size: 11px;
            font-weight: 700;
            color: #374151;
            border-bottom: 2px solid #e5e7eb;
        }

        /* ── Data Table ── */
        .table-wrap { padding: 0 24px; }
        table.data-table { width: 100%; border-collapse: collapse; font-size: 9.5px; }
        table.data-table thead tr { background: #4f46e5; color: #fff; }
        table.data-table thead th {
            padding: 8px 6px;
            text-align: left;
            font-weight: 700;
            font-size: 8.5px;
            letter-spacing: .3px;
            text-transform: uppercase;
        }
        table.data-table tbody tr:nth-child(even) { background: #f5f3ff; }
        table.data-table tbody tr:nth-child(odd)  { background: #fff; }
        table.data-table tbody tr { border-bottom: 1px solid #ede9fe; }
        table.data-table tbody td { padding: 7px 6px; vertical-align: middle; }

        .td-nama  { font-weight: 600; color: #1a1a2e; }
        .td-kota  { color: #6b7280; }
        .td-hp    { color: #16a34a; font-weight: 600; }
        .td-harga { font-weight: 700; color: #4f46e5; text-align: right; }
        .td-num   { text-align: center; }
        .td-center { text-align: center; }

        .badge { display: inline-block; border-radius: 10px; padding: 2px 5px; font-size: 8px; font-weight: 700; }
        .badge-dom   { background: #ede9fe; color: #5b21b6; }
        .badge-anak  { background: #dcfce7; color: #166534; }
        .badge-manca { background: #dbeafe; color: #1e40af; }

        .status { display: inline-block; border-radius: 10px; padding: 3px 7px; font-size: 8.5px; font-weight: 700; }
        .s-confirmed { background: #dcfce7; color: #166534; }
        .s-pending   { background: #fef9c3; color: #854d0e; }
        .s-cancelled { background: #fee2e2; color: #991b1b; }

        .strikethrough { text-decoration: line-through; color: #9ca3af; }
        .campuran-tag  { font-size: 8px; color: #3b5bdb; font-weight: 600; }

        /* ── Total row ── */
        .total-row td { background: #eef2ff !important; font-weight: 700; border-top: 2px solid #c7d2fe; padding: 8px 6px; }

        /* ── Footer ── */
        .footer { margin-top: 20px; padding: 12px 24px; border-top: 1px solid #e5e7eb; font-size: 8.5px; color: #9ca3af; }
        .footer-table { width: 100%; }
        .footer-table td:last-child { text-align: right; }
    </style>
</head>
<body>

@php
    $totalKlaim      = count($data);
    $totalDomDewasa  = $data->sum('jumlah_tiket_dewasa');
    $totalDomAnak    = $data->sum('jumlah_tiket_anak');
    $totalMancaDew   = $data->sum('jumlah_tiket_manca_dewasa');
    $totalMancaAnak  = $data->sum('jumlah_tiket_manca_anak');
    $totalPax        = $totalDomDewasa + $totalDomAnak + $totalMancaDew + $totalMancaAnak;
    $totalPendapatan = $data->whereNotIn('status', ['cancelled'])->sum('total_harga');
@endphp

{{-- ── HEADER ── --}}
<div class="header">
    <h1>Promo Klaim Ramadhan 2026</h1>
    <div class="subtitle">Saung Angklung Udjo &middot; Data klaim promo spesial Ramadhan 2026</div>
    <div class="export-info">
        Dicetak: {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WIB
        &nbsp;&middot;&nbsp; Total data: {{ $totalKlaim }} klaim
    </div>
</div>

{{-- ── SUMMARY (pakai table, bukan flexbox/grid) ── --}}
<div class="summary-wrap">
    <table class="summary-table">
        <tr>
            <td>
                <div class="stat-label">Total Klaim</div>
                <div class="stat-value">{{ $totalKlaim }}</div>
                <div class="stat-sub">entri data</div>
            </td>
            <td class="green">
                <div class="stat-label">Total Pax</div>
                <div class="stat-value green">{{ $totalPax }}</div>
                <div class="stat-sub">orang</div>
            </td>
            <td>
                <div class="stat-label">Domestik</div>
                <div class="stat-value">{{ $totalDomDewasa + $totalDomAnak }}</div>
                <div class="stat-sub">{{ $totalDomDewasa }} dewasa &middot; {{ $totalDomAnak }} anak</div>
            </td>
            <td>
                <div class="stat-label">Mancanegara</div>
                <div class="stat-value">{{ $totalMancaDew + $totalMancaAnak }}</div>
                <div class="stat-sub">{{ $totalMancaDew }} dewasa &middot; {{ $totalMancaAnak }} anak</div>
            </td>
            <td class="gold">
                <div class="stat-label">Est. Pendapatan</div>
                <div class="stat-value gold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                <div class="stat-sub">exclude cancelled</div>
            </td>
        </tr>
    </table>
</div>

{{-- ── TABLE ── --}}
<div class="section-title">Daftar Klaim</div>
<div class="table-wrap">
    <table class="data-table">
        <thead>
            <tr>
                <th style="width:20px;">#</th>
                <th style="width:110px;">Nama</th>
                <th style="width:65px;">Kota</th>
                <th style="width:80px;">No HP</th>
                <th style="width:50px;text-align:center;">Domestik</th>
                <th style="width:50px;text-align:center;">Manca.</th>
                <th style="width:25px;text-align:center;">Pax</th>
                <th style="width:65px;">Tgl Kunjungan</th>
                <th style="width:80px;text-align:right;">Total Harga</th>
                <th style="width:55px;text-align:center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $item)
            @php
                $hasDom      = $item->jumlah_tiket_dewasa > 0 || $item->jumlah_tiket_anak > 0;
                $hasManca    = $item->jumlah_tiket_manca_dewasa > 0 || $item->jumlah_tiket_manca_anak > 0;
                $paxRow      = $item->jumlah_tiket_dewasa + $item->jumlah_tiket_anak
                             + $item->jumlah_tiket_manca_dewasa + $item->jumlah_tiket_manca_anak;
                $isCancelled = $item->status === 'cancelled';
            @endphp
            <tr>
                <td class="td-num" style="color:#9ca3af;">{{ $i + 1 }}</td>

                <td class="td-nama {{ $isCancelled ? 'strikethrough' : '' }}">
                    {{ $item->nama }}
                    @if($hasDom && $hasManca)
                        <br><span class="campuran-tag">Campuran</span>
                    @endif
                </td>

                <td class="td-kota">{{ $item->kota }}</td>
                <td class="td-hp">{{ $item->no_hp }}</td>

                <td class="td-center">
                    @if($hasDom)
                        @if($item->jumlah_tiket_dewasa > 0)<span class="badge badge-dom">{{ $item->jumlah_tiket_dewasa }}D</span>@endif
                        @if($item->jumlah_tiket_anak > 0)<span class="badge badge-anak">{{ $item->jumlah_tiket_anak }}A</span>@endif
                    @else
                        <span style="color:#d1d5db;">-</span>
                    @endif
                </td>

                <td class="td-center">
                    @if($hasManca)
                        @if($item->jumlah_tiket_manca_dewasa > 0)<span class="badge badge-manca">{{ $item->jumlah_tiket_manca_dewasa }}D</span>@endif
                        @if($item->jumlah_tiket_manca_anak > 0)<span class="badge badge-manca">{{ $item->jumlah_tiket_manca_anak }}A</span>@endif
                    @else
                        <span style="color:#d1d5db;">-</span>
                    @endif
                </td>

                <td class="td-num" style="font-weight:700;">{{ $paxRow }}</td>

                <td>{{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d/m/Y') }}</td>

                <td class="td-harga {{ $isCancelled ? 'strikethrough' : '' }}">
                    Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                </td>

                <td class="td-center">
                    <span class="status s-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
                </td>
            </tr>
            @endforeach

            {{-- Total row --}}
            <tr class="total-row">
                <td colspan="6" style="text-align:right;color:#4338ca;font-size:9px;font-weight:700;">TOTAL</td>
                <td class="td-num" style="color:#4338ca;">{{ $totalPax }}</td>
                <td></td>
                <td style="text-align:right;color:#4338ca;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</div>

{{-- ── FOOTER ── --}}
<div class="footer">
    <table class="footer-table">
        <tr>
            <td><strong>Saung Angklung Udjo</strong> &middot; angklung-udjo.co.id</td>
            <td>Dokumen digenerate otomatis oleh sistem Admin SAU</td>
        </tr>
    </table>
</div>

</body>
</html>