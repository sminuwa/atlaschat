<?php
/**
 * Created by PhpStorm.
 * User: sunusi
 * Date: 2020-11-16
 * Time: 14:14
 */



?>

<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Chat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Responsive Bootstrap 4 Chat App" name="description" />
    <meta content="ATLAS" name="author" />
    <?php if($_GET['user_id']){ $user_id = $_GET['user_id']; ?>
        <meta name="userID" content="<?php $user_id ?>">
    <?php }?>
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- magnific-popup css -->
    <link href="assets/libs/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css" />

    <!-- owl.carousel css -->
    <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="assets/libs/owl.carousel/assets/owl.theme.default.min.css">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap-dark.min.css" id="bootstrap-dark-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app-dark.min.css" id="app-dark-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="layout-wrapper d-lg-flex">

    <!-- start chat-leftsidebar -->
    <div class="chat-leftsidebar mr-lg-1">
        <div class="tab-content">
            <!-- Start chats tab-pane -->
            <div class="tab-pane show active" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">
                <!-- Start chats content -->
                <div>
                    <div class="px-4 pt-4">
                        <h4 class="mb-4">Chats</h4>
                        <div class="search-box chat-search-box">
                            <div class="input-group mb-3 bg-light  input-group-lg rounded-lg">
                                <div class="input-group-prepend">
                                    <button class="btn btn-link text-muted pr-1 text-decoration-none" type="button">
                                        <i class="ri-search-line search-icon font-size-18"></i>
                                    </button>
                                </div>
                                <input type="text" id="search-users-input" class="form-control bg-light" placeholder="Search users">
                            </div>
                        </div> <!-- Search Box-->
                    </div> <!-- .p-4 -->

                    <!-- Start chat-message-list -->
                    <input type="hidden" id="active-receiver" value="0">
                    <div class="px-2">
                        <h5 class="mb-3 px-3 font-size-16" id="search-result-text">Recent</h5>
                        <div class="chat-message-list" style="height: calc(100% - 280px);overflow: auto" data-simplebar>
                            <ul class="list-unstyled chat-list chat-user-list">

                            </ul>
                        </div>

                    </div>
                    <!-- End chat-message-list -->
                </div>
                <!-- Start chats content -->
            </div>
            <!-- End chats tab-pane -->
        </div>
        <!-- end tab content -->
    </div>
    <!-- end chat-leftsidebar -->

    <!-- Start User chat -->
    <div class="user-chat w-100">
        <div class="d-lg-flex"  >
            <!-- start chat conversation section -->
            <div class="w-100">
                <div class="p-3 p-lg-4 border-bottom" id="active-chat-top">
                    <div class="row align-items-center">
                        <div class="col-sm-12 col-12">
                            <div class="media align-items-center">
                                <div class="d-block d-lg-none mr-2">
                                    <a href="javascript: void(0);" class="user-chat-remove text-muted font-size-16 p-2"><i class="ri-arrow-left-s-line"></i></a>
                                </div>
                                <div class="mr-3">
                                  <img width="60" height="60" class="rounded-circle avatar-xs" id="active-user-icon" src="" alt="IMG" />
                                </div>
                                <div class="media-body overflow-hidden">
                                    <h5 class="font-size-16 mb-0 text-truncate">
                                        <a href="#" class="text-reset user-profile-show" id="activeChatName"></a>
                                    </h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- end chat user head -->

                <!-- start chat conversation -->
                <div class="chat-conversation p-3 p-lg-4" data-simplebar="init">
                    <ul class="list-unstyled mb-0" id="chat-conversation" style="overflow-y:scroll;">

                    </ul>
                </div>
                <!-- end chat conversation end -->

                <!-- start chat input section -->
                <div class="p-3 p-lg-4 border-top mb-0" id="send-new-message-area">
                    <div class="row no-gutters">
                        <div class="col">
                            <div>
                                <input type="text" id="conversation-message-input" class="form-control form-control-lg bg-light border-light" placeholder="Enter Message...">
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="chat-input-links ml-md-2">
                                <ul class="list-inline mb-0">
                                    <li class="list-inline-item">
                                        <button type="submit" id="conversation-send-button" class="btn btn-primary font-size-16 btn-lg chat-send waves-effect waves-light">
                                            <i class="ri-send-plane-2-fill"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end chat input section -->
            </div>
            <!-- end chat conversation section -->

            <!-- start User profile detail sidebar -->
            <div class="user-profile-sidebar">
                <div class="px-3 px-lg-4 pt-3 pt-lg-4">
                    <div class="user-chat-nav text-right">
                        <button type="button" class="btn nav-btn" id="user-profile-hide">
                            <i class="ri-close-line"></i>
                        </button>
                    </div>
                </div>

                <div class="text-center p-4 border-bottom">
                    <div class="mb-4">
                        <img src="assets/images/users/avatar-4.jpg" class="rounded-circle avatar-lg img-thumbnail" alt="">
                    </div>

                    <h5 class="font-size-16 mb-1 text-truncate">Doris Brown</h5>
                    <p class="text-muted text-truncate mb-1"><i class="ri-record-circle-fill font-size-10 text-success mr-1"></i> Active</p>
                </div>
                <!-- End profile user -->

                <!-- Start user-profile-desc -->
                <div class="p-4 user-profile-desc" data-simplebar>
                    <div class="text-muted">
                        <p class="mb-4">If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual.</p>
                    </div>

                    <div id="profile-user-accordion" class="custom-accordion">
                        <div class="card shadow-none border mb-2">
                            <a href="#collapseOne" class="text-dark" data-toggle="collapse"
                               aria-expanded="true"
                               aria-controls="collapseOne">
                                <div class="card-header" id="headingOne">
                                    <h5 class="font-size-14 m-0">
                                        <i class="ri-user-2-line mr-2 align-middle d-inline-block"></i> About
                                        <i class="mdi mdi-chevron-up float-right accor-plus-icon"></i>
                                    </h5>
                                </div>
                            </a>

                            <div id="collapseOne" class="collapse show"
                                 aria-labelledby="headingOne" data-parent="#profile-user-accordion">
                                <div class="card-body">

                                    <div>
                                        <p class="text-muted mb-1">Name</p>
                                        <h5 class="font-size-14">Doris Brown</h5>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-muted mb-1">Email</p>
                                        <h5 class="font-size-14">adc@123.com</h5>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-muted mb-1">Time</p>
                                        <h5 class="font-size-14">11:40 AM</h5>
                                    </div>

                                    <div class="mt-4">
                                        <p class="text-muted mb-1">Location</p>
                                        <h5 class="font-size-14 mb-0">California, USA</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End About card -->

                        <div class="card mb-1 shadow-none border">
                            <a href="#collapseTwo" class="text-dark collapsed" data-toggle="collapse"
                               aria-expanded="false"
                               aria-controls="collapseTwo">
                                <div class="card-header" id="headingTwo">
                                    <h5 class="font-size-14 m-0">
                                        <i class="ri-attachment-line mr-2 align-middle d-inline-block"></i> Attached Files
                                        <i class="mdi mdi-chevron-up float-right accor-plus-icon"></i>
                                    </h5>
                                </div>
                            </a>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                 data-parent="#profile-user-accordion">
                                <div class="card-body">
                                    <div class="card p-2 border mb-2">
                                        <div class="media align-items-center">
                                            <div class="avatar-sm mr-3">
                                                <div class="avatar-title bg-soft-primary text-primary rounded font-size-20">
                                                    <i class="ri-file-text-fill"></i>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-left">
                                                    <h5 class="font-size-14 mb-1">admin_v1.0.zip</h5>
                                                    <p class="text-muted font-size-13 mb-0">12.5 MB</p>
                                                </div>
                                            </div>

                                            <div class="ml-4">
                                                <ul class="list-inline mb-0 font-size-18">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="text-muted px-1">
                                                            <i class="ri-download-2-line"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item dropdown">
                                                        <a class="dropdown-toggle text-muted px-1" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#">Action</a>
                                                            <a class="dropdown-item" href="#">Another action</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->

                                    <div class="card p-2 border mb-2">
                                        <div class="media align-items-center">
                                            <div class="avatar-sm mr-3">
                                                <div class="avatar-title bg-soft-primary text-primary rounded font-size-20">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-left">
                                                    <h5 class="font-size-14 mb-1">Image-1.jpg</h5>
                                                    <p class="text-muted font-size-13 mb-0">4.2 MB</p>
                                                </div>
                                            </div>

                                            <div class="ml-4">
                                                <ul class="list-inline mb-0 font-size-18">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="text-muted px-1">
                                                            <i class="ri-download-2-line"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item dropdown">
                                                        <a class="dropdown-toggle text-muted px-1" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#">Action</a>
                                                            <a class="dropdown-item" href="#">Another action</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->

                                    <div class="card p-2 border mb-2">
                                        <div class="media align-items-center">
                                            <div class="avatar-sm mr-3">
                                                <div class="avatar-title bg-soft-primary text-primary rounded font-size-20">
                                                    <i class="ri-image-fill"></i>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-left">
                                                    <h5 class="font-size-14 mb-1">Image-2.jpg</h5>
                                                    <p class="text-muted font-size-13 mb-0">3.1 MB</p>
                                                </div>
                                            </div>

                                            <div class="ml-4">
                                                <ul class="list-inline mb-0 font-size-18">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="text-muted px-1">
                                                            <i class="ri-download-2-line"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item dropdown">
                                                        <a class="dropdown-toggle text-muted px-1" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#">Action</a>
                                                            <a class="dropdown-item" href="#">Another action</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->

                                    <div class="card p-2 border mb-2">
                                        <div class="media align-items-center">
                                            <div class="avatar-sm mr-3">
                                                <div class="avatar-title bg-soft-primary text-primary rounded font-size-20">
                                                    <i class="ri-file-text-fill"></i>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <div class="text-left">
                                                    <h5 class="font-size-14 mb-1">Landing-A.zip</h5>
                                                    <p class="text-muted font-size-13 mb-0">6.7 MB</p>
                                                </div>
                                            </div>

                                            <div class="ml-4">
                                                <ul class="list-inline mb-0 font-size-18">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="text-muted px-1">
                                                            <i class="ri-download-2-line"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item dropdown">
                                                        <a class="dropdown-toggle text-muted px-1" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a class="dropdown-item" href="#">Action</a>
                                                            <a class="dropdown-item" href="#">Another action</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="#">Delete</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card -->

                                </div>

                            </div>
                        </div>
                        <!-- End Attached Files card -->
                    </div>
                    <!-- end profile-user-accordion -->
                </div>
                <!-- end user-profile-desc -->
            </div>
            <!-- end User profile detail sidebar -->
        </div>
    </div>
    <!-- End User chat -->
</div>
<!-- end  layout wrapper -->

<!-- JAVASCRIPT -->
<script src="assets/libs/jquery/jquery.min.js"></script>
<script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/libs/simplebar/simplebar.min.js"></script>
<script src="assets/libs/node-waves/waves.min.js"></script>
<!-- Magnific Popup-->
<script src="assets/libs/magnific-popup/jquery.magnific-popup.min.js"></script>
<!-- owl.carousel js -->
<script src="assets/libs/owl.carousel/owl.carousel.min.js"></script>
<!-- page init -->
<script src="assets/js/pages/index.init.js"></script>
<script src="assets/js/app.js"></script>

<script>
    var user_id = '<?php echo $user_id; ?>';
    let chat = $("#chat-conversation");
    let chatHeight = chat.prop("scrollHeight");
    let chatConversation = $('.chat-conversation');

    $(document).ready(function(){
        // var receiver = 0;
        setInterval(function(){
            if($("#active-receiver").val() != 0){
                loadMessages($("#active-receiver").val());

            }
            if($('#search-users-input').val() == "") {
                $("#search-result-text").text("Recent");
                loadChatList();
            }

        }, 1000);

        // chatuser
        $("body").on('click','.chatuser', function(){
            chatName = $(this).data('name');
            receiver = $(this).data('receiver');
            // console.log(receiver);
            $("#active-receiver").val(receiver);
            $("#activeChatName").html(chatName);
            $("#chat-conversation").html(
                `<h5><i>Loading chats...</i></h5>`
            );
            if($("#active-receiver").val() != 0){
                $("#send-new-message-area").show();
                $("#active-chat-top").show();
                $("#active-user-icon").attr('name', chatName)
                    .attr('src', 'https://ui-avatars.com/api/?name='+chatName+'&amp;color=153d77&amp;background=c5c0ff&amp;rounded=true');
                scrollTextUp()
            }

        });

        //send message
        $("body").on('click', '#conversation-send-button', function(){
            sendMessages();
            // $("#chat-conversation").animate({ scrollTop: $(this).height() }, "slow");
            // return false;
        });

        $("body").on('keyup', '#search-users-input', function(){
            $("#search-result-text").text("Search result");
            searchUsers()
        });

        $("#conversation-message-input").on('keyup',function (e) {
            let code = e.keyCode || e.which;
            if(code === 13) {
                sendMessages();
            }
        });

        loadChatList();
    });

    if($("#active-receiver").val() == 0){
        $("#send-new-message-area").hide();
        $("#active-chat-top").hide();
    }

    function loadChatList(){

        $.ajax({
            type: "GET",
            url: "ajax.php",
            data:{user_id: user_id,type:'chatlist'},
            success: function(data){
                // console.log(data);
                $(".chat-user-list").html(data)
            },
            error: function(){

            }
        })
    }


    function loadMessages(receiver){
        target_id = '#r' + receiver;
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                receiver: receiver,
                user_id:user_id,
                type:'messages'
            },
            beforeSend: function(){
            },
            success: function(data){
                // $("#chat-conversation").html(data);
                $("#chat-conversation").html(data);

                $('#conversation-message-input').focus();

                scrollTextUp(chat, chatConversation)

            },
            error: function(){

            }
        })
    }

    function sendMessages(){
        // target_id = '#r' + receiver;
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                receiver: $("#active-receiver").val(),
                message: $("#conversation-message-input").val(),
                user_id:user_id,
                type:'send'
            },
            beforeSend: function(){

            },
            success: function(data){
                $('#conversation-message-input')
                    .val('')
                    .focus();
                // scrollTextUp()
            },
            error: function(){

            }
        })
    }

    function scrollTextUp(chat, chatConversation){
        chat.css('max-height', chatConversation.height());
        if(chatHeight !== chat.prop("scrollHeight")){
            chatHeight = chat.prop("scrollHeight");
            chat.animate({ scrollTop: chatHeight }, "slow");
        }
    }

    function searchUsers(){
        // target_id = '#r' + receiver;
        $.ajax({
            type: "GET",
            url: "ajax.php/",
            data: {
                search: $("#search-users-input").val(),
                user_id: user_id,type:'search'
            },
            beforeSend: function(){
                console.log('sending data')
            },
            success: function(data){
                $(".chat-user-list").html(data);
                // console.log(data);
                // $("#chat-conversation").html(data);
            },
            error: function(){

            }
        })
    }
</script>
</body>
</html>

