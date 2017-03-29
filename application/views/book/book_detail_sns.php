<table cellpadding="0" cellspacing="0" class="I-sns">
    <!--<tr>
        <td><a href="https://www.facebook.com/eduniety/?fref=ts"><img src="/img/I_sns/I_facebook.png" alt="페이스북" /></a></td>
        <td><a href="#"><img src="/img/I_sns/I_naver.png" alt="네이버" /></a></td>
        <td><a href="#"><img src="/img/I_sns/I_cacaoStory.png" alt="카카오스토리" /></a></td>
        <td><a href="#"><img src="/img/I_sns/I_cacao.png" alt="카카오톡" /></a></td>
        <td><a href="#"><img src="/img/I_sns/I_instagram.png" alt="인스타그램" /></a></td>
        <td><a href="#"><img src="/img/I_sns/I_share.png" alt="공유" /></a></td>
    </tr>-->
    <tr>
        <td><img src="/img/I_sns/I_facebook_off.png" alt="페이스북" /></td>
        <td><img src="/img/I_sns/I_naver_off.png" alt="네이버" /></td>
        <td><img src="/img/I_sns/I_cacaoStory_off.png" alt="카카오스토리" /></td>
        <td><img src="/img/I_sns/I_cacao_off.png" alt="카카오톡" /></td>
        <td><img src="/img/I_sns/I_instagram_off.png" alt="인스타그램" /></td>
        <td><img src="/img/I_sns/I_share_off.png" alt="공유" /></td>
    </tr>
</table>

<ul class="BT">
<!--    <li><a href="/sub/BOOK/SAVE_book.php">찜한 도서</a></li>-->
    <li><a href="javascript:bMyCart('cart');">장바구니</a></li>
    <!--li class="BT_another"><a href="/membership/book/buy">바로구매</a></li-->
    <li class="BT_another"><a href="javascript:bMyCart('buy')">바로구매</a></li>
</ul>

<?php
    echo "<!--";
    print_r($aBookDetailInfo); 
    echo "-->";
?>
<FORM name='cartForm' id="cartForm_id" method='post' action='/shop/basket.php'>
<input type="hidden" name="Action" id="Action"> <!--{* 바로구매,장바구니}-->

<input type="hidden" name="member_no" id="member_no" value="<?=$aBookDetailInfo['member_no']?>" /> <!-- 타이탄북스 구매자 회원번호-->
<input type="hidden" name="mb_id" id="mb_id" value="<?=$aBookDetailInfo['mb_id']?>" /> <!-- 에듀니티 회원아이디 -->
<input type="hidden" name="g_num" id="g_num" value="<?=$aBookDetailInfo['g_num']?>" />
    <input type="hidden" name="gccode" id="gccode" value="<?=$aBookDetailInfo['gccode']?>" /><!-- 상품코드-->
    <input type="hidden" name="g_name" id="g_name" value="<?=$aBookDetailInfo['g_name']?>" /><!-- 상품명-->
    <input type="hidden" name="g_price_street" id="g_price_street" value="<?=$aBookDetailInfo['g_price_street']?>" /><!--시중가 즉 소비자가-->
    <input type="hidden" name="g_price" id="g_price" value="<?=$aBookDetailInfo['g_price']?>" /> <!-- 상품등록시 입력한 판매가-->
    <input type="hidden" name="g_point" id="g_point" value="<?=$aBookDetailInfo['g_point']?>" /> <!-- 상품등록시 입력한 적립금--> 
    <input type="hidden" name="g_point_div" id="g_point_div" value="<?$aBookDetailInfo['g_point_div']?>"/> <!-- 상품등록시 적립금 구분 퍼센트냐, 원이냐-->
    <input type="hidden" name="point_val" id="point_val" value="<?=$aBookDetailInfo['point_val']?>" /> <!-- 판매가에 맞춰 계산된 적립금 금액-->
    <input type="hidden" name="author_name" id="author_name" value="<?=$aBookDetailInfo['author_name']?>" /> <!-- 지은인(저작자) -->
    <input type="hidden" name="book_com" id="book_com" value="<?=$aBookDetailInfo['book_com']?>"/> <!-- 출판사?> -->
    <input type="hidden" name="date_val" id="date_val" value="<?=$aBookDetailInfo['date_val']?>" /> <!-- 최초 등록일 -->
</FORM>

<!-- form action script -->
<!-- member_no 를 기반으로 로그인 여부 확인 후 기능별 버튼 액션을 처리함 -->
<script>
function bMyCart(type){
    
    if(<?=$isBUY?>)
    {
        if (confirm("이미 구매 내역이 있습니다. \n구메내역으로 이동하시겠습니까?") == true){    
            location.href = "/membership/book/buylist"; 
        }else{
            return;
        }
        return;
    }
    
    var member_no = $.trim($('#member_no').val()) ;
    var mb_id     = $.trim($('#mb_id').val()) ;
    
    if( member_no == '' || mb_id == ''){
        if (confirm("로그인이 필요합니다.\n로그인페이지로 이동하시겠습니까?") == true){    
            location.href = "http://design.eduniety.net/sub/PORTAL/MEMBER_login.php?url=/membership/book"; 
        }else{
            return;
        }      
    }
    else
    {
        $.post(
            "/membership/Book/apiSetMyCart"
            ,{
                "member_no"    : member_no 
                ,"mb_id"       : mb_id 
                ,"g_num"       : $.trim($('#g_num').val())
                ,"gccode"      : $.trim($('#gccode').val())
                ,"g_name"      : $.trim($('#g_name').val())
                ,"g_price_street" : $.trim($('#g_price_street').val())
                ,"g_price"     : $.trim($('#g_price').val())
                ,"g_point"     : $.trim($('#g_point').val())
                ,"g_point_div" : $.trim($('#g_point_div').val())
                ,"point_val"   : $.trim($('#point_val').val())
                ,"author_name" : $.trim($('#author_name').val())
                ,"book_com"    : $.trim($('#book_com').val())
                ,"date_val"    : $.trim($('#date_val').val())
            }
            ,function(data, status){
                if(status == 'success' && data.code == 1)
                {
                    if(type == 'cart') 
                    {
                        if (confirm("카트에 보관되었습니다.\n카트페이지로 이동하시겠습니까?") == true){    
                            location.href = "http://design.eduniety.net/sub/PORTAL/MEMBER_login.php?url=/index.php"; 
                        }else{
                            return;
                        }
                    }
                    else
                    {
                        // 바로구매
                        location.href = "http://design.eduniety.net/membership/book/buy/"+data.idx ; 
                    }
                          
                }
                else
                {
                    if(data.code==301)
                    {
                        if(type == 'cart')
                        {
                            if (confirm("카트에 보관되었습니다.\n카트페이지로 이동하시겠습니까?") == true){    
                                location.href = "http://design.eduniety.net/membership/book/mycart"; 
                            }else{
                                return;
                            }
                        }
                        else
                        {
                            // 바로구매
                            location.href = "http://design.eduniety.net/membership/book/buy/"+data.idx ; 
                        }  
                    }
                    else
                    {
                        alert(data.msg);
                        return;
                    }
                
                }
            }
        );
    }
        
//   if (confirm("장바구니에 담겨졌습니다. \n장바구니로 이동하시겠습니까?") == true){    //확인
//       alert('a');
//   }else{   //취소
//       alert('b');
//   }
}
    
</script>
