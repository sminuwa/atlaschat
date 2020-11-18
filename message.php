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
    <meta content="ATLAS CHAT APP" name="description" />
    <meta content="ATLAS" name="author" />
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

My Messages <span id="new-message-notification"></span>

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
    $(document).ready(function(){
        setInterval(function(){messageNotification();}, 500);
    });
    function messageNotification(){
        $.ajax({
            type: "GET", url: "ajax.php?user_id=3",
            data: {type:'message-notification'},
            success: function(data){
                newData = parseInt(data);
                if(newData > 0){$("#new-message-notification").html('<span class="badge badge-danger">'+newData+'</span>');}
            },
        })
    }
</script>

</body>
</html>

