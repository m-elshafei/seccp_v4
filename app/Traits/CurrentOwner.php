<?php

namespace App\Traits;

trait CurrentOwner
{
    public static function bootCurrentOwner()
    {
        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            if (!$model->isDirty('current_owner_user_id')) {
                $model->current_owner_user_id = auth()->user()->id;
            }

        });
    }
}
