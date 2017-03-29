<!-- Button trigger modal -->
<div class="box-body">
  <button type="button" id="bAddPorgram" class="btn btn-info btn-block" data-toggle='modal' data-target='#myModal3'>프로그램 등록하기</button>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">프로그램등록</h4>
      </div>
      <div class="modal-body">
        <form name="fo_add">
          <input type="hidden" id="add_idx" value="">
          <div class="form-group">
            <label for="recipient-name" class="control-label">프로그램명[ 예) 16.8월, 프로그램명 ] 형식을 지켜 주세요</label>
            <input type="text" id="add_name" class="form-control">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">내용</label>
            <textarea id="add_content" class="form-control" rows="2"></textarea>           
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">일정</label>
            <input type="text" id="add_schedule" class="form-control">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">대상</label>
            <textarea id="add_target" class="form-control" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">장소</label>
            <input type="text" id="add_location" class="form-control">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">준비물</label>
            <input type="text" id="add_need" class="form-control">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">후원</label>
            <input type="text" id="add_sponsor" class="form-control">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">참가비</label>
            <input type="text" id="add_recurit" class="form-control">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">소개(긴글) [줄바꿈은 | 를 입력해 주세요]</label>
            <textarea id="add_content_long" class="form-control" rows="3"></textarea>           
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">대상(긴글) [줄바꿈은 | 를 입력해 주세요]</label>
            <textarea id="add_target_long" class="form-control" rows="3"></textarea>           
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">학습안내(긴글) [줄바꿈은 | 를 입력해 주세요]</label>
            <textarea id="add_guide_long" class="form-control" rows="3"></textarea>           
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">프로그램구룹</label>
            <div class="radio">
              <label>
                <input type="radio" name="add_pgroup" id="add_pgroup1" value="JUN">
                주니어시리즈 
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="add_pgroup" id="add_pgroup2" value="APP">
                앱인벤터시리즈 
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="add_pgroup" id="add_pgroup3" value="IOT">
                IOT시리즈 
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">프로그램활성화</label>
            <div class="radio">
              <label>
                <input type="radio" name="add_active" id="add_active1" value="ACT">
                활성화 
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="add_active" id="add_active2" value="HID">
                숨김( 홈페이지 ) 
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">시작일</label>
            <input type="text" id="add_sdate" class="form-control" placeholder="2016-10-10 12:34:56">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">종료일</label>
            <input type="text" id="add_edate" class="form-control" placeholder="2016-10-10 12:34:56">
          </div>
        </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="bSetCourseInfo" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


    <div class="box">
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>프로그램번호</th>
            <th>프로그램명</th>
            <th>구룹</th>
            <th>활성화</th>
            <th>시작일자</th>
            <th>종료일자</th>
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
                echo "  <td>".$val->pgroup."</td>"; 
                echo "  <td>".$val->active."</td>"; 
                echo "  <td>".$val->sdate."</td>"; 
                echo "  <td>".$val->edate."</td>"; 
                echo "  <td><button id='showsangse' onclick='javascript:showSangse(".$val->course_idx.")' class='btn btn-primary btn-xs' data-toggle='modal' data-target='#myModal' >상세보기</button>";
                echo "  <button id='modifysangse' onclick='javascript:modifySangse(".$val->course_idx.")' class='btn btn-success btn-xs' data-toggle='modal' data-target='#myModal2'>정보수정</button>";
                echo "  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button id='bChangeState' onclick='javascript:changeState(".$val->course_idx.")' class='btn btn-danger btn-xs'>삭제</button></td>";
                echo "</tr>";
              }
            }
?>
          </tbody> 
        </table>  
      </div> 
    </div>


<!-- Modal sangse view-->
<div class="modal fade modal-primary" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><div id="course_name"></div></h4>
      </div>
      <div class="modal-body">
        <div class="box-body">
          <dl class="dl-horizontal">
            <dt>내용</dt>
            <dd><div id="course_content"</div></dd>
            <dt>일정</dt>
            <dd><div id="course_schedule"></div></dd>
            <dt>대상</dt>
            <dd><div id="course_target"</div></dd>
            <dt>장소</dt>
            <dd><div id="course_location"</div></dd>
            <dt>준비물</dt>
            <dd><div id="course_need"></div></dd>
            <dt>후원</dt>
            <dd><div id="course_sponsor"></div></dd>
            <dt>참가비</dt>
            <dd><div id="course_recurit"></div></dd>
            <dt>소개(긴글)</dt>
            <dd><div id="course_content_long"></div></dd>
            <dt>대상(긴글)</dt>
            <dd><div id="course_target_long"></div></dd>
            <dt>학습안내(긴글)</dt>
            <dd><div id="course_guide_long"></div></dd>
            <dt>프로그램구룹</dt>
            <dd><div id="course_pgroup"></div></dd>
            <dt>프로그램활성화</dt>
            <dd><div id="course_active"></div></dd>
            <dt>시작일</dt>
            <dd><div id="course_sdate"></div></dd>
            <dt>종료일</dt>
            <dd><div id="course_edate"></div></dd>
          </dl>
        </div>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal modify view-->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><div id="course_name"></div></h4>
      </div>
      <div class="modal-body">
        <div class="box-body">
          <form name="fo_modify">
          <input type="hidden" id="modify_idx" value="">
          <div class="form-group">
            <label for="recipient-name" class="control-label">프로그램명[ 예) 16.8월, 프로그램명 ] 형식을 지켜 주세요</label>
            <input type="text" id="modify_name" class="form-control">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">내용</label>
            <textarea id="modify_content" class="form-control" rows="2"></textarea>           
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">일정</label>
            <input type="text" id="modify_schedule" class="form-control">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">대상</label>
            <textarea id="modify_target" class="form-control" rows="2"></textarea>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">장소</label>
            <input type="text" id="modify_location" class="form-control">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">준비물</label>
            <input type="text" id="modify_need" class="form-control">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">후원</label>
            <input type="text" id="modify_sponsor" class="form-control">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">참가비</label>
            <input type="text" id="modify_recurit" class="form-control">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">소개(긴글) [줄바꿈은 | 를 입력해 주세요]</label>
            <textarea id="modify_content_long" class="form-control" rows="3"></textarea>           
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">대상(긴글) [줄바꿈은 | 를 입력해 주세요]</label>
            <textarea id="modify_target_long" class="form-control" rows="3"></textarea>           
          </div>
          <div class="form-group">
            <label for="recipient-name" class="control-label">학습안내(긴글) [줄바꿈은 | 를 입력해 주세요]</label>
            <textarea id="modify_guide_long" class="form-control" rows="3"></textarea>           
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">프로그램구룹</label>
            <div class="radio">
              <label>
                <input type="radio" name="modify_pgroup" id="modify_pgroup1" value="JUN">
                주니어시리즈 
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="modify_pgroup" id="modify_pgroup2" value="APP">
                앱인벤터시리즈 
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="modify_pgroup" id="modify_pgroup3" value="IOT">
                IOT시리즈 
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">프로그램활성화</label>
            <div class="radio">
              <label>
                <input type="radio" name="modify_active" id="modify_active1" value="ACT">
                활성화 
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="modify_active" id="modify_active2" value="HID">
                숨김( 홈페이지 ) 
              </label>
            </div>
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">시작일</label>
            <input type="text" id="modify_sdate" class="form-control">
          </div>
          <div class="form-group">
            <label for="message-text" class="control-label">종료일</label>
            <input type="text" id="modify_edate" class="form-control">
          </div>
        </form> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="bUpdateCourseInfo" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


  <script>   
  $(function(){
    $("#example1").DataTable();
     
    $('#bSetCourseInfo').click(function(){
      $.post(
        "<?=HOSTURL?>/Admin/rpcInsertCourseInfo"
        ,{
          "idx" : $("#add_idx").val() 
          ,"content" : $("#add_content").val() 
          ,"name" : $("#add_name").val() 
          ,"target" : $("#add_target").val() 
          ,"schedule" : $("#add_schedule").val() 
          ,"need" : $("#add_need").val() 
          ,"recruit" : $("#add_recurit").val() 
          ,"location" : $("#add_location").val() 
          ,"sponsor" : $("#add_sponsor").val() 
          ,"content_long" : $("#add_content_long").val() 
          ,"target_long" : $("#add_target_long").val() 
          ,"guide_long" : $("#add_guide_long").val() 
          ,"pgroup" : $(":input:radio[name='add_pgroup']:checked").val()  
          ,"active" : $(":input:radio[name='add_active']:checked").val()  
          ,"sdate" : $("#add_sdate").val() 
          ,"edate" : $("#add_edate").val() 
        }
        ,function(data, status) {
          if (status == "success" && data.code == 1)
          {
            alert('등록되었습니다');
            location.reload();
          }
          else
          {
            alert('오류가 발생하였습니다');
          }
        }
      ); 
    }); 
    
    $('#bUpdateCourseInfo').click(function(){
      $.post(
        "<?=HOSTURL?>/Admin/rpcUpdateCourseInfo"
        ,{
          "idx" : $("#modify_idx").val() 
          ,"content" : $("#modify_content").val() 
          ,"name" : $("#modify_name").val() 
          ,"target" : $("#modify_target").val() 
          ,"schedule" : $("#modify_schedule").val() 
          ,"need" : $("#modify_need").val() 
          ,"recruit" : $("#modify_recurit").val() 
          ,"location" : $("#modify_location").val() 
          ,"sponsor" : $("#modify_sponsor").val() 
          ,"content_long" : $("#modify_content_long").val() 
          ,"target_long" : $("#modify_target_long").val() 
          ,"guide_long" : $("#modify_guide_long").val() 
          ,"pgroup" : $(":input:radio[name='modify_pgroup']:checked").val()  
          ,"active" : $("input:radio[name='modify_active']:checked").val() 
          ,"sdate" : $("#modify_sdate").val() 
          ,"edate" : $("#modify_edate").val() 
        }
        ,function(data, status) {
          if (status == "success" && data.code == 1)
          {
            alert('수정되었습니다');
            location.reload();
          }
          else
          {
            alert('오류가 발생하였습니다');
          }
        }
      );      
    });
    
  });
  function modifySangse(course_idx)
  {
    $.post(
      "<?=HOSTURL?>/Admin/rpcGetCourseInfo"
      ,{
        "idx" : course_idx 
       }
      ,function(data, status) {
        if (status == "success" && data.code == 1)
        {

          //$("input:checkbox[id='modify_pgroup1']").prop("checked", true);
          if(data.pgroup == 'JUN') 
            document.getElementById("modify_pgroup1").checked = true;
          if(data.pgroup == 'APP')
            document.getElementById("modify_pgroup2").checked = true;
          if(data.pgroup == 'IOT')
            document.getElementById("modify_pgroup3").checked = true;
  
          if(data.active == 'ACT')
            document.getElementById("modify_active1").checked = true;
          else
            document.getElementById("modify_active2").checked = true;

          $("#modify_idx").val(data.idx); 
          $("#modify_content").val(data.content); 
          $("#modify_name").val(data.name); 
          $("#modify_target").val(data.target); 
          $("#modify_schedule").val(data.schedule); 
          $("#modify_need").val(data.need); 
          $("#modify_recurit").val(data.recruit); 
          $("#modify_location").val(data.location); 
          $("#modify_sponsor").val(data.sponsor); 
          $("#modify_content_long").val(data.content_long); 
          $("#modify_target_long").val(data.target_long); 
          $("#modify_guide_long").val(data.guide_long); 
          $("#modify_pgroup").val(data.pgroup); 
          $("#modify_active").val(data.active); 
          $("#modify_sdate").val(data.sdate); 
          $("#modify_edate").val(data.edate); 
        }
      }
    );
  }
  function showSangse(course_idx)
  {
    $.post(
      "<?=HOSTURL?>/Admin/rpcGetCourseInfo"
      ,{
        "idx" : course_idx 
       }
      ,function(data, status) {
        if (status == "success" && data.code == 1)
        {
          document.getElementById('course_name').innerHTML = data.name; 
          document.getElementById('course_content').innerHTML = data.content; 
          document.getElementById('course_target').innerHTML = data.target; 
          document.getElementById('course_schedule').innerHTML = data.schedule; 
          document.getElementById('course_need').innerHTML = data.need; 
          document.getElementById('course_recurit').innerHTML = data.recruit; 
          document.getElementById('course_location').innerHTML = data.location; 
          document.getElementById('course_sponsor').innerHTML = data.sponsor; 
          document.getElementById('course_content_long').innerHTML = data.content_long; 
          document.getElementById('course_target_long').innerHTML = data.target_long; 
          document.getElementById('course_guide_long').innerHTML = data.guide_long; 
          document.getElementById('course_pgroup').innerHTML = data.pgroup; 
          document.getElementById('course_active').innerHTML = data.active; 
          document.getElementById('course_sdate').innerHTML = data.sdateF; 
          document.getElementById('course_edate').innerHTML = data.edateF; 
        }
      }
    );
  }
  function changeState(course_idx)
  {
    alert('준비중입니다');
        
  }     
  </script>
