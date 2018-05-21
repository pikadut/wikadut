<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>E-Auction</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

        <?php $curval = (isset($eauction_header['JUDUL'])) ? $eauction_header['JUDUL'] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Judul E-Auction</label>
          <div class="col-sm-7">
            <input type="text" class="form-control" required name="judul_eauction_inp" value="<?php echo $curval ?>">
          </div>

        </div>

        <?php $curval = (isset($eauction_header['DESKRIPSI'])) ? $eauction_header['DESKRIPSI'] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Deskripsi E-Auction</label>
          <div class="col-sm-8">
            <textarea name="deskripsi_eauction_inp" required class="form-control"><?php echo $curval ?></textarea>
          </div>
        </div>

        <?php $curval = (isset($eauction_header['BATAS_ATAS_PERCENT'])) ? $eauction_header['BATAS_ATAS_PERCENT'] : 0; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Batas Atas</label>
          <div class="col-sm-2">
            <div class="input-group">
              <input type="text" class="form-control money" id="b_atas" name="b_atas_eauction_percent_inp" value="<?php echo $curval ?>">
              <span class="input-group-addon">%</span>
            </div>
          </div>
          <?php $curval = (isset($eauction_header['BATAS_BAWAH_PERCENT'])) ? $eauction_header['BATAS_BAWAH_PERCENT'] : 0; ?>
          <label class="col-sm-2 control-label">Batas Bawah</label>
          <div class="col-sm-2">
            <div class="input-group">
              <input type="text" class="form-control money" id="b_bawah" name="b_bawah_eauction_percent_inp" value="<?php echo $curval ?>">
              <span class="input-group-addon">%</span>
            </div>
          </div>
          <div class="col-sm-4">
           <p class="form-control-static" id="b_eauction_label"></p>
           <?php $curval = (isset($eauction_header['BATAS_ATAS'])) ? $eauction_header['BATAS_ATAS'] : 0; ?>
           <input type="hidden" name="b_atas_eauction_money_inp" id="b_atas_eauction_money_inp" value="<?php echo $curval ?>">
           <?php $curval = (isset($eauction_header['BATAS_BAWAH'])) ? $eauction_header['BATAS_BAWAH'] : 0; ?>
           <input type="hidden" name="b_bawah_eauction_money_inp" id="b_bawah_eauction_money_inp" value="<?php echo $curval ?>">
         </div>
       </div>

       <div class="form-group">
        <label class="col-sm-2 control-label">Tanggal Mulai</label>
        <div class="col-sm-3">
          <?php $curval = (isset($eauction_header['TANGGAL_MULAI'])) ? $eauction_header['TANGGAL_MULAI'] : ""; ?>
          <input type="text" class="form-control datetimepicker" required name="tgl_mulai_eauction_inp" value="<?php echo $curval ?>">
        </div>
        <label class="col-sm-2 control-label">Tanggal Selesai</label>
        <div class="col-sm-3">
          <?php $curval = (isset($eauction_header['TANGGAL_BERAKHIR'])) ? $eauction_header['TANGGAL_BERAKHIR'] : ""; ?>
          <input type="text" class="form-control datetimepicker" required name="tgl_selesai_eauction_inp" value="<?php echo $curval ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="col-sm-2 control-label">Tipe</label>
        <div class="col-sm-2">
          <?php $curval = (isset($eauction_header['TIPE'])) ? $eauction_header['TIPE'] : ""; ?>
          <select name="tipe_eauction_inp" class="form-control">
            <option <?php echo ($curval == "A") ? "selected" : "" ?> value="A">Packet</option>
            <option <?php echo ($curval == "B") ? "selected" : "" ?> value="B">Itemize</option>
          </select>
        </div>
        <label class="col-sm-2 control-label type_a">Minimum Penurunan</label>
        <div class="col-sm-2 type_a">
          <?php $curval = (isset($eauction_header['MINIMAL_PENURUNAN'])) ? $eauction_header['MINIMAL_PENURUNAN'] : 0; ?>
          <input type="text" class="form-control money" name="penurunan_eauction_inp" value="<?php echo $curval ?>">
        </div>
        <label class="col-sm-2 control-label">Ulangi E-Auction</label>
        <div class="col-sm-1">
          <div class="checkbox">
            <input type="checkbox" name="reset_inp" value="1">
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    var tipe = "<?php echo (isset($eauction_header['TIPE'])) ? $eauction_header['TIPE'] : "A"; ?>";

    if(tipe == 'A'){
      $(".type_a").show();
      $(".type_b").hide();
    } else {
      $(".type_a").hide();
      $(".type_b").show();
    }

    var hps = $("#total_alokasi_inp").val();
    $("#b_atas_eauction_money_inp").val(hps);
    $("#b_bawah_eauction_money_inp").val(hps);
    $("#b_eauction_label").html('Range : <strong>'+inttomoney(hps)+'</strong> - <strong>'+inttomoney(hps)+'</strong>');
    
    function reset_range(){
      var val = moneytoint($("#b_atas").val());
      var persen = 1+(val/100);
      var nominal_atas = persen*hps;
      $("#b_atas_eauction_money_inp").val(nominal_atas);
      val = moneytoint($("#b_bawah").val());
      persen = 1-(val/100);
      var nominal_bawah = persen*hps;
      $("#b_bawah_eauction_money_inp").val(nominal_bawah);
      $("#b_eauction_label").html('Range : <strong>'+inttomoney(nominal_bawah)+'</strong> - <strong>'+inttomoney(nominal_atas)+'</strong>');
    }
    reset_range();
    $("#b_atas,#b_bawah").change(function(){
      reset_range();
    });

    $("select[name='tipe_eauction_inp']").change(function(){

      var val = $(this).find("option:selected").val();
      if(val == "A"){
        $(".type_a").show();
        $(".type_b").hide();
      } else {
        $(".type_a").hide();
        $(".type_b").show();
      }

    });

  });

</script>

<?php if($sampai-time() > 0){ ?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<style type="text/css">
  #toast-container > .toast-info:before {
    content: "";
  }
</style>
<script type="text/javascript">

  function update_lowest(money){
    $(".lowest_bid").text(money);
  }

  function update_latest(money){
    $(".latest_bid").text(money);
  }

  setInterval(function(){

    $.ajax({
      url:"<?php echo site_url('procurement/eauction_list') ?>",
      type:"post",
      data:"tenderid=<?php echo $permintaan['ptm_number'] ?>",
      dataType:"json",
      success:function(data){
        update_latest(data.latest_bid);
        update_lowest(data.lowest_bid);
      }
    })

  },1000);

  toastr.options.closeButton = false;
  toastr.options.extendedTimeOut = 0;
  toastr.options.timeOut = 0;
  toastr.options.tapToDismiss = false;
  toastr.info('<center><h4 id="waktu"></h4>Penawaran Terendah Saat Ini : <span class="lowest_bid" style="font-weight: bold;">0</span></center>');

  var deadline = '<?php echo date("Y-m-d H:i:s",$sampai) ?>';
  
  function getTimeRemaining(endtime){
    var t = Date.parse(endtime) - Date.parse(new Date());
    var seconds = Math.floor( (t/1000) % 60 );
    var minutes = Math.floor( (t/1000/60) % 60 );
    var hours = Math.floor( (t/(1000*60*60)) % 24 );
    var days = Math.floor( t/(1000*60*60*24) );
    return {
      'total': t,
      'days': days,
      'hours': hours,
      'minutes': minutes,
      'seconds': seconds
    };
  }

  function initializeClock(id, endtime){
    var clock = document.getElementById(id);
    var timeinterval = setInterval(function(){
      var t = getTimeRemaining(endtime);
      clock.innerHTML = '<strong>' + t.days + '</strong> Hari ' +
      '<strong>'+ t.hours + '</strong> Jam ' +
      '<strong>' + t.minutes + '</strong> Menit ' +
      '<strong>' + t.seconds+ '</strong> Detik ';
      if(t.total<=0){
        clearInterval(timeinterval);
        //window.location.reload();
      }
    },1000);
  }

  function updateClock(id){
    var clock = document.getElementById(id);
    var t = getTimeRemaining(deadline);
    clock.innerHTML = 'days: ' + t.days + '<br>' +
    'hours: '+ t.hours + '<br>' +
    'minutes: ' + t.minutes + '<br>' +
    'seconds: ' + t.seconds;
    if(t.total<=0){
      clearInterval(timeinterval);
    }
  }

  initializeClock('waktu', deadline);

</script>
<?php } ?>