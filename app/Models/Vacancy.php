<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    /** @use HasFactory<\Database\Factories\JobVacancyFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'reference',
        'title',
        'slug',
        'description',
        'status',
        'date_start',
        'date_end',
    ];

    public function criteria()
    {
        return $this->hasMany(Criterion::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($applicant) {
            $applicant->reference = 'REF-VAC-' . strtoupper(uniqid());
        });
    }
}
