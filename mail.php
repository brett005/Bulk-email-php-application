<?php

$connect = new PDO("mysql:host=localhost;dbname=hebnicin_mail", "hebnicin_plag", "wp75VT37oz");
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$query2 = "select * from count where id = 1";
$statement2 = $connect->prepare($query2);
$statement2->execute();
$result2 = $statement2->fetchAll();
foreach($result2 as $n){
$number = $n["count"];
}
echo "<center><h1><b>". $number."</b>&nbsp Emails has been sent successfully</h1></center>";

?>