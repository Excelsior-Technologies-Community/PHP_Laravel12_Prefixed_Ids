<?php

namespace App\Services;

use Illuminate\Support\Str;

class PrefixedIdManager
{
    protected $models = [];

    public function registerModels(array $models)
    {
        $this->models = $models;
    }

    public function generate(string $prefix): string
    {
        return $prefix . Str::random(12);
    }

    public function getModelClass(string $prefixedId): ?string
    {
        foreach ($this->models as $prefix => $model) {
            if (str_starts_with($prefixedId, $prefix)) {
                return $model;
            }
        }
        return null;
    }

    public function find(string $prefixedId)
    {
        $modelClass = $this->getModelClass($prefixedId);
        return $modelClass ? $modelClass::where('prefixed_id', $prefixedId)->first() : null;
    }
}