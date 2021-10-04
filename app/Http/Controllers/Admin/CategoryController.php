<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use Auth;
use Carbon\Carbon;
use Helper;

class CategoryController extends BaseController
{
    private $AdminData;

    public function index() {
        $this->AdminData['details'] = $this->GetAdminData();
        $AdminData = $this->AdminData;

        $AdminData['moduleData'] = (object) [
            'moduleName' => 'Category'
        ];

        $AdminData['datatableData']['columnList'] = $this->getDatatableColumnList();
        $AdminData['datatableData']['dataSource'] = route('admin.category.list');
        return view('admin.category.index', compact('AdminData'));
    }

    public function list(Request $request) {
        $categories = Category::select('id', 'name', 'image_name', 'isActive', 'isDisplayable', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->orderByDesc('created_at');
            
        return DataTables::of($categories)
            ->addIndexColumn()
            ->make(true);
    }

    public function create(Request $request) {
        // validation for uncommon request
        $rules = Category::$CategoryValidation;
        Helper::validateUserRequest($request, $rules);

        $category = new Category;
        
        $category->name = $request->name;
        $category->isActive = ($request->isActive == 'on') ? 1 : 0;

        // To upload image
        if($request->file('cat_image') != '' && $request->file('cat_image') != null) {
            $image = $request->file('cat_image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $new_name);
            $category->image_name = $new_name;
        }
        
        $category->created_by = Auth::id();
        $category->created_at = Carbon::now('Asia/Kolkata');
        $category->updated_at = Carbon::now('Asia/Kolkata');
        $category->save();

        $response['status'] = true;
        $response['data'] = $category;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function edit($id) {
        $category = Category::find($id);

        $response['status'] = true;
        $response['data'] = $category;
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function update(Request $request, $id) {
        // Validation for uncommon request
        $rules = Category::$CategoryValidation;
        Helper::validateUserRequest($request, $rules);

        $category = Category::find($id);
        
        $category->name = $request->name;
        $category->isActive = ($request->isActive == 'on') ? 1 : 0;

        // To upload image
        if($request->file('cat_image') != '' && $request->file('cat_image') != null) {
            $image = $request->file('cat_image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/categories'), $new_name);
            $category->image_name = $new_name;
        }
        $category->updated_by = Auth::id();
        $category->updated_at = Carbon::now('Asia/Kolkata');
        $category->save();

        $response['status'] = true;
        $response['data'] = $category;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function delete($id) {
        $Category = Category::find($id);
        $Category->delete();

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
            'displayName' => 'Category Name'
            , 'selectColumnName' => 'name'
            , 'columnName' => 'name'
            , 'className' => ''
            , 'orderable' => true
            , 'searchable' => true
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Image'
            , 'selectColumnName' => 'image_name'
            , 'columnName' => 'image_name'
            , 'className' => 'text-center'
            , 'orderable' => false
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
