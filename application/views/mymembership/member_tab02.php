<div class="invite">
    <span class="icon"><img src="/img/Membership/icon_mate.png"></span><span>짝궁과 함께 공부해보세요!</span>
</div>
<div class="analysis">
    <div class="partBtn clearfix">
        <span class="week">주간</span><span class="month on">월간</span>
    </div>
    <div class="chart_wrap3">
        <div class="announce">
            <div class="txt">
                <p>에듀니티 멤버십 회원의 학습 데이터 수집중입니다.</p>
                <p>수집이 완료되면 화면에서 확인 가능합니다.</p>
                <p>감사합니다.</p>
            </div>
        </div>
        <div class="chart" id="chart3_month"></div>
        <div class="chart chart_week" id="chart3_week"></div>
    </div>
    <br>
    <p>2017년 <span>1</span>월에 시작한 학습자들의 학습 비교(%)</p>
    <br>
    <br>
    <div class="chart_wrap4">
        <div class="announce">
            <div class="txt">
                <p>에듀니티 멤버십 회원의 학습 데이터 수집중입니다.</p>
                <p>수집이 완료되면 화면에서 확인 가능합니다.</p>
                <p>감사합니다.</p>
            </div>
        </div>
        <div class="chart" id="chart4"></div>
    </div>
</div>
<!--<div class="matePop">
    <div class="tit">
        <p class="color">함께 공부할 친구 초대</p>
        <p>멤버십 가입 선생님만 초대할 수 있습니다.</p>
    </div>
    <div class="searchMate">
        <form>
            <input type="text">
        </form>
    </div>
    <div class="listMate">
        <ul>
            <li>
                <div class="info">
                    <span><img src="/img/Membership/profile.png"></span>
                    <span><em>홍길동</em> 선생님</span>
                    <span class="plusBtn">추가버튼</span>
                </div>
            </li>
        </ul>
    </div>
</div>-->
<script id="script_code">

    /*주간 월간*/
    $(".partBtn .week").on("click",function () {
        $("#chart3_month").hide();
        $(".partBtn span").removeClass("on")
        $(this).addClass("on");
        $("#chart3_week").show();
    });
    $(".partBtn .month").on("click",function () {
        $("#chart3_week").hide();
        $(".partBtn span").removeClass("on")
        $(this).addClass("on");
        $("#chart3_month").show();
    });

   /* var _bHeight = $(window).height();
    /!*짝궁 popup*!/
    $(".icon").on("click",function () {
        $(".dimmed").show();
        $(".dimmed"). height(_bHeight);
        $(".matePop").show();
    });

    $(".dimmed").on("click", function () {
        $(this).hide();
        $(".matePop").hide();
    });*/
    /*차트*/
    var data = [
        { me : 1, f1 : 2, f2 : 1 },
        { me : 4, f1 : 1, f2 : 1 },
        { me : 3, f1 : 1, f2 : 2 },
        { me : 5, f1 : 5, f2 : 1 }
    ];

    var data2 = [
        { me : 1, f1 : 2, f2 : 1 },
        { me : 4, f1 : 1, f2 : 1 },
        { me : 3, f1 : 1, f2 : 2 },
        { me : 5, f1 : 5, f2 : 1 }
    ];


    jui.ready([ "chart.builder" ], function(chart) {
        c3 = chart("#chart3_month", {
            width: 350,
            height : 280,
            theme : "jennifer",
            padding : 50,
            axis : {
                x : {
                    domain : [ "1월", "2월", "3월", "4월" ],
                    line : true
                },
                y :
                    {
                        type : 'range',
                        domain : function(d) {
                            return [d.me, d.f1, d.f2];
                        },
                        step : 10
                    },
                data : data
            },
            brush : [
                {
                    type : 'line',
                    display : 'all',
                    activeEvent : "click",
                    active: "me",
                    animate: true
                }
            ],
            widget : [
                {
                    type : "title",
//                    text : "text",
                    render : true
                },
                {
                    type : "tooltip"
                }
            ]
        });
        c3_1 = chart("#chart3_week", {
            width: 350,
            height : 280,
            theme : "jennifer",
            padding : 50,
            axis : {
                x : {
                    domain : [ "1주", "2주", "3주", "4주" ],
                    line : true
                },
                y :
                    {
                        type : 'range',
                        domain : function(d) {
                            return [d.me, d.f1, d.f2];
                        },
                        step : 10
                    },
                data : data2
            },
            brush : [
                {
                    type : 'line',
                    display : 'all',
                    activeEvent : "click",
                    active: "me",
                    animate: true
                }
            ],
            widget : [
                {
                    type : "title",
//                    text : "text",
                    render : true
                },
                {
                    type : "tooltip"
                }
            ]
        });

        c4 = chart("#chart4", {
            width: 300,
            height : 280,
            theme : "jennifer",
            padding : 50,
            axis : {
                x : {
                    type : "range",
                    domain : [ 0, 100 ],
                    step : 10,
                    line : true
                },
                y : {
                    type : "block",
                    domain : "quarter",
                    line : true
                },
                data : [
                    { quarter : "직무연수", 평균 : 1, 나의학습량 : 1 },
                    { quarter : "e-Book", 평균 : 1, 나의학습량 : 1 },
                    { quarter : "세미연수", 평균 : 1, 나의학습량 : 1 },
                ]
            },
            brush : {
                type : "bar",
                target : [ "평균", "나의학습량"]
            },
            widget : [
//                { type : "title", text : "Bar Sample" },
                { type : "tooltip", orient: "right" },
                { type : "legend" }
            ]
        });
    });




</script>
