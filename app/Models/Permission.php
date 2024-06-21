<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'permissions';


  public $casts = [
    'default_roles' => 'array'
];

  protected $fillable = [
    'title',
    'action',
    'resource',
    'is_active',
    'description',
    'module',
    'default_roles',
    'created_at',
    'updated_at',
    'deleted_at',
  ];

  public function roles()
  {
    return $this->belongsToMany(Role::class);
  }

  protected function serializeDate(DateTimeInterface $date)
  {
    return $date->format(config('panel.datetime_format'));
    
  }

}
