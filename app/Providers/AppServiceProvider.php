<?php

namespace App\Providers;

use App\Image;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Image::deleting(function($image) {
            // Remove the real file when an image record is deleted
            $filePath = config('storage.images.products')
                . '/' . $image->filename;
            if (file_exists($filePath))
                unlink($filePath);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
