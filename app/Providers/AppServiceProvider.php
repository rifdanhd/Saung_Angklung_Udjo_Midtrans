<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Set locale dari session jika ada
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
    }
}