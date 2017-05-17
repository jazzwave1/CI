<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'models/Common_dao.php');

class Admin_dao extends Common_dao
{
    public function __construct()
    {
        $this->ebook_db = $this->load->database('ebook', true);
        $this->aws_db   = $this->load->database('dev_aws', true);
        $aQueryInfo = edu_get_config('query', 'query');
        $this->queryInfoAdmin = $aQueryInfo['admin'];
    }
    public function getBookCount($aParam)
    {
        $aConfig = $this->queryInfoAdmin['getBookCount'];
        return $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
    }
    public function getBookCountMeta($aParam)
    {
        $aConfig = $this->queryInfoAdmin['getBookCountMeta'];
        return $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
    }
    
    public function getAws($aParam)
    {
        $aConfig = $this->queryInfoAdmin['getAws'];
        print_r( $this->actModelFucFromDB($aConfig, $aParam, $this->aws_db) ) ;
        //return $this->actModelFucFromDB($aConfig, $aParam, $this->aws_db) ;
    }
}
