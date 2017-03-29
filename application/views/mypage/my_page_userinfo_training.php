			<strong>연수 구매내역</strong>
			<h3>1. 멤버십 구매</h3>
            <span>◎ 결제일&nbsp;:&nbsp;<br> 
            <?php
                foreach($aMemsvcInfo['aPurchaseInfo'] as $key=>$val)
                {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp; - ".$val->regdate . "<br>";
                }
            ?>
            </span>
            <span>◎ 결제금액&nbsp;:&nbsp;<br> 
            <?php
                foreach($aMemsvcInfo['aPurchaseInfo'] as $key=>$val)
                {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp; - ". number_format($val->price) . " 원<br>  ";
                }
            ?>
            </span>
            <span>◎ 혜택&nbsp;:&nbsp;<br> 
            <?php
                foreach($aMemsvcInfo['aPurchaseInfo'] as $key=>$val)
                {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp; - ". $val->contents . " <br>  ";
                }
            ?>
            </span>
 
			<span>
                ◎ [원격] 현재까지 구매 총수&nbsp;:&nbsp;<?=$aMemsvcInfo['aPossibleCnt']['et']?> / <?=$aMemsvcInfo['aUseCnt']['et']?><br>
            <?php
            if($aMemsvcInfo['aUsage_Contents']['et']) :
               foreach($aMemsvcInfo['aUsage_Contents']['et'] as $key=>$val) :
                    if($val->sel_type == "M") : 
            ?>
                  <span>① <?=$val->name?> &nbsp;:&nbsp; <?=$val->regdate?></span>
            <?
                    endif;
                endforeach;
            endif;
            ?>
            </span>
            <!--span>
                ◎ [현장] 현재까지 구매 총수&nbsp;:&nbsp;<?=$aMemsvcInfo['aPossibleCnt']['t']?> / <?=$aMemsvcInfo['aUseCnt']['t']?><br>
            <?php
            if($aMemsvcInfo['aUsage_Contents']['t']) :
                foreach($aMemsvcInfo['aUsage_Contents']['t'] as $key=>$val):
                    if($val->sel_type == "M") : 
            ?>
                  <span>① <?=$val->name?> &nbsp;:&nbsp; <?=$val->regdate?></span>
            <?
                    endif;
                endforeach;
            endif;
            ?>
			</span-->

            <!--span>
                <div class="set">
                    <span class="BT_reg"><a href="/sub/BOOK/MAIN_all.php"><img src="/img/myPage/I_pencil.png" alt="아이콘" style="width:22%;" />&nbsp;쇼핑하기</a></span>
                </div>
			</span-->
              
            <!-- ad 영역인것 같다 & DB  연동이 필요한 부분입니다 -->
            <!--h3>2. 일반</h3>
            <span>◎ [TV]<br>
            &nbsp;&nbsp;&nbsp;&nbsp; - 나의 영상 (10개)<br>
            &nbsp;&nbsp;&nbsp;&nbsp; - 찜한 영상 (10개)<br>
            &nbsp;&nbsp;&nbsp;&nbsp; - 최신 영상 (3개)<br>
            &nbsp;&nbsp;&nbsp;&nbsp; - 남긴 댓글 (3개)<br>
            </span>
            <span>◎ [원격연수] 모집중<br>
            &nbsp;&nbsp;&nbsp;&nbsp; -직무7기( 17.9.1 ~ 9.20)<br>
            &nbsp;&nbsp;&nbsp;&nbsp; - 전체교육일정보기<br>
			</span>
            <span>◎ [현장연수] 모집중<br>
            &nbsp;&nbsp;&nbsp;&nbsp; - 직무접수중(2개)<br>
            &nbsp;&nbsp;&nbsp;&nbsp; - 자율접수중(3개)<br>
			</span>
            <span>◎ [모임] <br>
            &nbsp;&nbsp;&nbsp;&nbsp; - 운영모임(2개)<br>
            &nbsp;&nbsp;&nbsp;&nbsp; - 가입모임(3개)<br>
            &nbsp;&nbsp;&nbsp;&nbsp; - 남긴댓글(3개)<br>
			</span-->




