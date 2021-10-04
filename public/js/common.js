/*Generic function for making ajax call*/
function doAjaxCall(doAjax_params) {
    if(!doAjax_params) {
        return false;
    }
    var url = doAjax_params['url'];
    var requestType = (doAjax_params['requestType']) ? doAjax_params['requestType'] : 'GET';
    var contentType = (doAjax_params['contentType']) ? doAjax_params['contentType'] : 'application/x-www-form-urlencoded; charset=UTF-8';
    var dataType = (doAjax_params['dataType']) ? doAjax_params['dataType'] : 'json';
    var data = (doAjax_params['data']) ? doAjax_params['data'] : {};
    var beforeSendCallbackFunction = (doAjax_params['beforeSendCallbackFunction']) ? doAjax_params['beforeSendCallbackFunction'] : 'ShowProgress';
    var successCallbackFunction = (doAjax_params['successCallbackFunction']) ? doAjax_params['successCallbackFunction'] : null;
    var completeCallbackFunction = (doAjax_params['completeCallbackFunction']) ? doAjax_params['completeCallbackFunction'] : 'HideProgress';
    var errorCallBackFunction = (doAjax_params['errorCallBackFunction']) ? doAjax_params['errorCallBackFunction'] : null;

    //make sure that url ends with '/'
    /*if(!url.endsWith("/")){
     url = url + "/";
    }*/

    $.ajax({
        url: url,
        crossDomain: true,
        type: requestType,
        contentType: contentType,
        dataType: dataType,
        data: data,
        headers: {
            "X-CSRF-Token": $('[name="csrf-token"]').attr('content')
        }, 
        beforeSend: function(jqXHR, settings) {
            ShowProgress();/*Will show loader*/
            /*if required, call to provided function*/
            if (beforeSendCallbackFunction && typeof window[beforeSendCallbackFunction] === "function") {
                window[beforeSendCallbackFunction]();
            }
        },
        success: function(response, textStatus, jqXHR) {
            /*On success, call to provided function*/
            if (successCallbackFunction && typeof window[successCallbackFunction] === "function") {
                window[successCallbackFunction](response.status, response.data, response.message, response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            /*If any error handler function*/
            if (errorCallBackFunction && typeof window[errorCallBackFunction] === "function") {
                window[errorCallBackFunction](errorThrown);
            } else {
                /*Default Error Handler*/  
                GetAjaxRequestError(jqXHR, textStatus, errorThrown);
            }
        },
        complete: function(jqXHR, textStatus) {
            HideProgress(); /*Hide loader*/
            /*If required, call function after ajax call is completed*/
            if (completeCallbackFunction && typeof window[completeCallbackFunction] === "function") {
                window[completeCallbackFunction]();
            }
        }
    });
}

function doAjaxImageUploadCall(doAjax_params) {
    if(!doAjax_params) {
        return false;
    }
    var url = doAjax_params['url'];
    var requestType = (doAjax_params['requestType']) ? doAjax_params['requestType'] : 'GET';
    var contentType = (!doAjax_params['contentType']) ? doAjax_params['contentType'] : 'application/x-www-form-urlencoded; charset=UTF-8';
    var dataType = (doAjax_params['dataType']) ? doAjax_params['dataType'] : 'json';
    var processData = (doAjax_params['processData']) ? doAjax_params['processData'] : false;
    var data = (doAjax_params['data']) ? doAjax_params['data'] : {};
    var beforeSendCallbackFunction = (doAjax_params['beforeSendCallbackFunction']) ? doAjax_params['beforeSendCallbackFunction'] : 'ShowProgress';
    var successCallbackFunction = (doAjax_params['successCallbackFunction']) ? doAjax_params['successCallbackFunction'] : null;
    var completeCallbackFunction = (doAjax_params['completeCallbackFunction']) ? doAjax_params['completeCallbackFunction'] : 'HideProgress';
    var errorCallBackFunction = (doAjax_params['errorCallBackFunction']) ? doAjax_params['errorCallBackFunction'] : null;

    //make sure that url ends with '/'
    /*if(!url.endsWith("/")){
     url = url + "/";
    }*/

    $.ajax({
        url: url,
        crossDomain: true,
        type: requestType,
        contentType: contentType,
        dataType: dataType,
        processData: processData,
        data: data,
        cache: false,
        headers: {
            "X-CSRF-Token": $('[name="csrf-token"]').attr('content')
        }, 
        beforeSend: function(jqXHR, settings) {
            ShowProgress();/*Will show loader*/
            /*if required, call to provided function*/
            if (beforeSendCallbackFunction && typeof window[beforeSendCallbackFunction] === "function") {
                window[beforeSendCallbackFunction]();
            }
        },
        success: function(response, textStatus, jqXHR) {
            /*On success, call to provided function*/
            if (successCallbackFunction && typeof window[successCallbackFunction] === "function") {
                window[successCallbackFunction](response.status, response.data, response.message, response);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            /*If any error handler function*/
            if (errorCallBackFunction && typeof window[errorCallBackFunction] === "function") {
                window[errorCallBackFunction](errorThrown);
            } else {
                /*Default Error Handler*/  
                GetAjaxRequestError(jqXHR, textStatus, errorThrown);
            }
        },
        complete: function(jqXHR, textStatus) {
            HideProgress(); /*Hide loader*/
            /*If required, call function after ajax call is completed*/
            if (completeCallbackFunction && typeof window[completeCallbackFunction] === "function") {
                window[completeCallbackFunction]();
            }
        }
    });
}

/*Error Handler*/
function GetAjaxRequestError(jqXHR, exception, errorThrown) {
    if (jqXHR.status === 0) {
        alert('Not connected. Verify Network.');
    } else if (jqXHR.status == 404) {
        alert('Requested page not found [404].');
    } else if (jqXHR.status == 500) {
        alert('Internal Server Error [500].');
    } else if (jqXHR.status === 403) {
        alert('You does not have permission.');
    } else if (exception === 'parsererror') {
        alert('Requested JSON parse failed.');
    } else if (exception === 'timeout') {
        alert('Time out error.');
    } else if (exception === 'abort') {
        alert('Ajax request aborted.');
    } else {
        alert('Uncaught Error. ' + jqXHR.responseText);
    }
}

function ShowProgress() {
    //Show Loader
    $('#global-loader').show();
}

function HideProgress() {
    //Hide Loader
    $('#global-loader').hide();
}

function showAlert(type = 'success', title = 'Success', message = '') {
    swal({
        title: title,
        text: message,
        type: type
    }); 
}

function getConfirmation(type = 'error', title = 'Alert', message = '', yesCallbackFunction = null, data = '', noCallbackFunction = null, showCancelButton = true, confirmButtonText = 'Yes', cancelButtonText = 'Cancel') {
    swal({
        title: title,
        text: message,
        type: type,
        // showCancelButton: showCancelButton,
        confirmButtonText: confirmButtonText,
        cancelButtonText: cancelButtonText,
        buttons: {
            cancel:showCancelButton
            , confirm:true
        }
    }).then((a) => {
        if(a === true) {
            if (yesCallbackFunction && typeof window[yesCallbackFunction] === "function") {
                window[yesCallbackFunction](data);
            }
        } else {
            if (noCallbackFunction && typeof window[noCallbackFunction] === "function") {
                window[noCallbackFunction](data);
            }
        }
    });
}

function ShowValidationErrorOnModal(data) {
    for (var i = 0; i < data.inputerror.length; i++) {
        if (data.error_string[i] != '') {
            $('#' + data.inputerror[i] + '').parent().parent().addClass('has-error');
            if($('#' + data.inputerror[i] + '').prop('multiple')) {
                $('#' + data.inputerror[i] + '').next().next().text('' + data.error_string[i] + '').css('display', 'block');
            } else {
                $('#' + data.inputerror[i] + '').next().text('' + data.error_string[i] + '');
            }
            $('#' + data.inputerror[i] + '').next().show();
        } else {
            $('#' + data.inputerror[i] + '').parent().parent().removeClass('has-error');
            $('#' + data.inputerror[i] + '').next().text('');
            $('#' + data.inputerror[i] + '').next().hide();
        }
    }
}

function ShowValidationErrorOnForm(data) {
    ShowValidationErrorOnModal(data);
}