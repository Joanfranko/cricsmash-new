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
    <div class="modal fade" id="notification-modal" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="notification-modal-title" id="notification-modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form name="notification-form" id="notification-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" class="form-control" name="notification_id" id="notification_id" />
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="form-group">
                                    <label for="title" class="form-control-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" id="title" />
                                    <label id="title-error" class="error" for="title"></label>
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12 col-sm-12">
                                <div class="form-group">
                                    <label for="message" class="form-control-label">Message <span class="text-danger">*</span></label>
                                    <textarea name="message" class="form-control" id="message"></textarea>
                                    <label id="description-error" class="error" for="description"></label>
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
        InitFormValidation();
        $('#message').ckeditor();
    });

    function InitFormValidation() {
        $("#notification-form").validate({
            ignore: [],
            rules : {
                title: {
                    required: true
                },
                message: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: 'Title is required.'
                },
                message: {
                    required: 'Message is required'
                }
            },
            errorPlacement: function (error, element) {
                //element.attr("type") == "checkbox")
                //error.insertAfter($(element).parents('div').next($('.question')));
                //error.before(element);
                error.appendTo( element.parent("div").parent("div"));
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
                    targets: 3,
                    title: "Actions",
                    orderable: !1,
                    render: function(a, e, t, n) {
                        return '<button type="button" title="Edit" onclick="editRecord(' + t.id + ')" class="btn btn-icon btn-warning btn-sm p-0"><i class="fa fa-edit"></i></button> ' +
                            '<button type="button" id="btn_delete" title="Delete" onclick="deleteRecord(' + t.id + ')" class="btn btn-icon btn-danger btn-sm p-0"><i class="fa fa-trash"></i></button>';
                    }
                },
                {
                    targets: 2,
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
        resetFormData();
        $('#notification-modal-title').empty();
        $('#notification-modal-title').append('<h5 class="notification-modal-title" id="notification-modal-title">Create Notification</h5>');
        $('#modal_submit').empty();
        $('#modal_submit').append('Create Notification');
        $('#notification-modal').modal('show');
    });
    $('#modal_cancel').click(function(){
        $('#notification-modal').modal('hide');
    });

    $('#modal_submit').click(function() {
        if(!$('#notification-form').valid()) {
            return false;
        }
        var doAjax_params_default = {};
        if($('#notification_id').val() != '') {
            doAjax_params_default = {
                'url': '{{ url('admin/notification/') }}' + '/update/' + $('#notification_id').val(),
                'requestType': 'PUT',
                'data': getFormData(),
                'successCallbackFunction': 'updateNotification',
            }
        } else {
            doAjax_params_default = {
                'url': '{{ route('admin.notification.create') }}',
                'requestType': 'POST',
                'data': getFormData(),
                'successCallbackFunction': 'createNotification',
            }
        }
        doAjaxCall(doAjax_params_default);
    });

    function editRecord(id) {
        resetFormData();
        $('#notification-modal-title').empty();
        $('#notification-modal-title').append('<h5 class="notification-modal-title" id="notification-modal-title">Edit Notification</h5>');
        $('#modal_submit').empty();
        $('#modal_submit').append('Update Notification');
        var doAjax_params_default = {
            'url': '{{ url('admin/notification') }}' + '/edit/' + id,
            'requestType': "GET",
            'successCallbackFunction': 'fillNotificationData'
        };
        doAjaxCall(doAjax_params_default);
    }

    function deleteRecord(id){        
        getConfirmation('warning', 'Delete?', 'Are you sure you want to delete this?', 'confirmedDeleteAction', id);
    }

    function confirmedDeleteAction(id) {
        var doAjax_params_default = {
            'url': '{{ url('admin/notification/') }}' + '/delete/' + id,
            'requestType': "DELETE",
            'successCallbackFunction': 'deleteNotificationData'
        }
        doAjaxCall(doAjax_params_default);
    }

    function deleteNotificationData(status, data, message) {
        if(!status) {
            showAlert('warning', title = 'Warning', (message.length > 0 ? message : 'Some error occured'));
            return false;
        }
        showAlert('success', title = 'Success', 'Notification Deleted Successfully..!');
        $('#DataGrid').dataTable().api().ajax.reload();
    }

    function fillNotificationData(status, data, message) {
        if(!status) {
            showAlert('warning', title = 'Warning', (message.length > 0 ? message : 'Some error occured!'));
            return false;
        }
        setFormData(data);
        $("#modal-title h5").text("Edit Notification");
        $('#notification-modal').modal('show');
    }

    function createNotification(status, data, message) {
        if(!status) {
            ShowValidationErrorOnModal(data);
            return false;
        }
        $('#notification-modal').modal('hide');
        showAlert('success', title = 'Success', 'Notification Created Successfully..!');
        $('#DataGrid').dataTable().api().ajax.reload();
    }

    function updateNotification (status, data, message) {
        if(!status) {
            ShowValidationErrorOnModal(data);
            return false;
        }
        $('#notification-modal').modal('hide');
        showAlert('success', title = 'Success', 'Notification Updated Successfully..!');
        $('#DataGrid').dataTable().api().ajax.reload();
    }

    function resetFormData() {
        $('#notification_id').val('');
        $('#title').val('');
        $('#message').val('');
        $('input[type=checkbox]').prop('checked',false);

        // To reset form validations
        $('#notification-form').validate().resetForm();
    }

    function setFormData(data) {
        $('#notification_id').val(data.id);
        $('#title').val(data.title);
        $('#message').val(data.message);
        if(data.isActive == 1) {
            $('#isActive').prop("checked", true);
        }
    }

    function getFormData() {
        var data = { notification_id: $('#notification_id').val(), title: $('#title').val(), 
        message: $('#message').val(), isActive: $('#isActive').is(':checked') ? 1 : 0 }
        return data; 
    }

</script>
@endpush