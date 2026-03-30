<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPrefixedId;

class Order extends Model
{
    use HasPrefixedId;

    protected $fillable = ['name'];


    /**
     * Use prefixed_id for route model binding instead of id
     */
    public function getRouteKeyName()
    {
        return 'prefixed_id';
    }
}
