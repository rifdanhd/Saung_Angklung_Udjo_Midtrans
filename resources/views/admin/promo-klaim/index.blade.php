{{-- resources/views/admin/promo/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Kelola Promo Klaim')
@section('content')

<style>
    .tabs { display:flex; gap:4px; background:var(--surface2); padding:4px; border-radius:10px; margin-bottom:20px; width:fit-content; border:1px solid var(--border); }
    .tab { padding:7px 16px; border-radius:7px; font-size:13px; font-weight:600; text-decoration:none; color:var(--text-muted); transition:all var(--transition); white-space:nowrap; display:flex; align-items:center; gap:6px; }
    .tab.active { background:var(--surface); color:var(--text); box-shadow:var(--shadow-sm); }
    .tab:hover:not(.active) { color:var(--text); }
    .tab-badge { background:var(--danger); color:#fff; border-radius:20px; padding:1px 6px; font-size:10px; font-weight:700; }

    .filter-bar { display:flex; gap:8px; margin-bottom:20px; flex-wrap:wrap; align-items:center; }
    .filter-input {
        padding:8px 13px; border-radius:var(--radius-sm); border:1.5px solid var(--border);
        font-size:13px; color:var(--text); background:var(--surface); outline:none;
        transition:border-color var(--transition); font-family:var(--font);
    }
    .filter-input:focus { border-color:var(--border-focus); box-shadow:0 0 0 3px rgba(124,111,255,.12); }

    .status-select {
        padding:6px 10px; border-radius:7px; border:1.5px solid var(--border);
        font-size:12px; font-weight:600; cursor:pointer; outline:none;
        background:var(--surface); min-width:128px; font-family:var(--font);
        transition:border-color var(--transition);
    }
    .status-select.s-pending   { color:#9a6c00; border-color:#f0d990; background:var(--gold-soft); }
    .status-select.s-confirmed { color:#1a7a4a; border-color:#9ddfc0; background:var(--success-soft); }
    .status-select.s-cancelled { color:#b81c21; border-color:#f5b8b0; background:var(--danger-soft); }

    .btn-del {
        width:30px; height:30px; display:flex; align-items:center; justify-content:center;
        border-radius:7px; border:1.5px solid var(--border); background:var(--surface);
        color:var(--danger); cursor:pointer; transition:all var(--transition); flex-shrink:0;
    }
    .btn-del:hover { background:var(--danger-soft); border-color:#f5b8b0; }
    .btn-del svg { width:14px; height:14px; }

    .wa-link { color:#22c55e; font-weight:600; text-decoration:none; font-size:12.5px; }
    .wa-link:hover { text-decoration:underline; }

    .empty-state { text-align:center; padding:60px 20px; color:var(--text-muted); }

    .modal-overlay {
        display:none; position:fixed; inset:0; background:rgba(10,8,30,.45);
        z-index:9999; align-items:center; justify-content:center; backdrop-filter:blur(3px);
    }
    .modal-box {
        background:var(--surface); border-radius:16px; padding:32px 28px;
        max-width:380px; width:90%; box-shadow:0 24px 64px rgba(34,24,93,.2);
        text-align:center; animation:modalIn .2s ease;
    }
    @keyframes modalIn { from { opacity:0; transform:scale(.95) translateY(10px); } to { opacity:1; transform:scale(1) translateY(0); } }
    .modal-box h3 { font-size:16px; font-weight:700; margin:12px 0 8px; color:var(--text); }
    .modal-box p  { font-size:13px; color:var(--text-muted); margin-bottom:22px; line-height:1.5; }
    .modal-actions { display:flex; gap:10px; justify-content:center; }

    /* ── Badge campuran ── */
    .badge-campuran {
        display:inline-flex; align-items:center; gap:3px;
        background:#f0f4ff; color:#3b5bdb; border:1px solid #c5d0fa;
        border-radius:20px; padding:2px 7px; font-size:10px; font-weight:700;
        letter-spacing:.3px;
    }

    /* ── Tiket breakdown tooltip ── */
    .tiket-wrap { display:flex; flex-direction:column; gap:3px; }
    .tiket-row  { display:flex; align-items:center; gap:4px; font-size:12px; white-space:nowrap; }
    .tiket-flag { font-size:12px; }

    /* ── Stat cards responsive ── */
    .stat-grid { display:grid; grid-template-columns:repeat(5,1fr); gap:12px; margin-bottom:24px; }
    @media(max-width:1200px) { .stat-grid { grid-template-columns:repeat(3,1fr); } }
    @media(max-width:700px)  { .stat-grid { grid-template-columns:repeat(2,1fr); } }
</style>

{{-- ── HEADER ── --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Promo Klaim Ramadhan 2026</h1>
        <div class="page-breadcrumb">Data klaim promo spesial Ramadhan 2026</div>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ url('/promo-ramadhan') }}" target="_blank" class="btn btn-outline">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            Lihat Halaman Promo
        </a>
        <a href="{{ route('admin.promo.exportPdf') }}" target="_blank" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
            Export PDF
        </a>
    </div>
</div>

{{-- ── STAT CARDS (5 kolom) ── --}}
<div class="stat-grid">

    {{-- Total Klaim --}}
    <div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:12px;"
         onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="width:42px;height:42px;border-radius:10px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="18" height="18" fill="none" stroke="var(--accent)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
        </div>
        <div>
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:3px;">Total Klaim</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);line-height:1;">{{ $totalKlaim }}</div>
        </div>
    </div>

    {{-- Total Pax --}}
    <div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:12px;"
         onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="width:42px;height:42px;border-radius:10px;background:#ede9ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <svg width="18" height="18" fill="none" stroke="#7c6fff" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/></svg>
        </div>
        <div>
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:3px;">Total Pax</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);line-height:1;">{{ $totalPax }}</div>
        </div>
    </div>

    {{-- Dewasa Domestik --}}
    <div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:12px;"
         onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="width:42px;height:42px;border-radius:10px;background:var(--gold-soft);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <span style="font-size:20px;">🇮🇩</span>
        </div>
        <div>
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:3px;">Dom. Dewasa</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);line-height:1;">{{ $totalDewasa }}</div>
           <div style="font-size:10px;color:var(--text-muted);">× Rp 68.000</div>
        </div>
    </div>

    {{-- Anak Domestik --}}
    <div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:12px;"
         onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="width:42px;height:42px;border-radius:10px;background:var(--success-soft);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <span style="font-size:20px;">👦</span>
        </div>
        <div>
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:3px;">Dom. Anak</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);line-height:1;">{{ $totalAnak }}</div>
            <div style="font-size:10px;color:var(--text-muted);">× Rp 60.000</div>
        </div>
    </div>

    {{-- Mancanegara --}}
    <div class="card" style="padding:18px 20px;display:flex;align-items:center;gap:12px;"
         onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
        <div style="width:42px;height:42px;border-radius:10px;background:#e8f0fa;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <span style="font-size:20px;">🌏</span>
        </div>
        <div>
            <div style="font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:3px;">Mancanegara</div>
            <div style="font-size:22px;font-weight:800;color:var(--text);line-height:1;">{{ $totalMancaDewasa + $totalMancaAnak }}</div>
            <div style="font-size:10px;color:var(--text-muted);">{{ $totalMancaDewasa }} dewasa · {{ $totalMancaAnak }} anak</div>
        </div>
    </div>

    {{-- Est. Pendapatan ── HIDDEN --}}

</div>

{{-- ── TABS ── --}}
<div class="tabs">
    <a href="{{ route('admin.promo.index') }}" class="tab {{ !request('status') ? 'active' : '' }}">Semua</a>
    <a href="{{ route('admin.promo.index', ['status'=>'pending']) }}" class="tab {{ request('status')=='pending' ? 'active' : '' }}">
        Pending
        @if(isset($totalPending) && $totalPending > 0)
            <span class="tab-badge">{{ $totalPending }}</span>
        @endif
    </a>
    <a href="{{ route('admin.promo.index', ['status'=>'confirmed']) }}" class="tab {{ request('status')=='confirmed' ? 'active' : '' }}">Confirmed</a>
    <a href="{{ route('admin.promo.index', ['status'=>'cancelled']) }}" class="tab {{ request('status')=='cancelled' ? 'active' : '' }}">Cancelled</a>
</div>

{{-- ── FILTER ── --}}
<form method="GET" action="{{ route('admin.promo.index') }}" class="filter-bar">
   @if(request('status'))
    <input type="hidden" name="status" value="{{ request('status') }}">
@endif
@if(request('sort'))
    <input type="hidden" name="sort" value="{{ request('sort') }}">
    <input type="hidden" name="dir" value="{{ request('dir') }}">
@endif
    <input type="text" name="search" placeholder="Cari nama, no HP..." value="{{ request('search') }}" class="filter-input" style="min-width:210px;">
    <input type="date" name="tanggal" value="{{ request('tanggal') }}" min="2026-02-23" max="2026-03-15" class="filter-input">
    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    @if(request('search') || request('tanggal') || request('status'))
        <a href="{{ route('admin.promo.index') }}" class="btn btn-outline btn-sm">Reset</a>
    @endif
</form>

{{-- ── TABLE ── --}}
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:36px;">#</th>
                    <th>Nama</th>
                    <th>Kota</th>
                    <th>No HP</th>
                    <th style="text-align:center;">🇮🇩 Domestik</th>
                    <th style="text-align:center;">🌏 Mancanegara</th>
                    <th style="text-align:center;">Total Pax</th>
                   @php
    $sortDir = request('sort') === 'tanggal_kunjungan' ? (request('dir') === 'asc' ? 'desc' : 'asc') : 'asc';
@endphp
<th>
    <a href="{{ request()->fullUrlWithQuery(['sort' => 'tanggal_kunjungan', 'dir' => $sortDir]) }}"
       style="text-decoration:none;color:inherit;display:flex;align-items:center;gap:4px;">
        Tgl Kunjungan
        @if(request('sort') === 'tanggal_kunjungan')
            {{ request('dir') === 'asc' ? '↑' : '↓' }}
        @else
            <span style="opacity:.3;">↕</span>
        @endif
    </a>
</th>
                    <th>Total Harga</th>
                    <th style="text-align:center;">Status</th>
                    <th>Input</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($klaims as $i => $item)
                @php
                    $hasDom   = $item->jumlah_tiket_dewasa > 0 || $item->jumlah_tiket_anak > 0;
                    $hasManca = $item->jumlah_tiket_manca_dewasa > 0 || $item->jumlah_tiket_manca_anak > 0;
                    $totalPaxRow = $item->jumlah_tiket_dewasa + $item->jumlah_tiket_anak
                                 + $item->jumlah_tiket_manca_dewasa + $item->jumlah_tiket_manca_anak;
                @endphp
                <tr>
                    <td style="color:var(--text-muted);font-size:12px;">{{ $klaims->firstItem() + $i }}</td>

                    <td style="font-weight:600;">
                        {{ $item->nama }}
                        @if($hasDom && $hasManca)
                            <span class="badge-campuran">Campuran</span>
                        @endif
                    </td>

                    <td style="color:var(--text-muted);font-size:13px;">{{ $item->kota }}</td>

                    <td>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}" target="_blank" class="wa-link">
                            {{ $item->no_hp }}
                        </a>
                    </td>

                    {{-- Domestik ── --}}
                    <td style="text-align:center;">
                        @if($hasDom)
                            <div class="tiket-wrap">
                                @if($item->jumlah_tiket_dewasa > 0)
                                    <div class="tiket-row"><span class="badge badge-brand">{{ $item->jumlah_tiket_dewasa }} Dewasa</span></div>
                                @endif
                                @if($item->jumlah_tiket_anak > 0)
                                    <div class="tiket-row"><span class="badge badge-success">{{ $item->jumlah_tiket_anak }} Anak</span></div>
                                @endif
                            </div>
                        @else
                            <span style="color:var(--text-muted);font-size:12px;">–</span>
                        @endif
                    </td>

                    {{-- Mancanegara ── --}}
                    <td style="text-align:center;">
                        @if($hasManca)
                            <div class="tiket-wrap">
                                @if($item->jumlah_tiket_manca_dewasa > 0)
                                    <div class="tiket-row"><span class="badge" style="background:#dbeafe;color:#1e40af;border:1px solid #bfdbfe;">{{ $item->jumlah_tiket_manca_dewasa }} Dewasa</span></div>
                                @endif
                                @if($item->jumlah_tiket_manca_anak > 0)
                                    <div class="tiket-row"><span class="badge" style="background:#ede9ff;color:#5b21b6;border:1px solid #c4b5fd;">{{ $item->jumlah_tiket_manca_anak }} Anak</span></div>
                                @endif
                            </div>
                        @else
                            <span style="color:var(--text-muted);font-size:12px;">–</span>
                        @endif
                    </td>

                    {{-- Total Pax ── --}}
                    <td style="text-align:center;">
                        <span style="font-weight:700;font-size:14px;color:var(--text);">{{ $totalPaxRow }}</span>
                        <span style="font-size:11px;color:var(--text-muted);"> org</span>
                    </td>

                    <td style="color:var(--text);font-size:13px;white-space:nowrap;">
                        {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->format('d M Y') }}
                    </td>

                    <td style="font-weight:700;color:var(--brand);font-size:13.5px;">
                        Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                    </td>

                    <td style="text-align:center;" id="status-badge-{{ $item->id }}">
                        @if($item->status === 'confirmed')
                            <span class="badge badge-success">Confirmed</span>
                        @elseif($item->status === 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-danger">Cancelled</span>
                        @endif
                    </td>

                    <td style="color:var(--text-muted);font-size:11.5px;white-space:nowrap;">
                        {{ $item->created_at->format('d/m/Y H:i') }}
                    </td>

                    <td>
                        <div style="display:flex;align-items:center;gap:6px;justify-content:center;">
                            <select class="status-select s-{{ $item->status }}"
                                    data-id="{{ $item->id }}"
                                    data-url="{{ route('admin.promo.updateStatus', $item->id) }}">
                                <option value="pending"   @selected($item->status==='pending')>Pending</option>
                                <option value="confirmed" @selected($item->status==='confirmed')>Confirmed</option>
                                <option value="cancelled" @selected($item->status==='cancelled')>Cancelled</option>
                            </select>
                            <button type="button" class="btn-del" onclick="showModal({{ $item->id }}, '{{ addslashes($item->nama) }}')">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12">
                        <div class="empty-state">
                            <svg width="40" height="40" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block;opacity:.3;"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p style="font-size:14px;">Belum ada data klaim promo</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($klaims->hasPages())
    <div style="padding:14px 20px;border-top:1px solid var(--border);">{{ $klaims->links() }}</div>
    @endif
</div>

{{-- ── MODAL HAPUS ── --}}
<div id="modalHapus" class="modal-overlay">
    <div class="modal-box">
        <div style="width:52px;height:52px;background:var(--danger-soft);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;">
            <svg width="22" height="22" fill="none" stroke="var(--danger)" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
        </div>
        <h3>Hapus Data Klaim?</h3>
        <p>Data klaim atas nama <strong id="namaHapus"></strong> akan dihapus secara permanen dan tidak dapat dikembalikan.</p>
        <div class="modal-actions">
            <button onclick="hideModal()" class="btn btn-outline">Batal</button>
            <form id="formHapus" method="POST" style="margin:0;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" style="background:var(--danger);color:#fff;border:none;">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

<script>
    function showModal(id, nama) {
        document.getElementById('namaHapus').textContent = nama;
        document.getElementById('formHapus').action = '/admin/promo-klaim/' + id;
        document.getElementById('modalHapus').style.display = 'flex';
    }
    function hideModal() {
        document.getElementById('modalHapus').style.display = 'none';
    }
    document.getElementById('modalHapus').addEventListener('click', function(e) {
        if (e.target === this) hideModal();
    });

    const badgeMap = {
        pending:   '<span class="badge badge-warning">Pending</span>',
        confirmed: '<span class="badge badge-success">Confirmed</span>',
        cancelled: '<span class="badge badge-danger">Cancelled</span>',
    };

    document.querySelectorAll('.status-select').forEach(sel => {
        sel.addEventListener('change', function() {
            const id = this.dataset.id, newStatus = this.value, self = this;
            const fd = new FormData();
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('status', newStatus);
            fetch(this.dataset.url, { method: 'POST', body: fd }).then(res => {
                if (res.ok || res.redirected) {
                    document.getElementById('status-badge-' + id).innerHTML = badgeMap[newStatus];
                    self.className = 'status-select s-' + newStatus;
                }
            });
        });
    });
</script>

@endsection