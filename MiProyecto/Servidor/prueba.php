<?php
//$var1="Adios";
//$var2="PHP";
//$fileContent = $var1 . "-" . $var2;
//$fileSave= file_put_contents("texto1.txt", $fileContent); 


$fileStr = file_get_contents("texto1.txt");
$pos1 = strpos($fileStr,"-");
echo $pos1 . "<br>";
$var1=substr($fileStr,0, $pos1); 
echo $var1 . "<br>";
$var2=substr($fileStr, 6, 3);
echo $var2 . "<br>";
$var3=substr($fileStr, 10,10);
echo $var3
?>