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
}
