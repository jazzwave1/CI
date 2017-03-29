<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MemClass {

    public function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i))
        {
        call_user_func_array(array($this,$f),$a);
        }
    }
    public function  __construct1($mb_id)
    {
        if(!$mb_id) return false;
        
        $this->mb_id = $mb_id;

        $this->oUserInfo = $this->_getUserInfo($this->mb_id);
        $this->oSSOInfo  = $this->_getSSOInfo($this->mb_id);
    }

    public function index()
    {
    }
    private function _getUserInfo($mb_id)
    {
        $oMemModel = edu_get_instance('member_model', 'model');
        return $oMemModel->member_model->getUserInfo($mb_id);
    }
    private function _setTMemberInfo($name, $email)
    {
        if(!$name || !$email) return false;

        $oBookDAO = edu_get_instance('Book_dao', 'model');
        return $oBookDAO->setShopMember($name, $email);
    }
    private function _getTMemberInfo($email)
    {
        if(!$email) return false;
        
        $oBookDAO = edu_get_instance('Book_dao', 'model');
        return $oBookDAO->getShopMemberEmail($email);
    }
    private function _getSSOInfo($mb_id)
    {
        if(!$mb_id) return false;

        $oMemModel = edu_get_instance('member_model', 'model');
        $oMemSSOInfo = $oMemModel->member_model->getSSOInfo(trim($mb_id));

        // if null SSO Info 
        if(!$oMemSSOInfo)
        {
            // get eduniety member info
            $oEMemInfo = $this->_getUserInfo($mb_id);
            
            // get titanbook member info 
            $oTMemInfo = $this->_getTMemberInfo($oEMemInfo->mb_email); 

            if(!$oTMemInfo->member_no)
            {
                // set titanbook member info 
                $this->_setTMemberInfo($oEMemInfo->mb_name, $oEMemInfo->mb_email);
                // get titanbook member info 
                $oTMemInfo = $this->_getTMemberInfo($oEMemInfo->mb_email); 
            }    
            // set SSO info
            $t_id   = trim($oEMemInfo->mb_email);
            $t_name = trim($oEMemInfo->mb_name);
            $t_usn  = trim($oTMemInfo->member_no);
            $e_id   = trim($oEMemInfo->mb_id);
            $e_name = trim($oEMemInfo->mb_name);
            
            $oMemModel->setSSOInfo($t_id, $t_name, $t_usn, $e_id, $e_name);
            
            // get Info
            $oMemSSOInfo = $oMemModel->member_model->getSSOInfo($mb_id);
        }

        return $oMemSSOInfo; 
    }
}
