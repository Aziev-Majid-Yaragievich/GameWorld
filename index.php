<?php

session_start();


if (isset($_SESSION["userId"])) {
    header("Location: /game.php");    
}

function generateTicket() {
    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


$db = new mysqli('localhost', 'root', '', 'daisy');
$db->set_charset("utf8_general_ci");

if (isset($_POST["username"]) && isset($_POST["password"])) {
  $a = $db->query("SELECT ID, PASSWORD, ROLEFLAGS FROM USERS WHERE USERNAME = '" . $_POST['username'] . "';");
  if ($a->num_rows == 0) {
    $error = "Нет такого смешарика";
  } else {
    $fetched = $a->fetch_assoc();
    
    if (password_verify(md5($_POST["password"]), $fetched['PASSWORD'])) {
      $token = generateTicket();
      $db->query("UPDATE USERS SET TICKET = '" . $token . "' WHERE USERNAME = '" . $_POST["username"] . "';");
      $_SESSION["userId"] = $fetched["ID"];
      $_SESSION["ticket"] = $token;
      $_SESSION["roleflags"] = $fetched["ROLEFLAGS"];
      header("Location: /");
    } else {
      $error = "Неправильный пароль.";
    }
  } 
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>Вход - DaisyDale</title>
	<link rel="stylesheet" type="text/css" href="/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<h1><a href="https://vk.com/gikior">Компания создавшея сайт</a></h1>
<h1><a href="https://vk.com/morkovo4kakrosha">Наш вк</a></h1>
	<center><h1>Открытие!Заходи!</h1></center>
	<div class="loginbox">
	<form action='' method='POST'>
                <p class="message"><?php if (isset($error)) { echo $error; } ?></p>
				        <h1>Вход</h1>
                <input name='username'  placeholder='Логин' /><br/>
                <input name='password' type='password' placeholder='Пароль'  /><br/>
                <br/>
                <button class='meow-btn' type='submit' name='btnLogin'> Войти </button>  <a class='meow-btn' style='background:#ff8787; text-decoration: none;' href='/register.php' name='btnReg'> Создать аккаунт </button>  <a/>
      </form>
      </div>
</body>
</html>
l