<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'message_histories';

    protected $fillable = [
        'content',
        'chat_history_id',
    ];

    public function chatHistory(): BelongsTo
    {
        return $this->belongsTo(ChatHistory::class);
    }
}
