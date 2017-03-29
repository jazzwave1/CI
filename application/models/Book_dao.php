<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'models/Common_dao.php');

class Book_dao extends Common_dao
{
    public function __construct()
    {
        $this->ebook_db = $this->load->database('ebook', true);
        $aQueryInfo = edu_get_config('query', 'query');  
        $this->queryInfoEBook = $aQueryInfo['eBook'];  
    }
    public function getBookList()
    {
        $aParam = array('g_num'=>1);
        $aConfig = $this->queryInfoEBook['getBookList'];
        return $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
    }
    public function getBestBook()
    {
        $aParam = array('sDate'=>date('Y-m-d'), 'eDate'=>date('Y-m-d'));
        $aConfig = $this->queryInfoEBook['getBestBook'];
        return $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
    }
    public function getNewBook()
    {
        $aParam = array('sDate'=>date('Y-m-d'), 'eDate'=>date('Y-m-d'));
        $aConfig = $this->queryInfoEBook['getNewBook'];
        return $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
    }
    public function getBookListFromCategory($gc_num)
    {
        $aParam = array('sDate'=>date('Y-m-d'), 'eDate'=>date('Y-m-d'), 'gc_num'=>$gc_num);
        $aConfig = $this->queryInfoEBook['getBookListFromCategory'];
        return $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
    }
    public function getBookImgInfo($aParam)
    {
        $aConfig = $this->queryInfoEBook['getBookImgInfo'];
        $aRtn = $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
        return $aRtn[0];
    }
    public function getBookDetailInfo($aParam)
    {
        $aConfig = $this->queryInfoEBook['getBookDetailInfo'];
        $aRtn = $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
        return $aRtn[0];
    }
    public function getBookDetailInfo_Content($aParam)
    {
        $aConfig = $this->queryInfoEBook['getBookDetailInfo_Content'];
        $aRtn = $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
        return $aRtn[0];
    }
    public function getMyBookList($member_no)
    {
        $aInput = array('member_no' => $member_no);
        $aConfig = $this->queryInfoEBook['getMyBookList'];
        $aRtn = $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
        return $aRtn;
    }
    public function getShopMember($member_no)
    {
        $aInput = array('member_no' => $member_no);
        $aConfig = $this->queryInfoEBook['getShopMember'];
        $aRtn = $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
        return $aRtn[0];
    }
    public function getShopMemberEmail($email)
    {
        $aInput = array('email' => $email);
        $aConfig = $this->queryInfoEBook['getShopMemberEmail'];
        $aRtn = $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
        return $aRtn[0];
    }
    public function setShopMember($name, $email)
    {
        if(!$name || !$email) return false;

        $aInput = array(
            'name' => $name
            ,'password' => '*E2176AF6A957076792D06B414619BFCC7A353D64'  // DB : password('eduniety_sso') 
            ,'email' => $email
            ,'cyber_point' => '0' 
            ,'is_issue' => 'y' // 본인확인 및 살아있는 아이디의 경우 y
            ,'login_str' => 'eduniety_sso' // real pwd // 이거만든놈을 찾고 있다.. 쩝..  
            ,'reg_date' => date('Y-m-d H:i:s') 
        );
        $aConfig = $this->queryInfoEBook['setShopMember'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db);
    }
    public function delMyBookInfo($list_no, $g_num, $member_no)
    {
        if(!$member_no ||  !$g_num || !$list_no) return false;

        $aInput = array(
            'member_no' => $member_no
            ,'list_no'  => $list_no
            ,'g_num'    => $g_num             
        );
        $aConfig = $this->queryInfoEBook['updateShopOrderList'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db);
    }
}
