<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Firestore;
use Kreait\Firebase\Contract\Storage;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(Factory::class, function ($app) {
            $credentials = env('FIREBASE_CREDENTIALS');
            $factory = new Factory();
            if ($credentials && file_exists(base_path($credentials))) {
                $factory = $factory->withServiceAccount(base_path($credentials));
                
                $json = json_decode(file_get_contents(base_path($credentials)), true);
                if (isset($json['project_id'])) {
                    $factory = $factory->withDefaultStorageBucket($json['project_id'] . '.appspot.com');
                }
            }
            return $factory;
        });

        $this->app->singleton(Firestore::class, function ($app) {
            return $app->make(Factory::class)->createFirestore();
        });

        $this->app->singleton(Storage::class, function ($app) {
            return $app->make(Factory::class)->createStorage();
        });

        $this->app->singleton(\Kreait\Firebase\Contract\Auth::class, function ($app) {
            return $app->make(Factory::class)->createAuth();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
