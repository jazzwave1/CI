<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Member extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        session_start();

        $this->membership_model = edu_get_instance('member_model','model');
        $this->today = date('Y-m-d H:i:s');
        
        $this->aLayoutConfig = array('book'=>'_BOOK', 'portal'=>'_PORTAL','training'=>'_TRAINING', 'tv'=>'_TV');
        $this->isEduniety = $this->isEduniety(); 
    }
    private function _isLogin()
    {
        // test code
        // return $mb_id = 'ahnjaejo';
        // return $mb_id = 'au0119';

        $mb_id = '';
        if(count($_SESSION)>0) 
        {
            if(empty($_SESSION['ss_mb_id']))
                return false;    
 
            $mb_id = $_SESSION['ss_mb_id'] ;
            return $mb_id;
        }
        return false;
    }
    // ####################################### //
    // ########## web Page Function ########## //
    // ####################################### //
    public function index()
    {
        $this->mypage_book();
    }
    public function pms()
    {
        // chkeduniety 
        if(!$this->isEduniety)
        {
            header('Location: /');
        }
        
        // chk login 
        if(! $mb_id = $this->_isLogin())
        {
            echo "로그인정보가 없습니다";
            die;

            //header('Location: /membership/mypage');
        }
        else
        {
            $aProductInfo = $this->membership_model->getProductInfo();
           
            $data = array(
                 'mb_id' => $mb_id  
                ,'aProductInfo' => $aProductInfo
                ,'sale_idx' => 1 // 전체리스트를 보여줌 
            ); 
            $this->load->view('mypage/pms_out', $data); // Purchase membership services

        }
    }
    private function isEduniety()
    {  
        // 8층 
        $aEdunietyIP_8 = array('1.220.133.75');

        // 4층 wifi & add IP 
        $aEdunietyIP = array('115.95.131.188','210.178.92.195');
        
        // 4층 lan 
        $aEdunietyIPS = array('112.216.251');  // 112.216.251.* ==> 112.216.251 이렇게 표기
        
        if(in_array($_SERVER['REMOTE_ADDR'], $aEdunietyIP)) return true;
        if(in_array($_SERVER['REMOTE_ADDR'], $aEdunietyIP_8)) return true;
            
        $bRtn = false; 
        foreach($aEdunietyIPS as $val)
        {
            if(strstr($_SERVER['REMOTE_ADDR'], $val))
            {
                $bRtn = true;
                break;
            }
        }

        return $bRtn;
    }   
    // ################################### //
    // ########## rpc  Function ########## //
    // ################################### //
    public function rpcBuy()
    {
        $post_mb_id = $this->input->post('mb_id');
        $sale_idx   = $this->input->post('sale_idx');
        
        // mb_id userinfo check
        if(!$oMemInfo = $this->_isMember($post_mb_id))
        {
            $aMSG = array('code'=>101, 'msg'=>'존재하지 않는 아이디 입니다.' );
            response_json($aMSG);
            die;
        } 
    
        // set log info -----------------------// 
        $aLogInfo['mb_id'] = $post_mb_id;
        $aLogInfo['type']  = 'buy';
        $aLogInfo['sale_type'] = 'ms';
        $aLogInfo['sale_idx']  = $sale_idx;
        $aLogInfo['regdate']   = $this->today ; 
        $aLogInfo['user_id']   = $post_mb_id; 
        $aLogInfo['msg']  = '';
        // ------------------------------------//
 
        // 구매프로세스  
        // 예상 PG page --> 완료 전달 페이지 
        // 만약에 완료 전달 페이지가 필요 하다면 
        // _rpcBuyPorcess 를 랩핑하는 하나의 페이지를 만들자
       
        if( $this->_rpcBuyProcess($post_mb_id, $sale_idx) )
            $aMSG = array('code'=>1, 'msg'=>'정상구매완료');
        else
        {
            $aMSG = array('code'=>201, 'msg'=>'구매실패');
            $aLogInfo['type']  = 'fail';
            $aLogInfo['msg']  = $aMSG['msg'];
        }
        // set log
        $this->member_model->setLog($aLogInfo); 
        
        response_json($aMSG);
        die;
    }
    private function _rpcBuyProcess($mb_id, $sale_idx)
    {
        // 순수하게 멤버쉽 상품을 구매하는 로직
        return $this->membership_model->pBuyService($mb_id, $sale_idx);
    }
    private function _isMember($mb_id)
    {
        if(!$mb_id) return false; 
        
        return $this->membership_model->isMember($mb_id);
    } 
    public function rpcEtrainingBuy()
    {
        // test code
        //print_r($_POST);        
        
        // chk Input Param
        $aPostConfig = array('mb_id', 'subj', 'year', 'subjseq', 'credit');
        foreach($aPostConfig as $key=>$val)
        {
            $aParam[$val] = $this->input->post($val);   
        }
        // chk member info 
        if(!$aParam['mb_id'])
        {
            $aMSG = array('code'=>100, 'msg'=>'로그인이 필요합니다' );
            response_json($aMSG);
            die;
        }
        // session chk  
        if( $this->_isLogin() != $aParam['mb_id']) 
        {
            $aMSG = array('code'=>101, 'msg'=>'비정상접근입니다.' );
            response_json($aMSG);
            die;
        }

        $type = "et"; 
        $oMember_model = edu_get_instance('member_model','model');
        $aChkPurchaseInfo = $oMember_model->chkPurchaseInfo($aParam['mb_id']);
         
        //print_r($aChkPurchaseInfo); 
        
        if($aChkPurchaseInfo['available_cnt'][$type] < $aParam['credit'] )
        {
            // 가능한 수량이 없음  
            $aMSG = array('code'=>300, 'msg'=>'가능수량이 없습니다.' );
            response_json($aMSG);
            die;
        }

        // Eduniety 무통장 결제 프로세스를 태웁니다. 
        // data 확인은 한번더 필요합니다
        if( ! $this->setEdunietyPayPorc($_POST) )
        {
            // 가능한 수량이 없음  
            $aMSG = array('code'=>400, 'msg'=>'존재하지 않습니다.' );
            response_json($aMSG);
            die;
        }

        /* membership Content BUY  
         * int type content_idx setting 
         * XXXX - XXXX - XXXX ==> XXXXYYXXXX 변환함 
         * */
        $content_idx = "".$aParam['subj'] . substr($aParam['year'], -2) . $aParam['subjseq']; 
        $fingerprint = '1234'; // dummy code
        $msg = "training_idx : ".$aParam['subj'] ."-". $aParam['year'] ."-". $aParam['subjseq'];

        $this->apiBuyMembershipContents($aParam['mb_id'], $type, $content_idx, $aParam['credit'], $fingerprint, $msg, 'return');
        
        // result 
        $aMSG = array('code'=>1, 'msg'=>'OK' );
        response_json($aMSG);
        die; 
    }
    public function setEdunietyPayPorc($aParam)
    {
        $oTraining_model = edu_get_instance('training_model','model');
        return $oTraining_model->setTrainingBUY($aParam); 
    } 

    // ################################## //
    // ########## API Function ########## //
    // ################################## //

    /*
     * PG or page에서 접근하는 
     * <<<<<<<<<< 멤버쉽 구매 API >>>>>>>>>>
     * page로 인식할 수 도 있음
        ==> script alert으로 메세징 처리가 되어야 함 
     * param RestURL /{mb_id}/{sale_idx}/{fingerprint}/{redirect_url}
     * 정상구매 완료 후 redirect url 로 페이지를 옮겨줌 
     * redirect_url 없다면 json 으로 리턴합니다. 
     * */ 
    public function apiBuyMembership($mb_id, $sale_idx, $fingerprint , $redirect_url = '')
    {
        return ;

        // chk param        
        if(!$mb_id || !$sale_idx || !$fingerprint)
        {
            if(!$redirect_url)
            {
                $aMSG = array('data'=>array('code'=>301, 'msg'=>'Input param') );
                response_json($aMSG);
                die;
            }
            else
            {
               //echo "alert('정상적인 접근이 아닙니다.');";
               header('Location: /membership/mypage');
            }
        }
        
        $post_mb_id   = urldecode(trim($mb_id));
        $fingerprint  = urldecode(trim($fingerprint));
        $redirect_url = urldecode(trim($redirect_url));

        // mb_id userinfo check
        if(!$oMemInfo = $this->_isMember($post_mb_id))
        {
            if(!$redirect_url)
            {
                $aMSG = array('code'=>101, 'msg'=>'존재하지 않는 아이디 입니다.' );
                response_json($aMSG);
                die;
            }
            else
            {
                //echo "alert('존재하지 않는 아이디 입니다.');";
                header('Location: /membership/mypage');
            }
        } 
        
        // set log info -----------------------// 
        $aLogInfo['mb_id'] = $post_mb_id;
        $aLogInfo['type']  = 'buy';
        $aLogInfo['sale_type'] = 'ms';
        $aLogInfo['sale_idx']  = $sale_idx;
        $aLogInfo['regdate']   = $this->today ; 
        $aLogInfo['user_id']   = $post_mb_id; 
        $aLogInfo['msg']       = ''; 
        // ------------------------------------//
       
        if( $this->member_model->BuyMemberProduct($post_mb_id, $sale_idx, $fingerprint) )
        {
            //$aMSG = array('code'=>1, 'msg'=>'정상구매완료');
            // 정상구매 완료 set log 
            $this->member_model->setLog($aLogInfo); 


            if(!$redirect_url) 
                header('Location: /membership/mypage');
            else
                header('Location: '.$redirect_url);
        }
        else
        {
            $aMSG = array('code'=>201, 'msg'=>'구매실패');
            // 해당 로그를 저장하는 어딘가가 있어야 함
            $aLogInfo['type']  = 'fail';
            $aLogInfo['msg']   = $aMSG['msg'];
            $this->member_model->setLog($aLogInfo); 
        }
        
        response_json($aMSG);
        die;
    }

    /*
     * <<<<<<<<<< 멤버쉽서비스 구매 취소API >>>>>>>>>>
     * input param
     *  - mb_id : user_id
     *  - sale_idx
     *  - p_idx : table idx
     *  - fingerprint : chkvalue
     *  - 운영툴에서 적용될것으로 판단 : 실제 삭제하는 운영자의 아이드를 입력 받아서 처리 해야한다.
     *    일단 자신의 아이디로 입력하도록 되어 있다
     *    추후 기존 운영툴과 연동시 처리 하도록 한다
     *  - 컨텐츠 구매기록에 대한 처리가 않되어 있음.. <== 이부분은 운영적 결정에 따라 대응하도록 함 
     * */
    public function apiCancelMembership($mb_id, $sale_idx, $p_idx, $fingerprint='')
    {
        // 멤버쉽 회원이 연수랑 책 구매취소시 관련 정보를 저장함 
        // type [ et : 원격연수, t:현장연수, b:책 ]

        if(!$mb_id || !$sale_idx || !$p_idx || !$fingerprint)
        {
            $aMSG = array('data'=>array('code'=>301, 'msg'=>'Input param error') );
            response_json($aMSG);
            die;
        }

        //ulrdecode
        $mb_id = urldecode(trim($mb_id));
        $sale_idx = urldecode(trim($sale_idx));
        $p_idx = urldecode(trim($p_idx));
        $fingerprint  = urldecode(trim($fingerprint));
       
        // set log info -----------------------// 
        $aLogInfo['mb_id'] = $mb_id;
        $aLogInfo['type']  = 'del';
        $aLogInfo['sale_type'] = 'ms';
        $aLogInfo['sale_idx']  = $sale_idx;
        $aLogInfo['regdate']   = $this->today ; 
        $aLogInfo['user_id']   = $mb_id; 
        $aLogInfo['msg']       = 'p_idx:'.$p_idx; 
        // ------------------------------------//


        // update act->del 
        if( !$this->membership_model->pCancelMemberProduct($mb_id, $p_idx, $fingerprint))
        {
            $aMSG = array('data'=>array('code'=>999, 'msg'=>'DB Error') );
            $aLogInfo['type']  = 'fail';
            $aLogInfo['msg']  = $aMSG['data']['msg'];
            $this->member_model->setLog($aLogInfo); 
            response_json($aMSG);
            die;
        }
        
        $this->member_model->setLog($aLogInfo); 
        $aMSG = array('data'=>array('code'=>1, 'msg'=>'OK') );
        response_json($aMSG);
        die;
    }

    /*
     * 일반 연수, 책 등의 구메시 
     * 멤버쉽 회원결재 연동으로 0월 결재 로직임
     * 해당 API를 호출하고 Json 결과로 확인가능
     * input param 
     *  - mb_id : User ID
     *  - type [ et : 원격연수, t:현장연수, b:책 , tv : tv]
     *  - content_idx : 실제 컨텐츠의 식별 번호
     *  - credit : 학점  
     *  - fingerprint : chkvalue
     * */
    public function apiBuyMembershipContents($mb_id, $type, $content_idx, $credit, $fingerprint='', $msg='', $rtype='')
    {
        // 멤버쉽 회원이 연수랑 책 구매시 관련 정보를 저장함 
        // type [ et : 원격연수, t:현장연수, b:책 ]
        if(!$mb_id || !$type || !$content_idx || !$fingerprint)
        {
            $aMSG = array('data'=>array('code'=>301, 'msg'=>'Input param error') );
            response_json($aMSG);
            die;
        }
        if(in_array($type, array('et','t')) && !$credit)
        {
            $aMSG = array('data'=>array('code'=>301, 'msg'=>'Input param error') );
            response_json($aMSG);
            die;
        }

        //ulrdecode
        $mb_id = urldecode(trim($mb_id));
        $type  = urldecode(trim($type));
        $content_idx = urldecode(trim($content_idx));
        $credit = urldecode(trim($credit));

        // set log info -----------------------// 
        $aLogInfo['mb_id'] = $mb_id;
        $aLogInfo['type']  = 'buy';
        $aLogInfo['sale_type'] = $type;
        $aLogInfo['sale_idx']  = $content_idx;
        $aLogInfo['regdate']   = $this->today ; 
        $aLogInfo['user_id']   = $mb_id; 
        $aLogInfo['msg']       = $msg; 
        // ------------------------------------//
 
        if( !$this->membership_model->pBuyContent($mb_id, $type, $content_idx, $fingerprint, $credit))
        {
            $aMSG = array('data'=>array('code'=>401, 'msg'=>'NO Count') );
            $aLogInfo['type']  = 'fail';
            $aLogInfo['msg']  = $aMSG['data']['msg'];
            $this->member_model->setLog($aLogInfo); 
            response_json($aMSG);
            die;
        }
        
        $this->member_model->setLog($aLogInfo); 

        // rpc 로 처리 되었을때 리턴해줌 
        if($rtype) 
            return true; 
        else
        {
            $aMSG = array('data'=>array('code'=>1, 'msg'=>'OK') );
            response_json($aMSG);
            die;
        } 
    }

    /*
     * 연수, 책등의 컨텐츠 구매 취소 액션
     * 기본적으로 취소액션은 운영툴에서만 진행된다고 가정한다. <== 이부분은 서비스 정의에 따라 변경가능
     *
     * 1. set log (select->insert)
     * 2. action member_service_usage_history delete
     * input param
     *  - h_idx : table idx
     *  - fingerprint : chkvalue
     * */
    public function apiCancelMembershipContents($mb_id, $h_idx, $fingerprint='', $user_id='')
    {
        // 멤버쉽 회원이 연수랑 책 구매취소시 관련 정보를 저장함 
        // type [ et : 원격연수, t:현장연수, b:책 ]

        if(!$mb_id || !$h_idx || !$fingerprint)
        {
            $aMSG = array('data'=>array('code'=>301, 'msg'=>'Input param error') );
            response_json($aMSG);
            die;
        }

        //ulrdecode
        $user_id = urldecode(trim($user_id));
        $h_idx = urldecode(trim($h_idx));
        $fingerprint = urldecode(trim($fingerprint));
        
        // update act->del 
        if( !$this->membership_model->pCancelMemberContent($mb_id, $h_idx, $fingerprint))
        {
            $aMSG = array('data'=>array('code'=>999, 'msg'=>'DB Error') );
            //$aLogInfo['type']  = 'fail';
            //$aLogInfo['msg']  = $aMSG['data']['msg'];
            //$this->member_model->setLog($aLogInfo); 
            response_json($aMSG);
            die;
        }
        $aMSG = array('data'=>array('code'=>1, 'msg'=>'OK') );
        response_json($aMSG);
        die;
    }
    /*
     * 결재 진행전 해당 회원의 멤버쉽 결재가 가능한지에 대해서 확인이 필요함
     * 해당 API를 호출하여 현재 멤버쉽 서비스 정보가 얼마나 남았는지 확인 할 수 있음
     * param 
     *  - mb_id : User ID
     * */
    public function apiGetMemSvcInfo($mb_id='')
    {
        if(!$mb_id)
        {
            $aMSG = array('data'=>array('code'=>301, 'msg'=>'Input param') );
            response_json($aMSG);
            die;
        }
        
        if(!$aResult = $this->membership_model->getPurchaseInfo($mb_id))
        {
            $aMSG = array('data'=>array('code'=>999, 'msg'=>'DB Error') );
            response_json($aMSG);
            die;
        }

        $aMSG = array('data'=>array('code'=>1, 'msg'=>'OK', 'result'=>$aResult) );
        response_json($aMSG);
        die;
    }


}
