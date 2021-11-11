<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Permission;
use Auth;
use Carbon\Carbon;
use Helper;
use Illuminate\Support\Facades\DB;

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

    /*public function create(Request $request) {
        // validation for common request
        $rules = Permission::$PermissionValidation;
        Helper::validateUserRequest($request, $rules);

        $modules = Module::where([['isActive', '=', 1]])
                    ->get();
        // TODO: Edit have to work with modules permissions
        $permission = new Permission();
        foreach($modules as $module) {
            $permission->name = str_replace(' ', '', $module->name.'.'.$request->name);
            $permission->display_name = $module->name.' '.$request->name;
            $permission->guard_name = 'web';        
            $permission->created_at = Carbon::now('Asia/Kolkata');
            $permission->updated_at = null;
            $modulePermissions[] = $permission->attributesToArray();
        }
        Permission::insert($modulePermissions);

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
        $permission = Permission::where([['name', 'like' , $permission->name .'%']])->get();
        dd($permission);
        // $permission->name = str_replace(' ', '', $request->name); //To avoid change the name of the permission
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
    }*/

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

        return $columnList;
    }
}
