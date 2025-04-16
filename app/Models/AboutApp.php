<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AboutApp extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $table = 'about_app';

    protected $fillable = [
        'title',
        'description',
        'greeting',
        'vision_mission',
        'history',
        'contact_email',
        'contact_phone',
        'contact_address',
    ];
}
