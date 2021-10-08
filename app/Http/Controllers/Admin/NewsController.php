<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\Reference;

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
        $news = News::select('id', 'category_id', 'title', 'media', 'media_link', 'description', 'state', 'city', 'view_count', 'display', 'isActive', 'isDeleted', 'reporter_id', 'news_date', 'created_by', 'updated_by', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc');
            
        return DataTables::of($news)
            ->addIndexColumn()
            ->addColumn('category_name', function (News $news) {
                return ($news->category != null) ? $news->category->name : '';
            })
            ->make(true);
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
            'displayName' => 'Description'
            , 'selectColumnName' => 'description'
            , 'columnName' => 'description'
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
