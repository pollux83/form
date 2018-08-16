<!DOCTYPE html>
<!--[if lt IE 7 ]>
<html lang="<?= $_SESSION['lang'] ?>" class="no-js ie6 lt8"> <![endif]-->
<!--[if IE 7 ]>
<html lang="<?= $_SESSION['lang'] ?>" class="no-js ie7 lt8"> <![endif]-->
<!--[if IE 8 ]>
<html lang="<?= $_SESSION['lang'] ?>" class="no-js ie8 lt8"> <![endif]-->
<!--[if IE 9 ]>
<html lang="<?= $_SESSION['lang'] ?>" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="<?= $_SESSION['lang'] ?>" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="UTF-8"/>
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">  -->
    <title><?= $title ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
          content="<?= ($description) ? $description : 'Login and Registration Form with HTML5 and CSS3' ?>"/>
    <meta name="keywords"
          content="<?= ($keywords) ? $keywords : 'html5, css3, form, switch, animation, :target, pseudo-class' ?>"/>
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/demo.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css?v2"/>
    <link rel="stylesheet" type="text/css" href="css/animate-custom.css"/>
  <?php if ($css_main): ?>
      <link rel="stylesheet" type="text/css" href="css/<?= $css_main ?>"/>
  <?php endif; ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        window.csrf = {csrf_token: '<?php echo $_SESSION['csrf_token']; ?>'};
        $.ajaxSetup({
            data: window.csrf
        });
        $(document).ready(function () {
            // CSRF token is now automatically merged in AJAX request data.
            $.post('/awesome/ajax/url', {foo: 'bar'}, function (data) {
                console.log(data);
            });
        });
    </script>
</head>