<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromoKlaim;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PromoKlaimController extends Controller
{
    public function index(Request $request)
    {
       $sortField = $request->get('sort', 'tanggal_kunjungan');
$sortDir   = $request->get('dir', 'desc');

// Whitelist kolom yang boleh di-sort
$allowed = ['tanggal_kunjungan', 'nama', 'total_harga', 'created_at'];
if (!in_array($sortField, $allowed)) {
    $sortField = 'tanggal_kunjungan';
}

$query = PromoKlaim::orderBy($sortField, $sortDir);
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_kunjungan', $request->tanggal);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $klaims = $query->paginate(50);

        // ── Stats umum ──
        $totalKlaim      = PromoKlaim::count();
        $totalPendapatan = PromoKlaim::sum('total_harga');

        // ── Domestik ──
        $totalDewasa = PromoKlaim::sum('jumlah_tiket_dewasa');
        $totalAnak   = PromoKlaim::sum('jumlah_tiket_anak');

        // ── Mancanegara ✅ Baru ──
        $totalMancaDewasa = PromoKlaim::sum('jumlah_tiket_manca_dewasa');
        $totalMancaAnak   = PromoKlaim::sum('jumlah_tiket_manca_anak');

        // ── Total pax gabungan ✅ Baru ──
        $totalPax = $totalDewasa + $totalAnak + $totalMancaDewasa + $totalMancaAnak;

        // ── Per status ──
        $totalPending   = PromoKlaim::where('status', 'pending')->count();
        $totalConfirmed = PromoKlaim::where('status', 'confirmed')->count();
        $totalCancelled = PromoKlaim::where('status', 'cancelled')->count();

        return view('admin.promo-klaim.index', compact(
            'klaims',
            'totalKlaim',
            'totalDewasa',
            'totalAnak',
            'totalMancaDewasa',   // ✅ Baru
            'totalMancaAnak',     // ✅ Baru
            'totalPax',           // ✅ Baru
            'totalPendapatan',
            'totalPending',
            'totalConfirmed',
            'totalCancelled'
        ));
    }

    public function updateStatus(Request $request, PromoKlaim $promoKlaim)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $promoKlaim->update(['status' => $request->status]);

        return back()->with('success', 'Status berhasil diperbarui.');
    }

    public function destroy(PromoKlaim $promoKlaim)
    {
        $promoKlaim->delete();

        return back()->with('success', 'Data klaim berhasil dihapus.');
    }

    public function exportPdf()
    {
        $data = PromoKlaim::where('status', 'confirmed')->latest()->get();

        // ── Hitung ringkasan untuk PDF ✅ Diperbarui ──
        $summary = [
            'total_klaim'        => $data->count(),
            'dom_dewasa'         => $data->sum('jumlah_tiket_dewasa'),
            'dom_anak'           => $data->sum('jumlah_tiket_anak'),
            'manca_dewasa'       => $data->sum('jumlah_tiket_manca_dewasa'), // ✅ Baru
            'manca_anak'         => $data->sum('jumlah_tiket_manca_anak'),   // ✅ Baru
            'total_pendapatan'   => $data->sum('total_harga'),
        ];

        $summary['total_pax'] = $summary['dom_dewasa']
                              + $summary['dom_anak']
                              + $summary['manca_dewasa']
                              + $summary['manca_anak'];

        $pdf = Pdf::loadView('admin.promo-klaim.pdf', compact('data', 'summary'));

        return $pdf->download('promo-klaim-confirmed.pdf');
    }
}