$(document).ready(function() {

    var options = {
        success:       showResponse,  // target element(s) to be updated with server response
        beforeSubmit:  showRequest,
        dataType: 'json'
    };

    $('.form-ajax').submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $('.form-ajax').ajaxSubmit(options);
    });

    $('.form-ajax-change-language').submit(function (e) {
        e.preventDefault();
        $('.form-ajax-change-language').ajaxSubmit(options);
    });

    $('.form-ajax-change-password').submit(function (e) {
        e.preventDefault();
        $('.form-ajax-change-password').ajaxSubmit(options);
    });

    function showRequest(formData, jqForm, options) {
        //$('.form-ajax .btn-success').attr('disabled', true);
        var submitButton = $(jqForm).find('button[type=submit]');
        if (submitButton.length) {
            //submitButton.attr("last-caption", submitButton.text());
            startLoading(submitButton);
        }
        //alert(caption);
        //$('#placeholder-loading').show();
        return true;
    }

    function showResponse(responseText, statusText, xhr, $form)  {
        //($('.form-ajax .btn-success').attr('disabled', false);
        //$('#placeholder-loading').hide();
        var submitButton = $form.find('button[type=submit], b');
        if (submitButton.length)
            endLoading(submitButton);

        var pageTitle = $(document).find("#page-title").text();

        if(responseText.result == false) {
            //alert('nao foi');

            var msg = [];
            if (responseText.fields) {
                $(Object.keys(responseText.fields)).each(function (index, element) {
                    $("[name='" + element + "']").addClass('error-input');
                    msg.push(responseText.fields[element]);
                });
            } else {
                msg.push(responseText.messages);
            }

            if (msg.length) {
                alert_box(pageTitle, msg.join('<BR>'), 'OK');
                $('#msg-form-error').show();
                $('#msg-form-error').html(msg);
            } else {

                if(responseText.url == 'reload') {
                    alert_box(pageTitle, msg, 'OK', 'reload');
                } else {
                    alert_box(pageTitle, responseText.messages, 'OK', '');
                }

                $('.form-ajax .btn').show();
            }
        } else if (responseText.result == true) {
            if(responseText.hidedialog == true) {
                if(responseText.url == 'reload'){
                    location.reload();
                } else {
                    window.location = responseText.url;
                }
            } else{
                alert_box_redirect(pageTitle, responseText.messages, 'OK', responseText.url);
            }
        }
    }

    function alert_box(title, content, button1, url){
        $('#modal-alert .modal-title').text(title);
        $('#modal-alert .modal-body').html(content);
        $('#modal-alert .btn-success').html(button1);
        $('#modal-alert').modal('show');
        $('#modal-alert .btn-success').click(function(e){
            if(url == 'reload')
                location.reload();
            else
                $('#modal-alert').modal('hide');
        });
        setTimeout(function() {$('#modal-alert .modal-footer').find('.btn').focus();}, 300);
    }

    function alert_box_redirect(title, content, button1, url){
        $('#modal-alert .modal-title').text(title);
        $('#modal-alert .modal-body').html(content);
        $('#modal-alert .btn-success').html(button1);
        $('#modal-alert .btn-success').click(function(e){
            $('#modal-alert').modal('hide');
            if(url == 'reload')
                location.reload();
            else
                window.location = url;
        });
        $('#modal-alert').modal('show');
        setTimeout(function() {$('#modal-alert .modal-footer').find('.btn').focus();}, 300);
    }
});
