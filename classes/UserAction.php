<?php

class UserAction {

  private $dataUser;
  private $language = 'en';
  private $action;
  private $db;

  function __construct() {
    session_start();

    include('../config.php');

    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    foreach ($_POST as $key => $val) { //validate
      $val = trim($val);
      $val = stripslashes($val);
      $val = htmlspecialchars($val);
      $this->dataUser[$key] = $val;
    }
    $this->dataUser = filter_input_array(INPUT_POST, $this->dataUser);

    $this->language = $_SESSION['lang'];

    $this->check();
    $this->run();
  }

  public function check() {
    if (!array_key_exists('csrf_token', $this->dataUser) || $this->dataUser['csrf_token'] !== $_SESSION['csrf_token']) {
      $this->errorMsg();
    }
    //choose an action
    if (array_key_exists('username', $this->dataUser)) {
      $this->action = 'log';
    }
    elseif (array_key_exists('usernamesignup', $this->dataUser)) {
      if (!filter_var($this->dataUser['emailsignup'], FILTER_VALIDATE_EMAIL)) {
        $this->errorMsg('format_email');
      }
      $this->action = 'reg';
      //check who writes (bot or person)
      $count = $this->dataUser['count'];
      if (empty($count) || $count < 6) {
        $this->errorMsg();
      }
    }
    //check image
    if (count($_FILES) && mb_strlen($_FILES['image']['name']) > 0) {
      $fileNameTmp = $_FILES['image']['tmp_name'];
      $nameImg = $this->dataUser['image'] = $_FILES['image']['name'];

      if (is_uploaded_file($fileNameTmp)) {
        $targetFile = SITE_ROOT . '/images/' . $nameImg;
        $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        if (file_exists($targetFile)) {
          $this->errorMsg('img_has');
        }
        elseif ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif') {
          $this->errorMsg('type_img');
        }
        elseif ($_FILES['image']['size'] > 2097152) {
          $this->errorMsg('big_size');
        }
        $result = move_uploaded_file($fileNameTmp, $targetFile);

        if (!$result) {
          $this->dataUser['image'] = 'facebook-default-pic.jpg';

        }
      }
    }
    else {
      $this->dataUser['image'] = 'facebook-default-pic.jpg';
    }
  }

  public function run() {
    $this->db = $this->connect();

    if ($this->action == 'log') {

      $userDB = $this->fetch($this->dataUser['username']);

      if(count($userDB) > 0) $userDB = $userDB[0];

      if (count($userDB) > 0) {
        $checkPassword = password_verify($this->dataUser['password'], $userDB['password']);
      }
      else {
        $this->errorMsg('wrong');
      }

      if ($checkPassword) {
        $this->give($userDB);
      } else {
        $this->errorMsg('wrong');
      }

    }
    elseif ($this->action == 'reg') {
      $values = $this->dataUser['usernamesignup'];
      $this->action = 'log'; //for to correct DB request
      $userDB = $this->fetch($values);

      if (count($userDB) === 0) {
        $sql = "INSERT INTO `users` (
                              `name`, 
                              `email`, 
                              `password`, 
                              `image`, 
                              `created_date`) VALUES (
                              :name, 
                              :email, 
                              :password, 
                              :image, 
                              :created_date);";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $this->dataUser['usernamesignup']);
        $stmt->bindValue(':email', $this->dataUser['emailsignup']);
        $stmt->bindValue(':password', password_hash($this->dataUser['passwordsignup'], PASSWORD_DEFAULT));
        $stmt->bindValue(':image', $this->dataUser['image']);
        $stmt->bindValue(':created_date', date('Y-m-d h:m:s'));
        $stmt->execute();
        $lastId = $this->db->lastInsertId();
        $this->action = 'reg'; //for to correct DB request
        $userDB = $this->fetch((int) $lastId)[0];
        $this->give($userDB);

      }
      else {
        $this->errorMsg('has');
      }
    }
  }

  public function fetch($values) {
    if ($this->action == 'reg') {
      $sql = 'SELECT * FROM `users` WHERE `id` = ?';
    }
    elseif ($this->action == 'log') {
      $sql = 'SELECT * FROM `users` WHERE `name` = ?';
    }
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$values]);
    return $stmt->fetchAll();
  }

  public function connect() {
    $host = DB_HOST;
    $user = DB_USER;
    $pass = DB_PASSWORD;
    $database = DB_NAME;

    $options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => FALSE,
    ];
    return new PDO("mysql:host=$host;dbname=$database", $user, $pass, $options);
  }

  public function errorMsg($messagerror = NULL) {
    switch ($messagerror) {
      case 'wrong':
        if ($this->language == '') {
          $_SESSION['message'] = 'Wrong password or name. Please, try again!';
        }
        elseif ($this->language == 'ru') {
          $_SESSION['message'] = 'Неправильный пароль или имя. Пожалуйста, повторите еще!';
        }
        break;
      case 'format_email':
        if ($this->language == '') {
          $_SESSION['message'] = 'Sorry, invalid email format!';
        }
        elseif ($this->language == 'ru') {
          $_SESSION['message'] = 'Извините, неправильный формат почты';
        }
        break;
      case 'has':
        if ($this->language == '') {
          $_SESSION['message'] = 'Such user is registered. Please, try log in or change the name!';
        }
        elseif ($this->language == 'ru') {
          $_SESSION['message'] = 'Такой пользователь зарегистрирован. Пожалуйста, попробуйте войти или измените имя!';
        }
        break;
      case 'img_has':
        if ($this->language == '') {
          $_SESSION['message'] = 'Sorry, the image with the same name already exists!';
        }
        elseif ($this->language == 'ru') {
          $_SESSION['message'] = 'Извините, картинка с таким именем уже есть!';
        }
        break;
      case 'big_size':
        if ($this->language == '') {
          $_SESSION['message'] = 'Sorry, your image is too large!';
        }
        elseif ($this->language == 'ru') {
          $_SESSION['message'] = 'Извините, картинка имеет большой размер!';
        }
        break;
      case 'type_img':
        if ($this->language == '') {
          $_SESSION['message'] = 'Sorry, only JPG, PNG & GIF files are allowed!';
        }
        elseif ($this->language == 'ru') {
          $_SESSION['message'] = 'Извините, только картинки с расширением JPG, PNG и GIF !';
        }
        break;
      default:
        if ($this->language == '') {
          $_SESSION['message'] = 'Bad Request. Please, try again!';
        }
        elseif ($this->language == 'ru') {
          $_SESSION['message'] = 'Получен некорректный запрос. Пожалуйста, повторите еще раз!';
        }
    }
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
  }

  public function give($user) {
    //$user['password'] = password_needs_rehash ($user['password'], PASSWORD_DEFAULT);
    $_SESSION['datauser'] = $user;

    header('Location: ../profile.php');
    exit;
  }

}

$checkUser = new UserAction();