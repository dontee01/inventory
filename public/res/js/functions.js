
function sent()
{
    $('.page-content').hide();
        page_num = 4;
        
        //Attempt at submitting token
        $.ajax({
            url: api_url+'/sent',
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
                    console.dir(data.data );
                }
            })
                .fail(function (e) {
                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
                    return;
                });
}


session_token = localStorage.getItem("sync_session_token");
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
authAppID = 50;
api_url = 'http://bbnlab.tech/api_v3/public/messages/';



$("document").ready(function () {
    
    $(".nav-load li a").on("click", function (){
//            $("#nav ul li a").on("click", function (){
            var lnk = $(this).attr("id");
            var shdiv = lnk+"-content";
            
            switch (shdiv)
            {
                case 'sent':
                    sent();
                    break;
                case 'drafts':
                    drafts();
                    break;
                case 'schedules':
                    schedules();
                    break;
                case 'notifications':
                    notifications();
                    break;
                case 'manage-group':
                    manage_group();
                    break;
                    
                default:
            }
            
            $('.page-content').hide();
            $('#'+shdiv).show();
//        });
    
//    $('.sent-item').click(function (){
//        $('.page-content').hide();
//        page_num = 4;
//        
//        //Attempt at submitting token
//        $.ajax({
//            url: api_url+'/sent',
//            type: 'post',
//            data: {
//                pageNumber: page_num,
//                sessionToken: session_token,
//                appId: authAppID
//            }
//        })
//                .done(function (data) {
//                    
//                var res_len =  Object.keys(data.status).length;
//                var status = data.status;
//                
//                if (status.code === "BS200")
//                {
//                    console.dir(data.data );
//                }
//            })
//                .fail(function (e) {
//                    showErrorMessage("A communication error occurred. Please check your internet connection and Try again");
//                    return;
//                });
//        $('#delivery-report-content').show();
    });
    
//    $(".signup-btn").on("click", function () {
//        window.location.assign("?activity=signup");
//    });

//////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////FUNCTIONS FOR////////////////////////////////////////////////
                ////////////////////////////LOADING//////////////////////////////////
        ///////////////////////////////////////////PAGES///////////////////////////////////

function sent()
{
//    $('.page-content').hide();
        page_num = 4;
        
        //Attempt at submitting token
        $.ajax({
            url: api_url+'/sent',
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
                    console.dir(data );
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

function drafts()
{
//    $('.page-content').hide();
        page_num = 4;
        
        //Attempt at submitting token
        $.ajax({
            url: api_url+'/drafts',
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
                    console.dir(data );
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



function showErrorMessage(eMessage) {
    $(".error-message").css("visibility", "visible");
    $(".error-message").css("margin", "3% 8%");
    $(".error-message").css("padding", "10px 5px");
    $(".error-message").css("padding", "5px");
    $(".error-message").css("borderRadius", "4px");
    $(".error-message").html(eMessage);
    errorMessageActive = 1;
    errorTimeout = setTimeout(function () {
        hideErrorMessage();
    }, 15000);
}

function hideErrorMessage() {
    if (errorMessageActive === 1) {
        $(".error-message").css("visibility", "hidden");
        $(".error-message").text("");
        $(".error-message").css("margin", "0");
        $(".error-message").css("padding", "0px");
        $(".error-message").css("border", "none");
        errorMessageActive = 0;
        clearTimeout(errorTimeout);
    }
}
    
});