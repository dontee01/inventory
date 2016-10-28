url = 'http://www.bbnlab.tech/api_v3/public/contacts/group';
url1 = 'http://www.bbnlab.tech/api_v3/public/contacts/show';
groupName = '';

function groups(shdiv)
{
    page_num = 4;

    $.ajax({
        url: url + 's',
        type: 'post',
        data: {
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
                    jQuery.each(data.result.data, function (index, item) {
                        console.dir(index + ' kkkk ');
                        console.log(JSON.stringify(item) + ' jjj ' + index);
                        if (item.sent === 0)
                        {
                            //stat = '<span class="btn btn-xs btn-queued">Queued</span>';
                        }
//                        var date_time = new Date(item.date * 1000).format('D M Y h i A');
                        var date_time = formatTime(item.date);
                        row += '<li class="sent-item"><table class=" msg-sent"><tr class="bt"><td width="100%" colspan="2" class="uname text-left">' +
                                item.grp_name + '</td></tr><tr class="bt"><td width="60%" class="cont bbn-text-left">'
                                + item.grp_desc +
                                '</td><td class="group-bottom bbn-text-right"><input class="" type="checkbox" name="sel" id="sel" /></td></tr><tr class=""><td class="group-bottom">' +
                                'Contacts &nbsp;' + '<span class="dash-foot-exec">' + item.contact_count + '</span></td><td class="group-bottom bbn-text-right"><!--<span class="exec">-->' +
                                '<span class="dash-foot-exec">' + date_time + '</span><!--</span>--></td></tr></table></li>';

                    });
                    $(".grp-list").html(row);
                    $('.page-content').hide();
                    $('#' + shdiv).show();
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
}


function manage_group(shdiv)
{

    $('.page-content').hide();
    $('#' + shdiv).show();
}


function manage_contacts(shdiv)
{

    $('.page-content').hide();
    $('#' + shdiv).show();
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
    return day + " " + month + " " + year + " " + hours + ":" + minutes;
}