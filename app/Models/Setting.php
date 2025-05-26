<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'user_id',
        'ai_model',
        'temperature',
        'system_message',
        'stream',
        'max_tokens'
    ];

    protected $casts = [
        'stream' => 'boolean',
        'temperature' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
