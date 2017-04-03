<div class="box">
    <div class="box-header">
        <div class="box-header with-border">
            <h3 class="box-title">판매 상세 현황</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <!--button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
            </div>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table id="example2" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>구매자</th>
                <th>책 이름</th>
                <th>구매일</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($aBookCountMetaInfo as $key=>$val) :?>
                <tr>
                    <td><?=$val->user_name?></td>
                    <td><?=$val->g_name?></td>
                    <td><?=$val->regdate?></td>
                </tr>
            <?php endforeach;?>
            </tbody>

        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<script>
    $(function () {
        $("#example2").DataTable();
    });
</script>