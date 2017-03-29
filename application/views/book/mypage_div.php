<script>
function OpenMyPage ()
{
	OpenPopup("mypage_layer", "slide");	
}

function CloseMyPage ()
{
	ClosePopup("mypage_layer", "slide");
}
</script>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
    $('#container').load('http://design.eduniety.net/membership/mypage/book');
    });
</script>

<div id="mypage_layer" class="layer_pop">
    <div class="myPage">
        <section id="myPage_IN"><!--- 상태 고유속성 --->
            <div class="_PORTAL"><!--- 페이지 고유속성 --->
     
            <div id="container">
            </div>
               
	     </div><!--- // 페이지 고유속성 --->
        </section><!--- 상태 고유속성 --->
    </div>
</div>
