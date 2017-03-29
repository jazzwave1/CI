<?php
function edu_get_instance($sClassName, $sType='library')
{
    $CI = & get_instance();

    $nLastPost = strrpos($sClassName, '/');
    if($nLastPost !== false)
        $sVarName = substr($sClassName, $nLastPost + 1 );
    else
        $sVarName = $sClassName;

    if($sType == 'model')
        $sCiValName = $sVarName;
    else
        $sCiValName = strtolower($sVarName);

    if(!isset($CI->{$sCiValName}))
    {
        $CI->load->{$sType}($sClassName);
    }

    return $CI->{$sCiValName};
}
function edu_get_config($sKey, $sFileName, $bUsePart=true)
{
    $CI = & get_instance();
    $CI->config->load($sFileName, $bUsePart);

    if($bUsePart)
        return $CI->config->item($sKey, $sFileName);
    else
        return $CI->config->item($sKey);
}
function response_json($aRtn)
{
    $res = "";

    if(is_array($aRtn))
        $res = json_encode($aRtn);
    elseif(is_array(json_encode($aRtn)))
        $res = $aRtn;

    if($res == '') return;

    header('Content-type: text/json');
    header('Content-type: application/json');
    echo $res;
}
function getCookieInfo()
{
    $CI = & get_instance();
    $CI->load->helper('cookie');
    return  get_cookie('codingclub_MemberInfo');
}
function setDateFormat($sDate, $type)
{
    if(!$sDate) return '-';

    switch($type)
    {
        case 'YMD':
            $result = substr($sDate, 0, 4). "년 ". substr($sDate, 5, 2). "월 ". substr($sDate, 8, 2). "일 ";
            break;
        case 'Y-M-D':
            $result = substr($sDate, 0, 4). "-". substr($sDate, 4, 2). "-". substr($sDate, 6, 2);
            break;
    }
    return $result;
}
?>
