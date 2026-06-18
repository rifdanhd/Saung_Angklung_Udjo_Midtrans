<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Frontend Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShowController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\BudayaController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TicketB1G1Controller;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin\OrderController;


// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShowController as AdminShowController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\PromoKlaimController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardVisitorController;
/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/tiket/sukses', [TicketController::class, 'success'])->name('tickets.success.query');

// dalam group admin yang sudah ada
Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');

// Payment - Midtrans
Route::post('/payment/snap-token', [PaymentController::class, 'createSnapToken'])->name('payment.snap-token')->middleware('auth');

// Tiket - pakai TicketController
Route::controller(TicketController::class)->group(function () {
    Route::get('/tiket/beli', 'buy')->name('tickets.buy');
    Route::post('/tiket/store', 'store')->name('tickets.store');
    Route::get('/tiket/payment/{order}', 'payment')->name('tickets.payment');
    Route::get('/tiket/sukses/{order}', 'success')->name('tickets.success');
    Route::get('/tiket/status/{order}', 'checkPaymentStatus')->name('tickets.check-status');
});

// Webhook Midtrans (tanpa auth!)
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');
// Google OAuth - Visitor Login
Route::get('/auth/google/redirect', [AuthController::class, 'googleRedirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'googleCallback'])->name('auth.google.callback');
Route::post('/logout-visitor', [AuthController::class, 'logout'])->name('auth.logout');

// Halaman login visitor
Route::get('/visitor/login', [AuthController::class, 'showVisitorLogin'])->name('visitor.login')->middleware('guest');
Route::post('/login-email', [AuthController::class, 'loginEmail'])->name('auth.email.login');
Route::post('/register-email', [AuthController::class, 'registerEmail'])->name('auth.email.register');
// WhatsApp OTP Login
Route::post('/auth/wa/send-otp', [AuthController::class, 'sendOtp'])->name('auth.wa.sendOtp');
Route::post('/auth/wa/verify-otp', [AuthController::class, 'verifyOtp'])->name('auth.wa.verifyOtp');
// Dashboard Visitor
Route::get('/dashboard', [DashboardVisitorController::class, 'index'])
    ->middleware('auth')
    ->name('visitor.dashboard');
// Promo Ramadhan
Route::get('/promo-ramadhan', [PromoController::class, 'index'])->name('promo.index');
Route::post('/promo-ramadhan', [PromoController::class, 'submit'])->name('promo.submit');


//buy ticket





// Webhook Midtrans (Jangan lupa daftarkan URL ini di Dashboard Midtrans)
Route::post('/midtrans/notification', [PaymentController::class, 'notification']);


Route::controller(TicketController::class)->group(function () {
    Route::get('/tiket/beli', 'buy')->name('tickets.buy');
    Route::post('/tiket/store', 'store')->name('tickets.store');
    Route::get('/tiket/payment/{order}', 'payment')->name('tickets.payment');
    Route::get('/tiket/sukses/{order}', 'success')->name('tickets.success');
});



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang-kami', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');

// Language Switcher
Route::get('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');

// Pertunjukan & Booking
Route::controller(ShowController::class)->group(function () {
    Route::get('/pertunjukan', 'index')->name('shows.index');
    Route::get('/pertunjukan/{show}', 'show')->name('shows.show');
});

Route::controller(BookingController::class)->group(function () {
    Route::get('/pertunjukan/{show}/booking', 'create')->name('bookings.create');
    Route::post('/pertunjukan/{show}/booking', 'store')->name('bookings.store');
    Route::get('/booking/sukses/{bookingCode}', 'success')->name('bookings.success');
});

// Produk & Artikel
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product:slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{article:slug}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery.index');
Route::post('/testimoni', [TestimonialController::class, 'store'])->name('testimonials.store');

// Static Pages
Route::get('/kebijakan-privasi', function () {
    return view('privacy-policy');
})->name('privacy-policy');
Route::get('/sejarah-angklung', function () {
    return view('heritage.angklung-history');
})->name('heritage.angklung');
Route::get('/experience/performances', function () {
    return view('experience.performances');
})->name('experience.performances');
Route::get('/heritage/angklung-unit', function () {
    return view('heritage.angklung-unit');
})->name('heritage.unit');
Route::get('/heritage/arumba', function () {
    return view('heritage.arumba');
})->name('heritage.arumba');
Route::get('/experience/souvenir-shop', function () {
    return view('experience.souvenir');
})->name('experience.souvenir');
Route::get('/experience/academy', function () {
    return view('experience.academy');
})->name('experience.academy');
Route::get('/heritage/cara-membuat-memainkan', function () {
    return view('heritage.angklung-craftsmanship');
})->name('heritage.craftsmanship');
Route::get('/experience/banguet', function () {
    return view('experience.banquet');
})->name('experience.banguet');
Route::get('/heritage/angklung-definition', function () {
    return view('heritage.angklung-definition');
})->name('heritage.angklung-definition');
Route::get('/heritage/history', function () {
    return view('heritage.history');
})->name('heritage.history');
Route::get('/heritage/vision-mission', function () {
    return view('heritage.vision-mission');
})->name('heritage.vision-mission');
Route::get('/heritage/achievements', function () {
    return view('heritage.achievements');
})->name('heritage.achievements');
Route::get('/heritage/jenis-angklung', function () {
    return view('heritage.jenis-angklung');
})->name('heritage.jenis-angklung');
Route::get('/Visitus/hotels', function () {
    return view('Visitus.hotel');
})->name('Visitus.hotel');
Route::get('/heritage/venue', function () {
    return view('heritage.venue');
})->name('heritage.venue');
Route::get('/Visitus/destinasi', function () {
    return view('Visitus.destinasi');
})->name('Visitus.destinasi');
Route::get('/experience/performancesoutdoor', function () {
    return view('experience.performancesoutdoor');
})->name('experience.performancesoutdoor');
Route::get('/Ramadhan', function () {
    return view('Ramadhan');
})->name('Ramadhan');

/*
|--------------------------------------------------------------------------
| Admin Routes (Auth Required)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', [BudayaController::class, 'index']);
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');



    // ✅ TAMBAHKAN DI SINI
    Route::get('users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');



    // Management Resources
    Route::resource('shows', AdminShowController::class);
    Route::resource('gallery', AdminGalleryController::class);
    Route::resource('articles', AdminArticleController::class);
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/delete-image', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');


    // Hero Carousel

    Route::prefix('hero')->name('hero.')->group(function () {
        Route::get('/', [HeroSlideController::class, 'index'])->name('index');
        Route::post('/', [HeroSlideController::class, 'store'])->name('store');
        Route::post('/{heroSlide}/toggle', [HeroSlideController::class, 'toggleActive'])->name('toggle');
        Route::post('/order', [HeroSlideController::class, 'updateOrder'])->name('order');
        Route::delete('/{heroSlide}', [HeroSlideController::class, 'destroy'])->name('destroy');
    });
    // Bookings Management
    Route::controller(AdminBookingController::class)->group(function () {
        Route::get('bookings', 'index')->name('bookings.index');
        Route::patch('bookings/{booking}/confirm', 'confirm')->name('bookings.confirm');
        Route::patch('bookings/{booking}/cancel', 'cancel')->name('bookings.cancel');
    });

    // Testimonials Management
    // Testimonials Management
    Route::resource('testimonials', AdminTestimonialController::class);
    Route::patch('testimonials/{testimonial}/approve', [AdminTestimonialController::class, 'approve'])->name('testimonials.approve');

    // Ticket Scanning for Admin
    Route::get('tickets/scan', [App\Http\Controllers\Admin\TicketScanController::class, 'index'])->name('tickets.scan.index');
    Route::post('tickets/scan', [App\Http\Controllers\Admin\TicketScanController::class, 'scan'])->name('tickets.scan.process');


    // Promo Klaim Ramadhan
    Route::get('promo-klaim/export-pdf', [PromoKlaimController::class, 'exportPdf'])->name('promo.exportPdf');
    Route::get('promo-klaim', [PromoKlaimController::class, 'index'])->name('promo.index');
    Route::delete('promo-klaim/{promoKlaim}', [PromoKlaimController::class, 'destroy'])->name('promo.destroy');
    Route::post('promo-klaim/{promoKlaim}/status', [PromoKlaimController::class, 'updateStatus'])->name('promo.updateStatus');
});

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Sitemap
|--------------------------------------------------------------------------
*/

use App\Models\Product;
use App\Models\Article;

Route::get('/sitemap.xml', function () {
    $locales = ['id', 'en'];
    $content = '<?xml version="1.0" encoding="UTF-8"?>';
    $content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($locales as $lang) {
        $heritage = ['heritage.history', 'heritage.vision-mission', 'heritage.angklung', 'heritage.jenis-angklung', 'heritage.craftsmanship'];
        $experience = ['experience.performances', 'experience.performancesoutdoor', 'heritage.achievements', 'experience.souvenir'];
        $visitus = ['contact', 'heritage.venue', 'experience.banguet', 'Visitus.hotel'];
        $stories = ['articles.index', 'gallery.index'];

        $allRoutes = array_merge(['home', 'promo.index', 'Ramadhan'], $heritage, $experience, $visitus, $stories);

        foreach ($allRoutes as $routeName) {
            try {
                $url = route($routeName, ['locale' => $lang]);
                $content .= '<url><loc>' . $url . '</loc><priority>' . ($routeName == 'home' ? '1.0' : '0.8') . '</priority></url>';
            } catch (\Exception $e) {
                continue;
            }
        }

        try {
            $articles = Article::orderBy('created_at', 'desc')->get();
            foreach ($articles as $article) {
                $content .= '<url><loc>' . route('articles.show', ['article' => $article->slug]) . '</loc><priority>0.7</priority></url>';
            }
            $products = Product::all();
            foreach ($products as $product) {
                $content .= '<url><loc>' . url($lang . '/produk/' . $product->slug) . '</loc><priority>0.7</priority></url>';
            }
        } catch (\Exception $e) {
            continue;
        }
    }

    $content .= '</urlset>';
    return response($content)->header('Content-Type', 'text/xml');
});
