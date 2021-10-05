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
    <div class="modal fade" id="roles-modal" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="roles-modal-title" id="roles-modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="roles-form" id="roles-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="role_id" id="role_id" />
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" />
                                    <label id="name-error" class="error" for="name"></label>
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
    $(document).ready(function () {
        // InitFormValidation();
    });

    function InitFormValidation() {
        $("#roles-form").validate({
            ignore: [],
            rules : {
                name: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: 'Role Name is required.'
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
                        return '<button type="button" title="Edit" onclick="editRecord(' + t.id + ')" class="btn btn-icon btn-warning btn-sm p-0"><i class="fa fa-edit"></i></button> ' +
                            '<button type="button" id="btn_delete" title="Delete" onclick="deleteRecord(' + t.id + ')" class="btn btn-icon btn-danger btn-sm p-0"><i class="fa fa-trash"></i></button>';
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
        $('#roles-modal-title').empty();
        $('#roles-modal-title').append('<h5 class="roles-modal-title" id="roles-modal-title">Create Role</h5>');
        $('#modal_submit').empty();
        $('#modal_submit').append('Create Role');
        $('#roles-modal').modal('show');
    });
    $('#modal_cancel').click(function(){
        $('#roles-modal').modal('hide');
    });
    $('#modal_submit').click(function() {
        if(!$('#roles-form').valid()) {
            return false;
        }
        var doAjax_params_default = {};
        if($('#role_id').val() != '') {
            doAjax_params_default = {
                'url': '{{ url('admin/role/') }}' + '/update/' + $('#role_id').val(),
                'requestType': 'PUT',
                'data': getFormData(),
                'successCallbackFunction': 'updateRole',
            }
        } else {
            doAjax_params_default = {
                'url': '{{ route('admin.roles.create') }}',
                'requestType': 'POST',
                'data': getFormData(),
                'successCallbackFunction': 'createRole',
            }
        }
        doAjaxCall(doAjax_params_default);
    });

    function createRole(status, data, message) {
        if(!status) {
            ShowValidationErrorOnModal(data);
            return false;
        }
        $('#roles-modal').modal('hide');
        showAlert('success', title = 'Success', 'Role Created Successfully..!');
        $('#DataGrid').dataTable().api().ajax.reload();
    }

    function updateRole (status, data, message) {
        if(!status) {
            ShowValidationErrorOnModal(data);
            return false;
        }
        $('#roles-modal').modal('hide');
        showAlert('success', title = 'Success', 'Role Updated Successfully..!');
        $('#DataGrid').dataTable().api().ajax.reload();
    }

    function editRecord(id) {
        resetFormData();
        $('#roles-model-title').empty();
        $('#roles-model-title').append('<h5 class="roles-model-title" id="roles-modal-title">Edit Role</h5>');
        $('#modal_submit').empty();
        $('#modal_submit').append('Update Role');
        var doAjax_params_default = {
            'url': '{{ url('admin/role') }}' + '/edit/' + id,
            'requestType': "GET",
            'successCallbackFunction': 'fillRoleData'
        };
        doAjaxCall(doAjax_params_default);
    }

    function fillRoleData(status, data, message) {
        if(!status) {
            showAlert('warning', title = 'Warning', (message.length > 0 ? message : 'Some error occured!'));
            return false;
        }
        setFormData(data);
        $("#modal-title h5").text("Edit Role");
        $('#roles-modal').modal('show');
    }

    function deleteRecord(id){        
        getConfirmation('warning', 'Delete?', 'Are you sure you want to delete this?', 'confirmedDeleteAction', id);
    }

    function confirmedDeleteAction(id) {
        var doAjax_params_default = {
            'url': '{{ url('admin/role/') }}' + '/delete/' + id,
            'requestType': "DELETE",
            'successCallbackFunction': 'deleteRoleData'
        }
        doAjaxCall(doAjax_params_default);
    }

    function deleteRoleData(status, data, message) {
        if(!status) {
            showAlert('warning', title = 'Warning', (message.length > 0 ? message : 'Some error occured'));
            return false;
        }
        showAlert('success', title = 'Success', 'Role Deleted Successfully..!');
        $('#DataGrid').dataTable().api().ajax.reload();
    }

    function resetFormData() {
        $('#role_id').val('');
        $('#name').val('');

        // To reset form validations
        $('#roles-form').validate().resetForm();
    }

    function setFormData(data) {
        $('#role_id').val(data.id);
        $('#name').val(data.name);
    }

    function getFormData() {
        var data = { role_id: $('#role_id').val(), name: $('#name').val() }
        return data; 
    }

</script>
@endpush