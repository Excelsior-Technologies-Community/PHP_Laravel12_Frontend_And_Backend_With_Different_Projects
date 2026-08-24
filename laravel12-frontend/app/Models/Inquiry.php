<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message',
        'is_read',
        'reference_number',
        'subject',
        'category_id',
        'attachment',
        'status',
        'priority',
        'tracking_token',
        'user_id',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
