<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'est_valide',
        'est_paye',
        'projection_id',
        'client_id',
    ];

    public function projection()
    {
        return $this->belongsTo(Projection::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format(config('panel.datetime_format'));
    }

}
