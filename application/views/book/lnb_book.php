<div id="LNB_slide" class="LNB_sub swiper-container swiper-container-horizontal">
	<ul class="nav swiper-wrapper">

            <li class="swiper-slide"><a href="/membership/book/booklist/all" class="">전체</a></li>
        <?php foreach($this->aCategoryInfo as $key=>$val) :
            $aTemp = explode( "/", $_SERVER['REQUEST_URI']);
            $sNowCategory = array_pop($aTemp);
            if($sNowCategory == $key)
                $sClassName = "active";
            else
                $sClassName = "";
        ?>
            <li class="swiper-slide"><a href="/membership/book/booklist/<?=$key?>" class="<?=$sClassName?>"><?=$val['name']?></a></li>
        <?php endforeach; ?>

        <!--li class="swiper-slide"><a href="/membership/book/booklist/philosophy">교육철학</a></li>
		<li class="swiper-slide"><a href="/membership/book/booklist/classop">학급운영</a></li>
		<li class="swiper-slide"><a href="/membership/book/booklist/inno">학교혁신</a></li>
		<li class="swiper-slide"><a href="/membership/book/booklist/improvement">수업개선</a></li>
		<li class="swiper-slide"><a href="/membership/book/booklist/growth">교사성장</a></li>
		<li class="swiper-slide"><a href="/membership/book/booklist/dbook">디지털교과서</a></li>
		<li class="swiper-slide"><a href="/membership/book/booklist/childedu">자녀교육</a></li>
		<class="swiper-slide"><a href="/membership/book/booklist/child">어린이</a></li>
		<li class="swiper-slide"><a href="/membership/book/booklist/etc">기타</a></li>
        <li class="swiper-slide"><div style="display:inline-block;width:44px;"></div></li-->
    </ul>
    <button class="BT_lnb" onclick="ToggleHeader();"><img id="BT_more_img" src="/img/BT_lnb_2.png" alt="검색버튼" /></button>
</div>
<?php
echo "<!--";
$aTemp = explode("/", $_SERVER["REQUEST_URI"] );
$sCategory = array_pop($aTemp);

$LNBMenuIndex = 0;
foreach($aCategory as $key=>$val)
{
    if($key == $sCategory)
    {
        $LNBMenuIndex = $val['listnum'];
    }
}
echo "-->";
?>
<script>
var LNBMenuIndex = <?=$LNBMenuIndex?>;
    
    function ToggleHeader()
    {
        var state = $('#TOGGLE_open').css('display'); // state 변수에 ID가 moreMenu인 요소의 display의 속성을 '대입'
        if(state == 'none')
        {
            $("#BT_more_img").attr("src", "/img/BT_lnb_3.png");

            // state가 none 상태일경우
            $('.TOGGLE_header').stop().slideDown( "fast", function()
            {
                // Animation complete.
            });
        }
        else
        {
            $("#BT_more_img").attr("src", "/img/BT_lnb_2.png");

            // 그 외에는
            $('.TOGGLE_header').stop().slideToggle( "fast", function()
            {
                // Animation complete.
            });
        }
    }
    $(document).ready(function ()
    {
        var LNBSwipe = new Swiper("#LNB_slide",
            {
                slidesPerView: 'auto',
                spaceBetween: 0
            });

        LNBSwipe.slideTo(LNBMenuIndex, 0);

        $(".nav li a").click(function () {
            $(".nav li a.active").removeClass("active");
            $(this).addClass("active");
        })

    });
</script>
<div id="TOGGLE_open" class="TOGGLE_header">
	<h3><big>BOOK</big>&nbsp;전체메뉴</h3>
    <ul>
        <li><a href="/membership/book/booklist/philosophy">교육철학</a></li>
        <li><a href="/membership/book/booklist/classop">학급운영</a></li>
        <li><a href="/membership/book/booklist/inno">학교혁신</a></li>
		<li><a href="/membership/book/booklist/improvement">수업개선</a></li>
		<li><a href="/membership/book/booklist/growth">교사성장</a></li>
		<!--li><a href="/membership/book/booklist/dbook">디지탈교과서</a></li-->
		<li><a href="/membership/book/booklist/childedu">자녀교육</a></li><!--- 추후 생성여부는 이팀장님과 상의요망. 본 주석은 작업 적용 후 삭제 --->
		<!--li><a href="/membership/book/booklist/child">어린이</a></li-->
		<!--li><a href="/membership/book/booklist/etc">기타</a></li-->
	</ul>
</div>


