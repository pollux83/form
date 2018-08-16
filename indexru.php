<?php
require_once('classes/Session.php');
$language = 'ru';
$session = new Session();
if(count($_GET) >0 && array_key_exists('act', $_GET) && $_GET['act'] == 'logout'){
  $session->close_user_session($language);
}
$session->mark($language);
$title = 'Форма входа и регистрации';
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
            <!-- hidden anchor to stop jump http://www.css3create.com/Astuce-Empecher-le-scroll-avec-l-utilisation-de-target#wrap4  -->
            <a class="hiddenanchor" id="toregister"></a>
            <a class="hiddenanchor" id="tologin"></a>
            <div id="wrapper">
                <div id="login" class="animate form ru">
                    <form method="post" action="classes/UserAction.php"
                          autocomplete="on">
                        <input type="hidden" name="csrf_token"
                               value="<?php echo $_SESSION['csrf_token']; ?>"/>
                        <h1>Вход</h1>
                        <p>
                            <label for="username" class="uname" data-icon="u">
                                Ваше имя </label>
                            <input id="username" name="username" type="text"
                                   required="required"
                                   placeholder="myusername"/>
                        </p>
                        <p>
                            <label for="password" class="youpasswd"
                                   data-icon="p"> Ваш пароль </label>
                            <input id="password" name="password" type="password"
                                   required="required"
                                   placeholder="eg. X8df!90EO"/>
                        </p>
                        <p class="login button">
                            <input type="submit"
                                   onclick="return validate(this.form);"
                                   value="Войти"/>
                        </p>
                        <p class="change_link">
                            Вы не зарегистрированы ?
                            <a href="#toregister" class="to_register">Регистрация</a>
                        </p>
                    </form>
                </div>

                <div id="register" class="animate form ru">
                    <form method="post" action="classes/UserAction.php"
                          enctype="multipart/form-data" autocomplete="on" ENCTYPE="multipart/form-data">
                        <input type="hidden" name="csrf_token"
                               value="<?php echo $_SESSION['csrf_token']; ?>"/>
                        <h1> Регистрация </h1>
                        <p>
                            <label for="usernamesignup" class="uname"
                                   data-icon="u">Ваше имя</label>
                            <input id="usernamesignup" name="usernamesignup"
                                   type="text" required="required"
                                   placeholder="myusername690"/>
                        </p>
                        <p>
                            <label for="emailsignup" class="youmail"
                                   data-icon="e"> Ваш электронный адрес
                                почты</label>
                            <input id="emailsignup" name="emailsignup"
                                   type="email" required="required"
                                   placeholder="mymail@mail.com"/>
                        </p>
                        <p>
                            <label for="passwordsignup" class="youpasswd"
                                   data-icon="p">Ваш пароль. Пожалуйста,
                                печатайте только с клавиатуры</label>
                            <input id="passwordsignup" name="passwordsignup"
                                   type="password" onkeyup="countme();"
                                   required="required"
                                   placeholder="eg. X8df!9 (не меньше 6 символов)"/>
                        </p>
                        <p>
                            <label for="passwordsignup_confirm"
                                   class="youpasswd" data-icon="p">Пожалуйста,
                                подтвердите Ваш пароль </label>
                            <input id="passwordsignup_confirm"
                                   name="passwordsignup_confirm" type="password"
                                   required="required"
                                   placeholder="eg. X8df!9"/>
                        </p>
                        <p>
                            <label for="image" class="img" data-icon="u">Ваша
                                аватарка (gif, jpg, png) не более 2Mбт,
                                необязательно</label>
                            <input id="image" name="image" type="file"/>
                        </p>
                        <p class="signin button">
                            <input type="submit"
                                   onclick="return validate(this.form);"
                                   value="Добавить"/>
                        </p>
                        <p class="change_link">
                            Уже зарегистрированы ?
                            <a href="#tologin" class="to_register">
                                Вернуться </a>
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>
<script src="js/validate.js"></script>
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