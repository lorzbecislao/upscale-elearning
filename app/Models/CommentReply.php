<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CommentReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comment_id',
        'reply'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comment(): HasOne
    {
        return $this->hasOne(Forum::class);
    }
}
