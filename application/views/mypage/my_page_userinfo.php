
<!--◎ log-out 상태 -->
<div class="add"><!-- 페이지 고유속성 -->
	<div class="log_out"><!--◎ 상태 -->
        <!--◎ BOOK -->
        <section class="<?=$class_state?>">
            <?php $this->load->view('mypage/my_page_userinfo_ad');?>
        </section><!--- // 고유속성-->
	</div><!--◎ // 상태 -->

</div><!-- // 페이지 고유속성 -->


<!--◎ log-in 상태  -->
<div class="add"><!--- 페이지 고유속성 -->
	<div class="log_in"><!--◎ 상태 -->
		<!--◎ BOOK -->
		<section class="<?=$class_state?>">
        <?php
           if(!$aMemsvcInfo)
               $this->load->view('mypage/my_page_userinfo_ad');
           else
               $this->load->view('mypage/'.$pagename , $aMemsvcInfo);
        ?>
        </section><!-- // 고유속성 -->
	</div><!--◎ // 상태 -->
</div><!--// 페이지 고유속성 -->
