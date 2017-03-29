<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'models/Common_dao.php');

class Mypage_dao extends Common_dao
{
    public function __construct()
    {
        $this->load->database('membership');
        $this->ebook_db = $this->load->database('ebook', true);
        $aQueryInfo = edu_get_config('query', 'query');  
        $this->queryInfoMypage = $aQueryInfo['mypage'];  
    }
    
    public function getADETraining($year)
    {
        $aParam = array(
            'isonoff' => 'on'
            ,'hakjum' => '2'
            ,'isuse'  => 'Y'
            ,'yunsugubun' => '012101'
            ,'grcode' => 'N000001'
            ,'isvisible' => 'Y'
            ,'year' => $year
            ,'txgisu1' => 1
            ,'txgisu2' => 2
        );
        $aConfig = $this->queryInfoMypage['getADETraining'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function getADTraining($year)
    {
        $aYunsugubun = array('012103','012104');
        $btype = 's';
        $query = 
            'SELECT q.subjnm, q.subj, q.year, q.subjseq, q.txgisu, q.propstart, q.propend, q.edustart, q.eduend, q.biyong_notmembership  
               FROM lms_subj s, lms_subjseq q  
              WHERE s.subj=q.subj  
                AND s.isonoff=? 
                AND s.isuse = ? 
                AND q.grcode = ?  
                AND q.isvisible = ? 
                AND q.year= ? 
                AND s.yunsugubun in (';
        
        foreach($aYunsugubun as $val)
        {
            $query .= '?,' ;
            $btype .= "i";
        }
        $query = substr($query, 0, -1);
        $query .= ') ORDER BY convert( q.txgisu, unsigned )';

        $aParam = array( 'off', 'Y', 'N000002', 'Y', $year );
        $aInputData = array_merge($aParam, $aYunsugubun); 

        //print_r($query); 
        //print_r($btype); 
        //print_r($aInputData); 

        $oResult = $this->db->query($query, $aInputData, true, $btype);
        return $oResult->result();
    }
    public function getAllTraining($userid)
    {
        $aParam = array( 'userid'=> $userid );
        $aConfig = $this->queryInfoMypage['getAllTraining'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function getEndTraining($userid)
    {
        $aParam = array( 'userid'=> $userid );
        $aConfig = $this->queryInfoMypage['getEndTraining'];
        return $this->actModelFuc($aConfig, $aParam);
    }
    public function getNewContentInfo()
    {
        // 7일 전 최근에 올라온 데이터들을 가지고 온다 
        $aParam = array( 'is_use'=> 'Y', 'getDate'=>7);
        $aConfig = $this->queryInfoMypage['getNewContentInfo'];
        return $this->actModelFuc($aConfig, $aParam);
    }

    public function getTest()
    {
        $aParam = array('admin_list'=>1);
        $aConfig = $this->queryInfoMypage['getTest'];
        print_r( $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) );

        //$query ='select * from admin_login where admin_list >=?'; 
        //$oResult = $this->ebook_db->query($query);
        //print_r($oResult->result()); 

    }
}
