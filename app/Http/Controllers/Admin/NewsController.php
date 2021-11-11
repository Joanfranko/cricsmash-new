<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\Reference;
use Helper;
use Auth;
use Carbon\Carbon;

class NewsController extends BaseController
{
    private $AdminData;

    public function index() {
        $this->AdminData['details'] = $this->GetAdminData();
        $AdminData = $this->AdminData;

        $AdminData['moduleData'] = (object) [
            'moduleName' => 'News'
        ];

        $categories = Category::where([['isActive', '=', 1]])
                        ->get();

        $references = Reference::where([['isActive', '=', 1], ['isDeleted', '=', 0]])
                        ->get();
        
        $AdminData['datatableData']['columnList'] = $this->getDatatableColumnList();
        $AdminData['datatableData']['dataSource'] = route('admin.news.list');
        return view('admin.news.index', compact('AdminData', 'categories', 'references'));
    }

    public function list(Request $request) {
        $news = News::select('id', 'category_id', 'reference_id', 'title', 'media', 'media_link', 'description', 'state', 'city', 'view_count', 'display', 'isActive', 'isDeleted', 'reporter_id', 'news_date', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc');
            
        return DataTables::of($news)
            ->addIndexColumn()
            ->addColumn('category_name', function (News $news) {
                return ($news->category != null) ? $news->category->name : '';
            })
            ->addColumn('reporter_name', function (News $news) {
                return ($news->reporter != null) ? $news->reporter->name : '';
            })
            ->addColumn('reference_name', function (News $news) {
                return ($news->reference != null) ? $news->reference->name : '';
            })
            ->make(true);
    }

    public function create(Request $request) {
        $rules = News::$NewsValidation;
        Helper::validateUserRequest($request, $rules);

        $news = new News;

        $news->title = $request->title;
        $news->category_id = $request->category;
        $news->tag = $request->tag;
        // To upload image
        if($request->file('image_video') != '' && $request->file('image_video') != null) {
            $image = $request->file('image_video');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/news'), $new_name);
            $news->media = $new_name;
        }
        $news->media_link = $request->media_link;
        $news->thumbnail = $request->youtube_link;
        $news->description = $request->description;
        $news->isActive = ($request->isActive == 'on') ? 1 : 0 ;
        $news->reference_id = $request->reference;
        $news->display = 1;
        $news->reporter_id = Auth::id();
        $news->news_date = Carbon::now('Asia/Kolkata');
        $news->created_by = Auth::id();
        $news->created_at = Carbon::now('Asia/Kolkata');
        $news->updated_at = null;
        $news->save();

        $response['status'] = true;
        $response['data'] = $news;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function edit($id) {
        $news = News::find($id);

        $response['status'] = true;
        $response['data'] = $news;
        $response['message'] = 'Success';
        return response()->json($response, 200);
    }

    public function update(Request $request, $id) {
        // Validation for common request
        $rules = News::$NewsValidation;
        Helper::validateUserRequest($request, $rules);

        $news = News::find($id);

        $news->title = $request->title;
        $news->category_id = $request->category;
        $news->tag = $request->tag;
        // To upload image
        if($request->file('image_video') != '' && $request->file('image_video') != null) {
            $image = $request->file('image_video');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/news'), $new_name);
            $news->media = $new_name;
        }
        $news->media_link = $request->media_link;
        $news->thumbnail = $request->youtube_link;
        $news->description = $request->description;
        $news->isActive = ($request->isActive == 'on') ? 1 : 0 ;
        $news->reference_id = $request->reference;
        $news->display = 1;
        $news->reporter_id = Auth::id();
        $news->news_date = Carbon::now('Asia/Kolkata');
        $news->updated_by = Auth::id();
        $news->updated_at = Carbon::now('Asia/Kolkata');
        $news->save();

        $response['status'] = true;
        $response['data'] = $news;
        $response['message'] = '';
        return response()->json($response, 200);
    }

    public function delete($id) {
        $news = News::find($id);
        $news->delete();

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
            'displayName' => 'News'
            , 'selectColumnName' => 'title'
            , 'columnName' => 'title'
            , 'className' => ''
            , 'orderable' => true
            , 'searchable' => true
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Category'
            , 'selectColumnName' => 'category_name'
            , 'columnName' => 'category_name'
            , 'className' => 'text-center'
            , 'orderable' => true
            , 'searchable' => true
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Reporter'
            , 'selectColumnName' => 'reporter_name'
            , 'columnName' => 'reporter_name'
            , 'className' => ''
            , 'orderable' => true
            , 'searchable' => true
        ]);
        array_push($columnList, (object)[
            'displayName' => 'Reference'
            , 'selectColumnName' => 'reference_name'
            , 'columnName' => 'reference_name'
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
