<?php

namespace App\Observers;

use App\Models\Article;
use App\Support\Str;

class ArticleObserver
{
    /**
     * Handle the Article "creating" event.
     */
    public function creating(Article $article): void
    {
        if ($article->is_published) {
            $article->published_at = now();
        }

        // slug
        $repository = new \App\Repositories\ArticleRepository();
        $article->slug = $repository->findUniqueSlug(Str::slug($article->title));
    }

    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "updating" event.
     */
    public function updating(Article $article): void
    {
        if ($article->is_published) {
            $article->published_at = now();
        }

        // slug
        $repository = new \App\Repositories\ArticleRepository();
        $article->slug = $repository->findUniqueSlug(Str::slug($article->title));
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        //
    }

    /**
     * Handle the Article "force deleted" event.
     */
    public function forceDeleted(Article $article): void
    {
        //
    }
}
