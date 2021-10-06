<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Yajra\DataTables\DataTables;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use App\Models\ModelHasPermission;

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
        $permissions = $user->getAllPermissions();
        $user->userPermissions = $permissions->pluck('id');
        
        $response['status'] = true;
        $response['data'] = $user;
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function givePermission(Request $request, $id) {
        if($request->permission != null && $request->permission != '') {
            DB::table('model_has_permissions')->where('model_id', $id)->delete();
            $insertUserPermissions = [];
            foreach($request->permission as $permission) {
                $modalPermission = new ModelHasPermission;
                $modalPermission->permission_id = $permission;
                $modalPermission->model_type = 'App\Models\User';
                $modalPermission->model_id = $id;
                $insertUserPermissions[] = $modalPermission->attributesToArray();
            }
            ModelHasPermission::insert($insertUserPermissions);
        } else {
            DB::table('model_has_permissions')->where('model_id', $id)->delete();
        }
        $response['status'] = true;
        $response['data'] = '';
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function userPermissions(Request $request, $id) {
        // Permissions List
        $permissionsList = Permission::orderBy('created_at', 'desc')
            ->get()->toArray();
        
        // User Permissions
        $user = User::find($id);
        $permissions = $user->getAllPermissions()->pluck('id');
        $userPermissionsList = $permissions;

        $response['status'] = true;
        $response['data'] = $permissionsList;
        $response['message'] = 'Permissions List';
        $response['userPermissions'] = $userPermissionsList;
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
