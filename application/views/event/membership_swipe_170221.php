<?php
$sDisplay = "";
if(date('YmdHis') <= '20170228230000')
{
    $sDisplay = "style=\"display:none\"";
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <meta name="HandheldFriendly" content="true">

    <title>Membership Slider</title>
    <link rel="stylesheet" href="/membership/static/css/reset.css">
    <link rel="stylesheet" href="/membership/static/css/swipe_style.css">
</head>
<body>
    <div class="main"><img src="/membership/static/img/Swipe/step_main.jpg"></div>
    <div id="slide_box">
        <div class="slider">
            <div class="list_wrap"> 
                <ul class="list clearfix">
                    <li><img src="/membership/static/img/Swipe/step_01.jpg"></li>
                    <li><img src="/membership/static/img/Swipe/step_02.jpg"></li>
                    <li><img src="/membership/static/img/Swipe/step_03.jpg"></li>
                    <li><img src="/membership/static/img/Swipe/step_04.jpg"></li>
                    <li><img src="/membership/static/img/Swipe/step_05.jpg"></li>
                    <li><img src="/membership/static/img/Swipe/step_06.jpg"></li>
                    <li><img src="/membership/static/img/Swipe/step_07.jpg"></li>
                </ul>
                <p class="slide_nav">
                    <span class="on">0</span>
                    <span class="">1</span>
                    <span class="">2</span>
                    <span class="">3</span>
                    <span class="">4</span>
                    <span class="">5</span>
                    <span class="">6</span>
                </p>
                <div class="arrow arrow_prev"><img src="/membership/static/img/Swipe/arrow_left.png" alt="왼쪽"></div>
                <div class="arrow arrow_next"><img src="/membership/static/img/Swipe/arrow_right.png" alt="오른쪽"></div>
                <div class="buyBtn" <?=$sDisplay?>><a href="http://design.eduniety.net/sub/training/membership_apply.php?sale_idx=1" target="_self"><img src="/membership/static/img/Swipe/buy_btn.png" alt="구매하기"></a></div>
            </div>
            
        </div>
    </div>
    <div class="closeBtn"><a href="javascript:history.back();"><img src="/membership/static/img/Swipe/close_btn.png" alt="닫기"></a></div>
    <script src="/membership/static/js/libs/jquery-1.12.4.min.js"></script>
    <script src="/membership/static/js/libs/jquery.mobile-1.4.5.min.js"></script>
    <script src="/membership/static/js/swipe.js"></script>
</body>
</html>
