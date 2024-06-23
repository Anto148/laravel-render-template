<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Process\Exceptions\ProcessTimedOutException;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Acteur extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public $table = "acteurs";

    protected $fillable = [
        'nom',
        'prenom',
    ];

    protected $appends = [
        'fullname'
    ];

    public function getFullnameAttribute()
    {
        return $this->prenom.' '.$this->nom;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
      return $date->format(config('panel.datetime_format'));
    }
}
