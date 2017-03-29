$(document).ready(function () {
    $('html').animate({scrollTop:0}, 1);
    $('body').animate({scrollTop:0}, 1);
    
    var _preBtn = $(".preBtn a");
    
    _preBtn.on("click",btnClick);
    
    function btnClick($e) {
        var tmpUser = navigator.userAgent;
        if (tmpUser.indexOf('iPhone') > 0 || tmpUser.indexOf('iPod') > 0 || tmpUser.indexOf('Android') > 0) {
            
            _preBtn.click(function(){
                alert("애듀니티 멤버십 사전구매는 PC에서만 참여하실 수 있습니다.");
            });

        }else{
         //구매페이지로 이동..  
        }
    }

    //모션
    var _motion = $(".motion");

    show();

    function show() {
        TweenMax.set(_motion, {
            opacity: 0,
            scale: 0
        });
        TweenMax.to(_motion, 0.8, {
            opacity: 1,
            scale: 1,
            ease: Power1.easeOut,
            delay: 0.3
        });
    }

    $(".tag").delay(1500).animate({
        top: 0
    }, 700);

    //자주하는 질문
    $(".list li .tit").on("click", function () {
        $(this).find("img").toggle();
        $(this).siblings(".txt").slideToggle();
    });

});