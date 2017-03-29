<!------------------------- 테이블 ----------------------------->
<div id="TABLE_wrap">
    <!-- 관심(찜) 도서 목록 -->
    <div id="SELECT_BOOK">
        <table cellpadding="1" cellspacing="1" class="TABLE_row myBook"><!--- 섹션  --->
            <!--- 리스트타이틀 --->
            <tr>
                <th><!--input id="chkMyBook_all" type="checkbox" name="chkMyBook_all" value="Y"--></th>
                <th colspan="2" class="BT_reg">
<!--                    <span class="moveBtn">이동</span>-->
                    <!--a class="deleteBtn"><span>선택삭제</span></a-->
                </th>
<!--                <th>-->
<!--                    <span class="BT_reg" style="margin-left:6px !important;"><a href="/sub/BOOK/CART.php">장바구니로</a></span>-->
<!--                    <span class="BT_reg"><a href="/sub/BOOK/CART.php"">전체 장바구니로</a></span>-->
<!--                </th>-->
            </tr>
            <!--- 리스트내용 --->
            <?php
            /*
            $aMyBookList =array(
                0=>array('booktitle'=>'긍정의교육(4~7세편)', 'sImgURL'=>'/img/BOOK/book/3d/ex_1.png', 'author_name'=>'제인 넬슨 외 2인 저 / 조고은 역','date'=>'2016-11-29 14:36:48','capacity'=>'120MB' )
               ,1=>array('booktitle'=>'긍정의교육(8~15세편)', 'sImgURL'=>'/img/BOOK/book/3d/ex_1.png', 'author_name'=>'제인 넬슨 외 2인 저 / 조고은 역','date'=>'2016-11-29 14:36:48','capacity'=>'120MB')
            );
            */
            if(!$aMyBookList)
            {
                echo '<tr style="clear:both !important;"><td colspan=2 align=center>구매한 도서가 없습니다.</td></tr>';
            }
            else
            {
                for($i=0; $i<count($aMyBookList); $i++) :?>
                    <tr style="clear:both !important;">
                        <td>&nbsp;<!--input id="chkMyBook" type="checkbox" name="chkMyBook" value="<?=$aMyBookList[$i]['list_no']."|".$aMyBookList[$i]['g_num']?>"></td-->
                        <td><a href="javascript:openViwer('<?=$aMyBookList[$i]['g_num']?>')"><img src="<?=$aMyBookList[$i]['sImgURL']?>" alt="도서사진"  /></a></td>
                        <td><a href="javascript:openViwer('<?=$aMyBookList[$i]['g_num']?>')">
                            <h2><?=$aMyBookList[$i]['booktitle']?></h2>
                            <div><?=$aMyBookList[$i]['author_name']?></div>
                            <!--div><?=$aMyBookList[$i]['date']?></div-->
                            <div><?=$aMyBookList[$i]['capacity']?></div>
                            <!--<div>리뷰쓰기</div>-->
                            </a> 
                        </td>
                    </tr>
            <?php endfor;
            }
            ?>
        </table>
    </div>
    
    <input type="hidden" name="member_no" id="member_no" value="<?=$member_no?>" /> <!-- 타이탄북스 구매자 회원번호-->
    <input type="hidden" name="mb_id" id="mb_id" value="<?=$mb_id?>" /> <!-- 에듀니티 회원아이디 -->

    <!--- 페이징 --->
</div>
<!-- // 테이블 -->

<script>
var isBrowserType = 0; //0:desktop, 1:Android, 2:Ios

function CheckBrowserType(){
    var uagent = navigator.userAgent.toLowerCase();
    if( uagent.search("android")  >  -1 ){
        isBrowserType= 1;
    }else if( uagent.search("iphone")  >  -1  ||  uagent.search("ipad")  >  -1   ) {
        isBrowserType= 2;
    } else {
        isBrowserType= 0;
    }
}


function openViwer(g_num)
{
    CheckBrowserType();
    
    var ebookUrl = "http://ebook.eduniety.net/ftp/titanbooks/_good/"+g_num;
    if(isBrowserType == 1) { // 안드로이드
        window.android.goContentPlayEbook(ebookUrl);
    } else if(isBrowserType == 2) {  //아이폰
        window.location.href = "jscall://goContentPlayEbook:"+ebookUrl;
	} else {
        alert("앱기능입니다.");
    }

}

</script>

<script>

             

    $("#chkMyBook_all").on("click",function()
    {
        if($(this).is(':checked')) {
            $(".deleteBtn span").html("전체삭제");
            $("input[name=chkMyBook]").prop("checked", true);
        } else {
            $(".deleteBtn span").html("선택삭제");
            $("input[name=chkMyBook]").prop("checked", false);
        }
    });

    $("input[name=chkMyBook]").on("click",function ()
    {
        if($("#chkMyBook_all").is(':checked') ){
            $(".deleteBtn span").html("선택삭제");
            $("#chkMyBook_all").prop("checked", false);
        }
    });

    $(".deleteBtn").on("click",function ()
    {
        var chkMyBookList = new Array();
        var n = $("input[name=chkMyBook]:checked").length;
        if (n > 0){
            $("input[name=chkMyBook]:checked").each(function(){
                chkMyBookList.push($(this).val());
            });
        }
        console.log(chkMyBookList);
        //alert(chkMyBookList);
        
        if (confirm("삭제시 복구가 불가능 합니다. \n삭제하시겠습니까?") == false){    
            return;
        }else{
            
            $.post(
                "/membership/Book/apiDelMyBookInfo"
                ,{
                     "mb_id"         : $.trim($('#mb_id').val())
                    ,"member_no"     : $.trim($('#member_no').val()) 
                    ,"chkMyBookList" : chkMyBookList 
                }
                ,function(data, status){
                    if(status == 'success' && data.code == 1)
                    {
                        alert('삭제되었습니다.');
                        location.reload();                     
                    }
                    else
                    {
                        alert(data.msg);
                        return;
                    }
                }
            );
        
        }      
    });


</script>
