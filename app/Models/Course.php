<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_code',
        'name',
        'credits',
        'semester',
        'major_concentration',
    ];

    public function lecturers()
    {
        return $this->belongsToMany(Lecturers::class, 'lecturer_course', 'course_id', 'lecturer_id')
            ->withTimestamps()
            ->withPivot('deleted_at')
            ->withTrashed();
    }
}
