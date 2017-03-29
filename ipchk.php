<?php
// 8층 
$aEdunietyIP_8 = array('1.220.133.75');

// 4층 wifi 
$aEdunietyIP = array('115.95.131.188');
// 4층 lan 
$aEdunietyIPS = array('112.216.251');  // 112.216.251.* ==> 112.216.251 이렇게 표기

// 210.178.92.195

$_SERVER['REMOTE_ADDR'] = "112.216.251.4";


echo "내 아이피 : ".$_SERVER['REMOTE_ADDR']. "<br>";

echo "<br>";

if(in_array($_SERVER['REMOTE_ADDR'], $aEdunietyIP))
{
    echo "4층 유선 OK<br>";
    die;
}
if(in_array($_SERVER['REMOTE_ADDR'], $aEdunietyIP_8))
{
    echo "8층 유선 OK<br>";
    die;
}

$bRtn = false;
foreach($aEdunietyIPS as $val)
{
    if(strstr($_SERVER['REMOTE_ADDR'], $val))
    {
        $bRtn = true;
        break;
    };

}
if($bRtn)
    echo "4층 와이파이 OK<br>";
else
    echo "앙대~~~<br>";

?>
