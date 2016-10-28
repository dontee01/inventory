
function delete_draft(id, shdiv)
{
    $('.page-content').hide();
    $('#loading-content').show();
    $.ajax({
    url: api_url+'drafts/delete',
    type: 'post',
    data: {
        draftId: id,
        sessionToken: session_token,
        appId: authAppID
    }
    })
    
    .done(function (data) {
        var status = data.status;

        if (status.code === "BS200")
        {
//            alert('Draft Deleted');
            drafts(shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    drafts(shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        drafts(shdiv);
//        return;
    });
}

function delete_sent(id, shdiv)
{
    $('.page-content').hide();
    $('#loading-content').show();
    $.ajax({
    url: api_url+'sent/delete',
    type: 'post',
    data: {
        messageId: id,
        sessionToken: session_token,
        appId: authAppID
    }
    })
    
    .done(function (data) {
        var status = data.status;

        if (status.code === "BS200")
        {
//            alert('Draft Deleted');
            sent(shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    sent(shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        sent(shdiv);
//        return;
    });
}

function edit_draft(id, shdiv)
{
    
}

function send_draft(shdiv)
{
    var sender = $('#compose-sender').val();
    var recipients = $('#compose-number').val();
    var message = $('#compose-message').val();
//    alert('Track: '+message+' s: '+sender);
    
    $('.page-content').hide();
    $('#loading-content').show();
    $.ajax({
    url: api_url+'send/standard',
    type: 'post',
    data: {
        sender: sender,
        recipients: recipients,
        message: message,
        sessionToken: session_token,
        appId: authAppID
    }
    })
    
    .done(function (data) {
        var status = data.status;

        if (status.code === "BS200")
        {
//            alert('Draft Deleted');
            drafts(shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    drafts(shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        drafts(shdiv);
//        return;
    });
}

function save_draft(id, shdiv)
{
    var sender = $('#compose-sender').val();
    var recipients = $('#compose-number').val();
    var message = $('#compose-message').val();
//    alert('Track: '+message+' s: '+sender);
    
    $('.page-content').hide();
    $('#loading-content').show();
    $.ajax({
    url: api_url+'draft/save',
    type: 'post',
    data: {
        draftId: id,
        sender: sender,
        recipients: recipients,
        message: message,
        sessionToken: session_token,
        appId: authAppID
    }
    })
    
    .done(function (data) {
        var status = data.status;

        if (status.code === "BS200")
        {
//            alert('Draft Deleted');
            drafts(shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    drafts(shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        drafts(shdiv);
//        return;
    });
}

function set_edit_draft(index)
{
    draftid = $("#draftId"+index).val();
    localStorage.setItem("draft_id", draftid);
    
    var sender = $('#sender'+index).html();
    var recipients = $('#recipients'+index).val();
    var message = $('#message'+index).html();
    
    $('#compose-sender').val(sender);
    $('#compose-number').val(recipients);
    $('#compose-message').val(message);
}

function set_delete_draft(index)
{
    draftid = $("#draftId"+index).val();
    localStorage.setItem("draft_id", draftid);
}

function set_delete_sent(index)
{
    sentid = $("#sentId"+index).val();
    localStorage.setItem("sent_id", sentid);
}
