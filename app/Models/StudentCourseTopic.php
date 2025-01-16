<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentCourseTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_course_id',
        'topic_id',
        'status',
        'completed_at'
    ];

    public function studentCourse()
    {
        return $this->belongsTo(StudentCourse::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

}
