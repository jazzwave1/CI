<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Mypage extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        session_start();
        
        $this->mypage_model = edu_get_instance('mypage_model','model'); 
        $this->membership_model = edu_get_instance('member_model','model'); 
        $this->today = date('Y-m-d H:i:s');
        
        $this->aLayoutConfig = array('book'=>'_BOOK', 'portal'=>'_PORTAL','training'=>'_TRAINING', 'tv'=>'_TV');
    }
    private function _isLogin()
    {
        // test code
        //return 'au0119';
        
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
    public function leftmenu()
    {
        $aMenu = array(
            'traing' => array(
                'title' => '행복연수원'
                ,'aMenu' => array(
                     '전체'     => 'http://design.eduniety.net/sub/training/MAIN_all.php'
                    ,'현장'     => 'http://design.eduniety.net/sub/training/MAIN_field.php'
                    ,'학교혁신' => 'http://design.eduniety.net/sub/training/MAIN_inno.php'
                    ,'수업개선' => 'http://design.eduniety.net/sub/training/MAIN_improve.php'
                    ,'교사성장' => 'http://design.eduniety.net/sub/training/MAIN_growth.php'
                    ,'교육철학' => 'http://design.eduniety.net/sub/training/MAIN_philo.php'
                    ,'ICT'      => 'http://design.eduniety.net/sub/training/MAIN_ICT.php'
                    ,'학급운영' => 'http://design.eduniety.net/sub/training/MAIN_class.php'
                )
            )
            ,'book' => array(
                'title' => 'BOOK'
                ,'aMenu' => array(
                     '전체'     => 'http://design.eduniety.net/membership/book'
                    ,'교육철학' => 'http://design.eduniety.net/membership/book/booklist/philosophy'
                    ,'학급운영' => 'http://design.eduniety.net/membership/book/booklist/classop'
                    ,'학교혁신' => 'http://design.eduniety.net/membership/book/booklist/inno'
                    ,'수업개선' => 'http://design.eduniety.net/membership/book/booklist/improvement'
                    ,'교사성장' => 'http://design.eduniety.net/membership/book/booklist/growth'
                    ,'자녀교육' => 'http://design.eduniety.net/membership/book/booklist/childedu'
                )
            )
            ,'tv' => array(
                'title' => 'TV'
                ,'aMenu' => array(
                     '전체'      => 'http://design.eduniety.net/sub/TV/MAIN_all.php'
                    ,'3분노하우' => 'http://design.eduniety.net/sub/TV/MAIN_3min_topics.php'
                    ,'Edu-DOCU'  => 'http://design.eduniety.net/sub/TV/MAIN_edudocu.php'
                    ,'강연'      => 'http://design.eduniety.net/sub/TV/MAIN_lecture.php'
                    ,'인터뷰'    => 'http://design.eduniety.net/sub/TV/MAIN_interview.php'
                    ,'교사창작'  => 'http://design.eduniety.net/sub/TV/MAIN_creat.php'
                    ,'연수영상'  => 'http://design.eduniety.net/sub/TV/MAIN_training.php'
                    ,'외부영상'  => 'http://design.eduniety.net/sub/TV/MAIN_outer.php'
                )
            )
        );

        $mb_id = $this->_isLogin();
        $aMemsvcInfo = ''; 
        $aUserInfo = ''; 
        if($mb_id)
        {
            $aMemsvcInfo = $this->membership_model->getMemsvcInfo($mb_id);
            $aUserInfo   = $this->membership_model->getUserInfo($mb_id);
        }
        $data = array(
            'isLogin' => $mb_id 
            ,'aMenu' => $aMenu
            ,'aMemsvcInfo' => $aMemsvcInfo 
            ,'aUserInfo'   => $aUserInfo
        );
            
        $this->load->view('menu/left_menu', $data);
    }
    
    public function index()
    {
        $this->portal();
    }
    public function portal($state='portal')
    {
        $this->mypage($state); 
    }
    public function training($state='training')
    {
        $this->mypage($state); 
    }
    public function book($state='book')
    {
        $this->mypage($state); 
    }
    public function tv($state='tv')
    {
        $this->mypage($state); 
    }
    public function mypage($state='portal')
    {
        
        $this->leftmenu(); 

        /*
         * 2017 / 03 / 20 마이페이지를 메뉴페이지로 변경 합니다.
         * 아래 코드는 기존 마이페이지 입니다
         * */        
        /*  
        $data = array();
        $data['myPage_state']  = $this->aLayoutConfig[$state];      // 기본 페이지 상태 레이아옷은 potal setting 
        $data['myPage_type']   = 'myPage_OUT';                      // 기본 뷰 레이아옷은 로그아웃으로 설정합니다.
        if($this->_isLogin() ) $data['myPage_type'] = 'myPage_IN'; 
        
        $data['view_userinfo'] = $this->_getViewUserInfo($state) ;
        $data['view_new_contents'] = $this->_getViewMyContents($state); 
               
        $this->load->view('mypage/myPage_book_out', $data);
        */
    }
    private function _getViewMyContents($state='portal')
    {
        $sFunctionName = '_getMyPageContents_'.$state;
        return $this->$sFunctionName(); 
    }
    private function _getViewUserInfo($state='portal')
    {
        $sFunctionName = '_getMyPage_'.$state;
        return $this->$sFunctionName(); 
    }
    private function _getNewContents()
    {
        $aViewDataNewContents = array(
            'aBook' => array(
                 (object)array('name'=>'행복한 교실을 위한 1-2-3 매직', 'writer'=>'토마스', 'price'=>'17000')
                ,(object)array('name'=>'행복한 교실을 위한 3-2-1 매직', 'writer'=>'터마스', 'price'=>'16900')
            ) 
            ,'aTraining'=> array(
                 (object)array('name'=>'직무7기' , 'term'=>'2017-01-01 ~ 2017-03-15') 
                ,(object)array('name'=>'직무8기' , 'term'=>'2017-02-01 ~ 2017-04-15') 
            )
            ,'aETraining'=> array(
                 (object)array('name'=>'직무7기' , 'term'=>'2017-01-01 ~ 2017-03-15') 
                ,(object)array('name'=>'직무8기' , 'term'=>'2017-02-01 ~ 2017-04-15') 
            )
        );
        return $aViewDataNewContents; 
    }
    private function _getMyPage_book()
    {
        /*
         * 멤버쉽 기본 정보를 기준으로 세팅합니다.
         * 기본은 비 로그인으로 설정을 합니다.
         */
        if($mb_id = $this->_isLogin())
        {
            $aViewData = array('aMemsvcInfo'=>"", 'class_state'=>'BOOK','pagename'=>'my_page_userinfo_book');

            // login 페이지 
            if ( $aMemsvcInfo = $this->membership_model->getMemsvcInfo($mb_id) )
            {
               //echo "<pre>";
               //print_r($aMemsvcInfo);
               //echo "</pre>";
                $aViewData = array('aMemsvcInfo'=>$aMemsvcInfo, 'class_state'=>'BOOK' ,'pagename'=>'my_page_userinfo_book');
            }
            return $this->load->view('mypage/my_page_userinfo', $aViewData, true) ;
        }
        return $this->load->view('mypage/my_page_userinfo', array('aMemsvcInfo'=>"",'class_state'=>'BOOK'), true);
    }
    private function _getMyPage_portal()
    {
        /*
         * 멤버쉽 기본 정보를 기준으로 세팅합니다.
         * 기본은 비 로그인으로 설정을 합니다.
         */
        if($mb_id = $this->_isLogin())
        {
            $aViewData = array('aMemsvcInfo'=>"", 'class_state'=>'PORTAL','pagename'=>'my_page_userinfo_portal');

            // login 페이지 
            if ( $aMemsvcInfo = $this->membership_model->getMemsvcInfo($mb_id) )
            {
                $aViewData = array('aMemsvcInfo'=>$aMemsvcInfo, 'class_state'=>'PORTAL','pagename'=>'my_page_userinfo_portal');
            }
            return $this->load->view('mypage/my_page_userinfo', $aViewData, true) ;
        }

        return $this->load->view('mypage/my_page_userinfo', array('aMemsvcInfo'=>"", 'class_state'=>'PORTAL') , true);
    }
    private function _getMyPage_training()
    {
        /*
         * 멤버쉽 기본 정보를 기준으로 세팅합니다.
         * 기본은 비 로그인으로 설정을 합니다.
         */
        if($mb_id = $this->_isLogin())
        {
            $aViewData = array('aMemsvcInfo'=>"", 'class_state'=>'TRAINING','pagename'=>'my_page_userinfo_training');

            // login 페이지
            if ( $aMemsvcInfo = $this->membership_model->getMemsvcInfo($mb_id) )
            {
                $aViewData = array('aMemsvcInfo'=>$aMemsvcInfo, 'class_state'=>'TRAINING','pagename'=>'my_page_userinfo_training');
            }
            return $this->load->view('mypage/my_page_userinfo', $aViewData, true) ;
        }
        return $this->load->view('mypage/my_page_userinfo', array('aMemsvcInfo'=>"",'class_state'=>'TRAINING'), true);
    }
    private function _getMyPage_tv()
    {
        /*
         * 멤버쉽 기본 정보를 기준으로 세팅합니다.
         * 기본은 비 로그인으로 설정을 합니다.
         */
        if($mb_id = $this->_isLogin())
        {
            $aViewData = array('aMemsvcInfo'=>"", 'class_state'=>'TV','pagename'=>'my_page_userinfo_tv');

            // login 페이지 
            if ( $aMemsvcInfo = $this->membership_model->getMemsvcInfo($mb_id) )
            {
                //$aViewData = array('aMemsvcInfo'=>$aMemsvcInfo, 'class_state'=>'TV','pagename'=>'my_page_userinfo_tv');
                // Book 정보가 정리 되니 않아서
                // 기본 포털정보로 세팅합니다 
                $aViewData = array('aMemsvcInfo'=>$aMemsvcInfo, 'class_state'=>'TV','pagename'=>'my_page_userinfo_portal');
                
            }
            return $this->load->view('mypage/my_page_userinfo', $aViewData, true) ;
        }
        return $this->load->view('mypage/my_page_userinfo', array('aMemsvcInfo'=>"",'class_state'=>'TV'), true);
    }
    
    private function _getMyPageContents_book()
    {
        $mb_id = $this->_isLogin();
        $aMyContentsInfo = $this->membership_model->getMyContentsBook($mb_id) ;

        $aViewData = array('aMyContentsInfo' => $aMyContentsInfo, 'isLogin'=>$mb_id);
        return $this->load->view('mypage/my_page_set_book', $aViewData, true) ;
    } 
    private function _getMyPageContents_training()
    {
        $mb_id = $this->_isLogin();
        $aMyContentsInfo = $this->mypage_model->getMyContentsTraining($mb_id) ;

        $aViewData = array('aMyContentsInfo' => $aMyContentsInfo, 'isLogin'=>$mb_id);
        return $this->load->view('mypage/my_page_set_training', $aViewData, true) ;
    } 
    private function _getMyPageContents_tv()
    {
        $mb_id = $this->_isLogin();
        $aMyContentsInfo = $this->mypage_model->getMyContentsTV($mb_id) ;

        $aViewData = array('aMyContentsInfo' => $aMyContentsInfo, 'isLogin'=>$mb_id);
        return $this->load->view('mypage/my_page_set_tv', $aViewData, true) ;
    } 
    private function _getMyPageContents_portal()
    {
        $mb_id = $this->_isLogin();
        $aMyContentsInfo = $this->mypage_model->getMyContentsPortal($mb_id) ;

        $aViewData = array('aMyContentsInfo' => $aMyContentsInfo, 'isLogin'=>$mb_id);
        return $this->load->view('mypage/my_page_set_portal', $aViewData, true) ;
    } 
    
    // ################################### //
    // ########## rpc  Function ########## //
    // ################################### //
    public function rpcBuy()
    {
        return ;

        $post_mb_id = $this->input->post('mb_id');
        $sale_idx   = $this->input->post('sale_idx');
        
        // mb_id userinfo check
        if(!$oMemInfo = $this->_isMember($post_mb_id))
        {
            $aMSG = array('data'=>array('code'=>101, 'msg'=>'존재하지 않는 아이디 입니다.') );
            response_json($aMSG);
            die;
        } 
    

        // 구매프로세스  
        // 예상 PG page --> 완료 전달 페이지 
        // 만약에 완료 전달 페이지가 필요 하다면 
        // _rpcBuyPorcess 를 랩핑하는 하나의 페이지를 만들자
       
        if( $this->_rpcBuyProcess($post_mb_id, $sale_idx) )
            $aMSG = array('data'=>array('code'=>1, 'msg'=>'정상구매완료') );
        else
        {
            $aMSG = array('data'=>array('code'=>201, 'msg'=>'구매실패') );
            // 해당 로그를 저장하는 어딘가가 있어야 함
        }

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


}
