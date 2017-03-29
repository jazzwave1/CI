<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Member_model extends CI_model
{
    public function __construct()
    {
        $this->member_dao = edu_get_instance('member_dao', 'model'); 
        $this->mypage_dao = edu_get_instance('mypage_dao', 'model'); 
        $this->mypage_model = edu_get_instance('mypage_model', 'model'); 
        $this->today = date('Y-m-d H:i:s');
        $this->aRtn = array('et'=>0, 't'=>0, 'b'=>0, 'tv'=>0);
    
        $this->c_config = array('et'=>'e_training', 't'=>'training', 'b'=>'book', 'tv'=>'tv');
    
    }

    public function setLog($aParam)
    {
        return $this->member_dao->setMembershipLog($aParam); 
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
    public function getMemsvcInfo($mb_id)
    {
        // 구매한 상품에 대한 기본 정보
        $aPurchaseInfo = $this->_getPurchaseInfo($mb_id);

        if(count($aPurchaseInfo) == 0 || !$aPurchaseInfo)        
            return false;

        // 구매가능한 카운트 정리 
        // get 멤버쉽서비스 구매기록
        // 구매내역 기준으로 실제 구매히스토리를 조회함 
        $aPidx   = $this->_getPurchaseIDX($aPurchaseInfo);
        $aUseCnt = $this->_getUseCnt($mb_id, $aPidx);
        $aPoCnt  = $this->_getPossibleCnt($aPurchaseInfo); 

        //print_r($aPidx);
        //print_r($aUseCnt);
        //print_r($aPoCnt);
        //print_r($aPurchaseInfo);
        //
        //die;

        
        $aUsageHistory  = $this->_getUsageHistory($mb_id); 
        $aUsageContents = $this->_getUsageContents($aUsageHistory);

        $aRtn['aUseCnt']         = $aUseCnt;
        $aRtn['aPossibleCnt']    = $aPoCnt; 
        $aRtn['aPurchaseInfo']   = $aPurchaseInfo; 
        $aRtn['aUsage_history']  = $aUsageHistory; 
        $aRtn['aUsage_Contents'] = $aUsageContents; 

        return $aRtn; 
    }
    private function _getUsageContents($aUsageHistory)
    {
        if(!$aUsageHistory) return false;

        $aBookIdx = array();
        $aTrainingIdx = array();
        $aETrainingIdx= array();
        $aTvIdx = array();

        foreach($aUsageHistory as $key=>$val)
        {
            if($val->type == 'b') $aBookIdx[] = $val->content_idx;
            if($val->type == 't') $aTrainingIdx[] = $val->content_idx;
            if($val->type == 'et') $aETrainingIdx[] = $val->content_idx;
            if($val->type == 'tv') $aTvIdx[] = $val->content_idx;
        }
        
        $aResult = array(); 
        $aResult['b']  = $this->_getUsageBook($aBookIdx);
        $aResult['t']  = $this->_getUsageTraining($aTrainingIdx);
        $aResult['et'] = $this->_getUsageETraining($aETrainingIdx);
        $aResult['tv'] = $this->_getUsageTv($aTvIdx);
        
        return $aResult;    
    }
    private function _getUsageBook($aBookIdx)
    {
       /* 멥버쉽 회원 구매와 비회원 구매 내역에 대해서 구분을 해야 함*/
//       if(!$aBookIdx || count($aBookIdx) == 0) return false; 

       // test code
       $aResult = array(); 
       //$aResult[] = (object)array('name'=>'평가란 무엇인가?', 'sel_type'=>'M', 'price'=>0, 'regdate'=>'2016-10-10 12:12:12');
       //$aResult[] = (object)array('name'=>'수학하는 신체', 'sel_type'=>'M', 'price'=>0, 'regdate'=>'2016-10-11 13:12:12');
       //$aResult[] = (object)array('name'=>'과학하는 신체', 'sel_type'=>'', 'price'=>10000, 'regdate'=>'2016-10-11 13:12:12');
       
       return $aResult;
    }
    private function _getUsageTraining($aTrainingIdx)
    {
//       if(!$aTrainingIdx|| count($aTrainingIdx) == 0) return false; 

       // test code
       $aResult = array(); 
       //$aResult[] = (object)array('name'=>'미크와 함께..', 'sel_type'=>'M', 'price'=>0, 'regdate'=>'2016-10-10 12:12:12');
       //$aResult[] = (object)array('name'=>'SW 교육이란', 'sel_type'=>'', 'price'=>20000,'regdate'=>'2016-10-11 13:12:12');
       
       return $aResult;
    }
    private function _getUsageETraining($aETrainingIdx)
    {
//       if(!$aETrainingIdx|| count($aETrainingIdx) == 0) return false; 

       // test code
       $aResult = array(); 
       //$aResult[] = (object)array('name'=>'함께보는 수학', 'sel_type'=>'M', 'price'=>0, 'regdate'=>'2016-10-10 12:12:12');
       //$aResult[] = (object)array('name'=>'생각해보는 신체', 'sel_type'=>'', 'price'=>3000, 'regdate'=>'2016-10-11 13:12:12');
       
       return $aResult;
    }
    private function _getUsageTv($aETrainingIdx)
    {
//       if(!$aETrainingIdx|| count($aETrainingIdx) == 0) return false; 

       // test code
       $aResult = array(); 
       //$aResult[] = (object)array('name'=>'함께보는 수학', 'sel_type'=>'M', 'price'=>0, 'regdate'=>'2016-10-10 12:12:12');
       //$aResult[] = (object)array('name'=>'생각해보는 신체', 'sel_type'=>'', 'price'=>3000, 'regdate'=>'2016-10-11 13:12:12');
       
       return $aResult;
    }
    private function _getUsageHistory($mb_id)
    {
        return $this->member_dao->getUsageHistory($mb_id); 
    }
    private function _getPurchaseInfo($mb_id)
    {
        return $this->member_dao->getPurchaseInfo($mb_id); 
    }
    private function _getUseCnt($mb_id, $aPidx)
    {
        /*
         * 연수 는 학점으로 계산
         * 북은 권 카운트로 계산
         * */
        $aResult = $this->member_dao->getUseCnt($mb_id, $aPidx); 
        $aRtn = $this->aRtn;

        foreach($aResult as $key=>$val)
        {
            if(in_array($val->type, array('et','t')))
            {
                if(!$val->sum_credit)
                    $aRtn[$val->type] = 0;
                else
                    $aRtn[$val->type] = $val->sum_credit;
            }
            else
                $aRtn[$val->type] = $val->cnt;
        }
        return $aRtn;
    }
    private function _getPossibleCnt($aPurchaseInfo)
    {
         $aRtn = $this->aRtn ;
         foreach($aPurchaseInfo as $key=>$val)
         {
            $aRtn['et'] += $val->e_training;
            $aRtn['t'] += $val->training;
            $aRtn['b'] += $val->book;
            $aRtn['tv'] += $val->tv;
         }
         return $aRtn; 
    }
    private function _getPurchaseIDX($aPurchaseInfo)
    {
        foreach($aPurchaseInfo as $key=>$val)
            $aPidx[] = $val->p_idx;
   
        return $aPidx;
    }
    private function _getAvailableCnt($aUseCnt, $aPoCnt)
    {
        $aRtn = $this->aRtn;

        $aRtn['et'] = $aPoCnt['et'] - $aUseCnt['et'];
        $aRtn['t']  = $aPoCnt['t'] - $aUseCnt['t'];
        $aRtn['b']  = $aPoCnt['b'] - $aUseCnt['b'];
        $aRtn['tv'] = $aPoCnt['tv'] - $aUseCnt['tv'];
    
        return $aRtn;
    }
    
    public function isMember($mb_id) 
    {
        if(!$mb_id) return false;
        $oRtn = $this->getUserInfo($mb_id);  
        return $oRtn;
    }   
    private function chkFingerPrint($mb_id, $fingerprint)
    {
        return true;
    } 
    public function BuyMemberProduct($mb_id, $sale_idx, $fingerprint)
    {
        if($this->chkFingerPrint($mb_id, $fingerprint))
        {
            return $this->pBuyService($mb_id, $sale_idx);
        }
        return false;
    }    
    public function pBuyService($mb_id, $sale_idx)
    {

        $aInput = array(
             'mb_id' => $mb_id
            ,'sale_idx' => $sale_idx
            ,'type'     => 'act' 

            // 구매와 동시에 효력이 발생함 
            ,'usedate' => $this->today
            ,'regdate' => $this->today
            
            // 일단 디폴트로 1/1 ~ 12/31 로 세팅함
            ,'exp_s_date' => date('Y').'-01-01'
            ,'exp_e_date' => date('Y').'-12-31'
            
            ,'oid' => "TEST|".$this->today
        );

        if( $this->member_dao->insertMemberPurchaseList($aInput) )
            return true;
        else
            return false ;
    }
    public function pBuyContent($mb_id, $type, $content_idx, $fingerprint, $credit='')
    {
        if(!$mb_id || !$type || !$content_idx || !$fingerprint) return false;
        if(in_array($type, array('et','t')) && !$credit) return false;
        if(!$this->chkFingerPrint($mb_id, $fingerprint)) return false; 

        $aResult = $this->chkPurchaseInfo($mb_id) ;
        
        if(in_array($type, array('et','t')) && ($aResult['available_cnt'][$type] < $credit))
        {
            return false;
        }
        else
        {
            if($aResult['available_cnt'][$type] < 1 )
            {
                // 가능한 수량이 없음  
                return false;
            }
        }
        
        
        $p_idx = $aResult['available_p_idx'][$type];
        
        $aInput = array(
             'mb_id' => $mb_id
            ,'p_idx' => $p_idx
            ,'type'  => $type
            ,'content_idx' => $content_idx
            ,'credit' => $credit
            ,'regdate' => $this->today
        );

        if( $this->member_dao->insertMemberServiceUsageHistory($aInput) )
            return true;
        else
            return false; 
    }
    public function getPurchaseInfo($mb_id)
    {
        if(!$mb_id) return false;
        return $this->chkPurchaseInfo($mb_id); 
    } 
    public function chkPurchaseInfo($mb_id)
    {
        // 구매한 상품에 대한 기본 정보
        $aPurchaseInfo = $this->_getPurchaseInfo($mb_id);

        if(count($aPurchaseInfo) == 0 || !$aPurchaseInfo)        
            return false;
        
        // 구매가능한 카운트 정리 
        // get 멤버쉽서비스 구매기록
        // 구매내역 기준으로 실제 구매히스토리를 조회함 
        $aPidx   = $this->_getPurchaseIDX($aPurchaseInfo);
        $aUseCnt = $this->_getUseCnt($mb_id, $aPidx);
        $aPoCnt  = $this->_getPossibleCnt($aPurchaseInfo); 

        //print_r($aPidx); 
        //print_r($aUseCnt); 
        //print_r($aPoCnt); 
        //print_r($aPurchaseInfo);

        $aAvailableCnt  = $this->_getAvailableCnt($aUseCnt, $aPoCnt);
        $aAvailablePidx = $this->_getAvailablePidx($aUseCnt, $aPurchaseInfo);

        $aRtn['available_p_idx'] = $aAvailablePidx;
        $aRtn['available_cnt']   = $aAvailableCnt;

        //print_r($aRtn);
        return $aRtn;         
    }
    private function _getAvailablePidx($aUseCnt, $aPurchaseInfo)
    {
        $aConfig = $this->c_config ;
        $aMaxCnt = $this->_getPossibleCnt($aPurchaseInfo);
       
        $aTemp = array();

        for($i=0 ; $i<count($aPurchaseInfo) ; $i++)
        {
            $aTemp[] = (array)$aPurchaseInfo[$i]; 
        }          
        
        foreach($aConfig as $k=>$v)
        {
            $temp_p_idx = $aPurchaseInfo[0]->p_idx;
            
            for($i=0;$i<count($aTemp);$i++)
            {
                if($i==0)
                    $chkCount = $aTemp[$i][$v];
                else
                    $chkCount += $aTemp[$i][$v]; 
                     
                if($aUseCnt[$k] >= $chkCount)
                {
                    if($aMaxCnt[$k] == $aUseCnt[$k])
                        $temp_p_idx = 0;
                    else
                        $temp_p_idx = $aTemp[$i+1]['p_idx']; 
                }
            }
            $aRtn[$k] = $temp_p_idx;
        }
        return $aRtn;
    }

    public function pCancelMemberProduct($mb_id, $p_idx, $fingerprint)
    {
        if($this->chkFingerPrint($mb_id, $fingerprint))
        {
            $aInput = array(
                 'mb_id' => $mb_id
                ,'p_idx' => $p_idx
                ,'type'  => 'del' 
            );

            if( $this->member_dao->updateCancelMemberPurchaseList($aInput) )
                return true;
        }
        return false;
    }    
    public function pCancelMemberContent($mb_id, $h_idx, $fingerprint)
    {
        if($this->chkFingerPrint($mb_id, $fingerprint))
        {
            $aInput = array('h_idx' => $h_idx);

            if( $this->member_dao->updateCancelMemberContent($aInput) )
                if( $this->member_dao->deleteCancelMemberContent($aInput) ) 
                    return true;
        }
        return false;
   
    }
    public function getMyContentsBook($mb_id='')
    {
        // login 여부를 확인 하고 다른 값을 두 값을 전부 세팅해서 보내 준다.
        // lginoutInfo = ad 정보가 될 확률이 크다
        $aRtn = array(
            'loginInfo'  => array(
                'book'=> array(
                 //   (object)array('name'=>'행복한 교실을 위한 1-2-3 매직', 'writer'=>'토마스', 'price'=>'17000')
                 //  ,(object)array('name'=>'행복한 교실을 위한 3-2-1 매직', 'writer'=>'터마스', 'price'=>'16900')
                )
            )
             ,'logoutInfo' => array(
                 'book'=> array(
                 //  (object)array('name'=>'행복한 교실을 위한 4-5-6 매직', 'writer'=>'토마스', 'price'=>'17000')
                 // ,(object)array('name'=>'행복한 교실을 위한 6-5-4 매직', 'writer'=>'터마스', 'price'=>'16900')
                )
            )
        );

        return $aRtn;
    }
    public function getSSOInfo($mb_id)
    {
        if(!$mb_id) return false;
        
        $aSSOInfo = $this->member_dao->getSSOInfo($mb_id) ;
        $oRtn = $aSSOInfo[0] ;
        return $oRtn;
   
    }
    public function setSSOInfo($t_id, $t_name, $t_usn, $e_id, $e_name)
    {
        if(!$t_id || !$t_name || !$t_usn || !$e_id || !$e_name ) return false;

        $aInput = array(
             't_email' => $t_id
            ,'t_name'  => $t_name
            ,'t_usn'   => $t_usn
            ,'e_mb_id' => $e_id
            ,'e_name'  => $e_name
        );
        return $this->member_dao->setSSOInfo($aInput) ;
    }
    public function getLoginHistory($mb_id)
    {
        if(!$mb_id) return false;

        return $this->member_dao->getLoginHistory($mb_id); 
    }

    public function getMembershipDeshboardInfo($mb_id)
    {
        $aResult = array(
            "aTraingEduInfo"=>array(
                 "aTraingEduReadyInfo"     => array("cnt"=>0, "aTraingReadyInfo"=>array())
                ,"aTraingEduPlayInfo"      => array("cnt"=>0, "aTraingPlayInfo"=>array())
                ,"aTraingEduCompleteInfo"  => array("cnt"=>0, "aTraingCompleteInfo"=>array())
            )
        );
        
        //test code 
        //$mb_id = "bolee";
        $aTraingReadyInfo = $this->member_dao->getTraingEduReady($mb_id); 
        $aResult['aTraingEduInfo']['aTraingEduReadyInfo']['cnt'] = count($aTraingReadyInfo);  
        $aResult['aTraingEduInfo']['aTraingEduReadyInfo']['aTraingReadyInfo'] = $aTraingReadyInfo;  

        $aTraingPlayInfo = $this->member_dao->getTraingEduPlay($mb_id); 
        $aResult['aTraingEduInfo']['aTraingEduPlayInfo']['cnt'] = count($aTraingPlayInfo);  
        $aResult['aTraingEduInfo']['aTraingEduPlayInfo']['aTraingPlayInfo'] = $aTraingPlayInfo;  
        
        $aTraingCompleteInfo = $this->member_dao->getTraingEduComplete($mb_id); 
        $aResult['aTraingEduInfo']['aTraingEduCompleteInfo']['cnt'] = count($aTraingCompleteInfo);  
        $aResult['aTraingEduInfo']['aTraingEduCompleteInfo']['aTraingCompleteInfo'] = $aTraingCompleteInfo;  

        return $aResult ;
    }
}
