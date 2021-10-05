<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Yajra\DataTables\DataTables;
use Auth;
use Carbon\Carbon;
use Helper;

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
        $rules = Role::$RoleValidation;
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

        $response['status'] = true;
        $response['data'] = $role;
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function update(Request $request, $id) {
        // Validation for common request
        $rules = Role::$RoleValidation;
        Helper::validateUserRequest($request, $rules);

        $role = Role::find($id);
        
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
