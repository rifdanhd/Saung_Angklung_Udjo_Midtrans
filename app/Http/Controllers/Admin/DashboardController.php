<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\Article;
use App\Models\PromoKlaim;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Stats sederhana
        $stats = [
            'total_articles'       => Article::count(),
            'pending_testimonials' => Testimonial::where('is_approved', false)->count(),
        ];

        // 2. Promo Klaim — Stat Cards
        $promoTotal     = PromoKlaim::count();
        $promoPending   = PromoKlaim::where('status', 'pending')->count();
        $promoConfirmed = PromoKlaim::where('status', 'confirmed')->count();
        $promoCancelled = PromoKlaim::where('status', 'cancelled')->count();
        $promoTotalPax  = PromoKlaim::selectRaw('
                SUM(jumlah_tiket_dewasa + jumlah_tiket_anak
                  + jumlah_tiket_manca_dewasa + jumlah_tiket_manca_anak) as total
            ')->value('total') ?? 0;

        // 3. Promo Klaim — Data Grafik (30 hari terakhir)
        $promoChart = PromoKlaim::selectRaw("
                DATE(created_at) as tgl,
                COUNT(*) as total_klaim,
                SUM(jumlah_tiket_dewasa + jumlah_tiket_anak
                  + jumlah_tiket_manca_dewasa + jumlah_tiket_manca_anak) as total_pax,
                SUM(CASE WHEN status = 'confirmed' THEN 1 ELSE 0 END) as confirmed
            ")
            ->where('created_at', '>=', now()->subDays(29))
            ->groupBy('tgl')
            ->orderBy('tgl')
            ->get();

        $chartLabels    = $promoChart->pluck('tgl')
                            ->map(function($d) { return Carbon::parse($d)->format('d M'); });
        $chartKlaim     = $promoChart->pluck('total_klaim');
        $chartPax       = $promoChart->pluck('total_pax');
        $chartConfirmed = $promoChart->pluck('confirmed');

        // 4. Klaim terbaru (5 data)
        $recentKlaims = PromoKlaim::latest()->take(5)->get();

        // 5. Testimoni belum diapprove (5 data)
        $pendingTestimonials = Testimonial::where('is_approved', false)
                                ->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'promoTotal',
            'promoPending',
            'promoConfirmed',
            'promoCancelled',
            'promoTotalPax',
            'chartLabels',
            'chartKlaim',
            'chartPax',
            'chartConfirmed',
            'recentKlaims',
            'pendingTestimonials'
        ));
    }
}