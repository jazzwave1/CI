<?php
////////////////////////////////
// membership common function //
////////////////////////////////

/*
 * 세션이 틀어져서 사용않합
 * return user_id or false 
 * 
 * 기존 애듀니티의 로그인 세션 쿠키 등을 확인하여
 * 현재 로그인 되어 있는 아이디 혹은 false 값을
 * 리턴 해준다.
 * */
function isLogin()
{
    return false;

//  $mb_id = $_SESSION['ss_mb_id'] ;
//  if(!$mb_id) return false;
//  else return $mb_id;
//
//
//  // $mb_id = '63yunsuk'; // UserInfo true, MemberShipInfo false
//  // $mb_id = 'au0119';   // UserInfo true, MemberShipInfo true , 브론즈회원w 
//  $mb_id = 'anes0110'; // UserInfo true, MemberShipInfo True , 중복구매회원 ( 중복구매 효력이 남아 있음 )
//  $mb_id = '01089293774';// UserInfo true, MemberShipInfo True , 단일구매회원  
//  return $mb_id;
}

/*
 * SSO 를 통해서 해당 fdesk 의 member_no 를 가지고 와야함
 * */
function getFdeskMemberNO($mb_id)
{
    if(!$mb_id) return false;

    $mem = cc_get_instance('MemClass');
    $oMemInfo = new $mem($mb_id); 

    print_r($oMemInfo);
}
?>
