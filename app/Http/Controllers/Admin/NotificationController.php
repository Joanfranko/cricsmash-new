<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Helper;
use Auth;
use Carbon\Carbon;

class NotificationController extends BaseController
{
    public function index() {
        $this->AdminData['details'] = $this->GetAdminData();
        $AdminData = $this->AdminData;

        $AdminData['moduleData'] = (object) [
            'moduleName' => 'Notification'
        ];

        $AdminData['datatableData']['columnList'] = $this->getDatatableColumnList();
        $AdminData['datatableData']['dataSource'] = route('admin.notification.list');
        return view('admin.notification.index', compact('AdminData'));
    }

    public function list(Request $request) {
        $notifications = Notification::select('id', 'title', 'message', 'isActive', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc');
            
        return DataTables::of($notifications)
            ->addIndexColumn()
            ->make(true);
    }

    public function create(Request $request) {
        // validation for common request
        $rules = Notification::$NotificationValidation;
        Helper::validateUserRequest($request, $rules);

        $notification = new Notification;
        
        $notification->title = $request->title;
        $notification->message = $request->message;
        $notification->isActive = $request->isActive;
        $notification->created_by = Auth::id();
        $notification->created_at = Carbon::now('Asia/Kolkata');
        $notification->updated_at = null;
        $notification->save();

        $response['status'] = true;
        $response['data'] = $notification;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function edit($id) {
        $notification = Notification::find($id);

        $response['status'] = true;
        $response['data'] = $notification;
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function update(Request $request, $id) {
        // Validation for common request
        $rules = Notification::$NotificationValidation;
        Helper::validateUserRequest($request, $rules);

        $notification = Notification::find($id);
        
        $notification->title = $request->title;
        $notification->message = $request->message;
        $notification->isActive = $request->isActive;
        $notification->updated_by = Auth::id();
        $notification->updated_at = Carbon::now('Asia/Kolkata');
        $notification->save();

        $response['status'] = true;
        $response['data'] = $notification;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function delete($id) {
        $notification = Notification::find($id);
        $notification->delete();

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
            'displayName' => 'Title'
            , 'selectColumnName' => 'title'
            , 'columnName' => 'title'
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
