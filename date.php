<?php

 
$date = date('Y F');
echo $date;
echo "<br/>";
echo gettype($date);


echo strtotime($date);
echo "<hr/>";
echo date(date("Y-m-d H:i:s", strtotime($date)));

?>