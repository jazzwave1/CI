<div class="memberInfo">
    <?php $this->load->view('mymembership/member_info.php', array('oMemberInfo'=>$oMemberInfo, 'aMemSVCInfo'=>$aMemberSVCInfo,'oMemberLoginInfo' => $oMemberLoginInfo)); ?>
</div>
<div class="memberContents">
    <div class="tabGnb">
        <ul>
            <li class="on"><span>사용량</span></li>
            <li><span>학습분석</span></li>
            <li><span>트랜드</span></li>
        </ul>
    </div>
<?php
// $Mymembership = array(
//     'oMemberInfo'    => $oMemberInfo
//     ,'aMemberSVCInfo' => $aMemberSVCInfo
//     ,'oMemberTraingInfo' => $aMemberTraingInfo
// );
// echo "<!--";
// print_r($Mymembership);
// echo "-->";
?>
    <div class="inner">
        <div class="tab tab1">
            <?php $this->load->view('mymembership/member_tab01.php' , array("aMemberSVCInfo"=>$aMemberSVCInfo, "aMemberTraingInfo"=>$aMemberTraingInfo)); ?>
        </div>
        <div class="tab tab2">
            <?php $this->load->view('mymembership/member_tab02.php'); ?>
        </div>
        <div class="tab tab3">
            <?php $this->load->view('mymembership/member_tab03.php'); ?>
        </div>
    </div>
</div>
<script>
    $(".tabGnb ul li").click(function () {
        $(this).siblings("li").removeClass("on");
        $(this).addClass("on");
        $(".tab").hide();
        $(".tab").eq($(this).index()).show();
    });
</script>
