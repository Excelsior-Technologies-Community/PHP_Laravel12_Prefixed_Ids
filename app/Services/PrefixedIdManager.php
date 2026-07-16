<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\PrefixConfig;

class PrefixedIdManager
{
    protected array $models = [];

    public function registerModels(array $models): void
    {
        $this->models = $models;
    }

    public function generate(string $prefix): string
    {
        return $prefix . Str::random(12);
    }

    public function getModelClass(string $prefixedId): ?string
    {
        // First check DB-driven prefixes
        try {
            $config = PrefixConfig::where('is_active', true)
                ->get()
                ->first(fn($c) => str_starts_with($prefixedId, $c->prefix));

            if ($config) return $config->model_class;
        } catch (\Exception $e) {
            // DB not ready yet, fall through to config
        }

        // Fallback to config file
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

    public function getPrefixForModel(string $modelClass): string
    {
        // Check DB first
        try {
            $config = PrefixConfig::where('model_class', $modelClass)
                ->where('is_active', true)
                ->first();
            if ($config) return $config->prefix;
        } catch (\Exception $e) {
            // fall through
        }

        // Fallback to config - key is prefix, value is model class
        foreach ($this->models as $prefix => $class) {
            if ($class === $modelClass) return $prefix;
        }

        return '';
    }
}
