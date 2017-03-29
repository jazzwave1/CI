<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Book extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        session_start();

        $this->ebook_model= edu_get_instance('book_model','model');
        $this->today = date('Y-m-d H:i:s');
        $this->file_path    = "/home/epubweb/ftp/titanbooks/"; 
        $this->img_url_path = "/ftp/titanbooks/";
        $this->aCategoryInfo = array(
            'philosophy'  => array('name'=>'교육철학'    ,'categorynum'=>12  ,  'listnum'=>1)
           ,'classop'     => array('name'=>'학급운영'    ,'categorynum'=>14  ,  'listnum'=>2)
           ,'inno'        => array('name'=>'학교혁신'    ,'categorynum'=>1   ,  'listnum'=>3)
           ,'improvement' => array('name'=>'수업개선'    ,'categorynum'=>10  ,  'listnum'=>4)
           ,'growth'      => array('name'=>'교사성장'    ,'categorynum'=>11  ,  'listnum'=>5)
        //   ,'dbook'       => array('name'=>'디지털교과서','categorynum'=>0 ,  'listnum'=>0)
           ,'childedu'    => array('name'=>'자녀교육'    ,'categorynum'=>17  ,  'listnum'=>6)
        //   ,'child'       => array('name'=>'어린이'      ,'categorynum'=>0 ,  'listnum'=>0)
        //   ,'etc'         => array('name'=>'기타'        ,'categorynum'=>0 ,  'listnum'=>0)
           ,'all'         => array('name'=>'전체'        ,'categorynum'=>0   ,  'listnum'=>0)
        );
        
        $this->aPayType = array(
             "membership" => 7  // 멤버쉽
            ,"bank" => 1        // 온라인
            ,"card" => 2        // 카드
            ,"escrow" => 3      // 에스크로우
            ,"account" => 4     // 계좌이체
            ,"phone" => 5       // 휴대폰
            ,"ars_line" => 6    // ARS
        );
        $this->aConfigEAStep = array(
             0 => "결제확인중"
            ,1 => "결제확인중"
            ,2 => "결제완료"
            ,3 => "환불요청"
            ,4 => "주문취소"
            ,5 => "주문완료"
            ,6 => "환불요청"
            ,7 => "주문취소"
            ,8 => "결제확인중"
            ,9 => "결제확인중"
        );
    }
    
    // ####################################### //
    // ########## web Page Function ########## //
    // ####################################### //
    public function index()
    {
        $this->booklist();
    }
    /**
     * $type 
     *  : all or null => main
     *  : philosophy  => 교육철학 : 12
     *  : classop     => 학급운영 : 14
     *  : inno        => 학교혁신 : 1
     *  : improvement => 수업개선 : 10
     *  : growth      => 교사성장 : 11
     *  : dbook       => 디지털교과서: x
     *  : childedu    => 자녀교육 : x
     *  : child       => 어린이 : x
     *  : etc         => 기타 : x
     *  $type 별로 추가 될 부분을 고려하여 확장이 가능하도록 구성한다
     *  titanbooks.goods_category table 의 내용을 기반으로 gc_num 은 구성된다
     *  변경시 테이블을 기준으로 다시 잡는다
    * **/
    public function booklist($type='all')
    {

        // test code
        echo "<!--";
        //print_r($this->aCategoryInfo); 
        echo "-->";

        if($type == 'all')
        {
            $this->booklist_all();
        }
        else
        {
            $aCategory = $this->aCategoryInfo[$type];

            if($aCategory['categorynum'] == 'x' || !$aCategory['categorynum'])
                $this->booklist_all();

            $this->booklist_category($aCategory);
        }
    }
    public function booklist_all()
    {
        if(!$aALLResult = $this->ebook_model->getBookList())
        {
            // no data
            // 기획이 필요합니다.
            // 검색범위를 넓혀서 검색을 합니다.
        }
        else
        {
            $data = array();
            $aViewDataNewContents['ALLlist'] = $aALLResult;
        }

        $mb_id = $this->_isLogin();        
        $data['aCategory'] = $this->aCategoryInfo; 
        $data['isLogin'] = $mb_id; 
        $data['contents'] = $this->load->view('book/book_list_all', $aViewDataNewContents, true) ;
        $this->load->view('book/book_out', $data);
    } 
    public function booklist_category($aCategory)
    {
        if(!$aResult = $this->ebook_model->getBookListFromCategory($aCategory['categorynum']))
        {
           $this->page_home = "/membership/book/booklist/all";
            echo "<script>alert('데이터가 존재하지 않아 전체로 이동합니다');window.location.href='".$this->page_home."'</script>";
        }
        else
        {
            $data = array();
            $aViewDataNewContents['booklist'] = $aResult;
            $aViewDataNewContents['sCategoryName'] = $aCategory['name'];
    
            $mb_id = $this->_isLogin();        
            $data['aCategory'] = $this->aCategoryInfo; 
            $data['isLogin']   = $mb_id; 
            $data['contents']  = $this->load->view('book/book_list_cat', $aViewDataNewContents, true) ;
            $this->load->view('book/book_out', $data);
        }

    }
	public function detail($g_num)
    {
        if(!$g_num)
        {
            $sLoginURL = "/membership/book/booklist/all";
            echo "<script>alert('존재하지 않은 책입니다.');window.location.href=' ".$sLoginURL."'</script>";
        }
        
        $member_no = '';
        $mb_id = $this->_isLogin();        
        
        if($mb_id) 
        {
            // SSO 를 통해서 member_no 를 가지고 와야함
            // member_no 
            $mem  = edu_get_instance('MemClass');        
            $oMem = new $mem($mb_id);
            $member_no = $oMem->oSSOInfo->t_usn;    
        }
       
        // get Book Detail Info
        $aBookDetailInfo = $this->ebook_model->getBookDetailInfo($g_num, $member_no, $mb_id) ;

        $isBUY = 0;
        if($member_no)
        {
            
            // 기존에 goods_extralist insert ex_case : book_view setting  /  delete 
            $mol = edu_get_instance('MolClass');        
            $oMol = new $mol($member_no);
            $oMol->setDetailView($member_no, $g_num, $aBookDetailInfo);
        
            // 구매기록이 있는지 확인
            $isBUY = $oMol->chkBuyBook($member_no, $g_num); 
        }
        
        $data = array();
        $aBookDetailInfo = array( 
            'aBookDetailInfo' => $aBookDetailInfo
            ,'isBUY' => $isBUY
        );
        
        $data['aCategory'] = $this->aCategoryInfo; 
        $data['isLogin'] = $mb_id; 
        $data['contents'] = $this->load->view('book/book_detail', $aBookDetailInfo, true) ;
        $this->load->view('book/book_out', $data);
    }
    public function mybook()
    {
        // mci 만 현재 디비를 라이브로 보고 있습니다. 
        // 
        $mb_id = $this->_isLogin();

        if(!$mb_id)
        {
            $sLoginURL = "/sub/PORTAL/MEMBER_login.php?url=/";
            echo "<script>alert('로그인이 필요합니다.');window.location.href=' ".$sLoginURL."'</script>";
        }
        else
        {
            // SSO 를 통해서 member_no 를 가지고 와야함
            // member_no 
            $mem  = edu_get_instance('MemClass');        
            $oMem = new $mem($mb_id);
            $member_no = $oMem->oSSOInfo->t_usn;    

// test code
// echo "<!--";
// print_r($oMem);
// echo "-->";
            
            $aMyBookList = array(
                'aMyBookList' => $this->ebook_model->getMyBookList($member_no)
                ,'member_no'  => $member_no
                ,'mb_id'      => $mb_id
            ); 
            
// test code
echo "<!--";
//print_r($aMyBookList);
echo "-->";
            
            $data = array();
            $mb_id = $this->_isLogin();        
            $data['aCategory'] = $this->aCategoryInfo; 
            $data['isLogin'] = $mb_id; 
            $data['contents'] = $this->load->view('book/my_book', $aMyBookList, true) ;
            $this->load->view('book/book_out', $data);

        }
    }
    public function buy($nGoodsExtralistIDX)
    {
        $mb_id = $this->_isLogin();        

        // SSO 를 통해서 member_no 를 가지고 와야함
        // member_no 
        $mem  = edu_get_instance('MemClass');        
        $oMem = new $mem($mb_id);
        $member_no = $oMem->oSSOInfo->t_usn;    
        
        // MyCart Insert process  
        $mol = edu_get_instance('MolClass');        
        $oMol = new $mol($member_no);
        $result = $oMol->getBuyBookInfo($member_no, $nGoodsExtralistIDX) ;

        // get Membership Service Info
        $memsvc = edu_get_instance('member_model', 'model'); 
        $aMemSVCInfo = $memsvc->getMemsvcInfo($mb_id); 

        // set aPayInfo
        $aPayInfo['member_no'] = $member_no;
        $aPayInfo['mb_id']     = $mb_id;
        $aPayInfo['sum_total'] = $result->g_price;
        $aPayInfo['sum_point'] = $result->g_point;
        $aPayInfo['extralist_idx'] = $result->idx;
        $aPayInfo['payment_div'] = 'bank';
        $aPayInfo['bank_name'] = "국민은행 | 123-456-789 | 에듀니티";

        if(!$aMemSVCInfo)
        {
            // 멤버쉽회원 미 구매자
            // 어떻게 처리 할 것인가?
            // 일단 결재 못하게 막아 놓음 
        }

echo "<!--";
//print_r($oMem);
//echo $member_no; 
//print_r($result);
//print_r($aMemSVCInfo);
echo "-->";


        $data = array();
        $aBuyBook = array( 
            'oBookInfo'  => $result
           ,'aMemSVCInfo'=> $aMemSVCInfo 
           ,'aPayInfo'   => $aPayInfo
        );
        
        $data['aCategory'] = $this->aCategoryInfo; 
        $data['isLogin'] = $mb_id; 
        $data['contents'] = $this->load->view('book/book_buy', $aBuyBook, true) ;
        $this->load->view('book/book_out', $data);
    }
    
    public function  mycart()
    {
        $member_no = '';
        $mb_id = $this->_isLogin();        
        
        $aMyCartList = array();
        
        if($mb_id) 
        {
            // SSO 를 통해서 member_no 를 가지고 와야함
            // member_no 
            $mem  = edu_get_instance('MemClass');        
            $oMem = new $mem($mb_id);
            $member_no = $oMem->oSSOInfo->t_usn;    
      
            $mol = edu_get_instance('MolClass');        
            $oMol = new $mol($member_no);
            $aResult = $oMol->getMyCartInfo($member_no) ;
            
            foreach($aResult as $key=>$val)
            {
                $aMyCartList[$key]['booktitle']   = $val->g_name;
                $aMyCartList[$key]['author_name'] = $val->author_name;
                $aMyCartList[$key]['price']       = $val->g_price;
                $aMyCartList[$key]['sImgURL']     = $oMol->getImgName($val->g_num, 'img_url');

            }
// test code
// echo "<!--";
// print_r($oMem);
// print_r($aResult);
// print_r($aMyCartList);
// echo "-->";
        
            $memsvc = edu_get_instance('member_model', 'model'); 
            $oMemSVCInfo = $memsvc->getMemsvcInfo($mb_id); 
            
// // test code
// echo "<!--";
// print_r($oMemSVCInfo);
// echo "-->";
        
             
        }
 
        $data = array();
        $aMyCartList = array('aMyCartList'=>$aMyCartList);
        
        $data['aCategory'] = $this->aCategoryInfo; 
        $data['isLogin'] = $mb_id; 
        $data['contents'] = $this->load->view('book/my_cart', $aMyCartList, true) ;
        $this->load->view('book/book_out', $data);
    }
    
    public function buylist()
    {
        $mb_id = $this->_isLogin();        

        // 비로그인 상태는 로그인 페이지로 돌립니다. 
        if(!$mb_id)
        {
            $sLoginURL = "/sub/PORTAL/MEMBER_login.php?url=/";
            echo "<script>alert('로그인이 필요합니다.');window.location.href=' ".$sLoginURL."'</script>";
        } 

        // SSO 를 통해서 member_no 를 가지고 와야함
        // member_no 
        $mem  = edu_get_instance('MemClass');        
        $oMem = new $mem($mb_id);
        $member_no = $oMem->oSSOInfo->t_usn;    
        
        // MyCart Insert process  
        $mol = edu_get_instance('MolClass');        
        $oMol = new $mol($member_no);
        $aShopOrder= $oMol->getShopOrder($member_no);

        $aResult = array();
        echo "<!--"; 
        //print_r($aShopOrder);
        
        $cnt = 0;
        foreach($aShopOrder as $key=>$val)
        {
            if( $aTemp = $oMol->getShopOrderList($val->order_code) )
            {
                $aResult[$cnt]['ShopOrderList'] = $aTemp[0]; 
                $aResult[$cnt]['ShopOrder'] = $val; 
                $aResult[$cnt]['img_url'] = $oMol->getImgName($aTemp[0]->g_num, "img"); 
                $aResult[$cnt]['ShopOrderList']->sEaOrderStep = $this->aConfigEAStep[$aTemp[0]->ea_order_step]; 
            
                $cnt++;
            }
        }

        //print_r($aResult); 
        echo "-->"; 
        
        $data = array();
        $aBuyBookList = array("aBuyBookInfo" => $aResult);
        
        $data['aCategory'] = $this->aCategoryInfo; 
        $data['isLogin'] = $mb_id; 
        $data['contents'] = $this->load->view('book/book_buy_list', $aBuyBookList, true) ;
        $this->load->view('book/book_out', $data);
    }
    public function  cancel()
    {
        $data = array();
        $aCancelBook= array();
        
        $mb_id = $this->_isLogin();        
        
        $data['aCategory'] = $this->aCategoryInfo; 
        $data['isLogin'] = $mb_id; 
        $data['contents'] = $this->load->view('book/book_buy_cancel', $aCancelBook, true) ;
        $this->load->view('book/book_out', $data);
    }

    private function _isLogin()
    {
        // test code 
        // $mb_id = 'ahnjaejo';
        // return $mb_id;

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

    // ############################################# //
    // ########## API & Rpc Page Function ########## //
    // ############################################# //
    /*
     * 내서재 북삭제 로직 
     * */
    public function apiDelMyBookInfo()
    {
        // chk Input Param
        $aPostConfig = array('mb_id','member_no', 'chkMyBookList');
        foreach($aPostConfig as $key=>$val)
        {
            $$val = $this->input->post($val);   
        }
        // chk BookList
        if(count($chkMyBookList) == 0)
        {
            $aMSG = array('code'=>102, 'msg'=>'선택된 책이 없습니다.' );
            response_json($aMSG);
            die;
       
        }
        // chk member info 
        if(!$mb_id || !$member_no)
        {
            $aMSG = array('code'=>100, 'msg'=>'로그인이 필요합니다' );
            response_json($aMSG);
            die;
        }
        
        // session chk  
        if( $this->_isLogin() != $mb_id) 
        {
            $aMSG = array('code'=>101, 'msg'=>'비정상접근입니다.' );
            response_json($aMSG);
            die;
        }

        $bRtn = true; 
        // del proc
        foreach($chkMyBookList as $key=>$val)
        {
            $aTemp = explode('|', $val);
            $list_no = $aTemp[0];
            $g_num   = $aTemp[1];
            
            if (!$this->ebook_model->delMyBookInfo($list_no, $g_num, $member_no) )
            {
                $bRtn = false;
                break;
            }
        } 
        if($bRtn)
        {
            $aMSG = array('code'=>1, 'msg'=>'OK' );
            response_json($aMSG);
            die;
        }
        else
        {
            $aMSG = array('code'=>999, 'msg'=>'시스템 오류입니다.' );
            response_json($aMSG);
            die;
        } 
    }
    /*
     * 장바구니 담기 
     * 장바구니에 담고 나서 구매로직이 일어 난다
     * input param
     *  member_no
     *  g_num
     *  gccode
     *  g_name   : 상품명
     *  g_price_street  : 시중가 즉 소비자가
     *  g_price  : 상품등록시 입력한 판매가
     *  g_point  : 상품등록시 입력한 적립금
     *  g_point_div  : 상품등록시 적립금 구분 퍼센트냐, 원이냐
     *  point_val  : 판매가에 맞춰 계산된 적립금 금액
     *  author_name : 지은인(저작자)
     *  book_com  : 출판사
     *  date_val  : 최초등록일
     **/
    public function apiSetMyCart()
    {
        // chk Input Param
        $aPostConfig = array('mb_id','member_no', 'g_num', 'gccode', 'g_name', 'g_price_street', 'g_price', 'g_point', 'g_point_div', 'point_val', 'author_name', 'book_com', 'date_val');
        foreach($aPostConfig as $key=>$val)
        {
            $aParam[$val] = $this->input->post($val);   
        }
        
        // chk member info 
        if(!$aParam['mb_id'] || !$aParam['member_no'])
        {
            $aMSG = array('code'=>100, 'msg'=>'로그인이 필요합니다' );
            response_json($aMSG);
            die;
        }
        // real member info chk 

        // fingerprint chk

        // SSO 를 통해서 member_no 를 가지고 와야함
        // member_no 
        $mem  = edu_get_instance('MemClass');        
        $oMem = new $mem($aParam['mb_id']);
        $member_no = $oMem->oSSOInfo->t_usn;    
        
// echo "<!--";
// print_r($oMem);
// print_r($aParam);
// echo $member_no; 
// echo "-->";

        // MyCart Insert process  
        $mol = edu_get_instance('MolClass');        
        $oMol = new $mol($aParam['member_no']);
        $result = $oMol->setMyCart($aParam) ;
        
        response_json($result);
        die;
    }
    /*
     * 상품구매 프로세스
     * */ 
    public function apiProcBuy()
    {
        // init data 
        $mileage_flag = "no"; 
        $coupon_select = "";
        $coupon_list_no = 0;
        $coupon_price = 0;

        // test code 
        // print_r($_POST);
        
        // chk Input Param
        $aPostConfig = array('member_no', 'mb_id', 'org_sum_total', 'End_Order_Price_SUM', 'mileage_set', 'mileage_get', 'extralist_idx', 'payment_div', 'bank_name', 'g_num');
        foreach($aPostConfig as $key=>$val)
        {
            $aParam[$val] = $this->input->post($val);   
        }
        
        // chk member info 
        if(!$aParam['mb_id'] || !$aParam['member_no'])
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

        // SSO 를 통해서 member_no 를 가지고 와야함
        // member_no 
        $mem  = edu_get_instance('MemClass');        
        $oMem = new $mem($aParam['mb_id']);
        $member_no = $oMem->oSSOInfo->t_usn;    

        // test code        
        // print_r($oMem);
        // print_r($aParam);
        // echo $member_no; 

        // 주문번호 생성!
        $order_code = time(); 

        $mol = edu_get_instance('MolClass');        
        $oMol = new $mol($aParam['member_no']);

        
        // membership 구매 관련 채크로직
        // 멀티 구매 로직시 카운트 부분을 수정 하셔야 합니다.
        // 단권구매만 현재 허용을 합니다. 
        $type = "b"; // book  
        $content_idx = $aParam['g_num'];
        $credit = 0;
        
        $oMember_model = edu_get_instance('member_model','model');
        $aChkPurchaseInfo = $oMember_model->chkPurchaseInfo($aParam['mb_id']);
        if($aChkPurchaseInfo['available_cnt'][$type] < 1 )
        {
            // 가능한 수량이 없음  
            $aMSG = array('code'=>300, 'msg'=>'가능수량이 없습니다.' );
            response_json($aMSG);
            die;
        }

        // 마일리지 사용시 차감 
        if($aParam['mileage_get'] > 0)
        {
            // set shop_member_mileage
            // update member cyber_point
            $oMol->setShopMileage($aParam['member_no'],$order_code, $aParam['mileage_get']) ;
            $mileage_flag = "yes"; 
        }
        
        // 쿠폰사용시 처리 
        if($coupon_select)
        {
            $coupon_select_tmp = explode("_@_",$coupon_select);
                
            $coupon_price = $coupon_select_tmp[0];
            $coupon_list_no = $coupon_select_tmp[1];
            
            // 쿠폰을 사용함으로 처리
            if($coupon_list_no != "")
            {
                $oMol->setCoupon($order_code, $coupon_list_no);
            } 
        } 

        // 주문정보저장 
        $oMol->setShopOrder($oMem, $order_code, $mileage_flag, $aParam, $this->aPayType, $coupon_list_no, $coupon_price); 
        
        // 주문정보저장 
        $oMol->setShopOrderList($order_code, $aParam['extralist_idx'], $aParam['member_no']); 

        // cart 에서 삭제 한다. 
        $oMol->delCartBook($aParam['member_no'], $aParam['extralist_idx']) ;

        // membership Book Info Setting
        $this->pBuyMembershipContents($aParam['mb_id'], $type, $content_idx, $credit);        
       
        $aMSG = array('code'=>1, 'msg'=>'OK' );
        response_json($aMSG);
        die;
    }
    public function pBuyMembershipContents($mb_id, $type, $content_idx, $credit)
    {   
        // Member Controller copy

        $oMember_model = edu_get_instance('member_model','model');
        
        // 멤버쉽 회원이 연수랑 책 구매시 관련 정보를 저장함 
        // type [ et : 원격연수, t:현장연수, b:책 ]
        if(!$mb_id || !$type || !$content_idx)
        {
            $aMSG = array('data'=>array('code'=>301, 'msg'=>'Input param error') );
            return $aMSG;
        }

        $mb_id = trim($mb_id);
        $type  = trim($type);
        $content_idx = trim($content_idx);
        $credit = trim($credit);
        $fingerprint = "1234"; // dummy value
        
        // set log info -----------------------// 
        $aLogInfo['mb_id'] = $mb_id;
        $aLogInfo['type']  = 'buy';
        $aLogInfo['sale_type'] = $type;
        $aLogInfo['sale_idx']  = $content_idx;
        $aLogInfo['regdate']   = $this->today ; 
        $aLogInfo['user_id']   = $mb_id; 
        $aLogInfo['msg']       = ''; 
        // ------------------------------------//
 
        if( !$oMember_model->pBuyContent($mb_id, $type, $content_idx, $fingerprint, $credit))
        {
            $aMSG = array('data'=>array('code'=>401, 'msg'=>'NO Count') );
            $aLogInfo['type']  = 'fail';
            $aLogInfo['msg']  = $aMSG['data']['msg'];
            $this->member_model->setLog($aLogInfo); 
            return $aMSG;
        }
        
        $this->member_model->setLog($aLogInfo); 
        return true;
    }
    /*
     * 모바일 메일 홈 
     * Book List 를 보여주는 API
     * */
    public function apiGetMainBookList($type='all')
    {
        if($type == 'all')
        {
            $aResult = $this->ebook_model->getNewBook();
        }
        else
        {
            $aCategory = $this->aCategoryInfo[$type];

            if($aCategory['categorynum'] == 'x' || !$aCategory['categorynum'])
                $aResult = $this->ebook_model->getNewBook();
            else
                $aResult = $this->ebook_model->getBookListFromCategory($aCategory['categorynum']);
        }

        $aResult = array(
            "code" => 1 
            ,"msg" => "OK" 
            ,"type" => $type 
            ,"typeString" => $this->aCategoryInfo[$type]['name']
            ,"result" => $aResult
        );
        response_json($aResult); 
    }
}
