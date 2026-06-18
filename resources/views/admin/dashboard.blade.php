{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Dashboard Admin')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <div class="page-breadcrumb">
            <span>Selamat datang kembali, {{ auth()->user()->name }} 👋</span>
        </div>
    </div>
</div>

{{-- ── STAT CARDS ── --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px;">

    {{-- Testimoni Pending --}}
    <div class="card" style="padding:22px;position:relative;overflow:hidden;transition:box-shadow .2s,transform .2s;"
         onmouseover="this.style.boxShadow='var(--shadow)';this.style.transform='translateY(-2px)'"
         onmouseout="this.style.boxShadow='var(--shadow-sm)';this.style.transform='translateY(0)'">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:var(--danger);"></div>
        <div style="width:40px;height:40px;border-radius:10px;background:var(--danger-soft);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
            <svg width="18" height="18" fill="none" stroke="var(--danger)" stroke-width="2" viewBox="0 0 24 24"><path d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
        </div>
        <div style="font-size:26px;font-weight:800;color:var(--text);line-height:1;letter-spacing:-1px;">{{ $stats['pending_testimonials'] }}</div>
        <div style="font-size:12px;color:var(--text-muted);margin-top:5px;font-weight:500;">Testimoni Pending</div>
        <div style="font-size:11.5px;color:var(--danger);margin-top:10px;font-weight:600;">Perlu review</div>
    </div>

    {{-- Total Klaim --}}
    <div class="card" style="padding:22px;position:relative;overflow:hidden;transition:box-shadow .2s,transform .2s;"
         onmouseover="this.style.boxShadow='var(--shadow)';this.style.transform='translateY(-2px)'"
         onmouseout="this.style.boxShadow='var(--shadow-sm)';this.style.transform='translateY(0)'">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:#7c6fff;"></div>
        <div style="width:40px;height:40px;border-radius:10px;background:#ede9ff;display:flex;align-items:center;justify-content:center;margin-bottom:14px;font-size:20px;">🎟️</div>
        <div style="font-size:26px;font-weight:800;color:var(--text);line-height:1;letter-spacing:-1px;">{{ $promoTotal }}</div>
        <div style="font-size:12px;color:var(--text-muted);margin-top:5px;font-weight:500;">Total Klaim Promo</div>
        <div style="font-size:11.5px;color:#7c6fff;margin-top:10px;font-weight:600;">{{ $promoTotalPax }} pax total</div>
    </div>

    {{-- Pending Klaim --}}
    <div class="card" style="padding:22px;position:relative;overflow:hidden;transition:box-shadow .2s,transform .2s;"
         onmouseover="this.style.boxShadow='var(--shadow)';this.style.transform='translateY(-2px)'"
         onmouseout="this.style.boxShadow='var(--shadow-sm)';this.style.transform='translateY(0)'">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:var(--warning);"></div>
        <div style="width:40px;height:40px;border-radius:10px;background:var(--gold-soft);display:flex;align-items:center;justify-content:center;margin-bottom:14px;font-size:20px;">⏳</div>
        <div style="font-size:26px;font-weight:800;color:var(--text);line-height:1;letter-spacing:-1px;">{{ $promoPending }}</div>
        <div style="font-size:12px;color:var(--text-muted);margin-top:5px;font-weight:500;">Klaim Pending</div>
        <div style="font-size:11.5px;color:var(--warning);margin-top:10px;font-weight:600;">Perlu dikonfirmasi</div>
    </div>

    {{-- Confirmed Klaim --}}
    <div class="card" style="padding:22px;position:relative;overflow:hidden;transition:box-shadow .2s,transform .2s;"
         onmouseover="this.style.boxShadow='var(--shadow)';this.style.transform='translateY(-2px)'"
         onmouseout="this.style.boxShadow='var(--shadow-sm)';this.style.transform='translateY(0)'">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:var(--success);"></div>
        <div style="width:40px;height:40px;border-radius:10px;background:var(--success-soft);display:flex;align-items:center;justify-content:center;margin-bottom:14px;font-size:20px;">✅</div>
        <div style="font-size:26px;font-weight:800;color:var(--text);line-height:1;letter-spacing:-1px;">{{ $promoConfirmed }}</div>
        <div style="font-size:12px;color:var(--text-muted);margin-top:5px;font-weight:500;">Klaim Confirmed</div>
        <div style="font-size:11.5px;color:var(--success);margin-top:10px;font-weight:600;">{{ $promoCancelled }} dibatalkan</div>
    </div>

</div>

{{-- ── GRAFIK PROMO KLAIM ── --}}
<div class="card" style="padding:24px;margin-bottom:24px;">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;">
        <div>
            <div style="font-size:15px;font-weight:700;color:var(--text);">📊 Rekap Promo Klaim Ramadhan 2026</div>
            <div style="font-size:12px;color:var(--text-muted);margin-top:3px;">Tren klaim & pax per hari (30 hari terakhir)</div>
        </div>
        <a href="{{ route('admin.promo.index') }}" class="btn btn-outline btn-sm">Lihat Detail →</a>
    </div>

    <div style="position:relative;height:300px;">
        <canvas id="promoChart"></canvas>
    </div>

    {{-- Legend --}}
    <div style="display:flex;gap:20px;margin-top:16px;flex-wrap:wrap;">
        <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text-muted);">
            <span style="width:14px;height:14px;border-radius:3px;background:#7c6fff;display:inline-block;"></span> Total Klaim
        </div>
        <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text-muted);">
            <span style="width:14px;height:14px;border-radius:3px;background:#22c55e;display:inline-block;"></span> Confirmed
        </div>
        <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text-muted);">
            <span style="width:28px;height:3px;background:#f59e0b;border-radius:99px;display:inline-block;"></span> Total Pax
        </div>
    </div>
</div>

{{-- ── BOTTOM ROW ── --}}
<div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">

    {{-- Klaim Terbaru --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">Klaim Terbaru</div>
            <a href="{{ route('admin.promo.index') }}" class="card-action">Lihat Semua →</a>
        </div>
        <div style="padding:8px 0;">
            @forelse($recentKlaims as $klaim)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);transition:background .15s;"
                 onmouseover="this.style.background='var(--surface2)'" onmouseout="this.style.background='transparent'">
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:13.5px;color:var(--text);">{{ $klaim->nama }}</div>
                    <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">{{ $klaim->kota }} · {{ \Carbon\Carbon::parse($klaim->tanggal_kunjungan)->format('d M Y') }}</div>
                </div>
                <div style="text-align:right;flex-shrink:0;margin-left:12px;">
                    <span class="badge {{ $klaim->status === 'confirmed' ? 'badge-success' : ($klaim->status === 'pending' ? 'badge-warning' : 'badge-danger') }}">
                        {{ ucfirst($klaim->status) }}
                    </span>
                    <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">
                        {{ $klaim->jumlah_tiket_dewasa + $klaim->jumlah_tiket_anak + $klaim->jumlah_tiket_manca_dewasa + $klaim->jumlah_tiket_manca_anak }} pax
                    </div>
                </div>
            </div>
            @empty
            <div style="text-align:center;padding:48px 20px;color:var(--text-muted);">
                <div style="font-size:13px;">Belum ada klaim</div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Testimoni Perlu Review --}}
    <div class="card">
        <div class="card-header">
            <div class="card-title">Testimoni Perlu Review</div>
            <a href="{{ route('admin.testimonials.index') }}" class="card-action">Lihat Semua →</a>
        </div>
        <div style="padding:8px 0;">
            @forelse($pendingTestimonials as $t)
            <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);transition:background .15s;"
                 onmouseover="this.style.background='var(--surface2)'" onmouseout="this.style.background='transparent'">
                <div style="flex:1;min-width:0;">
                    <div style="font-weight:600;font-size:13.5px;color:var(--text);">{{ $t->name }}</div>
                    <div style="font-size:12px;color:var(--text-muted);margin-top:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:220px;">{{ $t->message }}</div>
                </div>
                <span class="badge badge-warning" style="flex-shrink:0;margin-left:10px;">Pending</span>
            </div>
            @empty
            <div style="text-align:center;padding:48px 20px;color:var(--text-muted);">
                <div style="font-size:13px;">Semua testimoni sudah direview ✅</div>
            </div>
            @endforelse
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
    const labels    = @json($chartLabels);
    const klaim     = @json($chartKlaim);
    const pax       = @json($chartPax);
    const confirmed = @json($chartConfirmed);

    new Chart(document.getElementById('promoChart'), {
        data: {
            labels,
            datasets: [
                {
                    type: 'bar',
                    label: 'Total Klaim',
                    data: klaim,
                    backgroundColor: 'rgba(124,111,255,.75)',
                    borderRadius: 6,
                    yAxisID: 'y',
                    order: 2,
                },
                {
                    type: 'bar',
                    label: 'Confirmed',
                    data: confirmed,
                    backgroundColor: 'rgba(34,197,94,.6)',
                    borderRadius: 6,
                    yAxisID: 'y',
                    order: 3,
                },
                {
                    type: 'line',
                    label: 'Total Pax',
                    data: pax,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245,158,11,.1)',
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#f59e0b',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y2',
                    order: 1,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: { legend: { display: false } },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 }, color: '#94a3b8' }
                },
                y: {
                    position: 'left',
                    beginAtZero: true,
                    ticks: { stepSize: 1, font: { size: 11 }, color: '#94a3b8' },
                    grid: { color: 'rgba(0,0,0,.05)' }
                },
                y2: {
                    position: 'right',
                    beginAtZero: true,
                    ticks: { font: { size: 11 }, color: '#f59e0b' },
                    grid: { display: false }
                }
            }
        }
    });
})();
</script>

@endsection