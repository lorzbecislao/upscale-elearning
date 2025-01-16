<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'course_id',
        'created_by',
        'status'
    ];

    protected $casts = [
        // 'content' => PurifyHtmlOnGet::class,
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class, 'after_topic_id', 'id');
    }

    public function toggleStatus()
    {
        $this->status = $this->status == 1 ? 0 : 1;
        $this->save();
    }

}
