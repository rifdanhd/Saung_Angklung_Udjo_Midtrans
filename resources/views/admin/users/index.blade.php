@extends('admin.layouts.app')

@section('title', 'Manajemen User')

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen User</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 18l6-6-6-6"/>
            </svg>
            <span>Users</span>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;">

    <div class="card" style="padding:18px 20px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:8px;">Total User</div>
        <div style="font-size:28px;font-weight:800;color:var(--text);">{{ $stats['total'] }}</div>
    </div>

    <div class="card" style="padding:18px 20px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:8px;">Login Google</div>
        <div style="font-size:28px;font-weight:800;color:var(--accent);">{{ $stats['google'] }}</div>
    </div>

    <div class="card" style="padding:18px 20px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:8px;">Login WhatsApp</div>
        <div style="font-size:28px;font-weight:800;color:var(--success);">{{ $stats['whatsapp'] }}</div>
    </div>

    <div class="card" style="padding:18px 20px;">
        <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--text-muted);margin-bottom:8px;">Login Email</div>
        <div style="font-size:28px;font-weight:800;color:var(--gold);">{{ $stats['email'] }}</div>
    </div>

</div>

{{-- Table --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar User</div>
            <div class="card-sub">Semua visitor yang sudah mendaftar</div>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Kontak</th>
                    <th>Role</th>
                    <th>Login Via</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" style="width:34px;height:34px;border-radius:8px;object-fit:cover;">
                            @else
                                <div style="width:34px;height:34px;border-radius:8px;background:var(--accent-soft);color:var(--accent);font-weight:700;font-size:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div style="font-weight:600;font-size:13.5px;">{{ $user->name }}</div>
                                <div style="font-size:12px;color:var(--text-muted);">#{{ $user->id }}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        @if($user->email && !str_ends_with($user->email, '@wa.local'))
                            <div style="font-size:13px;">{{ $user->email }}</div>
                        @endif
                        @if($user->phone)
                            <div style="font-size:12px;color:var(--text-muted);">{{ $user->phone }}</div>
                        @endif
                    </td>

                    <td>
                        @if($user->role === 'admin')
                            <span class="badge badge-brand">Admin</span>
                        @else
                            <span class="badge badge-muted">Visitor</span>
                        @endif
                    </td>

                    <td>
                        @if($user->google_id)
                            <span class="badge badge-success">Google</span>
                        @elseif($user->phone)
                            <span class="badge badge-warning">WhatsApp</span>
                        @else
                            <span class="badge badge-muted">Email</span>
                        @endif
                    </td>

                    <td style="color:var(--text-muted);font-size:13px;">
                        {{ $user->created_at->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:40px;color:var(--text-muted);">
                        Belum ada user yang mendaftar
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div style="padding:16px 22px;border-top:1px solid var(--border);">
        {{ $users->links() }}
    </div>
    @endif
</div>

@endsection