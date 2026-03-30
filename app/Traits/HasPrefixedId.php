<?php

namespace App\Traits;

use App\Services\PrefixedIdManager;

trait HasPrefixedId
{
    protected static function bootHasPrefixedId()
    {
        static::creating(function ($model) {
            $manager = app(PrefixedIdManager::class);

            // Get prefix for this model from config
            $prefix = array_search(static::class, config('prefixed_ids.models'));

            $model->prefixed_id = $manager->generate($prefix);
        });
    }

    public function scopeFindByPrefixedId($query, $id)
    {
        return $query->where('prefixed_id', $id)->first();
    }

    public function getRouteKeyName()
    {
        return config('prefixed_ids.prefixed_id_attribute_name');
    }
}