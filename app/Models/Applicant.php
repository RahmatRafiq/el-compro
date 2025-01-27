<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'user_id',
        'experience',
        'education',
        'certification',
        'photo',
        'contact',
    ];

    protected $casts = [
        'certification' => 'array', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($applicant) {
            $applicant->reference = 'REF-APP-' . strtoupper(uniqid());
        });
    }
}
