<form method="post" action="<?php echo site_url("pengadaan/view");?>"  class="form-horizontal ajaxform">
  <input type="hidden" name="ids" value="<?php echo (isset($tender['ptm_number'])) ? $tender["ptm_number"] : ""; ?>">
  <div class="row">
    <div class="col-lg-12">

      <?php if(!empty($message)){ ?>
      <div class="alert alert-danger" role="alert"><?php echo $message ?></div>
      <?php } ?>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>HEADER</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>

        <div class="ibox-content">

          <div class="row">
            <div class="col-lg-12">

              <?php $curval = (isset($tender['ptm_number'])) ?  $tender["ptm_number"] : ""; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Nomor Tender</label>
                <div class="col-sm-10">
                  <p class="form-control-static"><?php echo $curval ?></p>

                </div>
              </div>

              <?php $curval = (isset($tender['ptm_subject_of_work'])) ?  $tender["ptm_subject_of_work"] : ""; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Deskripsi Tender</label>
                <div class="col-sm-10">
                  <p class="form-control-static"><?php echo $curval ?></p>
                </div>
              </div>

              <?php $curval = (isset($tender['JUDUL'])) ?  $tender["JUDUL"] : ""; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Judul E-Auction</label>
                <div class="col-sm-10">
                  <p class="form-control-static"><?php echo $curval ?></p>
                </div>
              </div>

              <?php $curval = (isset($tender['DESKRIPSI'])) ?  $tender["DESKRIPSI"] : ""; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Deskripsi</label>
                <div class="col-sm-10">
                  <p class="form-control-static"><?php echo $curval ?></p>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Waktu</label>
                <div class="col-sm-10">
                  <p class="form-control-static">
                    <?php echo date("d/m/Y H:i:s",$dari); ?>
                    - 
                    <?php echo date("d/m/Y H:i:s",$sampai); ?>

                  </p>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label">Durasi</label>
                <div class="col-sm-10">
                  <p class="form-control-static"><?php echo $sampai-$dari ?> detik</p>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>PENAWARAN TOTAL + PPN ANDA</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>

        <div class="ibox-content">

          <?php if($sampai-time() <= 0){ ?>
          <h1 class="text-right" style="font-weight: bold;"><?php echo inttomoney($last_quo['JUMLAH_BID']) ?></h1>
          <?php } else { ?>
          <input type="text" <?php echo ($tender['TIPE'] != "A") ? "readonly" : "" ?> name="penawaran_inp" class="form-control input-lg money text-right" value="<?php echo moneytoint($last_quo['JUMLAH_BID']) ?>" style="font-size:24pt">
          <?php } ?>

        </div>
      </div>
    </div>
  </div>

  <?php if($tender['TIPE'] != "A"){ ?>

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>ITEM</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>

        <div class="ibox-content">

         <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Deskripsi</th>
              <th>Jumlah</th>
              <th>Harga Satuan (Non PPN)</th>
              <th>Pajak(%)</th>
              <th>Harga Total Penawaran</th>
              <th>Harga Total Penawaran PPN</th>
            </tr>
          </thead>

          <tbody>
           <?php 
           $total = 0;
           foreach ($item as $key => $value) { 
            $harga = (isset($history_item[$value['tit_id']])) ? $history_item[$value['tit_id']] : $value['JUMLAH_BID'];
            $subtotal = $harga*$value['tit_quantity']; 
            $total += $subtotal*1.1;
            $no = $key+1;
            ?>
            <tr data-key="<?php echo $no ?>">
              <td><?php echo $no ?></td>
              <td><p class="form-control-static"><?php echo $value['tit_code'] ?></p></td>
              <td><p class="form-control-static"><?php echo $value['tit_description'] ?></p></td>
              <td>
               <p class="form-control-static">
                 <?php echo inttomoney($value['tit_quantity']) ?> <?php echo $value['tit_unit'] ?>
               </p>
               <input type="hidden" class="jumlah_inp" name="jumlah_inp[<?php echo $value['tit_id'] ?>]" value="<?php echo $value['tit_quantity'] ?>">
             </td>
             <td>
              <?php if($sampai-time() <= 0){ ?>
          <p class="text-right form-control-static" style="font-weight: bold;">
          <?php echo inttomoney($harga) ?>
            
          </p>
          <?php } else { ?>
              <input class="form-control text-right money harga_inp" type="text" data-key="<?php echo $no ?>" name="harga_inp[<?php echo $value['tit_id'] ?>]" value="<?php echo $harga ?>">
              <?php } ?>
            </td>
            <td><p class="form-control-static text-center">10</p></td>
            <td>
              <p class="subtotal text-right form-control-static">
                <?php echo inttomoney($subtotal) ?>
              </p>
            </td>
            <td>
              <p class="subtotal_ppn text-right form-control-static">
                <?php echo inttomoney($subtotal*1.1) ?>
              </p>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>
</div>
<?php } ?>

<?php 
$link = 'pengadaan/lists/'.$this->umum->forbidden($this->encryption->encrypt("eauction"), 'enkrip');
if($sampai-time() > 0){ 
  echo buttonsubmit($link,'Back','Save');
} else {
  echo buttonback($link,'Back');
}
?>


</form>

<?php if($sampai-time() > 0){ ?>
<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script type="text/javascript" src="<?php echo base_url('assets/js/autoNumeric-min.js') ?>"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/1.5.5/numeral.min.js"></script>
<style type="text/css">
  #toast-container > .toast-info:before {
    content: "";
  }
</style>
<script type="text/javascript">

function calculate(){
    var total = 0;

  $(".harga_inp").each(function(i,v){

    var harga = moneytoint($(this).val());
    var jumlah = $(this).parent().parent().find(".jumlah_inp").val();
    total += parseInt(harga*jumlah)*1.1;

  });

  $("input[name='penawaran_inp']").val(inttomoney(total));

}

calculate();

$(".harga_inp").change(function(){

calculate();

});

  $("input.money").autoNumeric({
    aSep: '.',
    aDec: ',', 
    aSign: ''
  });

function isInt(n){
  return Number(n) === n && n % 1 === 0;
}

function isFloat(n){
  return n === Number(n) && n % 1 !== 0;
}

  function inttomoney(money){

  money = parseFloat(money);

  money = numeral(money).format('0,0.00');

  money = money.replace(".","_");

  money = money.replace(/,/g,".");

  money = money.replace("_",",");

  return money;
}

function moneytoint(money){

  if(!isInt(money)){

    money = money.replace(/\./g,"");

    money = money.replace(",",".");

    money = parseInt(money);

}

  return money;
}

function update_lowest(money){
  $(".lowest_bid").text(money);
}

function update_latest(money){
  $(".latest_bid").text(money);
}

setInterval(function(){

  $.ajax({
    url:"<?php echo site_url('pengadaan/eauction_list') ?>",
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
toastr.info('<center><h4 id="waktu"></h4>Penawaran Terendah Saat Ini : <span class="lowest_bid" style="font-weight: bold;">0</span><br/>Penawaran Terakhir Anda : <span class="latest_bid" style="font-weight: bold;">0</span></center>');

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