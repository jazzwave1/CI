<!------------------------- 테이블 ----------------------------->
<div id="TABLE_wrap">
    <div class="sum_sec"><!--- 섹션 고유속성  --->
        <table cellpadding="1" cellspacing="1">
            <tr>
                <th colspan="2"><big>0권&nbsp;</big>을 선택하셨습니다.</th>
            </tr>
            <tr>
                <td>
                    <span>총 상품금액 :</span> <span class="TXT">0원</span>
                </td>
                <td>
                    <span>할인금액 :</span> <span class="TXT">00,000원</span>
                </td>
            </tr>
            <tr>
                <th colspan="2" class="sum">
                    <b>합계 :</b>
                    <big>00,000원</big>
                </th>
            </tr>
        </table>
        <!--- 결제버튼 --->
        <ul class="BT">
            <li class="buyBtn"><a href="#">구매하기</a></li>
            <li><a href="/membership/book/buylist" class="cancel">기존 구매목록</a></li>
        </ul>
        <!--- // 결제버튼 --->
    </div><!--- // 섹션 고유속성  --->
    <!-------------------------------------------- 장바구니 도서 목록 -------------------------------------------->
    <div id="SELECT_BOOK"><!--- 섹션 고유속성  --->
        <table cellpadding="1" cellspacing="1"><!--- 섹션  --->
            <!--- 리스트타이틀 --->
            <tr>
                <th><input id="chkMyCart_all" type="checkbox" name="chkMyCart_all" value="Y"></th>
                <th colspan="2" class="BT_reg"><a class="deleteBtn"><span>선택 삭제</span></a></th>
                <!--<th>
                    <span class="BT_reg" style="margin-left:6px !important;"><a href="/membership/book/mybook">내서재로</a></span>
                    <span class="BT_reg"><a href="/membership/book">다른도서 고르기</a></span>
                </th>-->
            </tr>
            <!--- 리스트내용 --->
            <?php
            if(count($aMyCartList) >= 1):
                for($i=0; $i<count($aMyCartList); $i++) :?>
                <tr class="cartListInfo" style="clear:both !important;">
                    <td><input id="chkMyCart" type="checkbox" name="chkMyCart" value="<?=$i?>"></td>
                    <td><img src="<?=$aMyCartList[$i]['sImgURL']?>" alt="도서사진"/></td>
                    <td class="cartBookInfo">
                        <h2><?=$aMyCartList[$i]['booktitle']?></h2>
                        <div><?=$aMyCartList[$i]['author_name']?></div>
                        <div>[정가]<span class="price"><?php echo number_format( $aMyCartList[$i]['price'] );?> </span> 원</div>
                        <!--[리뷰검색] 00개--><!--- 수록여부 및 방식, 이문주 팀장님과 상의, 적용 후 본 주석은 삭제할 것 --->
                    </td>
                </tr>
                <?php endfor;
            else : ?>
                 <tr class="cartListInfo" style="clear:both !important;">
                    <td colspan=2>카트가 비어 었습니다.</td>
                </tr>

            <?php endif; ?>
        </table>
    </div><!--- // 섹션 고유속성  --->
    <!--- 페이징 --->
</div>
<!------------------------- // 테이블 ----------------------------->
<!--- 최종버튼 --->
<!--<div id="BT_wrap">
    <ul class="BT cartBtn">
        <li><a href="/sub/BOOK/BUY.php">선택목록 구매하기</a></li>
        <li><a href="#" class="cancel">선택 삭제</a></li>
    </ul>
</div>-->

<script>
    $("#chkMyCart_all").on("click",function()
    {
        if($(this).is(':checked')) {
            $(".deleteBtn span").html("전체삭제");
            $("input[name=chkMyCart]").prop("checked", true);
        } else {
            $(".deleteBtn span").html("선택삭제");
            $("input[name=chkMyCart]").prop("checked", false);
        }
    });
    $("input[name=chkMyCart]").on("click",function ()
    {
        if($("#chkMyCart_all").is(':checked') ){
            $(".deleteBtn span").html("선택삭제");
            $("#chkMyCart_all").prop("checked", false);
        }
    });


    $(".buyBtn").on("click",function ()
    {
        var chkMyCartList = new Array();
        var n = $("input[name=chkMyCart]:checked").length;
        if (n > 0){
            $("input[name=chkMyCart]:checked").each(function(){
                chkMyCartList.push($(this).val());
            });
        }
        console.log(chkMyCartList);
        return chkMyCartList;
    });

</script>

