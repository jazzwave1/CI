<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'models/Common_dao.php');

class Friend_dao extends Common_dao
{
    public function __construct()
    {
        // test code dev setting 
        $this->friend_db = $this->load->database('dev_membership', true);
        
        $aQueryInfo = edu_get_config('query', 'query');  
        $this->queryInfoFriend = $aQueryInfo['friend'];  
    }

    public function getFriendList($mb_id, $type='ADD')
    {
        $aInput = array('mb_id'=>$mb_id, 'action'=>$type); 
        $aConfig = $this->queryInfoFriend['getFriendList'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->friend_db);
    }
    public function setFriend($mb_id, $friend_id)
    {
        $aInput = array(
             'mb_id'     => $mb_id
            ,'friend_id' => $friend_id
            ,'action'    => 'ADD'
            ,'regdate'   => date('Y-m-d H:i:s')
        ); 
        $aConfig = $this->queryInfoFriend['setFriend'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->friend_db);
    }
    public function deleteFriend($mb_id, $friend_id)
    {
        $aInput = array(
             'mb_id'     => $mb_id
            ,'friend_id' => $friend_id
            ,'action'    => 'DEL'
            ,'regdate'   => date('Y-m-d H:i:s')
        ); 
        $aConfig = $this->queryInfoFriend['deleteFriend'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->friend_db);
    }
}
