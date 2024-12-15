<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

            view()->composer('*', function () {
                if (Auth::check()) {
                    Auth::user()->refresh();
                    if (Auth::guard('web')->check() && Auth::user()->flag !== 'admin') {
                        Auth::guard('web')->logout(); // Specify the 'web' guard explicitly
                        return redirect()->route('login')->with('error', 'Unauthorized access.');
                    }
                }
            });
                $locale = Session::get('locale', config('app.locale')); // Default to the default locale
        App::setLocale($locale);
    }
}
