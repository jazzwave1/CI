<div class="blackBg"></div>
<div id="SELECT_BOOK" class="buyList">
    <table cellpadding="1" cellspacing="1" class="TABLE_row"><!--- 섹션  --->
        <!--- 리스트타이틀 --->
        <thead>
            <tr>
                <!--th><input id="chkBuyList_all" type="checkbox" name="chkBuyList_all"></th>
                <th class="BT_reg"><a class="deleteBtn"><span>선택 삭제</span></a></th>
                <th>구매내역 [<?php echo count($aBuyBookInfo);?>건]</th-->
                <th colspan=3>구매내역 [<?php echo count($aBuyBookInfo);?>건]</th>
            </tr>
        </thead>
        <tbody>
            <?php if(count($aBuyBookInfo) == 0 || !$aBuyBookInfo) : ?>
            <!--구매리스트가 없을경우-->
            <tr style="clear:both !important;">
                <td colspan=3 align=center>구매한 도서가 없습니다.</td>
            </tr>
            <?php else : ?>
            <?php foreach($aBuyBookInfo as $key=>$val):?>
            <tr>
                <td>
                    <?php if($val['ShopOrderList']->del_yn != 'del') :?>
                        <!--input id="chkBuyBook" type="checkbox" name="chkBuyBook" value=""-->
                    <?php else : ?>
                        삭제상품 
                    <?php endif;?>
                </td>
                <td><a href="javascript:buyInfoPop();"><img src="<?=$val['img_url']?>" alt="도서사진"/></a></td> <!--- 레이어팝업 적용 후, 태그수정 및 주석삭제 --->
                <td>
                    <a href="javascript:buyInfoPop();">
                    <h2><?=$val['ShopOrderList']->g_name?>[책ID:<?=$val['ShopOrderList']->g_num?>]</h2>
                    <p>[구매일] <?=$val['ShopOrder']->regdate?></p>
                        <?php if($val['ShopOrder']->payment_div == 7 ):?>
                            <p><u>멤버십결제</u></p>
                        <?php else :?>
                        <p>[결제한 금액] <span><?=$val['ShopOrder']->order_Price_SUM?>원</span></p>
                        <p>[주문상태] <u><?=$val['ShopOrder']->sEaOrderStep?></u></p>
                        <?php endif;?> 
                    </a>
                </td>
            </tr>
            <?php endforeach;?>
            <?php endif;?>
        </tbody>
        <!--<tr>
            <td><input id="chkBuyBook" type="checkbox" name="chkBuyBook" value=""></td>
            <td class="no_img">NO<br>Image</td>
            <td>
                <h2>저작자에 의해 삭제된 책입니다.</h2>
                "체크박스를 선택하여 삭제" 하시면 목록에 더이상 노출 되지 않습니다.
            </td>
        </tr>
        <tr>
            <td><input id="chkBuyBook" type="checkbox" name="chkBuyBook" value=""></td>
            <td><a href="/sub/BOOK/SUB_class.php"><img src="/img/BOOK/book/1.png" alt="도서사진"  /></a></td>
            <td>
                <h2>디지털 교과서 제작 방법 [책 ID 329]</h2>
                [구매일]&nbsp;20OO.00.00 / 00:00<br>
                [결제한 금액]&nbsp;<b><big>00,000원</big></b><br>
                [결제방식]&nbsp;<u>무료</u><b>배송중</b>
            </td>
        </tr>-->
    </table>
    <!--- 페이징 --->
</div>
<!------------------------- // 테이블 ----------------------------->
<!--- 최종버튼 --->
<ul class="BT">
    <!--li><a href="/membership/book/cancel">선택 구매취소</a></li-->
    <li><a href="/membership/book">다른도서 쇼핑계속</a></li>
</ul>
<!--팝업-->
<div id="buyPop">
    <div id="pop_TIT"><h1>구매항목 상세내역</h1><img src="/img/BT_close.png" alt="팝업페이지 닫기 아이콘" /></div>
    <!--- units --->
    <div id="TABLE_wrap"><!--- table wrap --->
        <div class="pop_detail"><!--- 페이지 고유속성 --->
            <table cellpadding="1" cellspacing="1" class="TABLE_1col">
                <tr>
                    <th>구매일 / 시간</th>
                    <td>20OO.00.00 / 00:00</td>
                </tr>
                <tr>
                    <th>주문번호</th>
                    <td>0000000000</td>
                </tr>
                <tr>
                    <th>구매내역</th>
                    <td style="text-align:left !impotant;"><h2>글제목글제목글제목글제목글제목글제목글제목글제목글제목글제목글제목</h2></td>
                </tr>
                <tr>
                    <th>주문금액</th>
                    <td><b>00,000원</b></td>
                </tr>
                <tr>
                    <th>쿠폰할인 / 혜택</th>
                    <td>10% 할인 (- 0,000원)</td>
                </tr>
                <tr>
                    <th>포인트 사용금액</th>
                    <td>총 0000 중, <b>(- 0,000원)</b></td>
                </tr>
                <tr>
                    <th>결제수단</th>
                    <td><b>계좌이체 결제 확인 중</b></td>
                </tr>
                <tr>
                    <th>주문금액</th>
                    <th><big>00,000원</big></th>
                </tr>
            </table>
        </div><!--- // 페이지 고유속성 --->
    </div><!--- // table wrap --->
</div><!--//팝업-->

<script>
    $("#chkBuyList_all").on("click",function()
    {
        if($(this).is(':checked')) {
            $(".deleteBtn span").html("전체삭제");
            $("input[name=chkBuyBook]").prop("checked", true);
        } else {
            $(".deleteBtn span").html("선택삭제");
            $("input[name=chkBuyBook]").prop("checked", false);
        }
    });

    $("input[name=chkBuyBook]").on("click",function()
    {
        if($("#chkBuyList_all").is(':checked')) {
            $(".deleteBtn span").html("선택삭제");
            $("#chkBuyList_all").prop("checked", false);
        }
    });

    /*팝업*/
    function buyInfoPop()
    {
        return ;
       window.scrollTo(0, 0);
       $(".blackBg").css({display:"block"});
       $("#buyPop").css({display:"block"});
    }
    $("#pop_TIT img").on("click",function()
    {
        $(".blackBg").css({display:"none"});
        $("#buyPop").css({display:"none"});
    });
</script>
