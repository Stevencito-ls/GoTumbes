<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \Illuminate\Support\Facades\Auth::provider('firebase', function ($app, array $config) {
            return new \App\Auth\FirebaseUserProvider();
        });

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $settings = \Illuminate\Support\Facades\Cache::remember('global_settings', 3600, function () {
                try {
                    $firestore = app(\Kreait\Firebase\Contract\Firestore::class);
                    $doc = $firestore->database()->collection('configuracion')->document('global')->snapshot();
                    return $doc->exists() ? $doc->data() : [];
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Error loading global settings: ' . $e->getMessage());
                    return [];
                }
            });
            $view->with('globalSettings', $settings);
        });
    }
}
