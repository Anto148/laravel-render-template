<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\InteractsWithMedia;

class Film extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    public const COVER_MEDIA_COLLECTION = 'covered_media';
    public $table = 'films';

    protected $fillable = [
        'titre',
        'synopsis',
        'duree',
        'cover_url',
        'bande_annonce',
        'date_sortie',
        'limite_age',
        'moyenne_note',
        'audio',
    ];

    protected $casts = [
        'moyenne_note' => 'float',
        // 'date_sortie' => 'date',
    ];

    public $appends = [
        'cover',
        // 'image_url',
    ];

    public function getCoverAttribute()
    {
      return $this->media()->where('collection_name', self::COVER_MEDIA_COLLECTION)->get()->pluck('original_url')->toArray();
    }

    // public function getImageUrlAttribute($image_url)
    // {
    //     return $image_url ?? $this->getFirstMedia(self::COVER_FILE_COLLECTION)?->original_url;
    // }

    public function realisateurs()
    {
        return $this->belongsToMany(Realisateur::class, 'film_realisateur');
    }

    public function acteurs()
    {
        return $this->belongsToMany(Acteur::class, 'film_acteur');
    }

    public function categories()
    {
        return $this->belongsToMany(Categorie::class, 'categorie_film');
    }
    public function avis()
    {
        return $this->hasMany(Avi::class);
    }

    public function recalculateMoyenneNote()
    {
        $this->moyenne_note = $this->avis()->avg('note');
        $this->save();
    }

}
