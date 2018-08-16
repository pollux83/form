<?php

class Session {

  function __construct() {
    session_start();
    // Create a new CSRF token.
    if (!isset($_SESSION['csrf_token'])) {
      $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
    }
  }

  public function mark($lang) {
    $_SESSION['lang'] = $lang;
  }

  public function close_user_session($lang) {
    if ($lang == 'en') {
      $lang = '';
    }
    session_destroy();
    header('location: index' . $lang . '.php');
  }

}