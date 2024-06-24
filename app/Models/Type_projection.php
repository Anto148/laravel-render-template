<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type_projection extends Model
{
    use HasFactory;

    public $table = "type_projections";

    protected $fillable = [
        'nom',
        'prix_enfant',
        'prix_adulte',
    ];

    public function projections()
    {
        return $this->hasMany(Projection::class);
    }

    public function films()
    {
        return $this->belongsToMany(Film::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format(config('panel.datetime_format'));
    }


}
