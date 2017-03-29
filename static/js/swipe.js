var list = $('ul.list');
var slide = $('ul.list li');
var slideCount = slide.length;
var slideIndex = slide.index();
var slideWidth = slide.width();
var slideHeight = slide.height();
var sliderUlWidth = slideCount * slideWidth;
var count = 0;
var navBtn = $('.slide_nav span');

console.log(slideWidth);
console.log(sliderUlWidth);

var _wWidth = $(window).width();
var _wHeight = $(window).height();
$(".slider .list_wrap .list li").width(_wWidth);
$(".slider .list_wrap .list li").height(_wHeight);


list.css({
    width: sliderUlWidth,
    marginLeft: -slideWidth
});
$('ul.list li:last-child').prependTo('ul.list');


$("#slide_box").hide();
$(".main").show();
//        $(".main").hide();


/*$(".contents").on("click", function(){
    $(".main").show();
});*/


$(".main").on("click", function () {
    $("#slide_box").show();
});


$('.arrow_prev').on("click", function () {
    moveLeft(list);
});

$('.arrow_next').on("click", function () {
    moveRight(list);
});


$('ul.list li').on("swipeleft", function () {
    moveRight(list);
});

$('ul.list li').on("swiperight", function () {

    moveLeft(list);
});

/*$('.closeBtn').on("click", function () {
    $(".main").hide();
    $("#slide_box").hide();
});*/


/*왼쪽*/
function moveLeft($box, target) {

    var box = $box;
    var w = box.children("li").width();

    if (target) {
        count = target;
    } else {
        count--;
    }
    if (count < 0) {
        count = slideCount - 1;
    }
    box.animate({
        left: w
    }, 200, function () {
        box.children("li:last-child").prependTo(box);
        box.css("left", "0");
        navBtn.removeClass("on");
        navBtn.eq(count).addClass("on");
    });

}
/*오른쪽*/
function moveRight($box, target) {

    var box = $box;
    var w = box.children("li").width();
    if (target) {
        count = target;
    } else {
        count++;
    }
    if (count > slideCount - 1) {
        count = 0;
    }
    box.animate({
        left: w * (-1)
    }, 200, function () {
        box.children("li:first-child").appendTo(box);
        box.css("left", "0");
        navBtn.removeClass("on");
        navBtn.eq(count).addClass("on");
    });

}
/*자동슬라이드*/
var timer = 0;

function setResetInterval(bool) {
    if (bool) {
        timer = setInterval(function () {
            moveRight(list);
        }, 3000);
    } else {
        clearInterval(timer);
    }
}
setResetInterval(true);