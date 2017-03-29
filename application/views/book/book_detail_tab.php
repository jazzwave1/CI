
<!--- 아코디언 contents --->
<link rel="stylesheet" href="/include/jq/accordion/easy-responsive-tabs.css">
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<!---- 내부 적용만 됨 ---->
<style>
    /*** 미디어쿼리 ***/
    @media (min-width:600px) {
        .lecturer img {width:50% !important; margin-right:20px !important; float:left;}
    }
    /*** // 미디어쿼리 ***/
</style>

<div id="horizontalTab"><!--- tab 정의--->
    <ul class="resp-tabs-list" class="table_1">
        <li class="select">책소개</li>
        <li>저자소개</li>
        <li>목차</li>
        <li>출판사리뷰</li>
        <li>회원리뷰</li>
    </ul>
    <div class="resp-tabs-container"><!-- start units -->
        <!-- 1 -->
        <div class="TIT">
            <?php echo str_replace("\n","<br>", $aBookDetailInfo['book_info'] ); ?>
        </div>

        <!--- 2 --->
        <div class="TIT">
            <?php echo str_replace("\n","<br>", $aBookDetailInfo['author_info']);?>
        </div>

        <!--- 3 --->
        <div class="TIT">
            <?php echo str_replace("\n","<br>", $aBookDetailInfo['book_detail'] );?>
        </div>

        <!--- 4 --->
        <!--div class="TIT">
            <h2>출판사리뷰</h2>
            출판사리뷰 지문
        </div-->

        <!--- 5 --->
        <!--div class="TIT">
            <h2>회원리뷰</h2>
            회원리뷰
        </div-->
    </div><!-- // end units -->

</div><!-- // tab정의 -->


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="/include/jq/accordion/easy-responsive-tabs.js"></script>
<script>
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true,   // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
        $('#verticalTab').easyResponsiveTabs({
            type: 'vertical',
            width: 'auto',
            fit: true
        });
    });
</script>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
