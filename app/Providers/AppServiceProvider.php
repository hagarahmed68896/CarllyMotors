<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        //
        $userAgent = request()->header('User-Agent');
        $os        = '';
        if (stripos($userAgent, 'Windows') !== false) {
            $os = 'Windows';
        } elseif (stripos($userAgent, 'Macintosh') !== false || stripos($userAgent, 'Mac OS') !== false) {
            $os = 'Mac';
        } elseif (stripos($userAgent, 'Linux') !== false) {
            $os = 'Linux';
        } elseif (stripos($userAgent, 'Android') !== false) {
            $os = 'Android';
        } elseif (stripos($userAgent, 'iPhone') !== false || stripos($userAgent, 'iPad') !== false) {
            $os = 'iOS';
        } else {
            $os = 'Unknown';
        }
        View::share('os', $os);

    }
}
