			<strong>Membsership 구매내역</strong>
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
           
            <!--span>
                ◎ [원격]현재까지 구매 종수&nbsp;:&nbsp;<?=$aMemsvcInfo['aPossibleCnt']['et']?> / <?=$aMemsvcInfo['aUseCnt']['et']?><br>
            </span>
		    <span>
                ◎ [현장]현재까지 구매 종수&nbsp;:&nbsp;<?=$aMemsvcInfo['aPossibleCnt']['t']?> / <?=$aMemsvcInfo['aUseCnt']['t']?><br>
            </span>
			<span>
                ◎ [BOOK]현재까지 구매 종수&nbsp;:&nbsp;<?=$aMemsvcInfo['aPossibleCnt']['b']?> / <?=$aMemsvcInfo['aUseCnt']['b']?><br>
            </span>
	        <span>
                ◎ [TV]현재까지 구매 종수&nbsp;:&nbsp;<?=$aMemsvcInfo['aPossibleCnt']['tv']?> / <?=$aMemsvcInfo['aUseCnt']['tv']?><br>
            </span-->
	    
