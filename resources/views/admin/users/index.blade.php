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
                    {{-- <div class="card-options">
                        <button type="button" class="admin-grid-action-create btn btn-outline-primary"><i class="fe fe-plus mr-2"></i> Add</button>
                    </div> --}}
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
    <div class="modal fade" id="users-modal" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="users-modal-title" id="users-modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="users-form" id="users-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="    " id="user_id" />
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" readonly />
                                    <label id="name-error" class="error" for="name"></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="form-group">
                                    <label for="permission" class="form-control-label">Select Permission <span class="text-danger">*</span></label>
                                    <select style="width:100%;" class="custom-select" id="permission" name="permission[]" multiple>
                                    </select>
                                    <label id="permission-error" class="error" for="permission"></label>
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
@endpush

@push('manual-scripts')
<script type="text/javascript">
    $(document).ready(function () {
        // InitFormValidation();
        RunSelect2();
    });

    function RunSelect2(){
        $('#permission').select2({
            allowClear: true,
            closeOnSelect: false,
            placeholder: "Select Permission",
        }).on('select2:open', function() {  
            setTimeout(function() {
                $(".select2-results__option .select2-results__group").bind( "click", selectAlllickHandler ); 
            }, 0);
        });
    }

    var selectAlllickHandler = function() {
        $(".select2-results__option .select2-results__group").unbind( "click", selectAlllickHandler );        
        $('#permission').select2('destroy').find('option').prop('selected', 'selected').end();
        RunSelect2();
    };

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
                        return (t.role_id != 1) ? '<button type="button" title="Grant Permission" onclick="givePermission(' + t.id + ')" class="btn btn-icon btn-warning btn-sm p-0"><i class="fa fa-shield"></i></button> ': '';
                    }
                },
                {
                    targets: 3,
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

    $('#modal_cancel').click(function(){
        $('#users-modal').modal('hide');
    });
    $('#modal_submit').click(function() {
        if(!$('#users-form').valid()) {
            return false;
        }
        var doAjax_params_default = {};
        if($('#user_id').val() != '') {
            doAjax_params_default = {
                'url': '{{ url('admin/user/permission') }}' + '/create/' + $('#user_id').val(),
                'requestType': 'POST',
                'data': getFormData(),
                'successCallbackFunction': 'updateRole',
            }
        }
        doAjaxCall(doAjax_params_default);
    });

    function updateRole (status, data, message) {
        if(!status) {
            ShowValidationErrorOnModal(data);
            return false;
        }
        $('#users-modal').modal('hide');
        showAlert('success', title = 'Success', 'Permissions Granted Successfully..!');
        $('#DataGrid').dataTable().api().ajax.reload();
    }

    function givePermission(id) {
        resetFormData();
        $('#users-modal-title').empty();
        $('#users-modal-title').append('<h5 class="users-modal-title" id="roles-modal-title">Grant Permission</h5>');
        $('#modal_submit').empty();
        $('#modal_submit').append('Grant Permission');
        var doAjax_params_default = {
            'url': '{{ url('admin/user') }}' + '/edit/' + id,
            'requestType': "GET",
            'successCallbackFunction': 'fillUserData'
        };
        doAjaxCall(doAjax_params_default);
    }

    function fillUserData(status, data, message) {
        if(!status) {
            showAlert('warning', title = 'Warning', (message.length > 0 ? message : 'Some error occured!'));
            return false;
        }
        var doAjax_params_default = {
            'url': '{{ url('admin/user') }}' + '/permission/' + data.id,
            'requestType': "GET",
            'successCallbackFunction': 'bindDropdownList',
        }
        doAjaxCall(doAjax_params_default);
        setFormData(data);
        $("#modal-title h5").text("Grant Permission");
        $('#users-modal').modal('show');
    }

    function bindDropdownList(status, data, message, responseObj) {
        var selectedVal = (responseObj && responseObj.userPermissions) ? responseObj.userPermissions : '';
        if(status) {
            bindPermissionsList(status, data, message);
            if(responseObj.userPermissions) {
                $("#permission").val(responseObj.userPermissions).trigger('change');
            }
        }
    }

    function bindPermissionsList(status, data, message) {
        $('#permission').empty();
        if(status && data != null && data != '') {
            var options = '';
            options += '<optgroup label="Select All">';
            $.each(data, function(i, v) {
                options += '<option value="' + v.id + '">'+ v.display_name +'</option>';
            });
            options += '</optgroup>';
        }
        $('select[name="permission[]"]').append(options);
    }

    function resetFormData() {
        $('#user_id').val('');
        $('#name').val('');
        $('#permission').val('');

        // To reset form validations
        $('#users-form').validate().resetForm();
    }

    function setFormData(data) {
        $('#user_id').val(data.id);
        $('#name').val(data.name);
        // $("#permission").val(data.permissions).trigger('change');
    }

    function getFormData() {
        var data = { user_id: $('#user_id').val(), permission: $('#permission').val() }
        return data; 
    }

</script>
@endpush