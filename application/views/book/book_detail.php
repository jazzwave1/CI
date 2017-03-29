<div class="conDetail_TIT_BOOK"><!--- 고유속성 --->
    <?php $this->load->view('book/book_detail_tit.php',array('aBookDetailInfo'=>$aBookDetailInfo)); ?>
</div><!--- // 고유속성 --->

<!--sns 공유버튼 확장해야함 -->
<div ID="TIT_BOOK_menus">
    <?php $this->load->view('book/book_detail_sns.php',array('aBookDetailInfo'=>$aBookDetailInfo, 'isBUY'=>$isBUY)); ?>
</div>
<!-- //sns 공유버튼 확장해야함 -->

<div class="demo" style="margin-top:20px !important;"><!--- demo: margin값, 여기선 아코디언만 적용됨 --->
    <?php $this->load->view('book/book_detail_tab.php',array('aBookDetailInfo'=>$aBookDetailInfo)); ?>
</div><!--- // demo --->

<!--- 이부분 분리 css 적용안됨 --->
<!--<div style="margin-top:-5px;">-->
<!--    <?php //$this->load->view('book/book_detail_slider.php', array('aBookDetailInfo'=>$aBookDetailInfo)); ?>-->
<!--</div>-->
<!--- //이부분 분리 css 적용안됨 --->

<!--하단버튼-->
<ul class="BT_bar">
    <li><a href="/membership/book">전체 목록으로</a></li>
</ul>
<!-- //하단버튼-->




