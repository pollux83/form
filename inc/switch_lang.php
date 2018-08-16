<header>
  <h1><?= ($language == 'ru') ? 'Форма <span>входа и регистрации</span>' :  'Form of <span>login and registration</span>' ?></h1>
  <nav class="codrops-demos">
    <span><?= ($language == 'en') ? 'Choice of language: ': 'Выбор языка: ' ?></span>
    <a href="index.php" class="current-demo"><?= ($language = 'en') ? 'English': 'Английский' ?></a>
    <a href="indexru.php"><?= ($language = 'en') ? 'Russian': 'Русский' ?></a>
  </nav>
</header>