<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorie extends Model
{
    use HasFactory, SoftDeletes;

    public $table = "categories";

    protected $fillable =
    [
        'titre',
    ];

    public function films()
    {
        return $this->hasMany(Film::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format(config('panel.datetime_format'));
    }
}
