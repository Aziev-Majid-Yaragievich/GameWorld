
<?php

session_start();

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
  if (preg_match("/[^a-z,A-Z,0-9,а-я,А-Я,\-,\_]/u", $_POST["username"])) { 
    $error = "Ваш логин содержит недопустимые символы.";
  } else {
    if (strlen($_POST["username"]) < 3 ) {
        $error = "Короткий логин";
    }  else if (strlen($_POST["username"]) > 40) {
        $error = "Длинный логин";
      } else {
      if (strlen($_POST["password"]) < 6) {
        $error = "Короткий пароль";
      } else {
        $c = $db->query("SELECT * FROM USERS WHERE USERNAME = '" . $_POST["username"] . "';");

        if ($c->num_rows == 0) {
          $ava = "IsBodyPart>true|BodyPartTypeId>5|MediaResourceID>67|LayerID>25|BodyPartId>30|Id>30|Color>NaN;IsBodyPart>true|BodyPartTypeId>6|MediaResourceID>68|LayerID>39|BodyPartId>31|Id>31|Color>16762375;IsBodyPart>true|BodyPartTypeId>7|MediaResourceID>74|LayerID>29|BodyPartId>40|Id>40|Color>NaN;IsBodyPart>true|BodyPartTypeId>8|MediaResourceID>98|LayerID>49|BodyPartId>73|Id>73|Color>NaN;IsBodyPart>true|BodyPartTypeId>2|MediaResourceID>55|LayerID>9|BodyPartId>1|Id>1|Color>NaN;IsBodyPart>true|BodyPartTypeId>3|MediaResourceID>56|LayerID>19|BodyPartId>2|Id>2|Color>16762375;IsBodyPart>false|GoodID>8712|MediaResourceID>27527|GoodTypeID>4|LayerID>45|Id>8712;IsBodyPart>false|GoodID>9235|MediaResourceID>29235|GoodTypeID>94|LayerID>57|Id>9235";
          $inv = "";
          $hash = password_hash(md5($_POST["password"]), PASSWORD_DEFAULT);
          $date = date("Y-m-d") . "T" . date("H-m-s") . ".0";
          $ticket = generateTicket();
          $qwery = $db->query("INSERT INTO `USERS`(`USERNAME`, `PASSWORD`, `ROLEFLAGS`, `LEVEL`, `AVATAR`, `TICKET`, `INVENTORY`, `REGDATE`) VALUES ('" . $_POST["username"] . "', '" . $hash . "', 131086 ,  999, '" . $ava . "', '" . $ticket . "',  '" . $inv . "', '" . $date . "');");
          if (!$qwery) { 
             echo $db->error;
             exit;   
          }
          $_SESSION["ticket"] = $ticket;
          $_SESSION["roleflags"] = 131086;
          $_SESSION["userId"] = $id;
          header("Location: /");
        } else {
          $error = "Смешарик с таким ником уже существует.";
        }
      }
    }
  }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>Создать аккаунт - DaisyDale</title>
  <link rel="icon" type="image/png" href="/favicon.png" />
	<link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>
	<div class="loginbox">
	<img class="logo" src="/logo.png">
	<form action='' method='POST'>
                <p class="message"><?php if (isset($error)) { echo $error; } ?></p>

                <h1>Регистрация</h1>

                <input name='username'  placeholder='Логин' /><br/>
                <input name='password' type='password' placeholder='Пароль'  /><br/>
                <br/>
                <button class='meow-btn' type='submit' name='btnLogin'> ОК </button> <a href='/' class='meow-btn' style='text-decoration:none;background:#ff8787;'> Назад </a> <br/>
      </form>
      </div>

</body>
</html>
