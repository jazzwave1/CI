<?php
if(!$sSearchDate)
{
    $today = time();
    $end_day = date("t", $today);

    $sSearchDate = date("m")."/01/".date("Y")." - ".date("m/").$end_day."/".date("Y");
}

?>

<div class="col-md-12">
    <div class="box box-primary">
        <div class="box-body">
            <!-- Date range -->
            <div class="form-group">
                <label>검색 기간 설정 </label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="reservation" value="<?=$sSearchDate?>">
                </div><!-- /.input group -->

            </div><!-- /.form group -->
            <div class="col-md-12">
                <button class="btn btn-block btn-primary" id="bSearch">검색</button>
            </div><!-- /.row -->
        </div><!-- /.box -->
    </div><!-- /.row -->
<div class="col-md-12">


<?php
if(count($aBookCountInfo) >= 1)
{
    echo '<div class="col-md-6">';
    $this->load->view('admin/book_count_donut.php', array('aBookCountInfo' => $aBookCountInfo));
    echo '</div>';

    echo '<div class="col-md-6">';
    $this->load->view('admin/book_count.php', array('aBookCountInfo' => $aBookCountInfo));
    echo '</div>';

}

echo '<div class="col-md-6"></div>';

if(count($aBookCountMetaInfo) >= 1)
{
    echo '<div class="col-md-6">';
    $this->load->view('admin/book_meta.php',array('aBookCountMetaInfo'=>$aBookCountMetaInfo));
    echo '</div>';
}
echo '</div>';

?>
</div><!-- /.row -->
<script>
    $(function () {
        //Date range picker
        $('#reservation').daterangepicker();

        // bSearch click
        $('#bSearch').click(function() {
            var sSearchDate = $('#reservation').val().replace(/ /g, '') ;
            sSearchDate = sSearchDate.replace(/\//g, '');
            var aDate = sSearchDate.split('-');

            window.location.replace("<?=HOSTURL?>/admin/eBookDashboard/"+ aDate[0] + "/" + aDate[1]);
        });
    });
</script>


