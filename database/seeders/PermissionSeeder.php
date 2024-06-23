<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $everybody = Role::ROLE_ALIASES;
        $admins = Role::ADMINS_ROLE_ALIASES;

        $admin = Role::ADMIN_ROLE_ALIAS;
        $controller = Role::CONTROLLER_ROLE_ALIAS;
        $client = Role::CLIENT_ROLE_ALIAS;

        $permissions = [

            ...$this->createPermissions('permission', ['create', 'edit', 'delete', 'manage'], $admins),
            ...$this->createPermissions('permission', ['show', 'access', 'search', 'list'], $everybody),

            ...$this->createPermissions('app_configuration', ['create', 'edit', 'delete', 'access'], $admins),
            ...$this->createPermissions('app_configuration', ['show', 'search', 'list'], $everybody),

            ...$this->createPermissions('role', ['create', 'edit', 'delete', 'manage'], $admins),
            ...$this->createPermissions('role', ['show', 'access', 'search', 'list'], $everybody),

            ...$this->createPermissions('user', ['access', 'create', 'edit', 'delete', 'history_access'], $admin),
            ...$this->createPermissions('user', ['show'], $everybody),

            ...$this->createPermissions('categorie', ['access', 'show','search'], $everybody),
            ...$this->createPermissions('categorie', ['create', 'edit', 'delete'], $admins),

            ...$this->createPermissions('acteur', ['access', 'show','search'], $everybody),
            ...$this->createPermissions('acteur', ['create', 'edit', 'delete'], $admins),

        ];

        Permission::insert($permissions);

    }

    public function createPermissions($resource, $permissions, $default_roles = [], $module = null)
  {
    $result = array_map(function ($permission, $description) use (&$resource, &$default_roles, &$module) {
      if(gettype($permission) == "integer")
      {
        $permission = $description;
        $description = null;
      }
      $item = [
        "title" => $resource . '_' . $permission,
        "resource" => $resource,
        "module" => $module,
        "description" => $description,
        "action" => $permission,
        "default_roles" => json_encode($default_roles)
      ];
      return $item;
    }, array_keys($permissions),   $permissions);

    return $result;
  }
}
