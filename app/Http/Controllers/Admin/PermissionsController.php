<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Permission;
use Auth;
use Carbon\Carbon;
use Helper;

class PermissionsController extends BaseController
{
    private $AdminData;

    public function index() {
        $this->AdminData['details'] = $this->GetAdminData();
        $AdminData = $this->AdminData;

        $AdminData['moduleData'] = (object) [
            'moduleName' => 'Permissions'
        ];

        $AdminData['datatableData']['columnList'] = $this->getDatatableColumnList();
        $AdminData['datatableData']['dataSource'] = route('admin.permissions.list');
        return view('admin.permissions.index', compact('AdminData'));
    }

    public function list(Request $request) {
        $permission = Permission::select('id', 'name', 'display_name', 'guard_name', 'created_at', 'updated_at')
            ->orderByDesc('created_at');
            
        return DataTables::of($permission)
            ->addIndexColumn()
            ->make(true);
    }

    public function create(Request $request) {
        // validation for common request
        $rules = Permission::$PermissionValidation;
        Helper::validateUserRequest($request, $rules);

        $permission = new Permission;
        
        $permission->name = str_replace(' ', '', $request->name);
        $permission->display_name = $request->name;
        $permission->guard_name = 'web';        
        $permission->created_at = Carbon::now('Asia/Kolkata');
        $permission->updated_at = Carbon::now('Asia/Kolkata');
        $permission->save();

        $response['status'] = true;
        $response['data'] = $permission;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function edit($id) {
        $permission = Permission::find($id);

        $response['status'] = true;
        $response['data'] = $permission;
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function update(Request $request, $id) {
        // Validation for common request
        $rules = Permission::$PermissionValidation;
        Helper::validateUserRequest($request, $rules);

        $permission = Permission::find($id);
        
        $permission->name = str_replace(' ', '', $request->name);
        $permission->display_name = $request->name;
        $permission->guard_name = 'web';
        $permission->updated_at = Carbon::now('Asia/Kolkata');
        $permission->save();

        $response['status'] = true;
        $response['data'] = $permission;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function delete($id) {
        $permission = Permission::find($id);
        $permission->delete();

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
