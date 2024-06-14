<?php

namespace App\Traits\Models;

trait UpdatedBy
{
    public static function bootUpdatedBy()
    {
        static::updating(function ($model) {
            if(auth()->check()){
                $model->updated_by = auth()->id();
            }

        });
    }
}
