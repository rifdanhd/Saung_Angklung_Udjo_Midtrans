<?php

namespace App\Http\Controllers;

use App\Models\Show;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function create(Show $show)
    {
        if ($show->isFull()) {
            return redirect()->route('shows.show', $show)
                ->with('error', 'Maaf, pertunjukan ini sudah penuh.');
        }

        return view('bookings.create', compact('show'));
    }

    public function store(Request $request, Show $show)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string',
            'nationality' => 'required|string',
            'num_tickets' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string'
        ]);

        // Cek ketersediaan kursi
        if ($show->available_seats < $validated['num_tickets']) {
            return back()->with('error', 'Kursi tidak mencukupi. Tersisa: ' . $show->available_seats);
        }

        // Hitung total harga
        $pricePerTicket = $validated['nationality'] === 'Indonesia'
            ? $show->price_domestic
            : $show->price_foreign;

        $totalPrice = $pricePerTicket * $validated['num_tickets'];

        // Buat booking
        $booking = Booking::create([
            'show_id' => $show->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'nationality' => $validated['nationality'],
            'num_tickets' => $validated['num_tickets'],
            'total_price' => $totalPrice,
            'notes' => $validated['notes'],
            'status' => 'pending'
        ]);

        // Update available seats
        $show->updateAvailableSeats();

        // Kirim email konfirmasi (opsional)
        // Mail::to($booking->email)->send(new BookingConfirmation($booking));

        return redirect()->route('bookings.success', $booking->booking_code)
            ->with('success', 'Booking berhasil! Kode booking: ' . $booking->booking_code);
    }

    public function success($bookingCode)
    {
        $booking = Booking::where('booking_code', $bookingCode)->firstOrFail();
        return view('bookings.success', compact('booking'));
    }
}
