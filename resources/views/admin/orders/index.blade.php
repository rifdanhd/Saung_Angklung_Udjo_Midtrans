@extends('admin.layouts.app')
@section('title', 'Manajemen Pembayaran')
@section('content')

{{-- Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen Pembayaran</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6"/>
            </svg>
            <span>Orders</span>
        </div>
    </div>
</div>

{{-- Stats --}}
<div style="display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:24px;">
    <div class="card" style="padding:18px 20px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:8px;">Total Order</div>
        <div style="font-size:28px;font-weight:800;color:var(--text);">{{ $stats['total'] }}</div>
    </div>
    <div class="card" style="padding:18px 20px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:8px;">Lunas</div>
        <div style="font-size:28px;font-weight:800;color:var(--success);">{{ $stats['paid'] }}</div>
    </div>
    <div class="card" style="padding:18px 20px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:8px;">Pending</div>
        <div style="font-size:28px;font-weight:800;color:var(--gold);">{{ $stats['pending'] }}</div>
    </div>
    <div class="card" style="padding:18px 20px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:8px;">Dibatalkan</div>
        <div style="font-size:28px;font-weight:800;color:#ef4444;">{{ $stats['cancelled'] }}</div>
    </div>
    <div class="card" style="padding:18px 20px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:8px;">Total Revenue</div>
        <div style="font-size:20px;font-weight:800;color:var(--accent);">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</div>
    </div>
</div>

{{-- Filter --}}
<div class="card" style="padding:16px 20px;margin-bottom:16px;">
    <form method="GET" style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari nama, email, kode order..."
            style="flex:1;min-width:200px;padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;">
        <select name="status" style="padding:8px 12px;border:1px solid var(--border);border-radius:8px;font-size:13px;">
            <option value="">Semua Status</option>
            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
            <option value="paid"      {{ request('status') === 'paid'      ? 'selected' : '' }}>Lunas</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            <option value="expired"   {{ request('status') === 'expired'   ? 'selected' : '' }}>Expired</option>
        </select>
        <button type="submit" class="btn-primary" style="padding:8px 20px;">Filter</button>
        <a href="{{ route('admin.orders.index') }}" style="padding:8px 16px;font-size:13px;color:var(--text-muted);">Reset</a>
    </form>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;gap:16px;">
        <div>
            <div class="card-title">Daftar Order</div>
            <div class="card-sub">Semua transaksi via Midtrans</div>
        </div>
        <a href="{{ route('admin.tickets.scan.index') }}" class="btn-primary" style="padding:10px 18px;white-space:nowrap;">Buka Scanner Tiket</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Pemesan</th>
                    <th>Kunjungan</th>
                    <th>Tiket</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>
                        <div style="font-weight:700;font-size:13px;font-family:monospace;">{{ $order->order_code }}</div>
                        <div style="font-size:11px;color:var(--text-muted);">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </td>
                    <td>
                        <div style="font-weight:600;font-size:13px;">{{ $order->nama_pemesan }}</div>
                        <div style="font-size:12px;color:var(--text-muted);">{{ $order->email }}</div>
                        <div style="font-size:12px;color:var(--text-muted);">{{ $order->no_telepon }}</div>
                    </td>
                  <td>
    <div style="font-size:13px;font-weight:600;">
        {{ \Carbon\Carbon::parse($order->tanggal_kunjungan)->format('d M Y') }}
    </div>
    <div style="font-size:12px;color:var(--text-muted);">
        @php
            $sesiLabel = match(strtolower($order->sesi)) {
                'pagi', 'morning'  => '09.00 – 11.00 WIB',
                'siang', 'noon'    => '13.00 – 14.30 WIB',
                'sore', 'evening'  => '15.30 – 17.00 WIB',
                'reg'              => '13.00 – 14.30 WIB',
                default            => $order->sesi,
            };
        @endphp
        {{ $sesiLabel }}
    </div>
</td>
                    <td style="font-size:13px;">{{ $order->total_tiket }} tiket</td>
                    <td style="font-weight:700;font-size:13px;">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $badge = match($order->status) {
                                'paid'      => 'badge-success',
                                'pending'   => 'badge-warning',
                                'cancelled' => 'badge-danger',
                                'expired'   => 'badge-muted',
                                default     => 'badge-muted',
                            };
                            $label = match($order->status) {
                                'paid'      => 'Lunas',
                                'pending'   => 'Pending',
                                'cancelled' => 'Dibatalkan',
                                'expired'   => 'Expired',
                                default     => $order->status,
                            };
                        @endphp
                        <span class="badge {{ $badge }}">{{ $label }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.orders.show', $order) }}"
                            style="font-size:12px;font-weight:600;color:var(--accent);text-decoration:none;">
                            Detail →
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted);">
                        Belum ada order masuk
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($orders->hasPages())
    <div style="padding:16px 22px;border-top:1px solid var(--border);">
        {{ $orders->links() }}
    </div>
    @endif
</div>
@endsection
