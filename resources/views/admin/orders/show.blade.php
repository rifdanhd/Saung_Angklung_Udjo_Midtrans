@extends('admin.layouts.app')
@section('title', 'Detail Order')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Detail Order</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <a href="{{ route('admin.orders.index') }}">Booking</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <span>{{ $order->order_code }}</span>
        </div>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">← Kembali</a>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;">

    {{-- Kiri --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Info Pemesan --}}
        <div class="card" style="padding:22px;">
            <div style="font-size:13px;font-weight:700;margin-bottom:16px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Data Pemesan</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:3px;">Nama</div>
                    <div style="font-weight:600;">{{ $order->nama_pemesan }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:3px;">Email</div>
                    <div style="font-weight:600;">{{ $order->email }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:3px;">No. HP / WA</div>
                    <div style="font-weight:600;">{{ $order->no_telepon }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:3px;">Kota Asal</div>
                    <div style="font-weight:600;">{{ $order->kota_asal ?? '-' }}</div>
                </div>
            </div>
        </div>

        {{-- Detail Kunjungan --}}
        <div class="card" style="padding:22px;">
            <div style="font-size:13px;font-weight:700;margin-bottom:16px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Detail Kunjungan</div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:3px;">Tanggal</div>
                    <div style="font-weight:600;">{{ $order->tanggal_kunjungan }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:3px;">Sesi</div>
                    <div style="font-weight:600;">{{ $order->sesi }}</div>
                </div>
            </div>
        </div>

        {{-- Item Tiket --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title">Rincian Tiket</div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Jenis Tiket</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($items)
                            @foreach($items as $item)
                            <tr>
                                <td style="font-weight:600;">{{ $item['name'] ?? '-' }}</td>
                                <td>{{ $item['quantity'] ?? $item['qty'] ?? 1 }}</td>
                                <td>Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                                <td style="font-weight:700;">Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? $item['qty'] ?? 1), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        @endif
                        <tr style="background:var(--surface2);">
                            <td colspan="3" style="font-weight:700;text-align:right;">TOTAL</td>
                            <td style="font-weight:800;font-size:15px;color:var(--accent);">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Kanan --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- Status --}}
        <div class="card" style="padding:22px;">
            <div style="font-size:13px;font-weight:700;margin-bottom:16px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Status Pembayaran</div>

            @php
                $badge = match($order->status) {
                    'paid'      => 'badge-success',
                    'pending'   => 'badge-warning',
                    'cancelled' => 'badge-danger',
                    default     => 'badge-muted',
                };
                $label = match($order->status) {
                    'paid'      => 'Lunas ✓',
                    'pending'   => 'Menunggu Pembayaran',
                    'cancelled' => 'Dibatalkan',
                    'expired'   => 'Expired',
                    default     => $order->status,
                };
            @endphp
            <span class="badge {{ $badge }}" style="font-size:13px;padding:6px 14px;">{{ $label }}</span>

            {{-- Update Status Manual --}}
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" style="margin-top:16px;">
                @csrf @method('PATCH')
                <div class="form-group">
                    <label class="form-label">Update Status</label>
                    <select name="status" class="form-control">
                        <option value="pending"   {{ $order->status==='pending'   ?'selected':'' }}>Pending</option>
                        <option value="paid"      {{ $order->status==='paid'      ?'selected':'' }}>Lunas</option>
                        <option value="cancelled" {{ $order->status==='cancelled' ?'selected':'' }}>Dibatalkan</option>
                        <option value="expired"   {{ $order->status==='expired'   ?'selected':'' }}>Expired</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%;">Simpan Status</button>
            </form>
        </div>

        {{-- Info Order --}}
        <div class="card" style="padding:22px;">
            <div style="font-size:13px;font-weight:700;margin-bottom:16px;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;">Info Order</div>
            <div style="display:flex;flex-direction:column;gap:12px;">
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:2px;">Kode Order</div>
                    <div style="font-weight:700;font-family:monospace;color:var(--accent);">{{ $order->order_code }}</div>
                </div>
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:2px;">Tanggal Order</div>
                    <div style="font-weight:600;">{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
                @if($order->snap_token)
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:2px;">Snap Token</div>
                    <div style="font-size:11px;font-family:monospace;word-break:break-all;color:var(--text-muted);">{{ Str::limit($order->snap_token, 40) }}</div>
                </div>
                @endif
                @if($order->paid_at)
                <div>
                    <div style="font-size:11px;color:var(--text-muted);margin-bottom:2px;">Dibayar Pada</div>
                    <div style="font-weight:600;color:var(--success);">{{ \Carbon\Carbon::parse($order->paid_at)->format('d M Y, H:i') }}</div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection