			<strong>TV 구매내역</strong>
			<h3>1. 멤버십 구매</h3>
            <span>◎ 결제일&nbsp;:&nbsp;<br> 
            <?php
                foreach($aMemsvcInfo['aPurchaseInfo'] as $key=>$val)
                {
                    echo "&nbsp;&nbsp;&nbsp;&nbsp; - ".$val->regdate . "<br>";
                }
            ?>           
            </span>
			<span>
                ◎ 현재까지 구매 총수&nbsp;:&nbsp;<?=$aMemsvcInfo['aPossibleCnt']['tv']?> / <?=$aMemsvcInfo['aUseCnt']['tv']?><br>
            <?php
                foreach($aMemsvcInfo['aUsage_Contents']['tv'] as $key=>$val):
                    if($val->sel_type == "M") : 
            ?>
                  <span>① <?=$val->name?> &nbsp;:&nbsp; <?=$val->regdate?></span>
            <?
                    endif;
                endforeach;
            ?>
			</span>
			<!--h3>2. 일반구매</h3>
            <span>
            <?php
                foreach($aMemsvcInfo['aUsage_Contents']['tv']as $key=>$val):
                    if($val->sel_type == "") :
            ?>
                  <span>① <?=$val->name?> (<?=$val->price?> 원) &nbsp;:&nbsp; <?=$val->regdate?></span>
            <?
                    endif;
                endforeach;
            ?>
			</span>
			<div class="set">
				<span class="BT_reg"><a href="/sub/BOOK/MAIN_all.php""><img src="/img/myPage/I_pencil.png" alt="아이콘" style="width:22%;" />&nbsp;쇼핑하기</a></span>
			</div-->

