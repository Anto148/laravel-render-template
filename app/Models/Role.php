<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use SoftDeletes;

    public const ADMIN_ROLE_ALIAS = "A";
    public const CONTROLLER_ROLE_ALIAS = "CON";
    public const CLIENT_ROLE_ALIAS = "CLIENT";

    public const ROLE_ALIASES = [
        self::ADMIN_ROLE_ALIAS,
        self::CONTROLLER_ROLE_ALIAS,
        self::CLIENT_ROLE_ALIAS,
    ];

    public const ADMINS_ROLE_ALIASES = [
        self::ADMIN_ROLE_ALIAS,
        self::CONTROLLER_ROLE_ALIAS
    ];  

    public $table = 'roles';

    protected $fillable = [
        'title',
        'description',
        'alias',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, "permission_role")->withPivot(['is_active']);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format(config('panel.datetime_format'));
    }
}
