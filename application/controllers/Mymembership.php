<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mymembership extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        session_start();
    
        $this->member_model = edu_get_instance('member_model', 'model'); 
    }

    // ####################################### //
    // ########## web Page Function ########## //
    // ####################################### //
    public function index()
    {
        $this->main();
    }
    public function main()
    {
        if( $mb_id = $this->_isLogin() )
        {
            $oMemberInfo       = $this->member_model->getUserInfo($mb_id); 
            $aMemberSVCInfo    = $this->member_model->getMemsvcInfo($mb_id); 
            $aMemberLoginInfo  = $this->member_model->getLoginHistory($mb_id); 
            $aMemberTraingInfo = $this->member_model->getMembershipDeshboardInfo($mb_id); 

            if(!$aMemberSVCInfo) 
            {
                $sLoginURL = "/";
                echo "<script>alert('멤버십회원 전용 공간입니다.');window.location.href=' ".$sLoginURL."'</script>";
            }
            else
            {
                echo "<!--";  
                //print_r($oMemberInfo);
                //print_r($aMemberSVCInfo);
                //print_r($aMemberLoginInfo);
                //print_r($aMemberTraingInfo);
                echo "-->";  
                $data = array();
                $Mymembership = array(
                     'oMemberInfo'    => $oMemberInfo
                    ,'aMemberSVCInfo' => $aMemberSVCInfo
                    ,'oMemberLoginInfo' => $aMemberLoginInfo[0]
                    ,'aMemberTraingInfo' => $aMemberTraingInfo
                );
                $data['contents'] = $this->load->view('mymembership/member_main',$Mymembership,true) ;
                $this->load->view('mymembership/membership_out', $data);
            }            
        }
        else
        {
            $sLoginURL = "/sub/PORTAL/MEMBER_login.php?url=/";
            echo "<script>alert('로그인이 필요합니다.');window.location.href=' ".$sLoginURL."'</script>";
        }
    }
    private function _isLogin()
    {
        // test code
        // return $mb_id = 'ahnjaejo';
        // return $mb_id = 'au0119';

        $mb_id = '';
        if(count($_SESSION)>0) 
        {
            if(empty($_SESSION['ss_mb_id']))
                return false;    
 
            $mb_id = $_SESSION['ss_mb_id'] ;
            echo "<!--";
            //print_r($_SESSION); 
            echo "-->";
            return $mb_id;
        }
        return false;
    }

    public function mypage()
    {
        if(!$mb_id = $this->_isLogin() )
        {
            
        }

    } 
}
