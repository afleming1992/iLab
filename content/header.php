<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Heriot-Watt Interaction Lab</title>
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/main.css" />
    <script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
       tinymce.init({
       selector: "textarea#tinymce",
       content_css: "css/bootstrap.css",
       height:"400px",
       toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l ink image | media fullpage | forecolor backcolor",
           plugins: [
               "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
               "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
               "save table contextmenu directionality emoticons template paste textcolor"
           ],
           relative_urls: false
        });
    </script>
    <link rel="stylesheet" href="jquery-ui/css/flick/jquery-ui.custom.css" />

</head>
<body>
    <script src="js/jquery.min.js" ></script>
    <script src="js/bootstrap.js" /></script>
    <script src="jquery-ui/js/jquery-ui.custom.min.js"></script>
    <div class="wrapper">
        <?php
            if(isset($message))
            {
                echo $message;
            }
        ?>
        <header>
            <?php
                include('navbar.php');
            ?>
        </header>
        <div class='maincontent'>