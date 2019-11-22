<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsController extends Controller
{
    public function getRolesAndPermissions() {
        return view('pages.security.roles-and-permissions');
    }

    public function getRolesApi() {
        return response()->json(Role::all());
    }

    public function getPermissionsApi() {
        if (request()->get('groupBy')) {
            return response()->json(Permission::all()
                ->groupBy(request()->get('groupBy')));
        }

        if (request()->get('only')) {
            return response()->json(Permission::all([request()->get('only')]));
        }

        return response()->json(Permission::all());
    }

    public function getRolesByUidApi($uid) {
        $user = User::where('uid', $uid)->first();
        return response()->json($user->getRoleNames());
    }

    public function getRolesDetails($name) {
        $role = Role::where('name', $name)->first();
        return response()->json($role);
    }

    public function getPermissionsFromRoleName($roleName) {

        $role = Role::where('name', $roleName)->first();
        if (request()->get('groupBy')) {
            if (request()->get('filter')) {
                $allPermissions = Permission::all()->groupBy(request()->get('groupBy'))->toArray();
                $rolePermissions = $role->permissions->toArray();
                $new = [];
                foreach($rolePermissions as $permission) {
                    unset($permission['pivot']);
                    array_push($new, $permission);
                }
                $rolePermissions = [];
                foreach ( $new as $value ) {
                    $rolePermissions[$value['category']][] = $value;
                }

                $includes = [];
                $excludes = [];
                $results = [];
                foreach ($allPermissions as $key => $value) {
                    for ($i = 0; $i < count($value); $i++) {
                        if (array_key_exists($key, $rolePermissions)) {
                            if (in_array($value[$i], $rolePermissions[$key])) {
                                array_push($includes, $value[$i]);
                            } else {
                                array_push($excludes, $value[$i]);
                            }
                        } else {
                            array_push($excludes, $value[$i]);
                        }
                    }

                    $key = str_replace(' ', '_', $key);
                    array_push($results, [$key => [
                        'contains' => $includes,
                        'excludes' => $excludes
                    ]]);

                    $includes = [];
                    $excludes = [];
                }
                return $results;
            }
            return $role->permissions->groupBy(request()->get('groupBy'));
        }

        return $role->permissions;
    }

    public function createRolesApi() {
        $name = request('role-name');
        $desc = request('role-desc');
        $permissions = [];
        foreach(request()->all() as $key => $value)
        {

            $permission = explode('-', $key);
            if ($permission[0] === 'permission') {
                unset($permission[0]);
                $permission = implode(' ', $permission);

                array_push($permissions, $permission);
            }
        }
        $role = Role::create(['name' => $name, 'description' => $desc]);

        foreach($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully'
        ]);
    }

    public function editRolesApi($name) {
        $name = request('edit-role-name');
        $desc = request('edit-role-desc');
        $permissions = [];

        foreach(request()->all() as $key => $value)
        {
            $permission = explode('-', $key);
            if ($permission[1] === 'permissions') {
                unset($permission[0]);
                unset($permission[1]);
                $permission = implode(' ', $permission);

                array_push($permissions, $permission);
            }
        }

        $role = Role::where('name', $name)->first();
        $role->update(['description' => $desc]);
        $role->save();

        foreach(Permission::all() as $permission) {
            if ($role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission);
            }
        }

        foreach($permissions as $permission) {
            $role->givePermissionTo($permission);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully'
        ]);
    }

    public function deleteRolesApi($name) {
        $role = Role::where('name', $name)->first();
        $role->delete();
        return ['success' => true, 'message' => "Role deleted"];
    }

}
