<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BindServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->bindService();
        $this->bindRepository();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Bind services.
     */
    private function bindService(): void
    {
        $arr = [
            \App\Interfaces\Services\ArticleTagServiceInterface::class => \App\Services\ArticleTagService::class,
            \App\Interfaces\Services\ArticleServiceInterface::class => \App\Services\ArticleService::class,
        ];

        foreach ($arr as $interface => $class) {
            $this->app->bind($interface, $class);
        }
    }

    /**
     * Bind repositories.
     */
    private function bindRepository(): void
    {
        $arr = [
            \App\Interfaces\Repositories\ArticleTagRepositoryInterface::class => \App\Repositories\ArticleTagRepository::class,
            \App\Interfaces\Repositories\ArticleRepositoryInterface::class => \App\Repositories\ArticleRepository::class,
        ];

        foreach ($arr as $interface => $class) {
            $this->app->bind($interface, $class);
        }
    }
}
