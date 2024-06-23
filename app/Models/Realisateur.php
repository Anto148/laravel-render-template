<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Realisateur extends Model
{
    use HasFactory , SoftDeletes;

    protected $table = 'realisateurs';

    protected $fillable = [
        'nom',
        'prenom',
    ];

    protected $appends = [
        'fullname'
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class);
    }

    public function getFullnameAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
      return $date->format(config('panel.datetime_format'));
    }
}
