session_token = localStorage.getItem("sync_session_token");
//session_token = "318d7dd03c166c413LdcCXDBWFLTDBpB";
connectionStarted = 0;
connectionOff = 0;
loginBlocked = 0; //Set to 1 when user is not allowed to login
maxLoginAttempts = 10;
blockDuration = 300000; //Time to wait before retry in milliseconds
loginAttempts = 0;
loginWaitDurationMinutes = Math.ceil(blockDuration / (1000 * 60));
errorMessageActive = 0;
username = null;
mobileNo = null;
errorTimeout = null;
balance = '';
email = '';
authAppID = 50;
api_url = 'http://bbnlab.tech/api_v3/public/message/';
account_url = 'http://bbnlab.tech/api_v3/public/accounts/';


$("document").ready(function () {
//    alert('loaded');
    if (! localStorage.getItem('sync_session_token'))
    {
        localStorage.removeItem("sync_session_token");
        window.location.assign("http://bbnlab.tech/accounts");
    }
    
        get_balance();
//        dashboard();
    home('home-content');
    
    function home(shdiv)
    {
        dashboard();
        get_balance();
        $(".p-content").css("visibility", "visible");
        $('#loading-content').show();
        get_notifications();
        $('.page-content').hide();
        $('#home-content').show();
//        alert('Test: '+balance);
        $('#balance-home').html(localStorage.balance+' credits');
        
        $('#dashboard-sent').html(localStorage.sent_total);
        $('#dashboard-drafts').html(localStorage.drafts_total);
        $('#dashboard-schedules').html(localStorage.schedules_total);
        $('#dashboard-contacts').html(localStorage.contacts_total);
        $('#dashboard-groups').html(localStorage.groups_total);
        
        $('#dashboard-total-undelivered-status').html(localStorage.undelivered_status_total);
        $('#dashboard-total-delivered-status').html(localStorage.delivered_status_total);
        $('#dashboard-total-pending-status').html(localStorage.pending_status_total);
//        alert('Test: '+localStorage.sent_total);
        $('#profile-email').html(localStorage.email);
        $('#profile-fullname').html(localStorage.fullname);
        $('#profile-mobile').html(localStorage.mobile);
    }
//localStorage.clear();
    
    $(".nav-load li a").on("click", function (){
//            $("#nav ul li a").on("click", function (){
            var lnk = $(this).attr("id");
            var shdiv = lnk+"-content";
            var page_num = '';
            
            switch (lnk)
            {
                case 'home':
                    home(shdiv);
                    break;
                case 'sent':
//                    $('.page-content').hide();
//                    $('#loading-content').show();
                    sent(page_num, shdiv);
//                    $('#loading-content').hide();
                    break;
                case 'drafts':
                    drafts(page_num, shdiv);
                    break;
                case 'schedules':
                    schedules(page_num, shdiv);
                    break;
                case 'notifications':
                    notifications(page_num, shdiv);
                    break;
                case 'groups':
                    groups(shdiv);
                    break;
                case 'manage-group':
                    manage_group(shdiv);
                    break;
                case 'manage-contacts':
                    manage_contacts(shdiv);
                    break;
                case 'recharge':
                    recharge(shdiv);
                    break;
                case 'share-credit':
                    share_credit(shdiv);
                    break;
                case 'settings':
                    settings(shdiv);
                    break;
                case 'logout':
                    logout();
                    break;
                    
                default:
                    alert('default');
            }
            
//            $('.page-content').hide();
//            $('#'+shdiv).show();
    });
    
    $('#home').on("click", function(){
        home('home-content');
    });
    
    $('#sent-dash').on("click", function(){
        sent('', 'sent-content');
    });
    
    $('#drafts-dash').on("click", function(){
        drafts('', 'drafts-content');
    });
    
    $('#schedules-dash').on("click", function(){
        schedules('', 'schedules-content');
    });
    
    $('#contacts-dash').on("click", function(){
        manage_contacts('manage-contacts-content');
    });
    
    $('#groups-dash').on("click", function(){
        groups('groups-content');
    });
    
    $('#logout').on("click", function(){
        logout();
    });



                                   

$(document).on("click", '.next-sent', function(){
    var p_num = $(this).attr('id');
    var shdiv = 'sent-content';
//    alert('Test: '+ shdiv);return;
    sent(p_num, shdiv);
});

$(document).on("click", '.prev-sent', function(){
    var p_num = $(this).attr('id');
    var shdiv = 'sent-content';
    sent(p_num, shdiv);
});


                    $(document).on("click", ".delete-sent", function (){
            
                        var id = $(this).attr("id");
                        set_delete_sent(id);
//                        alert('testing '+id);
            //            alert(localStorage.getItem('draft_id'));
                        console.dir(localStorage.getItem("sent_id")+ 'jhklsdj');
                    });
                    
                    $(document).on("click", "#delete-sent-confirm", function (){
            
                        var id = localStorage.getItem("sent_id");
//                        alert('jkdsf '+id);
//                        set_delete_draft(id);
                        delete_sent(id, 'sent-content');
                    });
        
//        DELETE DRAFTS
        
                    $(document).on("click", ".edit-draft", function (){
            
                        var id = $(this).attr("id");
                        set_edit_draft(id);
//                        alert(id);
                    });
                    
                    $(document).on("click", ".delete-draft", function (){
            
                        var id = $(this).attr("id");
                        set_delete_draft(id);
//                        alert('testing '+id);
            //            alert(localStorage.getItem('draft_id'));
                        console.dir(localStorage.getItem("draft_id")+ ' jhklsdj');
                    });
                    
                    $(document).on("click", "#delete-draft-confirm", function (){
            
                        var id = localStorage.getItem("draft_id");
//                        alert('jkdsf '+id);
//                        set_delete_draft(id);
                        delete_draft(id, 'drafts-content');
                    });

                    
                    $(document).on("click", "#compose-draft-save", function (){
                        var id = localStorage.getItem("draft_id");
//                        alert('Get: '+ id);
                        save_draft(id, 'drafts-content');
//                        set_delete_draft(id);
                    });
                    
                    $(document).on("click", "#compose-draft-send", function (){
//                        var id = localStorage.getItem("draft_id");
//                        alert('Get: '+ id);
                        send_draft('drafts-content');
//                        set_delete_draft(id);
                    });
                    
//                    DELETE NOTIFICATIONS
                    
                    $(document).on("click", ".delete-notification", function (){
            
                        var id = $(this).attr("id");
                        set_delete_notification(id);
//                        alert('testing '+id);
            //            alert(localStorage.getItem('draft_id'));
                        console.dir(localStorage.getItem("notification_id")+ ' test notification');
                    });
                    
                    $(document).on("click", "#delete-notification-confirm", function (){
            
                        var id = localStorage.getItem("notification_id");
//                        alert('jkdsf '+id);
//                        set_delete_draft(id);
                        delete_notification(id, 'notifications-content');
                    });
                    
//                    DELETE SCHEDULES
                             
                    $(document).on("click", ".edit-schedule", function (){
            
                        var id = $(this).attr("id");
                        set_edit_schedule(id);
//                        alert(id);
                    });
                    
                    $(document).on("click", "#schedule-save", function (){
                        var id = localStorage.getItem("schedule_id");
//                        alert('Get: '+ id);
                        save_schedule(id, 'schedules-content');
//                        set_delete_draft(id);
                    });
                    
                    
                    $(document).on("click", ".delete-schedule", function (){
                        var id = $(this).attr("id");
                        set_delete_schedule(id);
//                        alert('testing '+id);
            //            alert(localStorage.getItem('draft_id'));
                        console.dir(localStorage.getItem("schedule_id")+ ' test schedule');
                    });
                    
                    $(document).on("click", "#delete-schedule-confirm", function (){
                        var id = localStorage.getItem("schedule_id");
//                        alert('jkdsf '+id);
//                        set_delete_draft(id);
                        delete_schedule(id, 'schedules-content');
                    });
                       
        
//////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////FUNCTIONS FOR////////////////////////////////////////////////
                ////////////////////////////LOADING//////////////////////////////////
        ///////////////////////////////////////////PAGES///////////////////////////////////


function sent(page_num, shdiv)
{
//    alert('sent loaded');
//        page_num = 4;
        
    $('.page-content').hide();
    $('#loading-content').show();
    localStorage.removeItem("sent_id");
        $.ajax({
            url: api_url+'sent',
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
                    var result = data.hypermedia;
                    console.log(JSON.stringify(data.result)+' jjj '+session_token );
//                    console.dir(data.result );
                    var hypermedia = '<button class="btn btn-default prev-sent" id="'+result.prev_page+'">Previous</button>'+
                                    '<span>'+result.current_page+'/'+result.last_page+'</span>'+
                                    '<button class="btn btn-default next-sent" id="'+result.next_page+'">Next</button>';
                    $("#hypermedia-sent").html(hypermedia);
//                    alert('Test: '+hypermedia);return;
                    console.dir('Test: '+hypermedia );
                    if (data.result.length === 0)
                    {
                        row = '<li class="sent-item">You have no sent items</li>';
                    }
                    else if (data.result.length > 0)
                    {
                        jQuery.each(data.result, function(index, item) {
                            console.dir(index+' kkkk ' );
                            console.log(JSON.stringify(item)+' jjj '+index );
                            var stat = '<span class="btn btn-xs btn-danger">Sent</span>';
                            if (item.sent === 0)
                            {
                                stat = '<span class="btn btn-xs btn-queued">Queued</span>';
                            }
    //                        var date_time = new Date(item.date * 1000).format('D M Y h i A');
                            var date_time = formatTime(item.date);
                            row += '<li class="sent-item"><table class=" msg-sent"><tr class="bt">'+
              '<td width="55%" class="uname text-left">'+item.sender+'</td><td width="40%" class="bt text-right">'+
                stat+
              '</td><td rowspan="3" width="5%" class="text-center">'+
                  '<span class="contact-action">'+
                    '<div class="btn-group"><input type="hidden" id="sentId'+index+'" value="'+item.sendid+'">'+
                    '<i class="material-icons dropdown-toggle"  data-toggle="dropdown" >more_vertical</i>'+
                    '<ul class="dropdown-menu"><li><a class="delete-sent" style="color:#ff2500" id="'+
                    index+'" href="#delete-sent" data-toggle="modal" data-target="#deleteSentModal">Delete</a></li>'+
                        '</ul></div>'+
                  '</span></td></tr>'+
            '<tr><td colspan="2" width="95%" class="cont text-left">'+
            item.message+
            '</td></tr>'+
            '<tr><td colspan="2" width="95%" class="time text-right">'+
                '<span class="credit-header-label">&nbsp;'+
                        date_time+
                '</span></td></tr></table></li>';

                        });
                    }
                    
                        $("#msg-list-sent-content").html(row);
                    $('.page-content').hide();
                    $('#'+shdiv).show();
                    
                    
                    
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

function drafts(page_num, shdiv)
{
    $('.page-content').hide();
    $('#loading-content').show();
    localStorage.removeItem("draft_id");
//    alert('sent loaded');
        
        $.ajax({
            pageNumber: page_num,
            url: api_url+'drafts',
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
                    var stat = '<span class="btn btn-xs btn-queued">Queued</span>';
                    var row = '';
                    
                    var result = data.hypermedia;
                    var hypermedia = '<button class="btn btn-default prev-drafts" id="'+result.prev_page+'">Previous</button>'+
                                    '<span>'+result.current_page+'/'+result.last_page+'</span>'+
                                    '<button class="btn btn-default next-drafts" id="'+result.next_page+'">Next</button>';
                    $("#hypermedia-drafts").html(hypermedia);
//                    console.log(JSON.stringify(data.result)+' jjj '+session_token );
//                    console.dir(data.result );
                    if (data.result.length === 0)
                    {
                        row = '<li class="sent-item">You have no draft</li>';
                    }
                    else if (data.result.length > 0)
                    {
                    console.log(JSON.stringify(data.result)+' jjj '+session_token );
                        jQuery.each(data.result, function(index, item) {
                            
                            console.dir(index+' kkkk ' );
                            console.log(JSON.stringify(item)+' jjj '+index );
    //                        if (item.sent === 0)
    //                        {
    //                            stat = '<span class="btn btn-xs btn-queued">Queued</span>';
    //                        }
    //                        var date_time = new Date(item.date * 1000).format('D M Y h i A');
                            var date_time = formatTime(item.date);
                            row += '<li class="sent-item"><table class=" msg-sent"><tr class="bt">'+
              '<td width="55%" class="uname text-left" id="sender'+index+'">'+item.sender+'</td><td width="40%" class="bt text-right">'+
                stat+
              '</td><td rowspan="3" width="5%" class="text-center">'+
                  '<span class="contact-action">'+
                    '<div class="btn-group"><input type="hidden" id="draftId'+index+'" value="'+item.draftid+'">'+
                    '<input type="hidden" id="recipients'+index+'" value="'+item.recipients+'">'+
                    '<i class="material-icons dropdown-toggle"  data-toggle="dropdown" >more_vertical</i>'+
                    '<ul class="dropdown-menu">'+
                    '<li><a class="edit-draft" id="'+index+'" href="#edit-draft" data-toggle="modal" data-target="#editDraftModal">Edit</a></li>'+
                    '<li><a class="delete-draft" style="color:#ff2500" id="'+index+'" href="#delete-draft" data-toggle="modal" data-target="#deleteModal">Delete</a></li>'+
                        '</ul></div>'+
                  '</span></td></tr>'+
            '<tr><td colspan="2" width="95%" class="cont text-left" id="message'+index+'">'+
            item.message+
            '</td></tr>'+
            '<tr><td colspan="2" width="95%" class="time text-right">'+
                '<span class="credit-header-label">&nbsp;'+
                        date_time+
                '</span></td></tr></table></li>';

                        });
                    }
                        $("#msg-list-drafts-content").html(row);
                    $('.page-content').hide();
                    $('#'+shdiv).show();
                    
                    
                                   

$(document).on("click", '.next-drafts', function(){
    var p_num = $(this).attr('id');
    var shdiv = 'drafts-content';
//    alert('Test: '+ shdiv);return;
    drafts(p_num, shdiv);
});

$(document).on("click", '.prev-drafts', function(){
    var p_num = $(this).attr('id');
    var shdiv = 'drafts-content';
    drafts(p_num, shdiv);
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

function notifications(page_num, shdiv)
{
    $('.page-content').hide();
    $('#loading-content').show();
//    alert('sent loaded');
        $.ajax({
            url: api_url+'notifications',
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
                    var stat = '<span class="btn btn-xs btn-danger">Unread</span>';
                    var row = '';
                    console.log(JSON.stringify(data.result)+' jjj '+session_token );
//                    console.dir(data.result );
                    var result = data.hypermedia;
                    var hypermedia = '<button class="btn btn-default prev-notif" id="'+result.prev_page+'">Previous</button>'+
                                    '<span>'+result.current_page+'/'+result.last_page+'</span>'+
                                    '<button class="btn btn-default next-notif" id="'+result.next_page+'">Next</button>';
                    $("#hypermedia-notif").html(hypermedia);
                    console.log(JSON.stringify(data.result)+' jjj '+session_token );
//                    console.dir(data.result );
                    if (data.result.length === 0)
                    {
                        row = '<li class="sent-item">You have no notification</li>';
                    }
                    else if (data.result.length > 0)
                    {
                        jQuery.each(data.result, function(index, item) {
                            console.dir(index+' kkkk ' );
                            console.log(JSON.stringify(item)+' jjj '+index );
                            if (item.notif_viewed === 1)
                            {
                                stat = '<span class="btn btn-xs btn-queued">Read</span>';
                            }
    //                        var date_time = new Date(item.date * 1000).format('D M Y h i A');
                            var date_time = formatTime(item.notif_time);
                            row += '<li class="sent-item"><table class=" msg-sent"><tr class="bt">'+
              '<td width="55%" class="uname text-left">'+item.nt_name+'</td><td width="40%" class="bt text-right">'+
                stat+
              '</td><td rowspan="3" width="5%" class="text-center">'+
                  '<span class="contact-action">'+
                    '<div class="btn-group"><input type="hidden" id="notificationId'+index+'" value="'+item.notif_id+'">'+
                    '<i class="material-icons dropdown-toggle"  data-toggle="dropdown" >more_vertical</i>'+
                    '<ul class="dropdown-menu"><li><a class="delete-notification" style="color:#ff2500" id="'+index+'" href="#delete-notification" data-toggle="modal" data-target="#deleteNotificationModal">Delete</a></li>'+
                        '</ul></div>'+
                  '</span></td></tr>'+
            '<tr><td colspan="2" width="95%" class="cont text-left">'+
            item.notif_message+
            '</td></tr>'+
            '<tr><td colspan="2" width="95%" class="time text-right">'+
                '<span class="credit-header-label">&nbsp;'+
                        date_time+
                '</span></td></tr></table></li>';

                        });
                    }
                        $("#msg-list-notifications-content").html(row);
                    $('.page-content').hide();
                    $('#'+shdiv).show();
                    
                          

$('.next-notif').on("click", function(){
    var p_num = $(this).attr('id');
    var shdiv = 'notifications-content';
//    alert('Test: '+ shdiv);return;
    notifications(p_num, shdiv);
});

$('.prev-notif').on("click", function(){
    var p_num = $(this).attr('id');
    var shdiv = 'notifications-content';
    notifications(p_num, shdiv);
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

function schedules(page_num, shdiv)
{
    $('.page-content').hide();
    $('#loading-content').show();
//    alert('sent loaded');
        
        $.ajax({
            url: api_url+'schedules',
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
                    var stat = '<span class="btn btn-xs btn-queued">Queued</span>';
                    var row = '';
                    console.log(JSON.stringify(data.result)+' jjj '+session_token );
//                    console.dir(data.result );
                    var result = data.hypermedia;
                    var hypermedia = '<button class="btn btn-default prev-schedules" id="'+result.prev_page+'">Previous</button>'+
                                    '<span>'+result.current_page+'/'+result.last_page+'</span>'+
                                    '<button class="btn btn-default next-schedules" id="'+result.next_page+'">Next</button>';
                    $("#hypermedia-schedules").html(hypermedia);
                    console.log(JSON.stringify(data.result)+' jjj '+session_token );
//                    console.dir(data.result );
                    if (data.result.length === 0)
                    {
                        row = '<li class="sent-item">You have no schedules</li>';
                    }
                    else if (data.result.length > 0)
                    {
                        jQuery.each(data.result, function(index, item) {
                            console.dir(index+' kkkk ' );
                            console.log(JSON.stringify(item)+' jjj '+index );
                            if (item.sent === 0)
    //                        var date_time = new Date(item.date * 1000).format('D M Y h i A');
                            var date_time = formatTime(item.ms_sendtime);
                            row += '<li class="sent-item"><table class=" msg-sent"><tr class="bt">'+
              '<td width="55%" class="uname text-left">'+item.ms_sender+'</td><td width="40%" class="bt text-right">'+
                stat+
              '</td><td rowspan="3" width="5%" class="text-center">'+
                  '<span class="contact-action">'+
                    '<div class="btn-group"><input type="hidden" id="scheduleId'+index+'" value="'+item.ms_id+'">'+
                    '<input type="hidden" id="message'+index+'" value="'+item.ms_content+'">'+
                    '<input type="hidden" id="sender'+index+'" value="'+item.ms_sender+'">'+
                    '<input type="hidden" id="recipients'+index+'" value="'+item.ms_recipients+'">'+
                    '<input type="hidden" id="broadcast-time'+index+'" value="'+formatTime(item.ms_sendtime)+'">'+
                    '<input type="hidden" id="flash'+index+'" value="'+item.ms_flash+'">'+
                    '<i class="material-icons dropdown-toggle"  data-toggle="dropdown" >more_vertical</i>'+
                    '<ul class="dropdown-menu"><li><a class="edit-schedule" id="'+index+'" href="#edit-schedule" data-toggle="modal" data-target="#scheduleModal">Edit</a></li>'+
                    '<li><a class="delete-schedule" style="color:#ff2500" id="'+index+'" href="#delete-schedule" data-toggle="modal" data-target="#deleteScheduleModal">Delete</a></li>'+
                        '</ul></div>'+
                  '</span></td></tr>'+
            '<tr><td colspan="2" width="95%" class="cont text-left">'+
            item.ms_content+
            '</td></tr>'+
            '<tr><td colspan="2" width="95%" class="time text-right">'+
                '<span class="credit-header-label">&nbsp;'+
                        date_time+
                '</span></td></tr></table></li>';

                        });
                    }
                        $("#msg-list-schedules-content").html(row);
                    $('.page-content').hide();
                    $('#'+shdiv).show();
                    
                                

$('.next-schedules').on("click", function(){
    var p_num = $(this).attr('id');
    var shdiv = 'schedules-content';
//    alert('Test: '+ shdiv);return;
    schedules(p_num, shdiv);
});

$('.prev-schedules').on("click", function(){
    var p_num = $(this).attr('id');
    var shdiv = 'schedules-content';
    schedules(p_num, shdiv);
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


function logout()
{
    $('.page-content').hide();
    $('#loading-content').show();
    if (localStorage.getItem("sync_session_token"))
    {
        localStorage.removeItem("sync_session_token");
        window.location.assign("http://bbnlab.tech/accounts");
    }
}




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
            drafts('', shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    drafts('', shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        drafts('', shdiv);
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
            sent('', shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    console.log(status.message);
                    sent('', shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        sent('', shdiv);
//        return;
    });
}

function delete_schedule(id, shdiv)
{
    $('.page-content').hide();
    $('#loading-content').show();
    $.ajax({
    url: api_url+'schedule/delete',
    type: 'post',
    data: {
        scheduleId: id,
        sessionToken: session_token,
        appId: authAppID
    }
    })
    
    .done(function (data) {
        var status = data.status;

        if (status.code === "BS200")
        {
//            alert('Draft Deleted');
            schedules('', shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    schedules('', shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        schedules('', shdiv);
//        return;
    });
}

function delete_notification(id, shdiv)
{
    $('.page-content').hide();
    $('#loading-content').show();
    $.ajax({
    url: api_url+'notification/delete',
    type: 'post',
    data: {
        notificationId: id,
        sessionToken: session_token,
        appId: authAppID
    }
    })
    
    .done(function (data) {
        var status = data.status;

        if (status.code === "BS200")
        {
//            alert('Draft Deleted');
            notifications('', shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    notifications('', shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        notifications(shdiv);
//        return;
    });
}


function edit_draft(id, shdiv)
{
    
}

function send_draft(shdiv)
{
    var sender = $('#compose-draft-sender').val();
    var recipients = $('#compose-draft-number').val();
    var message = $('#compose-draft-message').val();
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
            drafts('', shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    drafts('', shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        drafts('', shdiv);
//        return;
    });
}

function save_draft(id, shdiv)
{
    var sender = $('#compose-draft-sender').val();
    var recipients = $('#compose-draft-number').val();
    var message = $('#compose-draft-message').val();
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
            drafts('', shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    drafts('', shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        drafts('', shdiv);
//        return;
    });
}

function save_schedule(id, shdiv)
{
    var flash_val = 0;
    var sender = $('#schedule-sender').val();
    var recipients = $('#schedule-number').val();
    var message = $('#schedule-message').val();
    var broadcast_time = $('#schedule-broadcast-time').val();
    var flash = $('#schedule-flash').prop("checked");
    if (flash === true)
    {
        flash_val = 1;
    }
    
//    $('#schedule-sender').val(sender);
//    $('#schedule-number').val(recipients);
//    $('#schedule-message').val(message);
//    $('#schedule-broadcast-time').val(broadcast_time);
//    $( "#schedule-flash" ).prop( "checked", true );
    
//    alert('Track: '+message+' s: '+sender+' r: '+recipients+' f: '+flash_val+' bc: '+broadcast_time);return;
    
    $('.page-content').hide();
    $('#loading-content').show();
    $.ajax({
    url: api_url+'schedule/create',
    type: 'post',
    data: {
        scheduleId: id,
        sender: sender,
        recipients: recipients,
        message: message,
        broadcastTime: broadcast_time,
        flash: flash_val,
        sessionToken: session_token,
        appId: authAppID
    }
    })
    
    .done(function (data) {
        var status = data.status;

        if (status.code === "BS200")
        {
//            alert('Draft Deleted');
            schedules('', shdiv);
        }
        else
        {
            switch (status.code)
            {
                default:
    //                            showErrorMessage(status.message);
                    alert(status.message);
                    schedules('', shdiv);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
        alert(errmsg);
        schedules('', shdiv);
//        return;
    });
}


function dashboard()
{
//    alert('Track: '+message+' s: '+sender+' r: '+recipients+' f: '+flash_val+' bc: '+broadcast_time);return;
    $.ajax({
    url: api_url+'dashboard',
    type: 'post',
    data: {
        sessionToken: session_token,
        appId: authAppID
    }
    })
    
    .done(function (data) {
        var status = data.status;

        if (status.code === "BS200")
        {
//            balance = data.result.unitBals;
            localStorage.setItem('sent_total', data.sent);
            localStorage.setItem('drafts_total', data.drafts);
            localStorage.setItem('schedules_total', data.schedules);
            localStorage.setItem('groups_total', data.groups);
            localStorage.setItem('contacts_total', data.contacts);
            localStorage.setItem('balance', data.balance);
            
            localStorage.undelivered_status_total =  data.undelivered_status;
            localStorage.delivered_status_total =  data.delivered_status;
            localStorage.pending_status_total =  data.pending_status;
            localStorage.sent_status_total =  data.sent_status;
//            profile
            var firstname = data.profile.firstname;
            var lastname = data.profile.lastname;
            var fullname = firstname+' '+lastname;
            localStorage.fullname = fullname;
            localStorage.email = data.profile.email;
            localStorage.mobile = data.profile.mobilephone;
            
//            $('#balance').html(balance+' credits');
//            $('.profile-address').html(email);
        }
        else
        {
            switch (status.code)
            {
                default: 
                var message = 'An Error occurred';
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
                var message = 'An Error occurred';
    });
}

function get_balance()
{
//    alert('Track: '+message+' s: '+sender+' r: '+recipients+' f: '+flash_val+' bc: '+broadcast_time);return;
    $.ajax({
    url: api_url+'balance',
    type: 'post',
    data: {
        sessionToken: session_token,
        appId: authAppID
    }
    })
    
    .done(function (data) {
        var status = data.status;

        if (status.code === "BS200")
        {
            balance = data.result.unitBals;
            localStorage.setItem('balance', balance);
            email = data.result.email;
            $('#balance').html(balance+' credits');
            $('.profile-address').html(email);
        }
        else
        {
            switch (status.code)
            {
                default: 
                var message = 'An Error occurred';
                $('.bal').html(message);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
                var message = 'An Error occurred';
                $('.bal').html(message);
    });
}

function get_notifications()
{
//    alert('Track: '+message+' s: '+sender+' r: '+recipients+' f: '+flash_val+' bc: '+broadcast_time);return;
    $.ajax({
    url: api_url+'notifications',
    type: 'post',
    data: {
        pageNumber: '',
        sessionToken: session_token,
        appId: authAppID
    }
    })
    
    .done(function (data) {
        var status = data.status;

        if (status.code === "BS200")
        {
            var notification_total = data.hypermedia.total;
//            var email = data.result.email;
            $('#notif-total').html(notification_total);
        }
        else
        {
            switch (status.code)
            {
                default: 
//                var message = 'An Error occurred';
//                $('.bal').html(balance);
            }
        }
    })
               
    .fail(function (e) {
        errmsg = "A communication error occurred. Please check your internet connection and Try again";
                var message = 'An Error occurred';
                $('.bal').html(message);
    });
}



function set_edit_draft(index)
{
    draftid = $("#draftId"+index).val();
    localStorage.setItem("draft_id", draftid);
    
    var sender = $('#sender'+index).html();
    var recipients = $('#recipients'+index).val();
    var message = $('#message'+index).html();
    
    $('#compose-draft-sender').val(sender);
    $('#compose-draft-number').val(recipients);
    $('#compose-draft-message').val(message);
}

function set_edit_schedule(index)
{
    scheduleid = $("#scheduleId"+index).val();
    localStorage.setItem("schedule_id", scheduleid);
    
    var sender = $('#sender'+index).val();
    var recipients = $('#recipients'+index).val();
    var message = $('#message'+index).val();
    var broadcast_time = $('#broadcast-time'+index).val();
    var flash = $('#flash'+index).val();
    
    $('#schedule-sender').val(sender);
    $('#schedule-number').val(recipients);
    $('#schedule-message').val(message);
    $('#schedule-broadcast-time').val(broadcast_time);
    $( "#schedule-flash" ).prop( "checked", true );
//    $('#schedule-flash').val(flash);
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

function set_delete_schedule(index)
{
    scheduleid = $("#scheduleId"+index).val();
    localStorage.setItem("schedule_id", scheduleid);
}

function set_delete_notification(index)
{
    notificationid = $("#notificationId"+index).val();
    localStorage.setItem("notification_id", notificationid);
}




    
    
    function formatTime(unixTimestamp) {
    var dt = new Date(unixTimestamp * 1000);
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    
    var year = dt.getYear();
    var month = months[dt.getMonth()];
    var day = dt.getDay();
    var hours = dt.getHours();
    var minutes = dt.getMinutes();
    var seconds = dt.getSeconds();

    // the above dt.get...() functions return a single digit
    // so I prepend the zero here when needed
    if (hours < 10) 
     hours = '0' + hours;

    if (minutes < 10) 
     minutes = '0' + minutes;

    if (seconds < 10) 
     seconds = '0' + seconds;

    return day+" "+month+" "+year+" "+ hours + ":" + minutes;
}  


//        $(".delete-draft").on("click", function (){
//            
//            var id = $(this).attr("id");
////            set_delete_draft(id);
//            alert('testing '+id);
////            alert(localStorage.getItem('draft_id'));
//            console.dir(localStorage.getItem("draft_id")+ 'jhklsdj');
//        });
    
});