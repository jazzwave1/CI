    <div class="box">
      <div class="row" style="margin-top: 10px; margin-bottom: 10px; ">
        <div class="col-xs-2">
          <label style="margin-top: 10px;margin-left: 10px;">검색조건</label>
        </div>
        <div class="col-xs-4">
          <div class="form-group">
            <select multiple id="course_idx" name="course_idx" class="form-control">
              <option value="" >프로그램 이름 선택</option>
  <?php
              foreach($aCourse as $key=>$val)
              {
                //if($key == $courseIdx)
                if(in_array($key ,$courseIdx))
                  echo '<option value="'.$key.'" selected>'.$val.'</option>';
                else
                  echo '<option value="'.$key.'">'.$val.'</option>';
              }
  ?>
            </select>
          </div>
        </div>
        <div class="col-xs-2">
          <button id="bSend" class="btn btn-block btn-default">검색</button>
        </div>
      </div>     
        
      <div class="box-header">
        <i class="fa fa-fw fa-list"></i>선택프로그램 : <?=$courseName?> 
      </div>
      
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>신청 프로그램</th>
            <th>이름</th>
            <th>학교</th>
            <th>학년</th>
            <th>부모님이름</th>
            <th>부모님HP</th>
            <th>부모님메일</th>
            <th>상태</th>
            <th>기능</th>
          </tr>
          </thead>
          <tbody>
<?php
            if($aRowData)
            {
              foreach($aRowData as $key=>$val)
              {
                echo "<tr>";
                echo "  <td>".$val->course_idx."</td>"; 
                echo "  <td>".$val->name."</td>"; 
                echo "  <td>".$val->school."</td>"; 
                echo "  <td>".$val->grde."</td>"; 
                echo "  <td>".$val->pname."</td>"; 
                echo "  <td>".$val->php."</td>"; 
                echo "  <td>".$val->pemail."</td>"; 
                echo "  <td>".$val->state."</td>"; 
                
                if($val->stateCode == 'REQ')
                {
                  echo "  <td><button id='bChangeState' onclick='javascript:changeState(".$val->usn.",".$val->courseIDX.",\"CONF\")' class='btn btn-info btn-xs'><b>입금확인</b></button>";
                }
                else
                {
                  echo "  <td><button id='bChangeState' onclick='javascript:changeState(".$val->usn.",".$val->courseIDX.",\"REQ\")' class='btn btn-danger btn-xs'><b>입급취소</b></button></td>";
                }
                echo "</tr>";
              }
            }
?>
          </tbody> 
        </table>  
      </div> 
    </div>
  <script>   
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
          window.location.reload(); 
        }
      }
    );         
  }     
  
  $(function(){
    $('#bSend').click(function(){
      var courseIDX = '' + $("select[name=course_idx]").val() ;
      var sCourseIDX = ''; 
      var aCourseIDX = courseIDX.split(',');
      for(var i in aCourseIDX)
      {
        sCourseIDX = sCourseIDX + aCourseIDX[i] + '_'; 
      }
      
      if($("select[name=course_idx]").val() == '')
      {
        alert('프로그램 이름을 선택해 주세요');
        $('#course_idx').focus();
        return;
      }
      window.location.replace("<?=HOSTURL?>/admin/userlist/" + sCourseIDX); 
    });
       
    $('#bLogout').click(function(){
        window.location.replace("<?=HOSTURL?>/admin/logout"); 
      });
        
    $("#example1").DataTable();

  });
  </script>
