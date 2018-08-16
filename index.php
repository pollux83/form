<?php
require_once('classes/Session.php');
$language = 'en';
$session = new Session();
$session->mark($language);
$title = 'Login and Registration Form';
?>

<?php require_once('inc/header.php'); ?>

<body>
<div class="container">

  <?php require_once('inc/switch_lang.php'); ?>

    <section>
        <div class="error">
          <?php
          if (array_key_exists('message', $_SESSION)) {
            echo '<span>' . $_SESSION['message'] . '</span>';
            unset($_SESSION['message']);
          }
          ?>
        </div>
        <div id="container_demo">
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>
            <div id="wrapper">
                <div id="login" class="animate form en">
                    <form method="post" action="classes/UserAction.php"
                          autocomplete="on">
                        <input type="hidden" name="csrf_token"
                               value="<?php echo $_SESSION['csrf_token']; ?>"/>
                        <h1>Log in</h1>
                        <p>
                            <label for="username" class="uname" data-icon="u">
                                Your username </label>
                            <input id="username" name="username" type="text"
                                   required="required"
                                   placeholder="myusername"/>
                        </p>
                        <p>
                            <label for="password" class="youpasswd"
                                   data-icon="p"> Your password </label>
                            <input id="password" name="password" type="password"
                                   required="required"
                                   placeholder="eg. X8df!90EO"/>
                        </p>
                        <p class="login button">
                            <input type="submit"
                                   onclick="return validate(this.form);"
                                   value="Login"/>
                        </p>
                        <p class="change_link">
                            Not a member yet ?
                            <a href="#toregister" class="to_register">Join
                                us</a>
                        </p>
                    </form>
                </div>

                <div id="register" class="animate form en">
                    <form method="post" action="classes/UserAction.php"
                          enctype="multipart/form-data" autocomplete="on" ENCTYPE="multipart/form-data">
                        <input type="hidden" name="csrf_token"
                               value="<?php echo $_SESSION['csrf_token']; ?>"/>
                        <h1> Sign up </h1>
                        <p>
                            <label for="usernamesignup" class="uname"
                                   data-icon="u">Your username</label>
                            <input id="usernamesignup" name="usernamesignup"
                                   type="text" required="required"
                                   placeholder="myusername690"/>
                        </p>
                        <p>
                            <label for="emailsignup" class="youmail"
                                   data-icon="e"> Your email</label>
                            <input id="emailsignup" name="emailsignup"
                                   type="email" required="required"
                                   placeholder="mymail@mail.com"/>
                        </p>
                        <p>
                            <label for="passwordsignup" class="youpasswd"
                                   data-icon="p">Your password. Please, type
                                only with use a keyboard </label>
                            <input id="passwordsignup" name="passwordsignup"
                                   onkeyup="countme();" type="password"
                                   required="required"
                                   placeholder="eg. X8df!9 (at least 6 characters)"/>
                        </p>
                        <p>
                            <label for="passwordsignup_confirm"
                                   class="youpasswd" data-icon="p">Please
                                confirm your password</label>
                            <input id="passwordsignup_confirm"
                                   name="passwordsignup_confirm" type="password"
                                   required="required"
                                   placeholder="eg. X8df!9"/>
                        </p>
                        <p>
                            <label for="image" class="img" data-icon="u">Your
                                avatar (gif, jpg, png image) is no more 2Mb, no
                                necessarily</label>
                            <input id="image" name="image" type="file"/>
                        </p>
                        <p class="signin button">
                            <input type="submit"
                                   onclick="return validate(this.form);"
                                   value="Sign up"/>
                        </p>
                        <p class="change_link">
                            Already a member ?
                            <a href="#tologin" class="to_register"> Go and
                                login </a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>
<script src="js/validate.js?v2"></script>
<script type="text/javascript">
    //check who writes (bot or person)
    var ct = 0;
    var addCount = document.createElement('input');
    addCount.type = "hidden";
    addCount.id = "count";
    addCount.name = "count";
    addCount.value = "0";
    $('form').click(function () {
        this.appendChild(addCount);
    });
    function countme() {
        document.getElementById('count').value = ++ct;
    }
</script>
</body>
</html>