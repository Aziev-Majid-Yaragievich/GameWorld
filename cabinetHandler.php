<?php

session_start();

$db = new mysqli('localhost', 'root', '', 'daisy');
$db->set_charset("utf8");

if (!isset($_SESSION["userId"]) || !isset($_POST["level"])) {
    exit;    
}

$q = $db->query("SELECT * FROM USERS WHERE ID = " . $_SESSION["userId"] . ";");
$a = $q->fetch_assoc();
$prevLevel = $a['LEVEL'];

$level = $_POST["level"];
$regdate = $_POST["regyear"] . "-" . $_POST["regmonth"] . "-" . $_POST["regday"] . "T" . explode("T", $a['REGDATE'])[1];

$level = strval($level);


$db->query("UPDATE USERS SET LEVEL = '" . $level . "' WHERE ID = " . $_SESSION["userId"] . ";");
$db->query("UPDATE USERS SET REGDATE = '" . $regdate . "' WHERE ID = " . $_SESSION["userId"] . ";");

$res = "ОК, данные обновлены!";

echo $res;