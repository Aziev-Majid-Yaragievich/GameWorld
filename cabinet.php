<?php
    session_start();
    
    if (!isset($_SESSION["userId"])) {
        header("Location: /");
        exit;
    }
    
$db = new mysqli('localhost', 'root', '', 'daisy');
$db->set_charset("utf8");


$q = $db->query("SELECT * FROM USERS WHERE ID = " . $_SESSION["userId"] . ";");
$a = $q->fetch_assoc();

$level = $a['LEVEL'];

$dat = explode("T", $a['REGDATE'])[0];
$date = explode("-", $dat);
$regday = $date[2];
$regmonth = $date[1];
$regyear = $date[0];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
	<title>Типа кабинет - DaisyDale</title>
  <link rel="icon" type="image/png" href="/favicon.png" />
	<link rel="stylesheet" type="text/css" href="/style.css">
</head>
<body>
    <h1>Типа кабинет</h1>
    <div class="message"></div>
    
    <form>
        <p>Лвл: <input name="level" value="<?php echo $level; ?>" /></p>
        <p>Дата: <input name="regday"  value="<?php echo $regday; ?>"/>.<input name="regmonth"  value="<?php echo $regmonth; ?>"/>.<input name="regyear"  value="<?php echo $regyear; ?>"/></p>
        <button type="submit">Отправить</button>
    </form>
    <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
    <script src="/cabinet.js"></script>
</body>
</html>
