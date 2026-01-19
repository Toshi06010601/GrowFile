<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ModelLogging
{
    protected static function bootModelLogging()
    {
        static::created(function (Model $model) {
            logger()->info('create', [
                'auth_id' => Auth::id(),
                'model' => get_class($model),
                'data' => $model->toArray(),
            ]);
        });

        static::updated(function (Model $model) {
            logger()->info('update', [
                'auth_id' => Auth::id(),
                'model' => get_class($model),
                'diff' => $model->getChanges(),
            ]);
        });

        static::deleted(function (Model $model) {
            logger()->info('delete', [
                'auth_id' => Auth::id(),
                'model' => get_class($model),
            ]);
        });
    }
}
