<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\ModelHasRole;
use App\Models\Role;

class UserManagementController extends BaseController
{
    private $AdminData;

    public function index() {
        $this->AdminData['details'] = $this->GetAdminData();
        $AdminData = $this->AdminData;

        $AdminData['moduleData'] = (object) [
            'moduleName' => 'User Management'
        ];

        $AdminData['datatableData']['columnList'] = $this->getDatatableColumnList();
        $AdminData['datatableData']['dataSource'] = route('admin.users.list');
        return view('admin.users.index', compact('AdminData'));
    }

    public function list(Request $request) {
        $users = User::select('id', 'role_id', 'name', 'email', 'isActive', 'created_at', 'updated_at')
            ->orderByDesc('created_at');
            
        return DataTables::of($users)
            ->addIndexColumn()
            ->make(true);
    }

    public function edit($id) {
        $user = User::find($id);

        // $users = User::get();
        $roles = $user->roles();
        $user->userRoles = $roles->pluck('id');
        
        $response['status'] = true;
        $response['data'] = $user;
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function assignRoles(Request $request, $id) {
        if($request->role != null && $request->role != '') {
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $insertUserRoles = [];
            foreach($request->role as $role) {
                $modalRole = new ModelHasRole;
                $modalRole->role_id = $role;
                $modalRole->model_type = 'App\Models\User';
                $modalRole->model_id = $id; // user id
                $insertUserRoles[] = $modalRole->attributesToArray();
            }
            ModelHasRole::insert($insertUserRoles);
            
            // To remove permission cache
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        } else {
            DB::table('model_has_roles')->where('model_id', $id)->delete();
        }
        $response['status'] = true;
        $response['data'] = '';
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function userRoles(Request $request, $id) {
        // Permissions List
        $rolesList = Role::orderBy('created_at', 'desc')
            ->get()->toArray();
        
        // User Permissions
        $user = User::with('roles')->find($id);
        $roles = $user->roles()->pluck('id');
        $userRolesList = $roles;

        $response['status'] = true;
        $response['data'] = $rolesList;
        $response['message'] = 'Permissions List';
        $response['userRoles'] = $userRolesList;
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
            , 'selectColumnName' => 'name'
            , 'columnName' => 'name'
            , 'className' => ''
            , 'orderable' => true
            , 'searchable' => true
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Email'
            , 'selectColumnName' => 'email'
            , 'columnName' => 'email'
            , 'className' => ''
            , 'orderable' => true
            , 'searchable' => true
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Status'
            , 'selectColumnName' => 'isActive'
            , 'columnName' => 'isActive'
            , 'className' => 'text-center'
            , 'orderable' => false
            , 'searchable' => false
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Created At'
            , 'selectColumnName' => 'created_at'
            , 'columnName' => 'created_at'
            , 'className' => 'text-center'
            , 'orderable' => false
            , 'searchable' => false
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
