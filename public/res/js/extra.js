url = 'http://www.bbnlab.tech/api_v3/public/contacts/group';
url1 = 'http://www.bbnlab.tech/api_v3/public/contacts/show';
groupName = '';
function groups(shdiv)
{
    $('.page-content').hide();
    $('#loading-content').show();
    page_num = 48;
    $.ajax({
        url: url + 's',
        type: 'post',
        data: {
            pageNumber: page_num,
            //groupId: 3,
            sessionToken: session_token,
            appId: authAppID
        }
    })
            .done(function (data) {

                var res_len = Object.keys(data.status).length;
                var status = data.status;
                if (status.code === "BS200")
                {
                    // var stat = '<span class="btn btn-xs btn-danger">Sent</span>';
                    var row = '';
                    console.log(JSON.stringify(data.result) + ' jjj ' + session_token);
//                    console.dir(data.result );
                    jQuery.each(data.result, function (index, item) {
                        console.dir(index + ' kkkk ');
                        console.log(JSON.stringify(item) + ' jjj ' + index);
                        if (item.sent === 0)
                        {
                            //stat = '<span class="btn btn-xs btn-queued">Queued</span>';
                        }
//                        var date_time = new Date(item.date * 1000).format('D M Y h i A');
                        var date_time = formatTime(item.created);
                        var groupDescription = item.groupDescription;
                        if (groupDescription == '' || groupDescription == null)
                        {
                            groupDescription = 'No descriptio found for this group';
                        }
                        row += '<li class="sent-item "><table class=" msg-sent"><tr class="bt"><td width="100%" colspan="2" class="uname text-left">' +
                                item.groupName + '</td></tr><tr class="bt"><td width="60%" class="cont bbn-text-left grp-sent-details" id="' + item.groupId + '">'
                                + groupDescription +
                                '</td><td class="group-bottom bbn-text-right"><input class="" type="checkbox" name="sel" id="sel" /></td></tr><tr class=""><td class="group-bottom">' +
                                'Contacts &nbsp;' + '<span class="dash-foot-exec">' + item.contact_count + '</span></td><td class="group-bottom bbn-text-right"><!--<span class="exec">-->' +
                                '<span class="dash-foot-exec">' + date_time + '</span><!--</span>--></td></tr></table></li>';
                    });
                    $(".grp-list").html(row);
                    $('.page-content').hide();
                    $('#' + shdiv).show();
                    $('.grp-sent-details').on("click", function () {
                        var groupid = $(this).attr('id');
//                        alert('Testing :' + groupid);
//                        return;
                        var shdiv = 'manage-group-content';
                        manage_group(groupid, shdiv);
                    });
                } else
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
    $('.page-content').hide();
    $('#' + shdiv).show();
    $('#create-group').on("click", function () {
        save_group(shdiv);
    });

    $('#select-all-grps').click(function () {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function () {
                this.checked = true;
            });

            $('#delete-grps').css("visibility", "visible");

        } else {
            $(':checkbox').each(function () {
                this.checked = false;
            });
            $('#delete-grps').css("visibility", "hidden");
        }
    });
}
//**************************************Manage Group Function*****************************************

function manage_group(groupid, shdiv)
{
    //Manage group content

//    alert('sent loaded');
    page_num = 4;
    $.ajax({
        url: url + '/show',
        type: 'post',
        data: {
            groupId: groupid,
            sessionToken: session_token,
            appId: authAppID
        }
    })
            .done(function (data) {

                var res_len = Object.keys(data.status).length;
                var status = data.status;
                if (status.code === "BS200")
                {
                    var row = '';
//                    var row1 = '';
                    row1 = '<li><div class=""><span class="dash-foot-exec">' + data.data.grp_name +
                            '</span><br />' + data.data.grp_desc +
                            '</div></li> <li><div class="grp-contact"><input type="hidden" id="grpid" /><span class="pull-left">Contacts &nbsp;<span class="dash-foot-exec">'
                            + data.hypermedia.total +
                            '</span></span><span class="pull-right"><span class="dash-foot-exec">' +
                            formatTime(data.data.date) +
                            '</span></span></div></li>';
                    if (data.history.length === 0)
                    {
                        row = '<li class="sent-item"><span class="dash-foot-exec">You have no message</span></li>';
                    } else if (data.history.length > 0)
                    {
                        console.log(JSON.stringify(data.history) + ' jjj ' + session_token);
                        console.dir(data.history);
                        jQuery.each(data.history, function (index, item) {

                            console.dir(index + ' kkkk ');
                            console.log(JSON.stringify(item) + ' jjj ' + index);
                            row += '<li><table class=" msg-sent"><tr class="bt">' +
                                    '<td width="100%" colspan="2" class="uname text-left">' +
                                    item.sender +
                                    '</td></tr>' +
                                    '<tr class="bt"><td colspan="2" width="100%" class="cont bbn-text-left">' +
                                    item.message +
                                    '</td></tr>' +
                                    '<tr class=""><td class="group-bottom">' +
                                    'Contacts <span class="dash-foot-exec">' +
                                    data.hypermedia.total +
                                    '</span></td>' +
                                    '<td class="group-bottom bbn-text-right">' +
                                    item.created +
                                    '</td></tr></table></li>';
                        });
                    }
//                    alert('Test: '+row1);
                    $("#group-summary").html(row1);
                    $("#msg-list-grp-details").html(row);
                    $('.page-content').hide();
                    $('#' + shdiv).show();

                    $('#add-new-contact-to-group').on('click', function () {
                        pull_contacts();
                    });

                    $('#delete-new-contact-from-group').on('click', function () {
                        pull_group_contacts();
                    });

                } else
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

function grp_detail(grp) {
    page_num = 4;
    // alert(grp);
    // return;
    $.ajax({
        url: url + "/show",
        type: 'post',
        data: {
//                pageNumber: page_num,
            sessionToken: session_token,
            appId: authAppID,
            groupId: grp
        }
    }).done(function (data) {

//alert("Track: "+JSON.stringify(data));
//return;
        var status = data.status;
        if (status.code === "BS200")
        {
            console.log(JSON.stringify(data.data) + ' jjj ' + session_token);
            console.dir(data.data);
            gn = data.data.grp_name;
            //alert('ddd '+gn);
            return gn;
        }
    })
            .fail(function (e) {
                errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
                alert(errmsg);
                //return;
            });
}
function manage_contacts(shdiv)
{
    $('.page-content').hide();
    $('#loading-content').show();
    page_num = 4;
    $.ajax({
        url: url1,
        type: 'post',
        data: {
//                pageNumber: page_num,
            sessionToken: session_token,
            appId: authAppID
        }
    })
            .done(function (data) {

                var res_len = Object.keys(data.status).length;
                var status = data.status;
                if (status.code === "BS200")
                {
                    var row = '';
                    var row1 = '';
                    //groupName = '';
                    console.log(JSON.stringify(data.result) + ' jjj ' + session_token);
                    console.dir(data.result);
                    jQuery.each(data.result.data, function (index, item) {
                        console.dir(index + ' kkkk ');
                        console.log(JSON.stringify(item) + ' jjj ' + index);
                        $.ajax({
                            url: url + "/show",
                            type: 'post',
                            data: {
                                sessionToken: session_token,
                                appId: authAppID,
                                groupId: item.gid
                            }
                        }).done(function (data) {
                            var status = data.status;
                            if (status.code === "BS200")
                            {
                                console.log(JSON.stringify(data.data) + ' jjj ' + session_token);
                                console.dir(data.data);
                                groupName = data.data.grp_name;
                                //alert('ddd '+ groupName);
                                // return gn;
                            }
                        })
                                .fail(function (e) {
                                    errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
                                    alert(errmsg);
                                    //return;
                                });
//                        var date_time = new Date(item.date * 1000).format('D M Y h i A');
                        //var date_time = formatTime(item.date);
                        // alert(item.gid);
                        row1 += '<li><table class="manage-contact"><tr><td rowspan="2" width="3%"><input class="" type="checkbox" name="sel" id="sel" /></td><td id="edit-fname' + index + '" width="40%">' + item.firstname +
                                '&nbsp' + item.surname +
                                '</td><td width="50%"></td><td rowspan="2" width="5%" class="text-center">' +
                                '<span class="contact-action">' +
                                '<div class="btn-group"><input type="hidden" id="contactId' + index + '" value="' + item.phone + '">' +
                                '<i class="material-icons dropdown-toggle"  data-toggle="dropdown" >delete forever</i>' +
                                '<ul class="dropdown-menu">' +
                                '<li><a class="delete-contact" style="color:#ff2500" id="' + index + '" href="#delete-contact" data-toggle="modal" data-target="#contactDeleteModal">Delete</a></li>' +
                                '</ul></div>' +
                                '</span></td>' +
                                '<td rowspan="2" width="5%" class="text-center">' +
                                '<span class="contact-action">' +
                                '<div class="btn-group">' +
                                '<i class="material-icons dropdown-toggle"  data-toggle="dropdown" >edit</i>' +
                                '<ul class="dropdown-menu">' +
                                '<li><a class="edit-contact" id="' + index + '" href="#edit-contact" data-toggle="modal" data-target="#contactEditModal">Modify Contact</a></li>' +
                                '</ul></div>' +
                                '</span></td></tr><tr><td id="phone' + index + '" width="40%" class="contact-email">' + item.phone +
                                '<input class="" type="hidden" name="sel1" value="' + groupName + '" id="grpName' + index + '" /></td><td width="50%" class="contact-email">' +
                                '<button id="' + index + '" title="View Contact Detail" class="btn btncon" data-toggle="modal" data-target="#viewContactModal">' +
                                item.email + '</button>' +
                                '<input type="hidden" id="email' + index + '" value="' + item.email + '">' +
                                '<input type="hidden" id="contactid-val' + index + '" value="' + item.id + '">' +
                                '<input type="hidden" class="contact-grp-id" id="contact-group-id-val' + index + '" value="' + item.gid + '">' +
                                '</div></td></tr></table></li>';
//                        row += '<div class="row"><ul><li><i class="material-icons">account_circle</i>'+item.firstname+'&nbsp'+item.surname+
//                                '</li><li><i class="material-icons">local_phone</i>'+item.phone+
//                                '</li><li>'+
//                                '<i class="material-icons">'+item.city+'</i>'+item.state+'</li></ul></div>';
                    });
                    $("#contact-list").html(row1);
//                    var a = $(shdiv);
                    $('.page-content').hide();
                    $('#' + shdiv).show();
                    //alert("mmmmmmmmmmm " + shdiv);
                    $(".btncon").click(function () {
                        var ind = $(this).attr('id');
                        var fn = $("#edit-fname" + ind).html();
                        var phone = $("#phone" + ind).html();
                        var grpName = $("#grpName" + ind).val();
                        $("#contactName").html(fn);
                        $("#contactPhoneNo").html(phone);
                        $("#grp_name").html(groupName);
                        // alert('dfghj' + grpName);
                    });
                    $(".delete-contact").on("click", function () {
                        var contactid = $(this).attr('id');
                        localStorage.setItem('contact_id', contactid);
                        var number = $("#phone" + contactid).html();
                        var name = $("#edit-fname" + contactid).html();
                        $("#deleteContactPhoneNo").html(number);
                        $("#deleteContactName").html(name);
                    });
                    $("#delete-contact").on("click", function () {
                        var id = localStorage.getItem('contact_id');
                        contactid = $('#contactid-val' + id).val();
                        deleteContact(contactid, shdiv);
                    });
                    $(".edit-contact").on("click", function () {
                        var id = $(this).attr('id');
                        var phone = $("#phone" + id).text();
                        var fullname = $("#edit-fname" + id).html();
                        var email = $("#email" + id).val();
//                        alert('Test: '+fullname);return;
                        var split_str = fullname.split('&nbsp;');
                        var fname = split_str[0];
                        var lname = split_str[1];
//                        alert(fname+' '+email+' test');return;
                        $("#contact-firstName").val(fname);
                        $("#contact-lastName").val(lname);
                        $("#contact-mobile").val(phone);
                        $("#contact-email").val(email);
                    });
                } else
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
                $('.page-content').hide();
                $('#' + shdiv).show();
                return;
            });
    $('.page-content').hide();
    $('#' + shdiv).show();
    $('#add-contact').on("click", function () {
        addContact(shdiv);
    });
    $('#select-all').click(function () {
        if (this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function () {
                this.checked = true;
            });
        } else {
            $(':checkbox').each(function () {
                this.checked = false;
            });
        }
    });
}


function save_group(shdiv)
{
    var groupName = $('#groupName').val();
    var groupDescription = $('#groupDescription').val();
//        alert('Track: '+groupName+' s: '+groupDescription);
//        return;

    $('.page-content').hide();
    $('#loading-content').show();
    $.ajax({
//        url: url + 's/create',
        url: 'http://www.bbnlab.tech/api_v3/public/contacts/groups/create',
        type: 'post',
        data: {
            groupName: groupName,
            groupDescription: groupDescription,
            sessionToken: session_token,
            appId: authAppID
        }
    })

            .done(function (data) {
                var status = data.status;
                if (status.code === "BS200")
                {
//            alert('New Group Created!');
                    groups(shdiv);
                } else
                {
                    switch (status.code)
                    {
                        default:
//                            showErrorMessage(status.message);
                            alert(status.message);
                            groups(shdiv);
                    }
                }
            })

            .fail(function (e) {
                errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
                alert(errmsg);
                groups(shdiv);
                return;
            });
}

function addContact(shdiv) {
    var firstName1 = $('#fName').val();
    var lastName1 = $('#lName').val();
    var mobile1 = $('#mobile').val();
    var email1 = $('#email').val();
    var groupId = $('.contact-grp-id').val();
//    alert('Track: ' + groupId);
//    return;
//        return;
    var contacts = [{
            firstName: firstName1,
            lastName: lastName1,
            mobile: mobile1,
            email: email1}];

    // alert('Test: '+JSON.stringify(contacts));return;
//    $('.page-content').hide();
//    $('#loading-content').show();
    $.ajax({
//        url: url + 's/create',
        url: 'http://www.bbnlab.tech/api_v3/public/contacts/save',
        type: 'post',
        data: {
            contacts: contacts,
            groupId: groupId,
            sessionToken: session_token,
            appId: authAppID
        }
    })

            .done(function (data) {
                var status = data.status;
                if (status.code === "BS200")
                {
//            alert('New Group Created!');
                    manage_contacts(shdiv);
                } else
                {
                    switch (status.code)
                    {
                        default:
//                            showErrorMessage(status.message);
                            alert(status.message);
                            manage_contacts(shdiv);
                    }
                }
            })

            .fail(function (e) {
                errmsg = "A communication error occurred. Please check your internet connection and Try again";
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
                alert(errmsg);
                manage_contacts(shdiv);
                return;
            });
}

function deleteContact(contactId, shdiv) {
    $('.page-content').hide();
    $('#loading-content').show();
    $.ajax({
//        url: url + 's/create',
        url: 'http://www.bbnlab.tech/api_v3/public/contacts/delete',
        type: 'post',
        data: {
            contactId: contactId,
            sessionToken: session_token,
            appId: authAppID
        }
    })

            .done(function (data) {
                var status = data.status;
                console.dir('Test: ' + JSON.stringify(data));
                return;
                if (status.code === "BS200")
                {
//            alert('New Group Created!');
                    manage_contacts(shdiv);
                } else
                {
                    switch (status.code)
                    {
                        default:
//                            showErrorMessage(status.message);
                            alert(status.message);
                            manage_contacts(shdiv);
                    }
                }
            })

            .fail(function (e) {
                errmsg = "A communication error occurred. Please check your internet connection and Try again";
                alert(errmsg);
                manage_contacts(shdiv);
                return;
            });
}
//******************************************MANAGE GROUP CONTACT**********************************

function pull_contacts()
{
    page_num = 4;
    $.ajax({
        url: url1,
        type: 'post',
        data: {
            pageNumber: page_num,
            sessionToken: session_token,
            appId: authAppID
        }
    })
            .done(function (data) {

                var res_len = Object.keys(data.status).length;
                var status = data.status;

                if (status.code === "BS200")
                {
                    var row = '';
                    console.log(JSON.stringify(data.result) + ' jjj ' + session_token);
//                    console.dir(data.result );
                    if (data.result.data.length === 0)
                    {
                        row += 'No Contact';
                    } else if (data.result.data.length > 0)
                    {
                        jQuery.each(data.result.data, function (index, item) {
                            console.dir(index + ' kkkk ');
                            console.log(JSON.stringify(item) + ' jjj ' + index);
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
                            var full_name = first_name + ' ' + other_name + ' ' + surname;
                            row += '<li><table class="msg-sent">' +
                                    '<tr><td rowspan="2" width="3%">' +
                                    '<input class="" type="checkbox" name="sel-group-contact" id="sel-group-contact" value="' + item.phone + '" />' +
                                    '</td>' +
                                    '<td width="40%">' +
                                    full_name +
                                    '</td>' +
                                    '<td width="50%"></td></tr>' +
                                    '<tr><td width="40%" class="contact-email">' +
                                    item.phone +
                                    '</td>' +
                                    '<td width="50%" class="contact-email">' +
                                    '<div id="contact" class="btn  " >' +
                                    item.email +
                                    '</div></td></tr></table></li>';
                        });
                    }

                    $("#add-contact-to-group-list").html(row);
                } else
                {
                    switch (status.code)
                    {
                        default:
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


function pull_group_contacts()
{
    page_num = 4;
    $.ajax({
        url: url1,
        type: 'post',
        data: {
            pageNumber: page_num,
            sessionToken: session_token,
            appId: authAppID
        }
    })
            .done(function (data) {

                var res_len = Object.keys(data.status).length;
                var status = data.status;

                if (status.code === "BS200")
                {
                    var row = '';
                    console.log(JSON.stringify(data.result) + ' jjj ' + session_token);
//                    console.dir(data.result );
                    if (data.result.data.length === 0)
                    {
                        row += 'No Contact';
                    } else if (data.result.data.length > 0)
                    {
                        jQuery.each(data.result.data, function (index, item) {
                            console.dir(index + ' kkkk ');
                            console.log(JSON.stringify(item) + ' jjj ' + index);
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
                            var full_name = first_name + ' ' + other_name + ' ' + surname;
                            row += '<li><table class="msg-sent">' +
                                    '<tr><td rowspan="2" width="3%">' +
                                    '<input class="" type="checkbox" name="del-group-contact" id="del-group-contact" value="' + item.phone + '" />' +
                                    '</td>' +
                                    '<td width="40%">' +
                                    full_name +
                                    '</td>' +
                                    '<td width="50%"></td></tr>' +
                                    '<tr><td width="40%" class="contact-email">' +
                                    item.phone +
                                    '</td>' +
                                    '<td width="50%" class="contact-email">' +
                                    '<div id="contact" class="btn  " >' +
                                    item.email +
                                    '</div></td></tr></table></li>';
                        });
                    }
//            row += '</select>';
                    $("#delete-contact-from-group-list").html(row);
//            alert('Test: '+row);
//            $('.page-content').hide();
//            $('#'+shdiv).show();


                } else
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


$('#add-contact-to-group-btn').on("click", function () {
    var mobile_check = [];
    $('input:checkbox[name=sel-group-contact]:checked').each(function () {
        mobile_check.push($(this).val());
    });
    var implode_mobile_check = mobile_check.join(',');
    alert('Test: ' + implode_mobile_check);
});


$('#delete-contact-from-group-btn').on("click", function () {
    var mobile_check = [];
    $('input:checkbox[name=del-group-contact]:checked').each(function () {
        mobile_check.push($(this).val());
    });
    var implode_mobile_check = mobile_check.join(',');
    alert('Test: ' + implode_mobile_check);
});

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
    return day + " " + month + " " + year + " " + hours + ":" + minutes;
}