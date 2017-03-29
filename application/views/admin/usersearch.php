
<!-- SangSe Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">설문지 상세보기</h4>
      </div>
      <div class="modal-body">
        <div class="box box-solid">
          <div class="box-header with-border">
            <i class="fa fa-text-width"></i>

            <h3 class="box-title">주니어메이커</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <dl>
              <dt><i class="fa fa-fw fa-question"></i>참가자가 주니어소프트웨어클럽 프로그램 참여 경험이 있다면 피드백 및 건의사항 부탁 드립니다</dt>
              <dd><div id="sangse_recommend"></dd>
              <dt><i class="fa fa-fw fa-question"></i>주니어소프트웨어클럽 참가 동기, 목적</dt>
              <dd><div id="sangse_motive"></dd>
              <dt><i class="fa fa-fw fa-question"></i>참여학생의 소프트웨어/컴퓨터과학/코딩 교육 경험을 간단히 설명해주세요</dt>
              <dd><div id="sangse_experience"></dd>
              <dt><i class="fa fa-fw fa-question"></i>참여신청 학생의 성향 및 성격은?</dt>
              <dd><div id="sangse_nature"></dd>
              <dt><i class="fa fa-fw fa-question"></i>참여신청 학생이 선호하고 즐기거나 잘하는 학과목, 방과후 수업은? 선호하지 않거나 싫어하는 것은?</dt>
              <dd><div id="sangse_favor"></dd>
              <dt><i class="fa fa-fw fa-question"></i>프로그램에 바라는점</dt>
              <dd><div id="sangse_jr_hope"></dd>
              <dt><i class="fa fa-fw fa-question"></i>본 프로그램을 알게 된 경로</dt>
              <dd><div id="sangse_channel"></dd>
              <dt><i class="fa fa-fw fa-question"></i>코딩클럽에 바라는 점</dt>
              <dd><div id="sangse_club_hope"></dd>
              <dt><i class="fa fa-fw fa-question"></i>문의사항</dt>
              <dd><div id="sangse_inquiry"></dd>
            </dl>
          </div>
          <!-- /.box-body -->
        </div> 


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<form name='fo' method='post' action='<?=HOSTURL?>/admin/usersearch'>
<section class="invoice">
  <div class="col-md-6">
      Email ID or UserName  
      <div class="input-group input-group-sm">
        <input id='sAccountIDorName' name='sAccountIDorName' type="text" class="form-control" value="<?=$sAccountIDorName?>">
            <span class="input-group-btn">
              <button id="bSend" name='bSend' type="button" class="btn btn-info btn-flat">Go!</button>
            </span>
      </div>
  <br>
  </div>
  <div class="row">
    <div class="col-xs-12">
    <!-- title row -->
<?php if( count($userinfo) >= 1){ ?>
      <h2 class="page-header">
        <i class="fa fa-globe"></i> 유저 상세 정보
        <!--small class="pull-right">Date: 2/10/2014</small-->
      </h2>
<?php } 
  if( $notice )
    echo'<h3 class="page-header">'.$notice.'</h3>';
?>
    </div>
    <!-- /.col -->
  </div>
  <!-- info row -->
<?php
if( count($userinfo) >= 1)
{
  for($i=0 ; $i<count($userinfo); $i++)
  { 
?>
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      <b>Account Info</b><br>
      Account ID : <?php echo $userinfo[$i]->account_id ; ?> <br>
      생성일 : <?php echo $userinfo[$i]->regdate ; ?><br>
      본인확인일 : <?php echo $userinfo[$i]->confirm; ?><br>
    </div>
    <div class="col-sm-4 invoice-col">
      <b>학생정보</b> 
      <address>
        이름 : <strong><?php echo $userinfo[$i]->name; ?></strong><br>
        학교 : <?php echo $userinfo[$i]->school; ?><br>
        학년 : <?php echo $userinfo[$i]->grde; ?><br>
        Email : <?php echo $userinfo[$i]->account_id ; ?><br>
      </address>
    </div>
    <div class="col-sm-4 invoice-col">
      <b>학부모정보</b> 
      <address>
        이름 : <strong><?php echo $userinfo[$i]->pname; ?></strong><br>
        HP : <?php echo $userinfo[$i]->php; ?><br>
        Email : <?php echo $userinfo[$i]->pemail; ?><br>
      </address>
    </div>
  </div>
  <!-- /.row -->
  <!-- Table row -->
  <div class="row">
    <div class="col-xs-12 table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>프로그램번호</th>
          <th>프로그램명</th>
          <th>상태</th>
          <th>신청일</th>
          <th>기능</th>
        </tr>
        </thead>
        <tbody>
<?php
    for ($j=0 ; $j<count($membersvc) ; $j++)
    {
      if($userinfo[$i]->usn == $membersvc[$j]->usn)
      {
?>
        <tr>
          <td><?php echo $membersvc[$j]->course_idx; ?></td>
          <td><?php echo $membersvc[$j]->name; ?></td>
          <td><?php echo $membersvc[$j]->state; ?></td>
          <td><?php echo $membersvc[$j]->regdate; ?></td>
          <?php echo '<td><button type="button" onclick="javascript:showSangse('.$membersvc[$j]->usn.','.$membersvc[$j]->course_idx.')" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">설문지보기</button>';?>
          <?php
            if($membersvc[$j]->stateCode == 'REQ') 
              echo "<button id='bChangeState' onclick='javascript:changeState(".$membersvc[$j]->usn.",".$membersvc[$j]->course_idx.",\"CONF\")' class='btn btn-info btn-xs'><b>입금확인</b></button></td>"; 
            else
              echo "<button id='bChangeState' onclick='javascript:changeState(".$membersvc[$j]->usn.",".$membersvc[$j]->course_idx.",\"REQ\")' class='btn btn-danger btn-xs'><b>입급취소</b></button></td>"; 
          ?>
        </tr>
<?php
      }
    } 
?>
        </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <HR width="95%" align="center" >
<?php
  }
}
?>
</section>
</form>
<script>
  $(function(){
    $('#bSend').click(function(){
      document.fo.submit();
    }); 
  });
  
  function changeState(usn, course_idx, state)
  {
    $.post(
      "<?=HOSTURL?>/Admin/rpcUpdateState"
      ,{
           "usn" : usn 
          ,"state" : state 
          ,"course_idx" : course_idx 
       }
      ,function(data, status) {
        if (status == "success" && data.code == 1)
        {
          alert('변경 되었습니다.'); 
          window.location.reload(true);
        }
      }
    );         
  } 
  function showSangse(usn,course_idx)
  {
    $.post(
      "<?=HOSTURL?>/Admin/rpcGetQuestionInfo"
      ,{
         "usn" : usn 
         ,"course_idx" : course_idx 
       }
      ,function(data, status) {
        if (status == "success" && data.code == 1)
        {
          document.getElementById('sangse_recommend').innerHTML = data.recommend; 
          document.getElementById('sangse_motive').innerHTML = data.motive; 
          document.getElementById('sangse_experience').innerHTML = data.experience; 
          document.getElementById('sangse_nature').innerHTML = data.nature; 
          document.getElementById('sangse_favor').innerHTML = data.favor; 
          document.getElementById('sangse_jr_hope').innerHTML = data.jr_hope; 
          document.getElementById('sangse_channel').innerHTML = data.channel; 
          document.getElementById('sangse_club_hope').innerHTML = data.club_hope; 
          document.getElementById('sangse_inquiry').innerHTML = data.inquiry; 
        }
      }
    );
  }
</script>
