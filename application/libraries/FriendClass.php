<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class FriendClass {

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

        $this->FriendList = $this->getFriendList();
    }
    
    public function getFriendList()
    {
        $oFriModel = edu_get_instance('friend_model', 'model');
        return $oFriModel->friend_model->getFriendList($this->mb_id);
    }

    /*
     * return code 
     * 1 : true
     * 0 : false
     * 101 : 친구존재 
     * */ 
    public function setFriend($friend_id)
    {
        if( !$this->chkFriendID($friend_id) )
        {
            $oFriModel = edu_get_instance('friend_model', 'model');
            if( $oFriModel->friend_model->setFriend($this->mb_id, $friend_id) )
                return "1";
            else 
                return "0";
        }
        
        return "101";
    }
    public function deleteFriend($friend_id)
    {
        $oFriModel = edu_get_instance('friend_model', 'model');
        return $oFriModel->friend_model->deleteFriend($this->mb_id, $friend_id);
    }
    public function chkFriendID($friend_id)
    {
        $bRtn = false;

        if(isset($this->FriendList))
        {
            foreach($this->FriendList as $key=>$val)
            {
                if($val->friend_id == $friend_id)
                {
                    $bRtn = true;
                    break;
                } 
            }
        }
        return $bRtn;
    }

}
