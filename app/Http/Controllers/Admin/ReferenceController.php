<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reference;
use Yajra\DataTables\DataTables;
use Auth;
use Carbon\Carbon;
use Helper;

class ReferenceController extends BaseController
{
    private $AdminData;

    public function index() {
        $this->AdminData['details'] = $this->GetAdminData();
        $AdminData = $this->AdminData;

        $AdminData['moduleData'] = (object) [
            'moduleName' => 'Reference'
        ];

        $AdminData['datatableData']['columnList'] = $this->getDatatableColumnList();
        $AdminData['datatableData']['dataSource'] = route('admin.reference.list');
        return view('admin.reference.index', compact('AdminData'));
    }

    public function list(Request $request) {
        $news = Reference::select('id', 'reference', 'short_name', 'isActive', 'isDeleted', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc');
            
        return DataTables::of($news)
            ->addIndexColumn()
            ->make(true);
    }

    public function create(Request $request) {
        // validation for common request
        $rules = Reference::$ReferenceValidation;
        Helper::validateUserRequest($request, $rules);

        $reference = new Reference;
        
        $reference->reference = $request->reference;
        $reference->short_name = $request->short_name;
        $reference->isActive = $request->isActive;
        $reference->created_by = Auth::id();
        $reference->created_at = Carbon::now('Asia/Kolkata');
        $reference->updated_at = Carbon::now('Asia/Kolkata');
        $reference->save();

        $response['status'] = true;
        $response['data'] = $reference;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function edit($id) {
        $reference = Reference::find($id);

        $response['status'] = true;
        $response['data'] = $reference;
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function update(Request $request, $id) {
        // Validation for common request
        $rules = Reference::$ReferenceValidation;
        Helper::validateUserRequest($request, $rules);

        $reference = Reference::find($id);
        
        $reference->reference = $request->reference;
        $reference->short_name = $request->short_name;
        $reference->isActive = $request->isActive;
        $reference->updated_by = Auth::id();
        $reference->updated_at = Carbon::now('Asia/Kolkata');
        $reference->save();

        $response['status'] = true;
        $response['data'] = $reference;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function delete($id) {
        $reference = Reference::find($id);
        $reference->delete();

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
            'displayName' => 'Image Reference / Copyright'
            , 'selectColumnName' => 'reference'
            , 'columnName' => 'reference'
            , 'className' => ''
            , 'orderable' => true
            , 'searchable' => true
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Source'
            , 'selectColumnName' => 'short_name'
            , 'columnName' => 'short_name'
            , 'className' => 'text-center'
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
