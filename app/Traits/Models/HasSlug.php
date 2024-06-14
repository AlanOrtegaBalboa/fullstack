<?php

namespace App\Traits\Models;

trait HasSlug
{
    public static function bootHasSlug()
    {
        static::saving(function ($model) {
            $model->slug = Str::slug($model->name);

        });
    }
}
