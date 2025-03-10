<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lecturers extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'name',
        'about',
        'image',
        'email',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'lecturer_course', 'lecturer_id', 'course_id')
            ->withTimestamps()
            ->withPivot('deleted_at')
            ->withTrashed();
    }
}
