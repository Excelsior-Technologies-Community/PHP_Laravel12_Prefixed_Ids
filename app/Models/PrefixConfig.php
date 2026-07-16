<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrefixConfig extends Model
{
    protected $fillable = ['model_class', 'prefix', 'label', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
