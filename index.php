<?php
  require_once "./config/constant.php";
  require_once "./config/db.php";
  Database::initialize();

  $request = $_SERVER["REQUEST_URI"];

  switch ($request) {
    case "/":
      require VIEW."/home.php";
      break;
    case "/statistic/":
      require VIEW."/statistic.php";
      break;
    default:
      http_response_code(404);
      require VIEW."/404.php";
  }

  Database::close();
?>