<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Mypage_model extends CI_model
{
    public function __construct()
    {
        $this->member_dao = edu_get_instance('member_dao', 'model'); 
        $this->mypage_dao = edu_get_instance('mypage_dao', 'model'); 
        $this->today = date('Y-m-d H:i:s');
        $this->aRtn = array('et'=>0, 't'=>0, 'b'=>0, 'tv'=>0);
    
        $this->c_config = array('et'=>'e_training', 't'=>'training', 'b'=>'book', 'tv'=>'tv');
    
    }

    public function getProductInfo()
    {
        $aInput = array('sale_idx' => 1); 
        return $this->member_dao->getProductInfo(); 
    }

    public function getUserInfo($mb_id)
    {
        if(!$mb_id) return false;
        $aInput = array('mb_id'=>$mb_id);
        $aMemInfo = $this->member_dao->getMemberInfo($aInput) ;
        $oRtn = $aMemInfo[0] ;
        return $oRtn;
    }
    private function _setViewDataTraing($aList=array())
    {
        if(!$aList) return false;
        
        $aData = array();
        foreach($aList as $key=>$val)
        {
            if( ($val->propstart <= date('YmdH'))&& date('YmdH')<= $val->propend )
            {
                $aData[$key]['state'] = '모집중';
                          
                $aData[$key]['name'] = $val->subjnm;
                $aData[$key]['term'] = setDateFormat($val->propstart,'Y-M-D')." ~ ".setDateFormat($val->propend,'Y-M-D');
                
                $aData[$key]['type'] = 'et';
            }
        } 
        return $aData;
    } 

    public function getMyContentsTV($mb_id='')
    {
        $aContentInfo= $this->mypage_dao->getNewContentInfo() ; 

        // login 여부를 확인 하고 다른 값을 두 값을 전부 세팅해서 보내 준다.
        // lginoutInfo = ad 정보가 될 확률이 크다
        $aRtn = array(
            'logoutInfo' => array( 'tv' => $aContentInfo )
            ,'loginInfo' => array( 'tv' => $aContentInfo )
        );

        return $aRtn;
       
    }
    public function getMyContentsPortal($mb_id='')
    {
        // 올해년도의 원격연수 리스트  
        $aETlist = $this->mypage_dao->getADETraining(date('Y'))  ; 
        $aETdata = $this->_setViewDataTraing($aETlist); 

        $aTlist = $this->mypage_dao->getADTraining(date('Y'));
        $aTdata = $this->_setViewDataTraing($aTlist); 

        // value init
        $aMemsvcInfo['aUseCnt'] = array('et'=>0,'t'=>0,'b'=>0,'tv'=>0);
        $aMemsvcInfo['aPossibleCnt'] = array('et'=>0,'t'=>0,'b'=>0,'tv'=>0);
            
        if($mb_id)
            $aMemsvcInfo = $this->membership_model->getMemsvcInfo($mb_id) ;


        // test code
        // echo "<!--";
        // print_r($aMemsvcInfo);
        // echo "-->";

        $aRtn = array(
            'logoutInfo' => array(
                'portal'=> array(
                     'etlist' => $aETdata
                    ,'elist'  => $aTdata 
                    ,'booklist'=>array(
                        array('name'=>'최신도서'  , 'cnt'=>1 ) 
                    )
                    ,'tvlist'=>array(
                       // array('name'=>'공감교실' , 'term'=>'2017-02-01 ~ 2017-04-15', 'state'=>'마감', 'cnt'=>22) 
                       //,array('name'=>'참여교실' , 'term'=>'2017-02-01 ~ 2017-04-15', 'state'=>'마감', 'cnt'=>22) 
                       //,array('name'=>'공감교실' , 'term'=>'2017-02-01 ~ 2017-04-15', 'state'=>'마감', 'cnt'=>22) 
                    ) 
                )
            )
            ,'loginInfo'  => array(
                'portal'=> array(
                    // 원격연수
					/*
                     (object)array('name'=>'수강과목'  , 'cnt'=>$aMemsvcInfo['aUseCnt']['et'] , 'type'=>'et') 
                    ,(object)array('name'=>'남은과목 ' , 'cnt'=>$aMemsvcInfo['aPossibleCnt']['et'] , 'type'=>'et') 
					*/
					(object)array('name'=>'수강학점'  , 'cnt'=>$aMemsvcInfo['aUseCnt']['et'] , 'type'=>'et') 
                    ,(object)array('name'=>'남은학점 ' , 'cnt'=>$aMemsvcInfo['aPossibleCnt']['et'] , 'type'=>'et') 
                    
                    // 현장연수
                    ,(object)array('name'=>'수강과목'  , 'cnt'=>$aMemsvcInfo['aUseCnt']['t'] , 'type'=>'t') 
                    ,(object)array('name'=>'남은과목 ' , 'cnt'=>$aMemsvcInfo['aPossibleCnt']['t'] , 'type'=>'t') 
                    
                    // Book 
                    ,(object)array('name'=>'구매도서'  , 'cnt'=>$aMemsvcInfo['aUseCnt']['b'] , 'type'=>'b') 
                    ,(object)array('name'=>'남은도서'  , 'cnt'=>$aMemsvcInfo['aPossibleCnt']['b'] - $aMemsvcInfo['aUseCnt']['b'], 'type'=>'b') 

                    // TV 
                    ,(object)array('name'=>'나의영상'  , 'cnt'=>32 , 'type'=>'tv') 
                    ,(object)array('name'=>'찜한영상'  , 'cnt'=>22 , 'type'=>'tv') 
                    ,(object)array('name'=>'최신영상'  , 'cnt'=>21 , 'type'=>'tv') 
                    ,(object)array('name'=>'남긴댓글'  , 'cnt'=>21 , 'type'=>'tv') 

                )
            )

        );

        return $aRtn;
    }
    public function getMyContentsTraining($mb_id='')
    {
        // 올해년도의 원격연수 리스트  
        $aETlist = $this->mypage_dao->getADETraining(date('Y'))  ; 
        $aETdata = $this->_setViewDataTraing($aETlist); 

        // 올해년도의 현장연수 리스트  
        $aTlist = $this->mypage_dao->getADTraining(date('Y'));
        $aTdata = $this->_setViewDataTraing($aTlist); 

        // value init
        $aMemsvcInfo['aUseCnt'] = array('et'=>0,'t'=>0,'b'=>0,'tv'=>0);
        $aMemsvcInfo['aPossibleCnt'] = array('et'=>0,'t'=>0,'b'=>0,'tv'=>0);
 
        $aTraingInfo = $this->getAllTraining($mb_id);
        echo "<!--";
        print_r($aTraingInfo); 
        print_r($aETlist); 
        echo "-->";

        // login 여부를 확인 하고 다른 값을 두 값을 전부 세팅해서 보내 준다.
        // lginoutInfo = ad 정보가 될 확률이 크다
        $aRtn = array(
            'logoutInfo' => array(
                'aTraining'=> array(
                     'etlist' => $aETdata
                    ,'elist'  => $aTdata 
                )
                ,'aETraining'=> array(
                     (object)array('name'=>'직무7기' , 'term'=>'2017-01-01 ~ 2017-03-15', 'state'=>'마감') 
                    ,(object)array('name'=>'직무8기' , 'term'=>'2017-02-01 ~ 2017-04-15', 'state'=>'모집중') 
                )
            )
            ,'loginInfo'  => $aTraingInfo 
        );

        return $aRtn;
    }
    public function getAllTraining($userid)
    {
        if(!$userid) return false;
        $aAllTraing = $this->mypage_dao->getAllTraining($userid);
        $aEndTraing = $this->mypage_dao->getEndTraining($userid);
        
        $aRtn['ET']['apply'] = ''; 
        $aRtn['ET']['pro'] = ''; 
        $aRtn['ET']['end'] = ''; 
        $aRtn['T']['apply'] = ''; 
        $aRtn['T']['pro'] = ''; 
        $aRtn['T']['end'] = ''; 

        if($aAllTraing)
        {
            foreach($aAllTraing as $key=>$val)
            {
                if($val->chkfinal == 'B' && $val->isonoff == 'ON') 
                    $aRtn['ET']['apply'][] = $val;
                if($val->chkfinal == 'B' && $val->isonoff == 'OFF') 
                    $aRtn['T']['apply'][] = $val;
                if($val->chkfinal == 'Y' && $val->isonoff == 'ON') 
                    $aRtn['ET']['pro'][] = $val;
                if($val->chkfinal == 'Y' && $val->isonoff == 'OFF') 
                    $aRtn['T']['pro'][] = $val;
            }
        } 
        if($aEndTraing)
        {
            foreach($aEndTraing as $key=>$val)
            {
                if( ($val->eduend <= date('YmdH')) && $val->isonoff == 'ON')
                    $aRtn['ET']['end'][] = $val;
                if( ($val->eduend <= date('YmdH')) && $val->isonoff == 'OFF')
                    $aRtn['T']['end'][] = $val;
            } 
        } 
        return $aRtn;
    }


}
