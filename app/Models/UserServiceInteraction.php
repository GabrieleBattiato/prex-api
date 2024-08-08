<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserServiceInteraction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service',
        'request_body',
        'http_code',
        'response_body',
        'ip_origin',
    ];

    protected $casts = [
        'request_body' => 'array',
        'response_body' => 'array',
    ];

    /**
     * Get the user that owns the interaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
