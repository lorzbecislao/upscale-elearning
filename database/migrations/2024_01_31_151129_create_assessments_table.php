<?php

use App\Enums\AssessmentType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('content')->nullable();
            $table->text('instruction')->nullable();
            $table->foreignId('after_topic_id')->references('id')->on('topics');
            $table->foreignId('course_id')->references('id')->on('courses');
            $table->tinyInteger('type')->default(AssessmentType::Quiz()->value);
            $table->tinyInteger('status')->default(0);
            $table->foreignId('created_by')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
