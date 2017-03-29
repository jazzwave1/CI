<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MolClass {

    public function __construct()
    {
        $a = func_get_args();
        $i = func_num_args();
        if (method_exists($this,$f='__construct'.$i))
        {
        call_user_func_array(array($this,$f),$a);
        }
    }
    public function  __construct1($member_no)
    {
        if(!$member_no) return false;
        
        $this->member_no = $member_no;
        $this->ftp_path = "/ftp/titanbooks";
        
        // book_dao model copy -------------------------------------------//
        $this->file_path    = "/home/epubweb/ftp/titanbooks/";
        $this->img_url_path = "http://ebook.eduniety.net/ftp/titanbooks/";
        // ---------------------------------------------------------------//
    }
    public function index()
    {
    }
    /*
     * 장바구니 담기
     * Input param : controllers/Book.php api 참조 
     * */
    public function setMyCart($aParam)
    {
        $this->updateCartHit($aParam['g_num']);
        
        $result = $this->isMyCartContent($aParam['member_no'], $aParam['g_num']);
        
        if(!$result) return array('code'=>999, 'msg'=>'입력값 오류입니다.', 'idx'=>'');
        if($result != 'F' && $result ) return array('code'=>301, 'msg'=>'이미 카트에 존재합니다.', 'idx'=>$result);

        if( $idx = $this->setMyCartContent($aParam) )
            return array('code'=>1, 'msg'=>'OK', 'idx'=>$idx);
        else    
            return array('code'=>999, 'msg'=>'System Error', 'idx'=>'');
    }
    /*
     * 카트에 동일한 상품이 있는지 확인 함
     * return T/F
     * return false : no param
     * */
    public function isMyCartContent($member_no, $g_num)
    {
        if(!$member_no || !$g_num) return false; 
       
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        if ($idx = $oMolDAO->chkMyCartInfo($member_no, $g_num) )
            return $idx;
        else
            return "F";
    }
    /*
     * 책 상품의 히트 카운트를 올려준다.
     * */
    public function updateCartHit($g_num)
    {
        if(!$g_num) return false; 
        
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->updateMyCartHit($g_num); 
    }
    /*
     * 카트정보 실제로 저장
     * */
    public function setMyCartContent($aParam)
    {
        // add param
        $aParam['ex_case'] = 'cart';
        
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->setGoodsExtralist($aParam); 
    }
    

    private function _deleteTodayGoods()
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->deleteTodayGoods(); 
    }
    private function _insertTodayGoods($aParam)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->insertTodayGoods($aParam); 
    }
    /*
     * 오늘본상품을 기준으로 삭제 및 저장
     * */
    private function _setTodayGoods($aParam)
    {
        $this->_deleteTodayGoods();
        $this->_insertTodayGoods($aParam);
        return;
    } 
    private function _deleteGoodsExtralist($member_no, $g_num, $ex_case)
    {
        if(!$member_no || !$g_num) return false;
        
        $aInput = array(
             'member_no' => $member_no
            ,'g_num'     => $g_num
            ,'ex_case'   => $ex_case 
        ); 
        // getGoodsExtralist
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        $result = $oMolDAO->getGoodsExtralist($aInput);
        
// test code
// echo "<<<<<<<<<<<<<<<<<<";
// print_r($result); 
// print_r(count($result)); 
        
        if(is_array($result) && count($result) > 1)
        {
            foreach($result as $key=>$val)
            {
                $oMolDAO->deleteGoodsExtralist($val->idx);
            }
            return true; 
        }
        if(is_array($result) && count($result) == 1)
        {
            return false;
        }
        
        return true;
    }
    public function getGoodsExtralist($aInput)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->getGoodsExtralist($aInput); 
    }
    public function getImgName($g_num, $rType = 'ftp')
    {
        $aInput = array('g_num'=>$g_num, 'gf_type'=>110);
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $this->_getImgURL($oMolDAO->getBookImgInfo($aInput), $rType); 
    } 
    private function _getImgURL($oBookImgInfo, $rType = 'ftp')
    {
        if($rType == 'ftp') 
            return $this->ftp_path."/_good/".$oBookImgInfo->gf_filename_new;
        else
            return $this->img_url_path."/_good/".$oBookImgInfo->gf_filename_new;

    }
    public function setDetailView($member_no, $g_num, $aBookDetailInfo)
    {
        /* 
         * insert goods_exrtalist 1row
         * ex_case : book_view 
         * titanbook 관리자에서는 최근 1건만 남기가 다시 삭제 한다. 
         */
        if(!$member_no) return false;

        // setting today_goods
        $img_name = $this->getImgName($g_num); 
        $aParamTodayGoods['date']     = date('Y-m-d');
        $aParamTodayGoods['datetime'] = date('Y-m-d H:i:s');
        $aParamTodayGoods['ip']       = $_SERVER["REMOTE_ADDR"] ;
        $aParamTodayGoods['g_num']    = $g_num;
        $aParamTodayGoods['gccode']   = $aBookDetailInfo['gccode'];
        $aParamTodayGoods['img_name'] = $img_name;
        $aParamTodayGoods['mem_no']   = $member_no;
        $this->_setTodayGoods($aParamTodayGoods); 

        // 최근 데이터만 살린다.
        $ex_case = "book_view";
        if( $this->_deleteGoodsExtralist($member_no, $g_num, $ex_case) )
        {
            // add param
            $aParam['ex_case']        = 'book_view';
            $aParam['g_num']          = $g_num ; 
            $aParam['gccode']         = $aBookDetailInfo['gccode'] ; 
            $aParam['member_no']      = $member_no ; 
            $aParam['g_name']         = $aBookDetailInfo['g_name'] ; 
            $aParam['g_price']        = $aBookDetailInfo['g_price'] ; 
            $aParam['g_price_street'] = $aBookDetailInfo['g_price_street'] ; 
            $aParam['g_point']        = $aBookDetailInfo['g_point'] ; 
            $aParam['g_point_div']    = $aBookDetailInfo['g_point_div'] ; 
            $aParam['point_val']      = $aBookDetailInfo['point_val'] ; 
            $aParam['author_name']    = $aBookDetailInfo['author_name'] ; 
            $aParam['book_com']       = $aBookDetailInfo['book_com'] ; 
            $aParam['date_val']       = $aBookDetailInfo['date_val'] ; 

            $oMolDAO = edu_get_instance('Mol_dao', 'model');
            return $oMolDAO->setGoodsExtralist($aParam); 
        }
        return ; 
    }
    public function getBuyBookInfo($member_no, $idx)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->getBuyBookInfo($member_no, $idx);
    }
    /*
     * 구매기록이 있는 책인지 확인함
     * */
    public function chkBuyBook($member_no, $g_num)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        $aRtn = $oMolDAO->chkBuyBook($member_no, $g_num);
        if($aRtn[0]->order_Count > 0)
            return '1';
        else 
            return '0';
    }
    /*
     * 카트정보가지고 오기
     * */
    public function getMyCartInfo($member_no='')
    {
        if(!$member_no) return false;

        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->getMyCartInfo($member_no);
    }

    /*
     *  마일리지 사용현황을 저장합니다. 
     * */
    public function setShopMileage($member_no, $order_code, $mileage_get)
    {
        if(!$member_no || !$order_code || !$mileage_get) return false;
        
        $this->_insertShopMemberMileage($member_no, $order_code, $mileage_get); 
        $this->_updateCyberPoint($member_no, $mileage_get); 
    }
    private function _insertShopMemberMileage($member_no, $order_code, $mileage_get)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->insertShopMemberMileage($member_no, $order_code, $mileage_get);
    }
    private function _updateCyberPoint($member_no, $mileage_get)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->updateCyberPoint($member_no, $mileage_get);
    }
    /*
     * 쿠폰 사용처리 
     * */
    public function setCoupon($order_code, $coupon_list_no)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->updateCoupon($order_code, $coupon_list_no);
    }
    /*
     * 주문정보저장
     * 상품판매리스트 증가
     * */
    public function setShopOrder($oMem, $order_code, $mileage_flag,  $aParam, $aConfigPayType, $coupon_list_no, $coupon_price)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->setShopOrder($oMem, $order_code, $mileage_flag,  $aParam, $aConfigPayType, $coupon_list_no, $coupon_price);
    }
    public function setShopOrderList($order_code, $extralist_idx, $member_no)
    {
        $orderBookInfo = $this->_getBookInfoFromMyCart($extralist_idx, $member_no) ;

        foreach($orderBookInfo as $key=>$val)
        {
            $aInput['order_code']= $order_code;
            $aInput['g_num']     = $val->g_num;
            $aInput['gc_code']   = $val->gccode;
            $aInput['g_name']    = $val->g_name;
            $aInput['order_price'] = $val->g_price;
            $aInput['point_val'] = $val->point_val;
            $aInput['member_no'] = $member_no;
            
            $this->_setShopOrderList($aInput);
            $this->_updateSellHit($val->g_num);
        }
    }
    private function _updateSellHit($g_num)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->updateSellHit($g_num);
    }
    private function _setShopOrderList($aInput)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->setShopOrderList($aInput);
    }
    private function _getBookInfoFromMyCart($extralist_idx, $member_no)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->getBookInfoFromMyCart($extralist_idx, $member_no);
    }
    /*
     * 카트정보 삭제
     * */
    public function delCartBook($member_no, $extralist_idx)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->deleteCartBook($extralist_idx , $member_no);
    }
    /*
     * 구매 내역 조회 
     * */
    public function getShopOrder($member_no)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->getShopOrder($member_no);
    }
    public function getShopOrderList($order_code)
    {
        $oMolDAO = edu_get_instance('Mol_dao', 'model');
        return $oMolDAO->getShopOrderList($order_code);
    }

}
