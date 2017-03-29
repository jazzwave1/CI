<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Friend_model extends CI_model
{
    public function __construct()
    {
        $this->member_dao = edu_get_instance('member_dao', 'model'); 
        $this->friend_dao = edu_get_instance('friend_dao', 'model'); 
        $this->today = date('Y-m-d H:i:s');
    }
    
    public function getFriendList($mb_id)
    {
        if(!$mb_id) return false;
        return $this->friend_dao->getFriendList($mb_id); 
    }
    public function setFriend($mb_id, $friend_id)
    {
        if(!$mb_id || !$friend_id) return false;
        return $this->friend_dao->setFriend($mb_id, $friend_id); 
    }
    public function deleteFriend($mb_id, $friend_id)
    {
        if(!$mb_id || !$friend_id) return false;
        return $this->friend_dao->deleteFriend($mb_id, $friend_id); 
    }
}
