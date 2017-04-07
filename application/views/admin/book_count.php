<!-- DataTables -->

<div class="box">
    <div class="box-header">
        <div class="box-header with-border">

            <h3 class="box-title">판매 현황</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <!--button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
            </div>
        </div>
    </div><!-- /.box-header -->
    <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>책 이름</th>
                <th>판매수</th>
            </tr>
            </thead>
            <tbody>
<?php foreach ($aBookCountInfo as $key=>$val) :?>
            <tr>
                <td><?=$val->g_name?></td>
                <td><?=$val->CNT?></td>
            </tr>
<?php endforeach;?>
            </tbody>

        </table>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<script>
    $(function () {
        $("#example1").DataTable();
    });
</script>


