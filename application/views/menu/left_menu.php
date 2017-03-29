<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <title>leftMenu</title>
    <link rel="stylesheet" href="/membership/static/css/menu_style.css">

    <!--- 메뉴 토글 및 슬라이더 --->
    <link rel="stylesheet" href="/external/Swiper-3.4.1/dist/css/swiper.min.css">
    <link rel="stylesheet" href="/css/swiper.css">
    <script src="/external/Swiper-3.4.1/dist/js/swiper.min.js"></script>
    <script src="/js/popup/popup.js"></script>
    <script>
        function OpenMyPage ()
        {
            OpenPopup("mypage_layer", "slide");
        }

        function CloseMyPage ()
        {
            ClosePopup("mypage_layer", "slide");
        }
    </script>
    <script language="javascript" type="text/javascript">
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

        function OnSetup(){
            CheckBrowserType();

            if(isBrowserType == 1) { // 안드로이드
                window.android.goSetting();
            } else if(isBrowserType == 2) {  //아이폰
                //document.location = "jscall://goContentPlayCDE:"+ url;
                window.location.href = "jscall://goSetting:";
            } else {
                alert("앱기능입니다.");
            }
        }

    </script>
</head>
<body>
    <div id="menu_wrap">
        <div class="left_menu">
            <span class="setting">
                <a href="javascript:OnSetup();">
                    <img class="set_img" src="/img/leftMenu/set_img.png" alt="설정" />
                </a>
            </span>
            <span class="close">
                <a href="javascript:CloseMyPage();">
                    <img src="/img/leftMenu/close.png" alt="창닫기" />
                </a>
            </span>
            <!-- 프로필 -->
            <div class="menu_top">
                <div class="pro_img">
                    <span class="pro_peo"><img src="/img/leftMenu/pro_img.png" alt="프로필이미지"/></span>
                    <img src="/img/leftMenu/pro_bg.png" alt="프로필이미지" class="pro_bg" />
                </div>
                
                <?php if($isLogin) : ?>
                <!--로그인 후-->
                <div class="pro_txt">
                    <p class="name"><?=$aUserInfo->mb_name?> &nbsp;&nbsp;&nbsp;&nbsp;<a href="/process/PORTAL/logout.php">[Logout]</a></p>
                    <p class="proId">ID : <?=$isLogin?></p>
                    <?php if($aMemsvcInfo) :?>
                        <p class="mem">멤버십회원 [<?=$aMemsvcInfo['aPurchaseInfo'][0]->exp_s_date?> ~ <?=$aMemsvcInfo['aPurchaseInfo'][0]->exp_e_date?>]</p>
                    <?php endif ?>
                    </div>
                <?php else : ?>
                <!-- 로그인 전 -->
                <div class="pro_txt">
                    <p class="name2"><a href="/sub/PORTAL/MEMBER_login.php?url=/">로그인이 필요합니다</a></p>
                </div>
                <?php endif ?>

            </div>

            <div class="menu_bottom">
                <ul class="menu_bt">
                    
                    <?php foreach($aMenu as $key=>$val) : ?> 
                    <li>
                        
                        <?php if($val['title'] == '행복연수원') {?> 
                        <p class="tit on"><img src="/img/leftMenu/lnb_tit_img.png" class="down" style="display:inline-block"/><img src="/img/leftMenu/lnb_tit_img2.png" class="tit_img" style="display: none"/><?=$val['title']?></p>
                        <?php } else {?> 
                        <p class="tit"><img src="/img/leftMenu/lnb_tit_img2.png" class="tit_img" /><img src="/img/leftMenu/lnb_tit_img.png" class="down"/><?=$val['title']?></p>
                        <?php }?> 

                        <?php $sStyle=""; if($val['title'] == '행복연수원') $sStyle = "style=\"display: block\"";?> 
                        <ul class="menu_st" <?=$sStyle?> >
                        <?php foreach($val['aMenu'] as $k=>$v) : ?> 
                        <li><a href="<?=$v?>"><?=$k?></a></li>
                        <?php endforeach; ?> 
                        </ul>
                    </li>
                    <?php endforeach; ?> 
                </ul>

                <ul class="menu">
                    <!-- 고객센터 -->
                    <li>
                        <p>
                           <a href="http://design.eduniety.net/sub/training/COMMUNITY_appguide.php"><img src="/img/leftMenu/cs_img.png" alt="고객센터" class="bt_icon" />
                            고객센터</a>
                        </p>
                    </li>

                    <!-- 의견 및 제안 -->
                    <li>
                        <p style="border-bottom:none !important;">
                            <a href="http://design.eduniety.net/sub/training/COMMUNITY_1_1_q.php"><img src="/img/leftMenu/id_img.png" alt="의견 및 제안" class="bt_icon" />
                            의견 및 제안</a>
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".menu_bt li .tit").click(function(){
                $(this).toggleClass("on");
                $(this).siblings(".menu_st").slideToggle();
                $(this).find("img").toggle();
            });
        });
    </script>
</body>
</html>
