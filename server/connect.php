<?
$link=mysqli_connect("database", "root", "tiger")
	or die ("Ошибка подключения к базе данных");
mysqli_set_charset($link, "utf8mb4");
mysqli_select_db($link,"docker");
?>