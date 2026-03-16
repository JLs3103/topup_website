<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class TopupOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'game_slug',
        'game_name',
        'player_id',
        'server_id',
        'package_id',
        'package_name',
        'package_price',
        'payment_method',
        'contact_type',
        'contact_value',
        'payment_proof_path',
        'payment_notes',
        'paid_at',
        'status',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
