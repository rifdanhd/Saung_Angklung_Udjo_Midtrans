{{-- resources/views/admin/articles/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Daftar Artikel')
@section('content')

<div class="page-header">
    <div>
        <h1 class="page-title">Daftar Artikel</h1>
        <div class="page-breadcrumb">
            <span>Dashboard</span>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 18l6-6-6-6"/></svg>
            <span>Artikel</span>
        </div>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        Tambah Artikel
    </a>
</div>

<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th style="width:90px;">Foto</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th style="width:100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td style="color:var(--text-muted);font-size:12.5px;">
                        {{ $loop->iteration + ($articles->currentPage() - 1) * $articles->perPage() }}
                    </td>

                    <td>
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                 alt="{{ $article->title }}"
                                 style="width:72px;height:46px;object-fit:cover;border-radius:8px;border:1px solid var(--border);">
                        @else
                            <div style="width:72px;height:46px;background:var(--surface2);border-radius:8px;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;">
                                <svg width="16" height="16" fill="none" stroke="var(--text-muted)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </td>

                    <td>
                        <div style="font-weight:600;font-size:13.5px;color:var(--text);max-width:340px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $article->title }}
                        </div>
                    </td>

                    <td>
                        <span class="badge badge-brand">{{ $article->category }}</span>
                    </td>

                    <td style="color:var(--text-muted);font-size:13px;">{{ $article->user->name ?? '-' }}</td>

                    <td style="color:var(--text-muted);font-size:13px;white-space:nowrap;">{{ $article->created_at->format('d M Y') }}</td>

                    <td>
                        @if($article->is_published)
                            <span class="badge badge-success">Published</span>
                        @else
                            <span class="badge badge-muted">Draft</span>
                        @endif
                    </td>

                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('admin.articles.edit', $article) }}"
                               style="display:inline-flex;align-items:center;gap:5px;font-size:12.5px;font-weight:600;color:var(--accent);text-decoration:none;padding:5px 10px;border-radius:7px;transition:background .15s;"
                               onmouseover="this.style.background='var(--accent-soft)'" onmouseout="this.style.background='transparent'">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M9 11l3 3L21 5l-3-3-12 12v3h3z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST"
                                  onsubmit="return confirm('Hapus artikel ini?')" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        style="display:inline-flex;align-items:center;gap:5px;font-size:12.5px;font-weight:600;color:var(--danger);background:none;border:none;cursor:pointer;padding:5px 10px;border-radius:7px;transition:background .15s;font-family:var(--font);"
                                        onmouseover="this.style.background='var(--danger-soft)'" onmouseout="this.style.background='transparent'">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:56px 20px;">
                        <svg width="40" height="40" fill="none" stroke="var(--text-muted)" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 12px;opacity:.4;display:block;"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        <div style="font-size:14px;color:var(--text-muted);">Belum ada artikel</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
    <div style="padding:14px 20px;border-top:1px solid var(--border);">
        {{ $articles->links() }}
    </div>
    @endif
</div>

@endsection