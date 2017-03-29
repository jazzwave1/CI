<div class="info_wrap clearfix">
    <div class="pic">
        <span><img src="/img/Membership/profile.png"></span>
    </div>
    <div class="txt">
    <p><span class="name"><?=$oMemberInfo->mb_name?></span> 선생님</p>
        <p>현재 에듀니티 멤버십 서비스를 이용하고 계십니다.</p>
        <p class="date"><span>멤버십 : <?=$aMemSVCInfo['aPurchaseInfo'][0]->exp_s_date?> ~ <?=$aMemSVCInfo['aPurchaseInfo'][0]->exp_e_date?></span><br><span>최근접속일 : <?=$oMemberLoginInfo->login_date?> </span></p>
    </div>
</div>
