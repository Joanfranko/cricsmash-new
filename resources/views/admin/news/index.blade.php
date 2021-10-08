@extends('admin.layouts.master')

<?php 
    /*Module variables*/
    $moduleName = isset($AdminData['moduleData']) ? $AdminData['moduleData']->moduleName: "";
?>

@push('page-level-plugins')
<!--Datatable -->
<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />

<!--Mutipleselect css-->
<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $moduleName }}</div>
                    <div class="card-options">
                        <button type="button" class="admin-grid-action-create btn btn-outline-primary"><i class="fe fe-plus mr-2"></i> Add</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="DataGrid" class="table table-striped table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    @if(isset($AdminData['datatableData']['columnList']) && count($AdminData['datatableData']['columnList']) > 0)
                                        @foreach ($AdminData['datatableData']['columnList'] as $column)
                                            <th class="text-center">{{ $column->displayName }}</th>
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <!-- table-wrapper -->
            </div>
            <!-- section-wrapper -->
        </div>
    </div>
    <!-- row end -->

    <!-- Modal Begins -->
    <div class="modal fade" id="news-modal" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="news-modal-title" id="news-modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="news-form" id="news-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="    " id="user_id" />
                        <div class="row">
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" />
                                    <label id="title-error" class="error" for="title"></label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="category" class="form-control-label">Select Category <span class="text-danger">*</span></label>
                                    <select style="width:100%;" class="custom-select" id="category" name="category">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <label id="category-error" class="error" for="category"></label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="tag" class="form-control-label">Tag <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="tag" id="tag" />
                                    <label id="tag-error" class="error" for="tag"></label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group form-elements">
                                    <label for="media_link" class="form-control-label">Media Link <span class="text-danger">*</span></label>
                                    <div class="custom-controls-stacked">
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="media_link" value="Video/Image">
                                            <span class="custom-control-label">Video/Image</span>
                                        </label>
                                        <label class="custom-control custom-radio">
                                            <input type="radio" class="custom-control-input" name="media_link" value="Youtube Link">
                                            <span class="custom-control-label">Youtube Link</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="image_video" class="form-control-label">Image / Video <span class="text-danger">*</span></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image_video">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="youtube_link" class="form-control-label">Youtube Link <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="youtube_link" id="youtube_link" />
                                    <label id="youtube_link-error" class="error" for="youtube_link"></label>
                                </div>
                            </div>
                            <div class="col-xl-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <label for="reference" class="form-control-label">Select Reference <span class="text-danger">*</span></label>
                                    <select style="width:100%;" class="custom-select" id="reference" name="reference">
                                        <option value="">Select reference</option>
                                        @foreach ($references as $reference)
                                            <option value="{{ $reference->id }}">{{ $reference->reference }}</option>
                                        @endforeach
                                    </select>
                                    <label id="reference-error" class="error" for="reference"></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="form-group">
                                    <label for="description" class="form-control-label">Description <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control" id="description"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" id="modal_cancel">Cancel</button>
                    <button type="submit" class="btn btn-outline-success" id="modal_submit"></button>
                </div>
            </div>
        </div>
    </div> 
    <!-- Modal Ends -->
@endsection

@push('page-level-scripts')
<!--Datatable -->
<script src="{{ asset('assets/plugins/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>

{{--Reference: https://stackoverflow.com/questions/38095165/datatables-export-buttons-not-showing --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.18/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.18/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.bootstrap.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.js"></script>
<script src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.js"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('js/jquery.validate-methods.js') }}"></script>
<script src="{{ asset('js/jquery.validate-additional-methods.js') }}"></script>
<!--Mutipleselect js-->
<script src="{{ asset('assets/js/select2.full.min.js') }}" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--CK Editor -->
<script src="{{ asset('assets/plugins/ck-editor/ckeditor.js') }}"></script>
<script src="{{ asset('assets/plugins/ck-editor/config.js') }}"></script>
<script src="{{ asset('assets/plugins/ck-editor/adapters/jquery.js') }}"></script>
@endpush

@push('manual-scripts')
<script type="text/javascript">
    $(document).ready(function () {
        // InitFormValidation();

        $('#description').ckeditor();
    });

    var BindDataToDataGrid = {
        init: function() {
            var table = $('#DataGrid');
            table.dataTable({
                responsive : true,
                // aaSorting : [],
                lengthMenu : [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100] // change per page values here
                ],
                pageLength : 10,
                //Ajax Request
                processing : true,
                serverSide : true,
                order: [ [0, 'desc'] ],
                ajax: {
                    url : '{{ $AdminData["datatableData"]["dataSource"] }}',
                },
                columns: [
                    @if(isset($AdminData['datatableData']['columnList']) && count($AdminData['datatableData']['columnList']) > 0)
                    @include('admin.components.datatable-render-columns', $AdminData['datatableData']['columnList'])
                    @endif
                ],
                columnDefs : [{
                    targets: 5,
                    title: "Actions",
                    orderable: !1,
                    render: function(a, e, t, n) {
                        return '<button type="button" title="Edit" onclick="editRecord(' + t.id + ')" class="btn btn-icon btn-warning btn-sm p-0"><i class="fa fa-edit"></i></button> ' +
                            '<button type="button" id="btn_delete" title="Delete" onclick="deleteRecord(' + t.id + ')" class="btn btn-icon btn-danger btn-sm p-0"><i class="fa fa-trash"></i></button>';
                    }
                },
                {
                    targets: 4,
                    render: function(a, e, t, n){
                        return (t.isActive == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    }

                }],
                bDestroy: true,
                buttons: [
                    'copy', 'excel', 'pdf'
                ]
            });
        }
    };
    $(function(e) {
        //To bind data to datatable
        BindDataToDataGrid.init();
    });

    $('.admin-grid-action-create').click(function(){
        // resetFormData();
        $('#news-modal-title').empty();
        $('#news-modal-title').append('<h5 class="news-modal-title" id="news-modal-title">Create News</h5>');
        $('#modal_submit').empty();
        $('#modal_submit').append('Create News');
        $('#news-modal').modal('show');
    });
    $('#modal_cancel').click(function(){
        $('#news-modal').modal('hide');
    });

    /*$('#modal_submit').click(function() {
        if(!$('#category-form').valid()) {
            return false;
        }

        var formData = new FormData($('#category-form')[0]);
        var doAjax_params_default = {};
        if($('#category_id').val() != '') {
            doAjax_params_default = {
                'url': '{{ url('admin/category') }}' + '/update/' + $('#category_id').val(),
                'requestType': 'POST',
                'data': formData,
                'successCallbackFunction': 'updateCategory',
                'contentType': false,
                'processData': false,
            }
        } else {
            doAjax_params_default = {
                'url': '{{ route('admin.category.create') }}',
                'requestType': 'POST',
                'data': formData,
                'successCallbackFunction': 'createCategory',
                'errorCallBackFunction': 'CategoryCreateError',
                'contentType': false,
                'processData': false,
            }
        }
        doAjaxImageUploadCall(doAjax_params_default);
    });*/

</script>
@endpush