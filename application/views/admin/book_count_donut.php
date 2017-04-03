<div class="box box-danger">
    <div class="box-header with-border">
        <h3 class="box-title">판매 차트</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <!--button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button-->
        </div>
    </div>
    <div class="box-body chart-responsive">
        <div class="chart" id="sales-chart" style="height: 530px; position: relative;"></div>
    </div><!-- /.box-body -->
</div><!-- /.box -->

<?php
$aChartColor = array(
     "#30A9DE","#EFDC05","#E53A40","#090707","#9DC8C8","#58C9B9","#D1B6E1","#F6B352","#F68657","#E0E3DA"
    ,"#D499B9","#FBFFB9","#C5E99B","#9055A2","#FDD692","#8FBC94","#2E294E","#E71D36","#DE6449","#5CAB7D"
    ,"#2EC4B6","#791E94","#5A9367","#EFFFE9","#FFBC42","#E3E36A","#4FB0C6","#E71D36","#4F86C6","#218380"
);
$color_num = 0;
echo "<!--";
foreach($aBookCountInfo as $key=>$val)
{
    $aData[] = array("label"=>$val->g_name, "value"=>$val->CNT);
    if(count($aChartColor) < $color_num )
        $color_num = 0;

    $aColor[] = $aChartColor[$color_num];
    $color_num++;
}
$sData  = json_encode($aData);
$sColor = json_encode($aColor);
echo "-->";
?>


<!-- jQuery 2.1.4 -->
<script src="<?=IMGURL?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?=IMGURL?>/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?=IMGURL?>/plugins/morris/morris.min.js"></script>
<!-- FastClick -->
<script src="<?=IMGURL?>/plugins/fastclick/fastclick.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=IMGURL?>/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=IMGURL?>/dist/js/demo.js"></script>
<!-- page script -->
<script>
    $(function () {
        "use strict";

        //DONUT CHART
        var donut = new Morris.Donut({
            element: 'sales-chart',
            resize: true,
            colors: <?=$sColor?>,
            data: <?=$sData?> ,
            hideHover: 'auto'
        });
    });
</script>

