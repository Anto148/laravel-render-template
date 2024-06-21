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

        $permission = [

            ...$this->createPermissions('permission', ['create', 'edit', 'delete', 'manage'], $admins),
            ...$this->createPermissions('permission', ['show', 'access', 'search', 'list'], $everybody),

        ];

        Permission::insert($permission);
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
