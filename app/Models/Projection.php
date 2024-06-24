<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Projection extends Model
{
    use HasFactory;

    public $table = 'projections';

    protected $fillable = [
        'date_projection',
        'heure_projection',
        'en_3d',
        'film_id',
        'salle_id',
        'created_by_id',
        'type_projection_id'
    ];

    public $casts = [
        'date_projection' => 'datetime',
        // 'heure_projection' => 'time'
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function typeProjection()
    {
        return $this->belongsTo(Type_projection::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format(config('panel.datetime_format'));
    }

    // public function tickets()
    // {
    //     return $this->hasMany(Ticket::class);
    // }
}
