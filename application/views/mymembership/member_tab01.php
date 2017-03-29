<!--직무연수-->
<div class="training">
    <div class="line clearfix">
        <span class="tit">직무연수</span>
        <span class="goBtn"><a href="/sub/training/MAIN_all.php">원격직무연수신청 바로가기</a></span>
    </div>
    <div class="chart_wrap1">
        <!--<div class="chartBg"><span class="open">서비스 준비중</span></div>-->
        <div class="chartInfo">
            <div class="chartInfoText">
                <p class="usedInfo"><?=$aMemberTraingInfo['aTraingEduInfo']['aTraingEduCompleteInfo']['cnt']?> 학점</p>
                <p class="line"></p>
                <p class="total">총 12학점 중</p>
            </div>
        </div>
        <!--직무연수차트-->
        <div class="chart" id="chart1"></div>
    </div>
</div><!--//직무연수-->
<!--ebook-->
<div class="ebook">
    <div class="line clearfix">
        <span class="tit">e-Book</span>
        <span class="goBtn"><a href="/membership/book/booklist/">e-Book 바로가기</a></span>
    </div>
    <div class="chart_wrap2">
        <!--<div class="chartBg"><span class="open">서비스 준비중</span></div>-->
        <div class="chartInfo">
            <div class="chartInfoText">
                <p class="usedInfo"><?=$aMemSVCInfo['aUseCnt']['b']?> 권</p>
                <p class="line"></p>
                <p class="total">총 8권 중</p>
            </div>
        </div>
        <!--ebook 차트-->
        <div class="chart" id="chart2"></div>
    </div>
</div><!--//ebook-->
<?php
echo "<!--";
//print_r($aMemberTraingInfo);
echo "-->";
?>
<script id="script_code">
    jui.ready([ "chart.builder" ], function(chart) {

        c1 = chart("#chart1", {

            width: 350,
            height : 280,
//            padding: 70,
            theme : "jennifer",
            axis : {
                data: []
            },
            brush : [{
                type : "doubledonut",
//                showText : "outside",
                size : 20,
//                active : [ "red" ],
//                activeEvent : "click",
                showValue : true
            }],
            widget : [{
                type : "tooltip"
            }, {
                type : "legend"
            }]
        });

        setTimeout(function() {
            c1.axis(0).update([ { 학습완료 : <?=$aMemberTraingInfo['aTraingEduInfo']['aTraingEduCompleteInfo']['cnt']?>, 학습중: <?=$aMemberTraingInfo['aTraingEduInfo']['aTraingEduPlayInfo']['cnt']?>, 학습예정: <?=$aMemberTraingInfo['aTraingEduInfo']['aTraingEduReadyInfo']['cnt']?> } ]);
            c1.render(true);
        }, 500);

        c2 = chart("#chart2", {

            width: 350,
            height : 280,
//            padding: 70,
            theme : "jennifer",
            axis : {
                data: []
            },
            brush : [{
                type : "doubledonut",
//                showText : "outside",
                size : 20,
//                active : [ "red" ],
//                activeEvent : "click",
                showValue : true
            }],
            widget : [{
                type : "tooltip"
            }, {
                type : "legend"
            }]
        });

        setTimeout(function() {
            c2.axis(0).update([ { 구매완료: <?=$aMemSVCInfo['aUseCnt']['b']?>, 잔여권: <?=$aMemSVCInfo['aPossibleCnt']['b'] - $aMemSVCInfo['aUseCnt']['b']?> } ]);
            c2.render(true);
        }, 500);

    })
</script>
