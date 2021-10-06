@extends('admin.layouts.master')

<?php 
    /*Module variables*/
    $moduleName = isset($AdminData['moduleData']) ? $AdminData['moduleData']->moduleName: "";
?>

@push('page-level-plugins')
<!--Datatable -->
<link href="{{ asset('assets/plugins/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatable/responsivebootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">{{ $moduleName }}</div>
                    @can('CreateCategory')
                        <div class="card-options">
                            <button type="button" class="admin-grid-action-create btn btn-outline-primary"><i class="fe fe-plus mr-2"></i> Add</button>
                        </div>
                    @endcan
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
    <div class="modal fade" id="category-modal" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="category-model-title" id="category-model-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="category-form" id="category-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="category_id" id="category_id" />
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Category Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" />
                                    <label id="name-error" class="error" for="name"></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="form-group">
                                    <label for="cat_image" class="form-control-label">Select File for Upload <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="cat_image" id="cat_image" />
                                    <label id="cat_image-error" class="error" for="cat_image"></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="form-group m-0">
                                    <label for="isActive" class="form-control-label">Status</label>
                                    <div class="custom-controls-stacked" style="padding-top: 10px;">
                                        <label class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="isActive" id="isActive" />
                                            <span class="custom-control-label">Yes</span>
                                            <label id="isActive-error" class="error" for="isActive"></label>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" id="modal_cancel"> Cancel</button>
                    <button type="submit" class="btn btn-outline-success" id="modal_submit"> Add Category</button>
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
@endpush

@push('manual-scripts')
<script type="text/javascript">
    var isCatImageExists = false; /*to check whether image is already exists in edit request*/
    $(document).ready(function () {
        InitFormValidation();
    });

    function InitFormValidation() {
        $("#category-form").validate({
            ignore: [],
            rules : {
                name: {
                    required: true
                },
                cat_image:{
                    // catImageRequired: true,
                    extension: "jpg|jpeg|png"
                }
            },
            messages: {
                name: {
                    required: 'Category Name is required.'
                },
                cat_image:{
                    // catImageRequired: "Category Image is required",
                    extension: "Please upload file in these format only (jpg, jpeg, png)."
                }
            }
        });        
    }

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
                    targets: 4,
                    title: "Actions",
                    orderable: !1,
                    render: function(a, e, t, n) {
                        @if(auth()->user()->can('EditCategory') && auth()->user()->can('DeleteCategory'))
                            return '<button type="button" title="Edit" onclick="editRecord(' + t.id + ')" class="btn btn-icon btn-warning btn-sm p-0"><i class="fa fa-edit"></i></button> ' +
                                '<button type="button" id="btn_delete" title="Delete" onclick="deleteRecord(' + t.id + ')" class="btn btn-icon btn-danger btn-sm p-0"><i class="fa fa-trash"></i></button>';
                        @elseif(auth()->user()->can('EditCategory'))
                            return '<button type="button" title="Edit" onclick="editRecord(' + t.id + ')" class="btn btn-icon btn-warning btn-sm p-0"><i class="fa fa-edit"></i></button> ';
                        @elseif(auth()->user()->can('DeleteCategory'))
                            return '<button type="button" id="btn_delete" title="Delete" onclick="deleteRecord(' + t.id + ')" class="btn btn-icon btn-danger btn-sm p-0"><i class="fa fa-trash"></i></button>';
                        @else
                            return '';
                        @endif
                    }
                },
                {
                    targets: 3,
                    render: function(a, e, t, n){
                        return (t.isActive == 1) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Inactive</span>';
                    }

                },
                {
                    targets: 2,
                    render: function(a, e, t, n){
                        return (t.imageUrl != '' && t.imageUrl != null) ? '<a href="'+ t.imageUrl +'" target="_blank"><img src="'+ t.imageUrl +'" class="img-thumbnail" height="35px" width="35px" /></a>' : '';
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
        resetFormData();
        $('#category-model-title').empty();
        $('#category-model-title').append('<h5 class="category-model-title" id="category-modal-title">Create Category</h5>');
        $('#modal_submit').empty();
        $('#modal_submit').append('Create Category');
        $('#parent_category_id').attr('disabled', false);
        $('#category-modal').modal('show');
    });
    $('#modal_cancel').click(function(){
        $('#category-modal').modal('hide');
    });

    $('#modal_submit').click(function() {
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
    });
    
    function createCategory(status, data, message) {
        if(!status) {
            ShowValidationErrorOnModal(data);
            return false;
        }
        $('#category-modal').modal('hide');
        showAlert('success', title = 'Success', 'Category Created Successfully..!');
        $('#DataGrid').dataTable().api().ajax.reload();
    }

    function updateCategory (status, data, message) {
        if(!status) {
            ShowValidationErrorOnModal(data);
            return false;
        }
        $('#category-modal').modal('hide');
        showAlert('success', title = 'Success', 'Category Updated Successfully..!');
        $('#DataGrid').dataTable().api().ajax.reload();
    }

    function editRecord(id) {
        resetFormData();
        $('#category-model-title').empty();
        $('#category-model-title').append('<h5 class="category-model-title" id="category-modal-title">Edit Category</h5>');
        $('#modal_submit').empty();
        $('#modal_submit').append('Update Category');
        $('#parent_category_id').attr('disabled', true);
        var doAjax_params_default = {
            'url': '{{ url('admin/category') }}' + '/edit/' + id,
            'requestType': "GET",
            'successCallbackFunction': 'fillCategoryData'
        };
        doAjaxCall(doAjax_params_default);
    }

    function fillCategoryData(status, data, message) {
        if(!status) {
            showAlert('warning', title = 'Warning', (message.length > 0 ? message : 'Some error occured!'));
            return false;
        }
        setFormData(data);
        $("#modal-title h5").text("Edit Category");
        $('#category-modal').modal('show');
    }

    function deleteRecord(id){        
        getConfirmation('warning', 'Delete?', 'Are you sure you want to delete this?', 'confirmedDeleteAction', id);
    }

    function confirmedDeleteAction(id) {
        var doAjax_params_default = {
            'url': '{{ url('admin/category') }}' + '/delete/' + id,
            'requestType': "DELETE",
            'successCallbackFunction': 'deleteCategoryData'
        }
        doAjaxCall(doAjax_params_default);
    }

    function deleteCategoryData(status, data, message) {
        if(!status) {
            showAlert('warning', title = 'Warning', (message.length > 0 ? message : 'Some error occured'));
            return false;
        }
        showAlert('success', title = 'Success', 'Category Deleted Successfully..!');
        $('#DataGrid').dataTable().api().ajax.reload();
    }

    function resetFormData() {
        $('#category_id').val('');
        $('#name').val('');
        $('#cat_image').val('');
        $('input[type=checkbox]').prop('checked',false);

        // To reset form validations
        $('#category-form').validate().resetForm();

        isCatImageExists = false;
    }

    function setFormData(data) {
        $('#category_id').val(data.id);
        $('#name').val(data.name);
        // if(data.image_name != null && data.image_name != '') {
        //     isCatImageExists = true;
        //     $('#upload-image').css('display', 'block');
        //     $('div#upload-image > img').remove();
        //     $("#upload-image").append('<img id="uploaded_image" src="{{ url("uploads/categories/")}}/' + data.image_name +'" style="height: 100px;">');
        // } else {
        //     $('#upload-image').css('display', 'none');
        //     $('div#upload-image > img').remove();
        // }
        if(data.isActive == 1) {
            $('#isActive').prop("checked", true);
        }
    }

    function getFormData() {
        var data = { category_id: $('#category_id').val(), name: $('#name').val()
                    , cat_image: $('#cat_image')[0].files[0], isActive: $('#isActive').is(':checked') ? 1 : 0 }
        return data; 
    }

</script>
@endpush