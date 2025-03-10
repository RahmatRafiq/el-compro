<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'name',
        'slug',
    ];
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    public function virtuals()
    {
        return $this->hasMany(Virtual::class, 'category_id');
    }
}
