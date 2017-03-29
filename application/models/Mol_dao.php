<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'models/Common_dao.php');

class Mol_dao extends Common_dao
{
    public function __construct()
    {
        $this->ebook_db = $this->load->database('ebook', true);
        $aQueryInfo = edu_get_config('query', 'query');  
        $this->queryInfoMol = $aQueryInfo['eBook'];  
    }
    public function chkMyCartInfo($member_no, $g_num)
    {
        $aInput = array('member_no'=>$member_no, 'g_num'=>$g_num);
        $aConfig = $this->queryInfoMol['chkMyCartInfo'];
        if( $aRtn = $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) )
            return $aRtn[0]->idx;
        else
            return $aRtn;
    }
    public function updateMyCartHit($g_num)
    {
        $aInput = array('g_num'=>$g_num);
        $aConfig = $this->queryInfoMol['updateMyCartHit'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function setGoodsExtralist($aParam)
    {
        // add param
        $aParam['ip'] = $_SERVER['REMOTE_ADDR'];
        $aParam['regdate'] = date('Y-m-d H:i:s');
        
        $aConfig = $this->queryInfoMol['setGoodsExtralist'];
        $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
        
        return $this->ebook_db->insert_id();
    }
    public function getBuyBookInfo($member_no, $idx)
    {
        $aInput = array('member_no'=>$member_no, 'idx'=>$idx);
        $aConfig = $this->queryInfoMol['getBuyBookInfo'];
        $aRtn = $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
        return $aRtn[0];
    }
    public function deleteGoodsExtralist($idx)
    {
        $aInput = array('idx' => $idx);
        $aConfig = $this->queryInfoMol['deleteGoodsExtralist'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function getGoodsExtralist($aInput)
    {
        $aConfig = $this->queryInfoMol['getGoodsExtralist'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function deleteTodayGoods()
    {
        $aInput = array('today'=>date('Ymd'));
        $aConfig = $this->queryInfoMol['deleteTodayGoods'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }  
    public function getBookImgInfo($aParam)
    {
        $aConfig = $this->queryInfoMol['getBookImgInfo'];
        $aRtn = $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
        return $aRtn[0];
    }
    public function insertTodayGoods($aParam)
    {
        $aConfig = $this->queryInfoMol['insertTodayGoods'];
        return $this->actModelFucFromDB($aConfig, $aParam, $this->ebook_db) ;
    }
    public function getMyCartInfo($member_no)
    {
        $aInput = array('member_no'=>$member_no);
        $aConfig = $this->queryInfoMol['getMyCartInfo'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function insertShopMemberMileage($member_no, $order_code, $mileage_get)
    {
        $aInput['member_no']    = $member_no;
        $aInput['order_code']   = $order_code;
        $aInput['mileage_get']  = $mileage_get;
        $aInput['mileage_memo'] = '상품구매시 사용함';
        $aInput['plus_minus']   = 'minus';
        $aInput['ret_yn']       = 'order';
        $aInput['regdate']      = date('Y-m-d H:i:s');
 
        $aConfig = $this->queryInfoMol['setMileage'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function updateCyberPoint($member_no, $mileage_get)
    {
        $aInput['member_no']    = $member_no;
        $aInput['mileage_get']  = $mileage_get;
         
        $aConfig = $this->queryInfoMol['setMileage'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function updateCoupon($order_code, $coupon_list_no)
    {
        $aInput['order_code']     = $order_code;
        $aInput['coupon_list_no'] = $coupon_list_no;
         
        $aConfig = $this->queryInfoMol['updateCoupon'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function setShopOrder($oMem, $order_code, $mileage_flag,  $aParam, $aConfigPayType, $coupon_list_no, $coupon_price)
    {
        $aInput['order_code'] = $order_code;
        $aInput['member_no']  = $aParam['member_no'];
        $aInput['user_name']  = $oMem->oUserInfo->mb_name;
        $aInput['user_email'] = $oMem->oSSOInfo->t_id;
        $aInput['u_ip']       = $_SERVER["REMOTE_ADDR"]; ;
        $aInput['order_Price_SUM'] = $aParam['End_Order_Price_SUM'] ;
        $aInput['mileage_set']  = $aParam['mileage_set'] ;
        $aInput['mileage_get']  = $aParam['mileage_get'] ;
        $aInput['mileage_flag'] = $mileage_flag ;
        $aInput['sca_code']     = $coupon_list_no ;
        $aInput['sca_price']    = $coupon_price ;
        $aInput['bank_name']    = $aParam['bank_name'] ;
        $aInput['payment_div']  = $aConfigPayType[$aParam['payment_div']] ;
        $aInput['order_step']   = 1;
        $aInput['regdate']      = date('Y-m-d H:i:s');

        $aConfig = $this->queryInfoMol['setShopOrder'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function getBookInfoFromMyCart($extralist_idx, $member_no)
    {
        $aInput['idx'] = $extralist_idx ;
        $aInput['member_no'] = $member_no ;
         
        $aConfig = $this->queryInfoMol['getBookInfoFromMyCart'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function setShopOrderList($aInput)
    {
        $aInput['ea_order_step'] = '1' ;

        $aConfig = $this->queryInfoMol['setShopOrderList'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function deleteCartBook($idx, $member_no)
    {
        $aInput = array(
             'idx' => $idx
            ,'member_no' => $member_no
            ,'ex_case' => 'cart'
        );
        $aConfig = $this->queryInfoMol['deleteCartBook'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function updateSellHit($g_num)
    {
        $aInput = array(
            'g_num' => $g_num
        );
        $aConfig = $this->queryInfoMol['updateSellHit'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
   
    }
    public function chkBuyBook($member_no, $g_num)
    {
        $aInput['member_no'] = $member_no ;
        $aInput['g_num']     = $g_num;
         
        $aConfig = $this->queryInfoMol['chkBuyBook'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
    public function getShopOrder($member_no)
    {
        $aInput['member_no'] = $member_no ;
         
        $aConfig = $this->queryInfoMol['getShopOrder'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }   
    public function getShopOrderList($order_code)
    {
        $aInput['order_code'] = $order_code;
         
        $aConfig = $this->queryInfoMol['getShopOrderList'];
        return $this->actModelFucFromDB($aConfig, $aInput, $this->ebook_db) ;
    }
}
