<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
        'code',
        'name',
        'description',
        'slug',
        'content',
        'image_url',
        'created_by',
        'status'
    ];

    public function toggleStatus()
    {
        $this->status = $this->status == 1 ? 0 : 1;
        $this->save();
    }

    /**
     * Get all of the topics for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'course_id', 'id');
    }

    /**
     * Get all of the assessments for the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class, 'course_id', 'id');
    }

    public function numberOfStudents(): int
    {
        return $this->students()->count();
    }

    public function numberOfCompletedStudents(): int
    {
        return $this->students()->whereNotNull('completed_at')->count();
    }

    public function students(): HasMany
    {
        return $this->hasMany(StudentCourse::class, 'course_id', 'id');
    }
}
