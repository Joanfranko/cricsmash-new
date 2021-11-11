<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use App\Models\Role;
use Yajra\DataTables\DataTables;
use Auth;
use Carbon\Carbon;
use Helper;
use App\Models\User;
use App\Models\RoleHasPermission;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RolesController extends BaseController
{
    private $AdminData;

    public function index() {
        $this->AdminData['details'] = $this->GetAdminData();
        $AdminData = $this->AdminData;

        $AdminData['moduleData'] = (object) [
            'moduleName' => 'Roles'
        ];

        $AdminData['datatableData']['columnList'] = $this->getDatatableColumnList();
        $AdminData['datatableData']['dataSource'] = route('admin.roles.list');
        return view('admin.roles.index', compact('AdminData'));
    }

    public function list(Request $request) {
        $roles = Role::select('id', 'name', 'display_name', 'guard_name', 'created_at', 'updated_at')
            ->orderByDesc('created_at');
            
        return DataTables::of($roles)
            ->addIndexColumn()
            ->make(true);
    }

    public function create(Request $request) {
        // validation for common request
        $rules = Role::$RoleCreateValidation;
        Helper::validateUserRequest($request, $rules);

        $role = new Role;
        
        $role->name = str_replace(' ', '', $request->name);
        $role->display_name = $request->name;
        $role->guard_name = 'web';        
        $role->created_at = Carbon::now('Asia/Kolkata');
        $role->updated_at = Carbon::now('Asia/Kolkata');
        $role->save();

        $response['status'] = true;
        $response['data'] = $role;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function edit($id) {
        $role = Role::find($id);

        /* Role has permissions list */
        $role->roleHasPermission = RoleHasPermission::where([['role_id', '=', $id]])
                ->pluck('permission_id');
        
        $response['status'] = true;
        $response['data'] = $role;
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function update(Request $request, $id) {
        $role = Role::find($id);

        // Validation for common request
        $rules = Role::$RoleUpdateValidation;
        $rules['name'] = $rules['name'] . ',display_name,' . $role->id;
        Helper::validateUserRequest($request, $rules);
        
        $role->name = str_replace(' ', '', $request->name);
        $role->display_name = $request->name;
        $role->guard_name = 'web';
        $role->updated_at = Carbon::now('Asia/Kolkata');
        $role->save();

        $response['status'] = true;
        $response['data'] = $role;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function delete($id) {
        $role = Role::find($id);
        $role->delete();

        $response['status'] = true;
        $response['message'] = '';
        $respone['data'] = null;
        return response()->json($response, 200);
    }

    public function rolePermissions($id) {
        $permissions = [['name' => 'Read'], ['name' => 'Write'], ['name' => 'Update'], ['name' => 'Delete'], ['name' => 'Export']];

        $rolePermissions = RoleHasPermission::with('rolePermissionsList')
                            ->where([['role_id', '=', $id]])
                            ->get();
        $selectedPermissionsList = [];
        if($rolePermissions != null && $rolePermissions != '') {
            foreach($rolePermissions as $rolePermission) {
                $selectedPermissionsList[] = $rolePermission->rolePermissionsList[0];
            }
        }
        $modules = Module::where([['isActive', '=', 1]])
                        ->get();

        $response['status'] = true;
        $response['data'] = $permissions;
        $response['rolePermissions'] = $selectedPermissionsList;
        $response['modules'] = $modules;
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function rolePermissionsCreate(Request $request, $id) {
        $permissions = Permission::get();
        $rolePermissions = [];
        foreach($permissions as $permission) {
            DB::table('role_has_permissions')->where('role_id', $id)->delete();
            $roleHasPermission = new RoleHasPermission();
            if($request->has(str_replace('.', '_', $permission->name)) === true) {
                $roleHasPermission->role_id = $id;
                $roleHasPermission->permission_id = $permission->id;
                $rolePermissions[] = $roleHasPermission->attributesToArray();
            }
        }
        RoleHasPermission::insert($rolePermissions);

        // To remove permission cache
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        
        $response['status'] = true;
        $response['data'] = $rolePermissions;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    private function getDatatableColumnList(){
        $columnList = [];
        array_push($columnList, (object)[
            'displayName' => 'S.No.'
            , 'selectColumnName' => 'DT_RowIndex'
            , 'columnName' => 'DT_RowIndex'
            , 'className' => 'text-center'
            , 'orderable' => false
            , 'searchable' => false
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Name'
            , 'selectColumnName' => 'display_name'
            , 'columnName' => 'display_name'
            , 'className' => ''
            , 'orderable' => true
            , 'searchable' => true
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Guard Name'
            , 'selectColumnName' => 'guard_name'
            , 'columnName' => 'guard_name'
            , 'className' => 'text-center'
            , 'orderable' => false
            , 'searchable' => true
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Created At'
            , 'selectColumnName' => 'created_at'
            , 'columnName' => 'created_at'
            , 'className' => 'text-center'
            , 'orderable' => false
            , 'searchable' => true
        ]);
        array_push($columnList, (object) [
            'displayName' => 'Action'
            , 'selectColumnName' => 'action'
            , 'columnName' => 'action'
            , 'className' => 'text-center'
            , 'orderable' => false
            , 'searchable' => false
        ]);

        return $columnList;
    }
}