<!--
<?php
//    print_r($oBookInfo);
?>
-->


<div class="BUY"><!--- 페이지 고유 속성 --->
    <!--<span class="upload">[ 오늘 등록 <b>3권</b> / 전체 등록 <b>3,561권</b> ]</span>-->
    <!--<div style="height:10px;"></div>--><!--- 지우지 말것 --->
    <!------ 리스트 부분 ------->
    <h2 style="margin-top:-5px !important;">주문목록</h2>
    <table cellpadding="1" cellspacing="1" class="LIST">
        <tr>
            <th width="70%">상품명</th>
            <th style="width:30%;">금액</th>
        </tr>
        <tr>
            <td width="70%"><?=$oBookInfo->g_name?></td>
            <td style="width:30%; text-align:right !important;"><?php echo number_format($oBookInfo->g_price) ; ?> 원</td>
        </tr>
        
        <tr>
            <th colspan="2"><b>멤버쉽회원 : 0원</b></td>
        </tr>

<!-- 
        <tr>
            <th colspan="2"><b>합계 : 00,000원</b></td>
        </tr>
-->
    </table>

    <h2>결제정보</h2>
    <table cellpadding="1" cellspacing="1" class="LIST">
        <!--tr class="final_info">
            <th>총 주문금액</th>
            <td>00,000원</td>
        </tr-->
        <?php if($aMemSVCInfo) :?>
        <tr class="final_info">
            <th>멤버십 내역</th>
            <td class="use_POINTs">
                <form>
                    <fieldset>
                        <div> 서비스내용 : <span><?=$aMemSVCInfo['aPurchaseInfo'][0]->contents?></span></div>
                        <div> 현재 사용 : <span><?=$aMemSVCInfo['aUseCnt']['b']?></span></div>
                    </fieldset>
                </form>
            </td>
        </tr>

        <tr class="sum">
            <th>현재 구매 가능</th>
            <td colspan="2"><big><div><?=$aMemSVCInfo['aPossibleCnt']['b']-$aMemSVCInfo['aUseCnt']['b']?> 권</div></big></td>
        </tr>
        <?php else :?>
        <tr class="sum">
            <th>현재 구매 불가능</th>
            <td colspan="2"><big><div>멤버쉽회원구매를 하시겠습니까?</div></big></td>
        </tr>
        <?php endif;?>
    </table>

    <?php if($aMemSVCInfo) :?>
    <h2>결제수단</h2>
    <ul class="pay_way">
        <li><input type="radio" name="pay_way" value="membership" checked readonly><label>멤버십</label></li>
        <!--<li><input type="radio" name="" value=""><label>무통장입금</label></li>
        <li><input type="radio" name="" value=""><label>신용카드</label></li>
        <li><input type="radio" name="" value=""><label>휴대폰</label></li>
        <li><input type="radio" name="" value=""><label>계좌이체</label></li>-->
    </ul>

    <!--- 최종버튼 --->
    <ul class="BT">
        <li><a href="javascript:bBuy()">결제하기</a></li>
        <li><a href="/membership/book/buylist">기존 구매목록</a></li>
    </ul>
    <?php endif;?>
</div><!--- 페이지 고유 속성 --->

<form name="send_Form" id="send_Form"  method="post">
    <input type="hidden" name="g_num" id="g_num" value="<?=$oBookInfo->g_num ?>" />                       <!-- book content num -->

    <input type="hidden" name="mb_id" id="mb_id" value="<?=$aPayInfo['mb_id'] ?>" />                      <!-- 로그인(주문자)회원아이디 -->
    <input type="hidden" name="member_no" id="member_no" value="<?=$aPayInfo['member_no'] ?>" />          <!-- 로그인(주문자)회원번호 -->

    <input type="hidden" name="org_sum_total" id="org_sum_total"  value="<?=$aPayInfo['sum_total']?>" />  <!-- 장바구니 리스트 합계금액 => 적립금과 쿠폰 사용전 오리지널 금액이다.-->
    <input type="hidden" name="End_Order_Price_SUM" id="End_Order_Price_SUM" />                           <!-- 최종결제금액-->
    <input type="hidden" name="mileage_set" id="mileage_set" value="<?=$aPayInfo['sum_point'] ?>" />      <!-- 주문시 적립될 적립금 합계 -->
    <input type="hidden" name="mileage_get" id="mileage_get" value="0"/>                                  <!-- 사용될 적립금 -->
    <input type="hidden" name="extralist_idx" id="extralist_idx" value="<?=$aPayInfo['extralist_idx'];?>" />

<input type="hidden" name="bank_name" id="bank_name" value="<?=$aPayInfo['bank_name'];?>" />
</form>

<script>
function bBuy(){
    var member_no = $.trim($('#member_no').val()) ;
    var mb_id     = $.trim($('#mb_id').val()) ;
    var End_Order_Price_SUM = $.trim($('#org_sum_total').val()) ;
    
    if( member_no == '' || mb_id == ''){
        if (confirm("로그인이 필요합니다.\n로그인페이지로 이동하시겠습니까?") == true){    
            location.href = "http://design.eduniety.net/sub/PORTAL/MEMBER_login.php?url=/index.php"; 
        }else{
            return;
        }      
    }

    if (confirm("구매 하시겠습니까?") == true){

        if($(':radio[name="pay_way"]:checked').val() == 'membership')
            End_Order_Price_SUM = 0;

        $.post(
            "/membership/Book/apiProcBuy"
            ,{
                "member_no"    : member_no
                ,"mb_id"       : mb_id

                ,"g_num"       : $.trim($('#g_num').val())

                ,"org_sum_total" : $.trim($('#org_sum_total').val())
                ,"End_Order_Price_SUM" : End_Order_Price_SUM
                ,"mileage_get"   : $.trim($('#mileage_get').val())
                ,"mileage_set"   : $.trim($('#mileage_set').val())
                ,"extralist_idx" : $.trim($('#extralist_idx').val())
                ,"payment_div"   : $(':radio[name="pay_way"]:checked').val()
                ,"bank_name"     : $.trim($('#bank_name').val())
            }
            ,function(data, status){
                if(status == 'success' && data.code == 1)
                {
                    if (confirm("구매가 완료 되었습니다. \n구매 내역으로 이동하시겠습니까?") == true){
                        location.href = "/membership/book/buylist";
                    }else{
                        return;
                    }
                }
                else if(data.code == 101)
                {
                    if (confirm("이미 구매 내역이 있습니다. \n 구메내역으로 이동하시겠습니까?") == true){
                        location.href = "/membership/book/buylist";
                    }else{
                        return;
                    }
                }
                else
                {
                    alert(data.msg);
                    return;
                }
            }
        );

    }else{
        return;
    }

}
    
</script>
