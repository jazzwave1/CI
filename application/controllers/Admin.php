<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class admin extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->admin_model= edu_get_instance('admin_model','model');

    $this->aMenu = array(/*{{{*/
      array( 
         'title' => '검색 & DashBoard'
        ,'title_class'=> 'fa fa-search' 
        ,'active'=> true
        ,'child' => array( 
           array('link' => HOSTURL.'/admin/eBookDashboard', 'title' => 'DashBoard')
          //,array('link' => HOSTURL.'/admin/userlist', 'title' => '프로그램별 검색')
        )
      )
      /*
      ,array( 
         'title' => '프로그램관리'
        ,'title_class'=> 'fa fa-list' 
        ,'active'=> false
        ,'child' => array( 
           array('link' => HOSTURL.'/admin/courselist', 'title' => '프로그램 리스트')
        )
      )
      ,array( 
         'title' => '다운로드'
        ,'title_class'=> 'fa fa-download' 
        ,'active'=> false
        ,'child' => array( 
           array('link' => HOSTURL.'/admin/filedown', 'title' => '16년 가을학기')
        )

      )
      */
    );  /*}}}*/
  }
  public function test()
  {
      echo "<pre>";
      $this->admin_model->getAws() ;
      //$this->load->view('admin/table_test.php');
  }
  public function index()/*{{{*/
  {
    $this->userlist();
//  빈공간 
//  $aMenu = array('aMenu'=>$this->aMenu);
//  $aContentHeader= array( 
//     'bTitle' => 'Dashboard'
//    ,'sTitle' => 'Control panel'
//    ,'navi'   => array('Home', 'Dashboard')
//  );
//  $temp = "";
//
//  $data = array(
//     'menu'   => $this->load->view('admin/menu', $aMenu , true)
//    ,'content_header' => $this->load->view('admin/content_header', $aContentHeader , true)
//    , 'main_content' => ''  
//    ,'footer' => $this->load->view('admin/footer', $temp, true)
//  );
//  
//  $this->load->view('admin/layout', $data);  
  }/*}}}*/
  public function login()/*{{{*/
  { 
    $data = array();
    $this->load->view('admin/adminlogin', $data);  
  }/*}}}*/
  public function logout()/*{{{*/
  {
    $this->load->helper('cookie');
    
    delete_cookie("AdminInfo",'.codingclubs.org', '/', 'codingclub_');      
    header('Location: http://codingclubs.org'); 
   
    // test code
    //delete_cookie("AdminInfo",'localhost', '/', 'codingclub_');      
    //header('Location: http://localhost/~leehojun/CC/codingclub/admin/login'); 
  }/*}}}*/
  public function chkCookie()/*{{{*/
  {
    $this->load->helper('cookie');
    $oAdminInfo = json_decode( get_cookie('codingclub_AdminInfo') );
 
    if(!$oAdminInfo)
    {
      echo "로그인이 필요한 서비스 입니다.<br>"; 
      echo '<a href="'.HOSTURL.'/admin/login" >Admin Login</a>'; 
      die;
    }
  }/*}}}*/

    public function eBookDashboard2($sSDate='' , $sEDate='')
    {

        $sSearchDate = "";

        if(!$sSDate || !$sEDate)
        {
            $aBookCountInfo = array();
            $aBookCountMetaInfo = array();
        }
        else
        {
            $sSDateY  = substr($sSDate, 4);
            $sSDateMD = substr($sSDate, 0,4);
            $sSDate = $sSDateY.$sSDateMD;

            $sEDateY  = substr($sEDate, 4);
            $sEDateMD = substr($sEDate, 0,4);
            $sEDate = $sEDateY.$sEDateMD;

            $sSearchDate = substr($sSDateMD, 0,2)."/".substr($sSDateMD, 2,2)."/".$sSDateY." - ".substr($sEDateMD, 0,2)."/".substr($sEDateMD, 2,2)."/".$sEDateY;

            $aBookCountInfo = $this->admin_model->getBookCount($sSDate, $sEDate);
            $aBookCountMetaInfo = $this->admin_model->getBookCountMeta($sSDate, $sEDate);
        }



        $this->load->view('admin/ebook_dashboard', array("aBookCountInfo"=>$aBookCountInfo ,"sSearchDate"=>$sSearchDate, "aBookCountMetaInfo" => $aBookCountMetaInfo));



    }
  
  public function eBookDashboard($sSDate='' , $sEDate='')
  {
    $aMenu = $this->_setMenuActive(0);

    $temp = "";
    $sSearchDate = "";

    if(!$sSDate || !$sEDate)
    {
        $aBookCountInfo = array();
        $aBookCountMetaInfo = array();
    }
    else
    {
      $sSDateY  = substr($sSDate, 4);
      $sSDateMD = substr($sSDate, 0,4);
      $sSDate = $sSDateY.$sSDateMD;

      $sEDateY  = substr($sEDate, 4);
      $sEDateMD = substr($sEDate, 0,4);
      $sEDate = $sEDateY.$sEDateMD;

      $sSearchDate = substr($sSDateMD, 0,2)."/".substr($sSDateMD, 2,2)."/".$sSDateY." - ".substr($sEDateMD, 0,2)."/".substr($sEDateMD, 2,2)."/".$sEDateY;

      $aBookCountInfo = $this->admin_model->getBookCount($sSDate, $sEDate);
      $aBookCountMetaInfo = $this->admin_model->getBookCountMeta($sSDate, $sEDate);
    }

    $aContentHeader= array(
        'bTitle' => 'eBook DashBoard '
        ,'sTitle' => '[ Tip : 팁입니다. ]'
        ,'navi'   => array('검색', 'DashBoard ')
    );

    $data = array(
        'menu'   => $this->load->view('admin/menu', $aMenu , true)
        ,'content_header' => $this->load->view('admin/content_header', $aContentHeader , true)
        ,'main_content' => $this->load->view('admin/ebook_dashboard', array("aBookCountInfo"=>$aBookCountInfo ,"sSearchDate"=>$sSearchDate, "aBookCountMetaInfo" => $aBookCountMetaInfo), true)
        ,'footer' => $this->load->view('admin/footer', $temp, true)
    );

    $this->load->view('admin/layout', $data);
  }

  public function userlist($courseIdx='')/*{{{*/
  {
    $this->chkCookie() ;
    
    $aMainData = array();
    $aMainData['aCourse']  = $this->admin_model->getCourse();
    $aMainData['courseName'] = '';
    $aMainData['aRowData'] = false;
    $aMainData['courseIdx']  = array();
   
    if($courseIdx)/*{{{*/
    {
      $courseIdx = substr($courseIdx , 0, -1);
      $aResult = $this->admin_model->getUserList($courseIdx) ; 
      
      $aCourseIdx = explode("_", $courseIdx);
      
      $sCourseName = '';
      foreach($aCourseIdx as $key=>$val)
      {
        $sCourseName .= $aMainData['aCourse'][$val]." , ";
      }
      
      $aMainData['courseName'] = $sCourseName;
      $aMainData['courseIdx']  = $aCourseIdx;
     
      if(!$aResult)
      {
        $aMainData['aRowData'] = false;
      }
      else
      {
        $aMainData['aRowData']   = $aResult;
      }
    }/*}}}*/
    
    $aMenu = $this->_setMenuActive(0);
    
    $aContentHeader= array( 
       'bTitle' => '강좌별검색 '
      ,'sTitle' => '[ Tip : 중복검색시 shift key를 누르고 선택하세요 ]' 
      ,'navi'   => array('검색', '프로그램별 검색')
    );
    $temp = "";
 
    $data = array(
       'menu'   => $this->load->view('admin/menu', $aMenu , true)
      ,'content_header' => $this->load->view('admin/content_header', $aContentHeader , true)
      ,'main_content' => $this->load->view('admin/admin', $aMainData, true) 
      ,'footer' => $this->load->view('admin/footer', $temp, true)
    );
    
    $this->load->view('admin/layout', $data);  
  }/*}}}*/
  public function usersearch($sParam='')/*{{{*/
  {
    $this->chkCookie() ;
    
    $sParam = trim($this->input->post('sAccountIDorName')); 
    // test code --------------------- //
    //$sParam = "jazzwave14@naver.com";
    //$sParam = urlencode($sParam); 
    
    //$sParam = "이지훈";
    // ------------------------------- // 
    $aUserInfo = array(); 
    $aMemberSVC = array(); 
    $notice = '';
   
    if($sParam)
    {
      if($this->_isEmailID($sParam))
      {
        // Email ID
        if( $aResult = $this->_getUserInfoFromEmailID($sParam) )
        { 
          $aUserInfo = $aResult; 
          $aMemberSVC = $this->_getMemberSVC($aUserInfo[0]->usn); 
        }
        else
        {
          $notice = '없는 정보 입니다.';
        }
      }
      else
      {
        // 이름
        if( $aResult = $this->_getUserInfoFromName($sParam) )
        { 
          $aUserInfo = $aResult; 
          foreach($aUserInfo as $key=>$val)
          {
            $result = $this->_getMemberSVC($val->usn); 
            array_push($aMemberSVC, $result);
          }
          foreach($aMemberSVC as $key=>$val)
          {
            foreach($val as $k=>$v)
            {
              $tmp[] = $v;
            }
          }
          $aMemberSVC = $tmp;
        }
        else
        {
          $notice = '없는 정보 입니다.';
        }
      }
    }

    $aMenu = $this->_setMenuActive(0);

    $aContentHeader= array( 
       'bTitle' => '유저검색 '
      ,'sTitle' => '[ Tip : Email ID 또는 학색이름을 입력하세요 ]' 
      ,'navi'   => array('검색', '유저검색')
    );

    $temp = "";
    $aMainData['userinfo']  = $aUserInfo;
    $aMainData['membersvc'] = $aMemberSVC;
    $aMainData['notice']    = $notice;
    $aMainData['sAccountIDorName'] = $sParam;

    $data = array(
       'menu'   => $this->load->view('admin/menu', $aMenu , true)
      ,'content_header' => $this->load->view('admin/content_header', $aContentHeader , true)
      ,'main_content' => $this->load->view('admin/usersearch', $aMainData, true) 
      ,'footer' => $this->load->view('admin/footer', $temp, true)
    );
    
    $this->load->view('admin/layout', $data);  

  }/*}}}*/
  public function courselist()/*{{{*/
  {
    $this->chkCookie() ;
    $aMainData = array();
    $aMainData['aRowData'] = $this->admin_model->getCourseList(); 
   
    $aMenu = $this->_setMenuActive(1);

    $aContentHeader= array( 
       'bTitle' => '프로그램 리스트'
      ,'sTitle' => '' 
      ,'navi'   => array('프로그램관리', '프로그램 리스트')
    );
    $temp = "";
 
    $data = array(
       'menu'   => $this->load->view('admin/menu', $aMenu , true)
      ,'content_header' => $this->load->view('admin/content_header', $aContentHeader , true)
      ,'main_content' => $this->load->view('admin/courselist', $aMainData, true) 
      ,'footer' => $this->load->view('admin/footer', $temp, true)
    );
    
    $this->load->view('admin/layout', $data);  
  }/*}}}*/
  
  public function rpcAdminLogin()/*{{{*/
  {
    $accountID = trim($this->input->post('account_id')); 
    $passwd    = trim($this->input->post('passwd')); 
    
    if(!$accountID || !$passwd)
      response_json(array("code"=>999,"msg"=>"input pwd fail"));
    
    if( $this->_chkAdminLogin($accountID,$passwd) )
      response_json(array("code"=>1,"msg"=>"OK"));
    else
      response_json(array("code"=>0,"msg"=>"Fail"));
  }/*}}}*/
  public function rpcUpdateState()/*{{{*/
  {
    $usn   = trim($this->input->post('usn')); 
    $state = trim($this->input->post('state')); 
    $courseIDX = trim($this->input->post('course_idx')); 
  
    if($this->_updateState($usn, $state, $courseIDX)) 
      response_json(array("code"=>1,"msg"=>"OK"));
    else
      response_json(array("code"=>0,"msg"=>"fail"));
    die; 
  }/*}}}*/
  public function rpcGetCourseInfo()/*{{{*/
  {
    $idx = trim($this->input->post('idx')); 
    
    if(!$idx) response_json(array('code'=>999,''=>'not input')); 
   
    $oCourseInfo = $this->_getCourseInfo($idx);
    response_json(array(
         'code'  => 1
        ,'msg'  => 'OK'
        ,'idx'  => $oCourseInfo->idx
        ,'name' => $oCourseInfo->name 
        ,'content'  => $oCourseInfo->content 
        ,'target'   => $oCourseInfo->target
        ,'schedule' => $oCourseInfo->schedule
        ,'need' => $oCourseInfo->need
        ,'recruit' => $oCourseInfo->recruit
        ,'location' => $oCourseInfo->location
        ,'sponsor' => $oCourseInfo->sponsor
        ,'content_long' => $oCourseInfo->content_long
        ,'target_long' => $oCourseInfo->target_long
        ,'guide_long' => $oCourseInfo->guide_long
        ,'pgroup' => $oCourseInfo->pgroup
        ,'active' => $oCourseInfo->active
        ,'sdate' => $oCourseInfo->sdate
        ,'edate' => $oCourseInfo->edate
        ,'sdateF' => $oCourseInfo->sdateF
        ,'edateF' => $oCourseInfo->edateF
      )
    );
    
    die;
  }/*}}}*/
  public function rpcUpdateCourseInfo()/*{{{*/
  {
    $aParam = array();
    $aParam['idx']      = trim($this->input->post('idx')); 
    $aParam['name']     = trim($this->input->post('name')); 
    $aParam['content']  = trim($this->input->post('content')); 
    $aParam['target']   = trim($this->input->post('target')); 
    $aParam['schedule'] = trim($this->input->post('schedule')); 
    $aParam['need']     = trim($this->input->post('need')); 
    $aParam['recruit']  = trim($this->input->post('recruit')); 
    $aParam['location'] = trim($this->input->post('location')); 
    $aParam['sponsor']  = trim($this->input->post('sponsor')); 
    $aParam['content_long']  = trim($this->input->post('content_long')); 
    $aParam['target_long']   = trim($this->input->post('target_long')); 
    $aParam['guide_long']    = trim($this->input->post('guide_long')); 
    $aParam['pgroup']    = trim($this->input->post('pgroup')); 
    $aParam['active']    = trim($this->input->post('active')); 
    $aParam['sdate']    = trim($this->input->post('sdate')); 
    $aParam['edate']    = trim($this->input->post('edate')); 
  
    if($this->_updateCourseInfo($aParam)) 
      response_json(array("code"=>1,"msg"=>"OK"));
    else
      response_json(array("code"=>0,"msg"=>"fail")); 
    die;
  }/*}}}*/
  public function rpcInsertCourseInfo()/*{{{*/
  {
    $aParam = array();
    $aParam['name']     = trim($this->input->post('name')); 
    $aParam['content']  = trim($this->input->post('content')); 
    $aParam['target']   = trim($this->input->post('target')); 
    $aParam['schedule'] = trim($this->input->post('schedule')); 
    $aParam['need']     = trim($this->input->post('need')); 
    $aParam['recruit']  = trim($this->input->post('recruit')); 
    $aParam['location'] = trim($this->input->post('location')); 
    $aParam['sponsor']  = trim($this->input->post('sponsor')); 
    $aParam['content_long']  = trim($this->input->post('content_long')); 
    $aParam['target_long']   = trim($this->input->post('target_long')); 
    $aParam['guide_long']    = trim($this->input->post('guide_long')); 
    $aParam['pgroup']   = trim($this->input->post('pgroup')); 
    $aParam['active']   = trim($this->input->post('active')); 
    $aParam['sdate']    = trim($this->input->post('sdate')); 
    $aParam['edate']    = trim($this->input->post('edate')); 
 
    if($this->_InsertCourseInfo($aParam)) 
      response_json(array("code"=>1,"msg"=>"OK"));
    else
      response_json(array("code"=>0,"msg"=>"fail")); 
    die;
  }/*}}}*/
  public function rpcGetQuestionInfo()/*{{{*/
  {
    $usn = trim($this->input->post('usn')); 
    $courseIDX = trim($this->input->post('course_idx')); 
    
    if(!$usn || !$courseIDX) response_json(array('code'=>999,''=>'not input')); 
   
    $oQuestionInfo = $this->_getQuestionInfo($usn, $courseIDX);
     
    response_json(array(
         'code'  => 1
        ,'msg'  => 'OK'
        ,'recommend'  => $oQuestionInfo->recommend
        ,'motive'     => $oQuestionInfo->motive
        ,'experience' => $oQuestionInfo->experience
        ,'nature'     => $oQuestionInfo->nature
        ,'favor'      => $oQuestionInfo->favor
        ,'jr_hope'    => $oQuestionInfo->jr_hope
        ,'channel'    => $oQuestionInfo->channel
        ,'club_hope'  => $oQuestionInfo->club_hope
        ,'inquiry'    => $oQuestionInfo->inquiry
      )
    );
    die;  
  }/*}}}*/

// Full User Excel file Down
/*
* 추후에 변경을 해야 되는 부분
* 너무 어거지로 만들어 둔 부분 리팩토링 필요
* 전체 명단 다운로드 부분 CI 플랫폼을 이용해서 처리 할 수 있도록 
* 추후 변경해야 합니다
*/
  public function excelDownSummerCampFull()/*{{{*/
  {
    $data = array( "aUserList" => $this->admin_model->getSummerCampFull() );
    $this->load->view('admin/exceldown', $data);  
  }/*}}}*/
  public function excelDownAutumnCampFull()/*{{{*/
  {
    $data = array( "aUserList" => $this->admin_model->getAutumnCampFull() );
    $this->load->view('admin/exceldown', $data);  
  }/*}}}*/
  public function adminsendmail($sMailList="")/*{{{*/
  {
    $this->admin_model->adminsendmail($sMailList); 
    die; 
  }/*}}}*/

  
  private function _getQuestionInfo($usn, $courseIDX)/*{{{*/
  {
    if(!$usn || !$courseIDX) return false;
    $aResult = $this->admin_model->getQuestionInfo($usn, $courseIDX); 
    return $aResult[0];
  }/*}}}*/
  private function _getCourseInfo($idx)/*{{{*/
  {
    if(!$idx) return false;
    return $this->admin_model->getCourseInfo($idx); 
  }/*}}}*/
  private function _InsertCourseInfo($aParam)/*{{{*/
  {
    return $this->admin_model->insertCourseInfo($aParam); 
  }/*}}}*/
  private function _updateCourseInfo($aParam)/*{{{*/
  {
    if(!$aParam['idx']) return false;
    
    return $this->admin_model->updateCourseInfo($aParam); 
  }/*}}}*/
    private function _getMemberSVC($usn)/*{{{*/
  {
    if(!$usn) return false; 
    return $this->admin_model->getMemberSVC($usn); 
  }/*}}}*/
  private function _getUserInfoFromEmailID($sEmailID)/*{{{*/
  {
    if(!$sEmailID) return false;
    $sEmailID = trim(urldecode($sEmailID));
    return $this->admin_model->getUserInfoFromEmailID($sEmailID); 
  }/*}}}*/
  private function _getUserInfoFromName($sName)/*{{{*/
  {
    if(!$sName) return false;
    $sName = trim($sName); 
    return $this->admin_model->getUserInfoFromName($sName); 
  }/*}}}*/
  private function _isEmailID($sParam)/*{{{*/
  {
    $sParam = urldecode($sParam);

    if (!filter_var($sParam, FILTER_VALIDATE_EMAIL)) 
      return false;
    else
      return true;
  }/*}}}*/
  private function _updateState($usn, $state, $courseIDX)/*{{{*/
  {
    if(!$usn || !$state) return false;
    
    return $this->admin_model->updateState($usn, $state , $courseIDX); 
  }/*}}}*/
  private function _sendConfMail()/*{{{*/
  {
     
  } /*}}}*/
  private function _chkAdminLogin($accountID, $passwd)/*{{{*/
  {
    if(!$accountID || !$passwd) return false;
    
    return $this->admin_model->chkAdminLogin($accountID, $passwd);
  }/*}}}*/
  private function _setMenuActive($num)/*{{{*/
  {
    $aMenu = array('aMenu'=>$this->aMenu);
    
    foreach($this->aMenu as $key=>$val)
    {
      if($key == $num)
        $aMenu['aMenu'][$key]['active'] = true;
      else
        $aMenu['aMenu'][$key]['active'] = false;
    }
    
    return $aMenu;
  }/*}}}*/
}
?>
