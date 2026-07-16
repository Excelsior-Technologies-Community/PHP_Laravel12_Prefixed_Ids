<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPrefixedId;

class Order extends Model
{
    use HasPrefixedId;

    protected $fillable = ['name', 'status', 'notes'];

    public function getRouteKeyName()
    {
        return 'prefixed_id';
    }

    public function getStatusBadgeClass(): string
    {
        return match($this->status) {
            'pending'    => 'badge-pending',
            'processing' => 'badge-processing',
            'completed'  => 'badge-completed',
            'cancelled'  => 'badge-cancelled',
            default      => 'badge-pending',
        };
    }

    public function getStatusEmoji(): string
    {
        return match($this->status) {
            'pending'    => '⏳',
            'processing' => '⚙️',
            'completed'  => '✅',
            'cancelled'  => '❌',
            default      => '⏳',
        };
    }
}
