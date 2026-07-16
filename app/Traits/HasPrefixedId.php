<?php

namespace App\Traits;

use App\Services\PrefixedIdManager;

trait HasPrefixedId
{
    protected static function bootHasPrefixedId(): void
    {
        static::creating(function ($model) {
            $manager = app(PrefixedIdManager::class);
            $prefix  = $manager->getPrefixForModel(static::class);
            $model->prefixed_id = $manager->generate($prefix);
        });
    }

    public function scopeFindByPrefixedId($query, string $id)
    {
        return $query->where('prefixed_id', $id)->first();
    }

    public function getRouteKeyName(): string
    {
        return config('prefixed_ids.prefixed_id_attribute_name');
    }
}
