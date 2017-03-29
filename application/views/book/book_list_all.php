<!--- 검색바 --->
<?php $this->load->view('book/search_bar.php'); ?>

<!--- 흐르는 공지 --->
<?php $this->load->view('book/notice_flow_book.php'); ?>

<div class="BAN_slide">
    <!--img src="/img/BOOK/BANNER/BANNER_1.png" alt-="BOOK 광고배너_1" style="width:100%;"/--><!--- 예제이니 추후 슬라이딩 이미지 적용 후 삭제한다 --->
    <a href="http://design.eduniety.net/sub/training/COMMUNITY_appguide.php"> <img src="/img/BOOK/BANNER/mo_book_ban.png" alt-="BOOK 광고배너_1" style="width:100%;"/></a><!--- 예제이니 추후 슬라이딩 이미지 적용 후 삭제한다 --->
</div>


<!-- BOOK list (미디어쿼리) -->
<div id="LIST_book">
    <p class="mid_bar">eBook</p>
        <?php $this->load->view('book/best_book_list.php', array('bestlist'=>$ALLlist)); ?>
</div>


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
