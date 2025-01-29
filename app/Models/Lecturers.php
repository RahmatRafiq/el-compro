<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lecturers extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'image'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'lecturer_course', 'lecturer_id', 'course_id')
            ->withTimestamps()
            ->withPivot('deleted_at')
            ->withTrashed();
    }
}
