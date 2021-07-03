<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Uuid
{
    public static function bootUuid()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
}
