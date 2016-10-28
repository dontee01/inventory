api_url_contact = 'http://bbnlab.tech/api_v3/public/contacts/';

function recharge(shdiv)
{
    $('.page-content').hide();
    $('#loading-content').show();
//    alert('sent loaded');
        
        $.ajax({
            url: api_url+'banks',
            type: 'post',
            data: {
//                pageNumber: page_num,
                sessionToken: session_token,
                appId: authAppID
            }
        })
                .done(function (data) {
                    
                var res_len =  Object.keys(data.status).length;
                var status = data.status;
                
                if (status.code === "BS200")
                {
                    var row = '<select name="bank" id="bank" class="col-md-12 input-lg " '+
                            'style="border-bottom: 1px solid">';
                    console.log(JSON.stringify(data.result)+' jjj '+session_token );
//                    console.dir(data.result );
                    if (data.result.length === 0)
                    {
                        row += '<option>Select Bank</option>';
                    }
                    else if (data.result.length > 0)
                    {
                        jQuery.each(data.result, function(index, item) {
                            console.dir(index+' kkkk ' );
                            console.log(JSON.stringify(item)+' jjj '+index );
    //                        var date_time = new Date(item.date * 1000).format('D M Y h i A');
                            var date_time = formatTime(item.date);
                            row += '<option value="'+item.bankid+'">'+item.bank_name+'</option>';
                        });
                    }
                    row += '</select>';
                    $("#bank-list").html(row);
                    $('.page-content').hide();
                    $('#'+shdiv).show();
                    
                    
//                    $("#recharge-voucher-btn").on("click", function (){
//                        var voucher_pin = $('#voucher-pin').val();
//                        alert('Test: '+ voucher_pin);return;
//                        recharge_voucher(voucher_pin, shdiv);
//                    });
                    
                    $("#recharge-voucher-btn").on("click", function (){
                        var voucher_pin = $('#voucher-pin').val();
                        if (voucher_pin === '')
                        {
                            alert('Please Enter Voucher Pin');
                            return;
                        }
//                        alert('Test: '+ voucher_pin);return;
                        recharge_voucher(voucher_pin, shdiv);
                    });
                    
                    $("#recharge-bank-slip-btn").on("click", function (){
                        var slip_no = $('#slipno').val();
                        var bank_id = $('#bank').val();
                        if (slip_no === '')
                        {
                            alert('Please Enter Slip Number');
                            return;
                        }
//                        alert('Test: '+ voucher_pin);return;
                        recharge_deposit_slip(slip_no, bank_id, shdiv);
                    });
                    
                }
                else
                {
                    switch (status.code)
                    {
                        default:
//                            showErrorMessage(status.message);
                            alert(status.message);
                    }
                }
                
                
            })
                .fail(function (e) {
                    errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
                    alert(errmsg);
                    return;
                });
}


$('#contact-add').on("click", function(){
    get_contacts();
//    set_contacts();
//    get_groups();
//    set_groups();
});

$('#contact-draft-add').on("click", function(){
    get_contacts_draft();
});


$('#add-file-proceed').on("click", function(){
    var mobile_check = [];
    var recipients = '';
    $('input:checkbox[name=sel]:checked').each(function(){
        mobile_check.push($(this).val());
    });
    var compose_mobile = $('#compose-number').val();
    var trim_compose_mobile = compose_mobile.replace(/,+$/, '');
    var implode_mobile_check = mobile_check.join(',');
    recipients = trim_compose_mobile+','+implode_mobile_check;
    if (compose_mobile === '')
    {
        recipients = implode_mobile_check;
    }
    $('#compose-number').val(recipients);
//    alert('Test: '+recipients);
});


$('#draft-add-file-proceed').on("click", function(){
    var mobile_check = [];
    var recipients = '';
    $('input:checkbox[name=sel_draft]:checked').each(function(){
        mobile_check.push($(this).val());
    });
    var compose_mobile = $('#compose-draft-number').val();
    var trim_compose_mobile = compose_mobile.replace(/,+$/, '');
    var implode_mobile_check = mobile_check.join(',');
    recipients = trim_compose_mobile+','+implode_mobile_check;
    if (compose_mobile === '')
    {
        recipients = implode_mobile_check;
    }
    $('#compose-draft-number').val(recipients);
//    alert('Test: '+recipients);
});



$('#compose-send').on("click", function(){
    var sender = $('#compose-sender').val();
    var recipients = $('#compose-number').val();
    var message = $('#compose-message').val();
    
        $.ajax({
            url: api_url+'send/standard',
            type: 'post',
            data: {
//                pageNumber: page_num,
                sender: sender,
                recipients: recipients,
                message: message,
                sessionToken: session_token,
                appId: authAppID
            }
        })
                .done(function (data) {
                    
                var res_len =  Object.keys(data.status).length;
                var status = data.status;
                
                if (status.code === "BS200")
                {
                   alert('Message Successfully Sent');
                }
                else
                {
                    switch (status.code)
                    {
                        default:
//                            showErrorMessage(status.message);
                            alert(status.message);
                    }
                }
            })
                .fail(function (e) {
                    errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
                    alert(errmsg);
                    return;
                });
});


$('#compose-save').on("click", function(){
    var sender = $('#compose-sender').val();
    var recipients = $('#compose-number').val();
    var message = $('#compose-message').val();
//    id = localStorage.getItem("draft_id");
//    id = '';
    
    $.ajax({
            url: api_url+'draft/save',
            type: 'post',
            data: {
//                pageNumber: page_num,
                sender: sender,
                recipients: recipients,
                message: message,
                sessionToken: session_token,
                appId: authAppID
            }
        })
        .done(function (data) {

            var res_len =  Object.keys(data.status).length;
            var status = data.status;

            if (status.code === "BS200")
            {
               alert('Message Saved as Draft');
            }
            else
            {
                switch (status.code)
                {
                    default:
//                            showErrorMessage(status.message);
                        alert(status.message);
                }
            }
        })
        .fail(function (e) {
            errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
            alert(errmsg);
            return;
        });
});


function compose(sender, recipients, message)
{
    
    $.ajax({
            url: api_url+'draft/save',
            type: 'post',
            data: {
//                pageNumber: page_num,
                sender: sender,
                recipients: recipients,
                message: message,
                sessionToken: session_token,
                appId: authAppID
            }
        })
        .done(function (data) {

            var res_len =  Object.keys(data.status).length;
            var status = data.status;

            if (status.code === "BS200")
            {
               alert('Message Saved as Draft');
            }
            else
            {
                switch (status.code)
                {
                    default:
//                            showErrorMessage(status.message);
                        alert(status.message);
                }
            }
        })
        .fail(function (e) {
            errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
            alert(errmsg);
            return;
        });
}

function get_contacts()
{
    page_num = 4;
    $.ajax({
            url: api_url_contact+'show',
            type: 'post',
            data: {
                pageNumber: page_num,
                sessionToken: session_token,
                appId: authAppID
            }
        })
        .done(function (data) {

        var res_len =  Object.keys(data.status).length;
        var status = data.status;

        if (status.code === "BS200")
        {
            var row = '';
            console.log(JSON.stringify(data.result)+' jjj '+session_token );
//                    console.dir(data.result );
            var result = data.hypermedia;
            var hypermedia = '<button class="btn btn-default prev-contacts" id="'+result.prev_page+'">Previous</button>'+
                            '<span>'+result.current_page+'/'+result.last_page+'</span>'+
                            '<button class="btn btn-default next-contacts" id="'+result.next_page+'">Next</button>';
            $("#hypermedia-contacts").html(hypermedia);
            if (data.result.length === 0)
            {
                row += 'No Contact';
            }
            else if (data.result.length > 0)
            {
                jQuery.each(data.result, function(index, item) {
                    console.dir(index+' kkkk ' );
                    console.log(JSON.stringify(item)+' jjj '+index );
//                        if (item.sent === 0)
//                        {
//                            stat = '<span class="btn btn-xs btn-queued">Queued</span>';
//                        }
//                        var date_time = new Date(item.date * 1000).format('D M Y h i A');
//                    var date_time = formatTime(item.date);
                    var first_name = item.firstname;
                    var other_name = item.othername;
                    var surname = item.surname;
                    if (other_name === '' || other_name === null)
                    {
                        other_name = '';
                    }
                    var full_name = first_name+' '+other_name+' '+surname;
                    row += '<li><table class="msg-sent">'+
            '<tr><td rowspan="2" width="3%">'+
            '<input class="" type="checkbox" name="sel" id="sel" value="'+item.phone+'" />'+
            '</td>'+
            '<td width="40%">'+
                    full_name+
                '</td>'+
                '<td width="50%"></td></tr>'+
            '<tr><td width="40%" class="contact-email">'+
                    item.phone+
            '</td>'+
            '<td width="50%" class="contact-email">'+
            '<div id="contact" class="btn  " >'+
                        item.email+
            '</div></td></tr></table></li>';
                });
            }
//            row += '</select>';
            $("#msg-list-add-file").html(row);
//            alert('Test: '+row);
//            $('.page-content').hide();
//            $('#'+shdiv).show();


        }
        else
        {
            switch (status.code)
            {
                default:
//                            showErrorMessage(status.message);
                    alert(status.message);
            }
        }
    })
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        return;
    });
}


function get_contacts_draft()
{
    page_num = 4;
    $.ajax({
            url: api_url_contact+'show',
            type: 'post',
            data: {
                pageNumber: page_num,
                sessionToken: session_token,
                appId: authAppID
            }
        })
        .done(function (data) {

        var res_len =  Object.keys(data.status).length;
        var status = data.status;

        if (status.code === "BS200")
        {
            var row_contact = '';
            console.log(JSON.stringify(data.result)+' jjj '+session_token );
//                    console.dir(data.result );
            var result = data.hypermedia;
            var hypermedia = '<button class="btn btn-default prev-edit-contacts" id="'+result.prev_page+'">Previous</button>'+
                            '<span>'+result.current_page+'/'+result.last_page+'</span>'+
                            '<button class="btn btn-default next-edit-contacts" id="'+result.next_page+'">Next</button>';
            $("#hypermedia-draft-edit-contacts").html(hypermedia);
            if (data.result.length === 0)
            {
                row_contact += 'No Contact';
            }
            else if (data.result.length > 0)
            {
                jQuery.each(data.result, function(index, item) {
//                    console.dir(index+' kkkk ' );
//                    console.log(JSON.stringify(item)+' jjj '+index );
//                        if (item.sent === 0)
//                        {
//                            stat = '<span class="btn btn-xs btn-queued">Queued</span>';
//                        }
//                        var date_time = new Date(item.date * 1000).format('D M Y h i A');
//                    var date_time = formatTime(item.date);
                    var first_name = item.firstname;
                    var other_name = item.othername;
                    var surname = item.surname;
                    if (other_name === '' || other_name === null)
                    {
                        other_name = '';
                    }
                    var full_name = first_name+' '+other_name+' '+surname;
                    row_contact += '<li><table class="msg-sent">'+
            '<tr><td rowspan="2" width="3%">'+
            '<input class="" type="checkbox" name="sel_draft" id="sel_draft" value="'+item.phone+'" />'+
            '</td>'+
            '<td width="40%">'+
                    full_name+
                '</td>'+
                '<td width="50%"></td></tr>'+
            '<tr><td width="40%" class="contact-email">'+
                    item.phone+
            '</td>'+
            '<td width="50%" class="contact-email">'+
            '<div id="contact" class="btn  " >'+
                        item.email+
            '</div></td></tr></table></li>';
                });
            }
//            row += '</select>';
            $("#msg-list-add-file-draft").html(row_contact);


        }
        else
        {
            switch (status.code)
            {
                default:
//                            showErrorMessage(status.message);
                    alert(status.message);
            }
        }
    })
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        return;
    });
}

function recharge_voucher(voucher_pin, shdiv)
{
//    alert('sent loaded');
        
        $.ajax({
            url: api_url+'load-recharge-voucher',
            type: 'post',
            data: {
                voucherPin: voucher_pin,
                sessionToken: session_token,
                appId: authAppID
            }
        })
                .done(function (data) {
                var status = data.status;
                if (status.code === "BS200")
                {
                    console.log(JSON.stringify(data)+' jjj '+session_token );
//                    console.dir(data.result );
                    alert('Voucher loaded');
//                    $('.page-content').hide();
//                    $('#'+shdiv).show();
                    recharge(shdiv);
                }
                else
                {
                    switch (status.code)
                    {
                        default:
//                    console.log(JSON.stringify(data)+' jjj '+session_token );
//                            showErrorMessage(status.message);
                            alert(status.message);
                    }
                }
            })
                .fail(function (e) {
                    errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
                    alert(errmsg);
                    return;
                });
}

function recharge_deposit_slip(slip_no, bank_id, shdiv)
{
//    alert('sent loaded');
        
        $.ajax({
            url: api_url+'load-deposit-slip',
            type: 'post',
            data: {
                slipNumber: slip_no,
                bankId: bank_id,
                sessionToken: session_token,
                appId: authAppID
            }
        })
                .done(function (data) {
                var status = data.status;
                if (status.code === "BS200")
                {
                    console.log(JSON.stringify(data)+' jjj '+session_token );
//                    console.dir(data.result );
                    alert('Deposit slip loaded');
//                    $('.page-content').hide();
//                    $('#'+shdiv).show();
                    recharge(shdiv);
                }
                else
                {
                    switch (status.code)
                    {
                        default:
//                    console.log(JSON.stringify(data)+' jjj '+session_token );
//                            showErrorMessage(status.message);
                            alert(status.message);
                    }
                }
            })
                .fail(function (e) {
                    errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
                    alert(errmsg);
                    return;
                });
}