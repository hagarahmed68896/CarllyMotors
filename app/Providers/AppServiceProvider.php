<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\CarListingModel;
use App\Models\CarBrand;
use Illuminate\Support\Facades\DB;

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
        /**
         * 1️⃣ Detect User OS (always shared)
         */
        $userAgent = request()->header('User-Agent') ?? '';
        $os = 'Unknown';
        if (stripos($userAgent, 'Windows') !== false) {
            $os = 'Windows';
        } elseif (stripos($userAgent, 'Macintosh') !== false || stripos($userAgent, 'Mac OS') !== false) {
            $os = 'Mac';
        } elseif (stripos($userAgent, 'Android') !== false) {
            $os = 'Android';
        } elseif (stripos($userAgent, 'iPhone') !== false || stripos($userAgent, 'iPad') !== false) {
            $os = 'iOS';
        } elseif (stripos($userAgent, 'Linux') !== false) {
            $os = 'Linux';
        }

        /**
         * 2️⃣ Shared default variables
         */
        $shared = [
            'os' => $os,
            'bodyTypes' => collect(),
            'models' => collect(),
            'years' => collect(),
            'navbarBrands' => collect(),
        ];

        /**
         * 3️⃣ Load CarListing related data if the table exists
         */
        try {
            if (Schema::hasTable((new CarListingModel())->getTable())) {

                $shared['bodyTypes'] = CarListingModel::whereNotNull('body_type')
                    ->distinct()
                    ->pluck('body_type');

                $shared['models'] = CarListingModel::whereNotNull('listing_model')
                    ->distinct()
                    ->pluck('listing_model');

                $shared['years'] = CarListingModel::whereNotNull('listing_year')
                    ->distinct()
                    ->orderBy('listing_year', 'desc')
                    ->pluck('listing_year');
                
                // $shared['brands'] = CarListingModel::whereNotNull('listing_type')
                //       ->distinct()
                //       ->pluck('listing_type');
            }

            /**
             * 4️⃣ Load brands if available
             */
   if (Schema::hasTable('car_brands')) {
    $shared['navbarBrands'] = CarBrand::select('id', 'name', 'logo')
        ->orderBy('name')
        ->get();
}


        } catch (\Throwable $e) {
            // Prevent breaking during migrations or early boot
            // \Log::warning('AppServiceProvider boot error: '.$e->getMessage());
        }

        /**
         * 5️⃣ Share everything globally
         */
        View::share($shared);
    }
}
