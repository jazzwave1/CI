<!--- 3 단계 슬라이딩 --->
<!-------------------------------- 3col_slide ---------------------------------------->
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="/include/jq/slide/3col/slick/slick.css">
<link rel="stylesheet" type="text/css" href="/include/jq/slide/3col/slick/slick-theme.css">
<style>
    h2 {color:#333 !important; line-height:16px !important;}
    h3 {margin-top:8px !important; line-height:16px !important;}
    .slick-slide img {border-radius:0 !important; -webkit-border-radius:0 !important; -moz-border-radius:0 !important; -o-border-radius:0 !important; -ms-border-radius:0 !important;}

    /*** 미디어쿼리 ***/
    /*@media (min-width:401px) and (max-width:999px) {*/
        /*.img {width:3.8% !important;}*/
    /*}*/
    /*** // 미디어쿼리 ***/

    /*** 미디어쿼리 ***/
    /*@media (min-width:1000px){*/
        /*.img {width:2.7% !important; margin-right:20px !important;}*/
    /*}*/
    /*** // 미디어쿼리 ***/
</style>

<div class="regular slider">
    <?php

$aBookList =array(
                0=>array('booktitle'=>'긍정의교육(4~7세편)', 'sImgURL'=>'/img/BOOK/book/3d/ex_1.png', 'bookinfo'=>'[학급운영] 제인 넬슨 외 2인 저 / 조고은 역')
                ,1=>array('booktitle'=>'긍정의교육(8~15세편)', 'sImgURL'=>'/img/BOOK/book/3d/ex_1.png', 'bookinfo'=>'[학급운영] 제인 넬슨 외 2인 저 / 조고은 역')
            );
        for($i=0; $i<2; $i++) :?>
        <div class="img">
            <a href="#">
                <img src="<?=$aBookList[$i]['sImgURL']?>" style="width:94%;" alt="도서사진" />
                <h3 class="h3"><?=$aBookList[$i]['booktitle']?></h3>
                <span><?=$aBookList[$i]['bookinfo']?></span>
            </a>
        </div>
    <?php endfor; ?>
</div>


<script src="/include/jq/slide/3col/slick/slick.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(document).on('ready', function() {
        $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".center").slick({
            dots: true,
            infinite: true,
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".variable").slick({
            dots: true,
            infinite: true,
            variableWidth: true
        });
    });
</script>