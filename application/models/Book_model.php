<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Book_model extends CI_model
{
    public function __construct()
    {
        $this->file_path    = "/home/epubweb/ftp/titanbooks/";
        $this->img_url_path = "http://ebook.eduniety.net/ftp/titanbooks/";

        $this->ebook_dao = edu_get_instance('book_dao', 'model'); 
    }

    private function _getBookList($aBookList)
    {
        if(!$aBookList || count($aBookList)==0) return false;

        $aRtn = array();
        foreach($aBookList as $key=>$val)
        {
            $aRtn[$key]['g_num']   = $val->g_num;
            $aRtn[$key]['name']    = $val->g_name;
            $aRtn[$key]['sImgURL'] = $this->_getImgURL($this->ebook_dao->getBookImgInfo(array('gf_type'=>'110', 'g_num'=>$val->g_num)) );
            $aRtn[$key]['hitCnt']  = number_format($val->g_click_hit);
            $aRtn[$key]['price']   = number_format($val->g_price);
            $aRtn[$key]['g_price_street'] = number_format($val->g_price_street);
            $aRtn[$key]['author_name'] = $val->author_name;
        }
        return $aRtn;
    }
    
    public function getBookList()
    {
        $aOrderList = array(
             54, 49, 31, 38, 51
            ,33, 50, 35, 45, 48
            ,52, 39, 37, 53, 46
            ,41, 40, 42, 32, 55
            ,44, 36, 47, 43, 34
            ,57
        );
        if(!$aResult= $this->ebook_dao->getBookList() )
            return false;

        $aTemp = $this->_getBookList($aResult);
        foreach($aOrderList as $key=>$val)
        {
            foreach($aTemp as $k=>$v)
            {
                if($val == $v["g_num"])
                {
                    $aRtn[] = $v;
                    continue;
                }
            }
        }
        
        return $aRtn;
    }
    public function getBestBook()
    {
        if(!$aResult= $this->ebook_dao->getBestBook() )
            return false;

        return $this->_getBookList($aResult);
    }
    public function getNewBook()
    {
        if(!$aResult= $this->ebook_dao->getNewBook() )
            return false;

        return $this->_getBookList($aResult);
    }

    public function getBookListFromCategory($gc_num)
    {
        if(!$gc_num) return false;

        if(!$aResult= $this->ebook_dao->getBookListFromCategory($gc_num) )
            return false;

        return $this->_getBookList($aResult);
    }

    private function _getImgURL($oBookImgInfo)
    {
        if(!$oBookImgInfo->gf_filename_new)
            return $this->img_url_path."/images/total/no_img_".$gt_type.".jpg";

        // 원격지의 파일임
        //$sFilePath = $this->file_path."/_good/".$oBookImgInfo->gf_filename_new;

        return $this->img_url_path."/_good/".$oBookImgInfo->gf_filename_new;
    }

    public function getBookDetailInfo( $g_num, $member_no='', $mb_id='')
    {
        if(!$g_num) return false;

        $aBookDetail = array();

        $aInput = array('g_num'=>$g_num);
        $aBookInfo = $this->ebook_dao->getBookDetailInfo($aInput) ;

// test code
// echo "<!--";
// print_r($aBookInfo); 
// echo "-->";
        
        $aBookDetail['member_no']  = $member_no;        
        $aBookDetail['mb_id']      = $mb_id;        

        $aBookDetail['g_num']  = $aBookInfo->g_num;         // 책 고유번호
        $aBookDetail['g_name'] = $aBookInfo->g_name;        // 책 이름
        $aBookDetail['hitCnt'] = $aBookInfo->g_click_hit;   // 클릭수(인기순)
        $aBookDetail['price']  = $aBookInfo->g_price;       // 가격
        $aBookDetail['wdate']  = $aBookInfo->date;          // 출판일
        $aBookDetail['showdate'] = $aBookInfo->g_show_sdate .' ~ '. $aBookInfo->g_show_edate;  // 구독가능 날자

        $aBookDetail['g_price_street']  = $aBookInfo->g_price_street;  // 시중가 
        $aBookDetail['g_price']  = $aBookInfo->g_price;        // 상품등록시 입력한 판매가 
        $aBookDetail['g_point']  = $aBookInfo->g_point;        // 상품등록시 입력한 적립금  
        $aBookDetail['g_point_div'] = $aBookInfo->g_point_div; // 상품등록시 적립금 구분 퍼센트냐, 원이냐  

        //적용할 적립금 관련
        if($aBookInfo->g_point_div == "coin")
            $point_val = $aBookInfo->g_point;
        else
            $point_val = ceil(($aBookInfo->g_point * $aBookInfo->g_price) / 100);

        $aBookDetail['point_val'] = $point_val ; // 판매가에 맞춰 계산된 적립금 금액  
        $aBookDetail['date_val']  = $aBookInfo->date;    // 최초등록일 
        
        
        $aInput = array('g_num'=>$g_num);
        $aBookContentInfo = $this->ebook_dao->getBookDetailInfo_Content($aInput) ;
        
// test code
// echo "<!--";
// print_r($aBookContentInfo); 
// echo "-->";


        $aBookDetail['author_name'] = $aBookContentInfo->author_name; // 저자이름
        $aBookDetail['author_info'] = $aBookContentInfo->author_info; // 저자소개
        $aBookDetail['book_info']   = $aBookContentInfo->book_info;   // 책소개
        $aBookDetail['book_detail'] = $aBookContentInfo->book_detail; // 목차
        $aBookDetail['book_com']    = $aBookContentInfo->book_com;    // 출판사
        $aBookDetail['gccode']      = $aBookContentInfo->gccode;      // 상품코드 


        $aImgInfo = $this->ebook_dao->getBookImgInfo(array('gf_type'=>'200', 'g_num'=>$g_num)) ;
        $aBookDetail['sImgURL'] = $this->_getImgURL($aImgInfo); // 책이미지

        //dummy
        $aBookDetail['file_form'] = "EPUB3(전자북)"; // 파일형태
        $aBookDetail['support']   = "아이폰, 아이패드, 안드로이드폰, 안드로이드패드, 전자책단말"; // 지원기기
        // test code
        //print_r($aBookInfo);
        //print_r($aBookContentInfo);
        //print_r($aImgInfo);
        //echo $this->_getImgURL($aImgInfo);

        return $aBookDetail;
    }

    public function getMyBookList($member_no)
    {
        if(!$member_no) return false; 
    
        $aRtn = array();
        if( $aMyBookInfo = $this->ebook_dao->getMyBookList($member_no) )
        {
            // test code 
            echo "<!--";
            //print_r($aMyBookInfo);
            echo "-->";
            
            foreach($aMyBookInfo as $key=>$val)
            {
                $aRtn[$key]['booktitle'] = $val->g_name;
                $aRtn[$key]['g_num'] = $val->g_num;
                
                $aImgInfo = $this->ebook_dao->getBookImgInfo(array('gf_type'=>'200', 'g_num'=>$val->g_num)) ;
                $aRtn[$key]['sImgURL'] = $this->_getImgURL($aImgInfo); // 책이미지
                $aRtn[$key]['author_name'] = '';  // 저자 삭제  
                $aRtn[$key]['date'] = $val->g_show_sdate .' ~ '. $val->g_show_edate;    
                $aRtn[$key]['capacity'] = '';    
                $aRtn[$key]['list_no'] = $val->list_no;    
            }    
            return $aRtn;
        }
        return false; 
    }    
    public function getTUserInfo($member_no)
    {
        if(!$member_no) return false;

        return $this->ebook_dao->getShopMember($member_no) ;
    }
    public function delMyBookInfo($list_no, $g_num, $member_no)
    {
        if(!$member_no ||  !$g_num || !$list_no) return false;
        return $this->ebook_dao->delMyBookInfo($list_no, $g_num, $member_no) ;
    }
}
