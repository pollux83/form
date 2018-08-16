<?php
session_start();
$title = $description = $keywords = 'Профиль пользователя';
$css_main = 'main.css';

if (array_key_exists('lang', $_SESSION)) {
  $lang = $_SESSION['lang'];
}
else {
  $lang = '';
}

if($lang == 'en') $lang = ''; //for correct links in a page

if (!array_key_exists('datauser', $_SESSION)) {
  header('Location: ../index' . $lang . '.php');
}

$createdDate = $_SESSION['datauser']['created_date'];
$createdDate = strtotime($createdDate);
$createdDate = date("d.m.Y", $createdDate);
?>

<?php require_once('inc/header.php'); ?>


<body>

<div id="wrapper">
    <div class="header">
        <a href="#"><?= ($lang == 'ru') ? 'Форма': 'Form' ?></a>
        <a href="/index<?= $lang ?>.php?act=logout" class="logout"><?= ($lang == 'ru') ? 'Выйти': 'Logout' ?></a>
    </div>

    <div class="content">
      <?php if ($lang == 'ru'): ?>
          <h1>Профайл</h1>
        <?php if ($_SESSION['datauser']): ?>
              <p><img src="/images/<?= $_SESSION['datauser']['image'] ?>"
                      width="100px" alt=""></p>
              <p>Имя: <strong><?= $_SESSION['datauser']['name'] ?></strong></p>
              <p>Почта: <em><?= $_SESSION['datauser']['email'] ?></em></p>
              <p>Дата создания: <?= $createdDate ?></p>
        <?php else: ?>
              <p style="color:red;">Данных нет!!!</p>
        <?php endif; ?>
      <?php else: ?>
          <h1>Profile</h1>
        <?php if ($_SESSION['datauser']): ?>
              <p><img src="/images/<?= $_SESSION['datauser']['image'] ?>"
                      width="100px" alt=""></p>
              <p>Name: <strong><?= $_SESSION['datauser']['name'] ?></strong></p>
              <p>Email: <em><?= $_SESSION['datauser']['email'] ?></em></p>
              <p>Created data: <?= $createdDate ?></p>
        <?php else: ?>
              <p style="color:red;">Data hasn't!!!</p>
        <?php endif; ?>
      <?php endif; ?>
    </div>
    <div class="footer">
        <p class="change_link"><?= ($lang == 'ru') ? 'Тестовая задача - ': 'Test task - '?>2018</p>
    </div>
</div>

</body>
</html>