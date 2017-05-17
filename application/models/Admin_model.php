<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_model extends CI_model
{
    public function __construct()
    {
        $this->file_path    = "/home/epubweb/ftp/titanbooks/";
        $this->img_url_path = "http://ebook.eduniety.net/ftp/titanbooks/";

        $this->admin_dao = edu_get_instance('admin_dao', 'model');
    }

    public function getBookCount($sSDate, $sEDate)
    {
        if(!$sSDate || !$sEDate) return false;

        $aInput = array('sDate'=>$sSDate."000000",'eDate'=>$sEDate."235959") ;
        return $this->admin_dao->getBookCount($aInput);
    }
    public function getBookCountMeta($sSDate, $sEDate)
    {
        if(!$sSDate || !$sEDate) return false;

        $aInput = array('sDate'=>$sSDate."000000",'eDate'=>$sEDate."235959") ;
        return $this->admin_dao->getBookCountMeta($aInput);
    }
    public function getAws()
    {
        $aInput = array('account'=>'1') ;
        return $this->admin_dao->getAws($aInput);
    }
}
