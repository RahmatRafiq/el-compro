<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criterion extends Model
{
    use HasFactory, SoftDeletes;

    protected $table  = 'criterion';

    protected $fillable = [
        'vacancy_id',
        'name',
        'categorical',
        'numerical'
    ];

    protected $casts = [
        'categorical' => 'array'
    ];

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
