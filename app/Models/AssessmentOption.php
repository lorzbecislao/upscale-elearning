<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssessmentOption extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'assessment_id',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'answer',
        'question',
    ];
}
