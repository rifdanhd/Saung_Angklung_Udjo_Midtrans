<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromoKlaim;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index()
    {
        return view('promo-ramadhan');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'nama'                      => 'required|string|max:100',
            'kota'                      => 'required|string|max:100',
            'no_hp'                     => ['required', 'regex:/^(\+62|62|0)8[0-9]{8,11}$/'],
            'jumlah_tiket_dewasa'       => 'nullable|integer|min:0|max:100',
            'jumlah_tiket_anak'         => 'nullable|integer|min:0|max:100',
            'jumlah_tiket_manca_dewasa' => 'nullable|integer|min:0|max:100', // ✅ Baru
            'jumlah_tiket_manca_anak'   => 'nullable|integer|min:0|max:100', // ✅ Baru
            'tanggal_kunjungan'         => 'required|date|after_or_equal:2026-02-23|before_or_equal:2026-03-15',
        ], [
            'no_hp.regex' => 'Nomor HP harus nomor Indonesia yang valid (diawali 08 atau +62).',
        ]);

        // Domestik
        $dewasa = (int) ($request->jumlah_tiket_dewasa ?? 0);
        $anak   = (int) ($request->jumlah_tiket_anak   ?? 0);

        // Mancanegara ✅ Baru
        $mancaDewasa = (int) ($request->jumlah_tiket_manca_dewasa ?? 0);
        $mancaAnak   = (int) ($request->jumlah_tiket_manca_anak   ?? 0);

        // Validasi minimal 1 tiket (gabungan)
        if ($dewasa + $anak + $mancaDewasa + $mancaAnak < 1) {
            return back()
                ->withErrors(['tiket' => 'Harap masukkan minimal 1 tiket (domestik atau mancanegara).'])
                ->withInput();
        }

        // Hitung subtotal
        $totalDomDewasa   = $dewasa      * 68000;
        $totalDomAnak     = $anak        * 60000;
        $totalMancaDewasa = $mancaDewasa * 120000; // ✅ Baru
        $totalMancaAnak   = $mancaAnak   * 85000;  // ✅ Baru
        $totalHarga       = $totalDomDewasa + $totalDomAnak + $totalMancaDewasa + $totalMancaAnak;

        // Simpan ke DB
        PromoKlaim::create([
            'nama'                      => $request->nama,
            'kota'                      => $request->kota,
            'jumlah_tiket_dewasa'       => $dewasa,
            'jumlah_tiket_anak'         => $anak,
            'jumlah_tiket_manca_dewasa' => $mancaDewasa, // ✅ Baru
            'jumlah_tiket_manca_anak'   => $mancaAnak,   // ✅ Baru
            'tanggal_kunjungan'         => $request->tanggal_kunjungan,
            'no_hp'                     => $request->no_hp,
            'total_harga'               => $totalHarga,
            'status'                    => 'pending',
        ]);

        // Susun pesan WhatsApp
        Carbon::setLocale('id');
        $tanggal = Carbon::parse($request->tanggal_kunjungan)->translatedFormat('l, d F Y');

        $pesan  = "🌙 *PROMO SPESIAL RAMADHAN 2026*\n";
        $pesan .= "_Saung Angklung Udjo · Bandung_\n";
        $pesan .= "🗓️ *Periode:* 23 Feb – 15 Mar 2026\n";
        $pesan .= "━━━━━━━━━━━━━━━━━━━━\n\n";
        $pesan .= "• *Nama :* {$request->nama}\n";
        $pesan .= "• *Kota :* {$request->kota}\n\n";

        // Tiket Domestik
        if ($dewasa > 0 || $anak > 0) {
            $pesan .= "🇮🇩 *Tiket Domestik (Promo):*\n";
            if ($dewasa > 0) {
               $pesan .= "  ↳ Dewasa : {$dewasa} org × Rp 68.000 = *Rp " . number_format($totalDomDewasa, 0, ',', '.') . "*\n";
            }
            if ($anak > 0) {
                $pesan .= "  ↳ Anak   : {$anak} org × Rp 60.000 = *Rp " . number_format($totalDomAnak, 0, ',', '.') . "*\n";
            }
            $pesan .= "\n";
        }

        // Tiket Mancanegara ✅ Baru
        if ($mancaDewasa > 0 || $mancaAnak > 0) {
            $pesan .= "🌏 *Tiket Mancanegara (Harga Normal):*\n";
            if ($mancaDewasa > 0) {
                $pesan .= "  ↳ Dewasa : {$mancaDewasa} org × Rp 120.000 = *Rp " . number_format($totalMancaDewasa, 0, ',', '.') . "*\n";
            }
            if ($mancaAnak > 0) {
                $pesan .= "  ↳ Anak   : {$mancaAnak} org × Rp 85.000 = *Rp " . number_format($totalMancaAnak, 0, ',', '.') . "*\n";
            }
            $pesan .= "\n";
        }

        $pesan .= "• *Tanggal Kunjungan :* {$tanggal}\n";
        $pesan .= "• *Waktu Pertunjukan :* 15.30 WIB\n";
        $pesan .= "• *No HP :* {$request->no_hp}\n\n";
        $pesan .= "━━━━━━━━━━━━━━━━━━━━\n";
        $pesan .= "💰 *Total Estimasi : Rp " . number_format($totalHarga, 0, ',', '.') . "*\n\n";
        $pesan .= "Halo Admin, saya ingin mengklaim *Promo Ramadhan 2026* Saung Angklung Udjo. Mohon konfirmasinya 🙏";

        $nomorAdmin = '6282182821200';
        $url = 'https://wa.me/' . $nomorAdmin . '?text=' . urlencode($pesan);

        return redirect()->away($url);
    }
}