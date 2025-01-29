<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'general_information';

    protected $fillable = [
        'type',
        'name',
        'description',
    ];

    protected $dates = ['deleted_at'];
}
