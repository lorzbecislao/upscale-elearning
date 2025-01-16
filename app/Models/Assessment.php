<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Assessment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'after_topic_id',
        'course_id',
        'status',
        'instruction',
        'content',
        'created_by',
        'type'
    ];

    public function toggleStatus()
    {
        $this->status = $this->status == 1 ? 0 : 1;
        $this->save();
    }

    /**
     * Get the user associated with the Assessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function option(): HasMany
    {
        return $this->hasMany(AssessmentOption::class);
    }

    public function course(): HasOne
    {
        return $this->hasOne(Course::class, 'id', 'course_id');
    }

    public function afterTopic(): HasOne
    {
        return $this->hasOne(Topic::class, 'id', 'after_topic_id');
    }


}
