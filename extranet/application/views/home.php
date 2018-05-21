<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5><?php echo $this->lang->line('Ringkasan Pekerjaan'); ?></h5>
          </div>
          <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width: 37.5%; text-align: center;"><?php echo $this->lang->line('Aktifitas'); ?></th>
                            <th style="width: 12.5%; text-align: center;"><?php echo $this->lang->line('Jumlah'); ?></th>
                            <th style="width: 37.5%; text-align: center;"><?php echo $this->lang->line('Aktifitas'); ?></th>
                            <th style="width: 12.5%; text-align: center;"><?php echo $this->lang->line('Jumlah'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $this->lang->line('Undangan Pengadaan/Pengadaan'); ?></td>
                            <?php if($undangan["jumlah"] > 0){ ?>
                            <td style="text-align: center; background-color: moccasin;"><a href="<?php echo site_url('pengadaan/lists/'.$this->umum->forbidden($this->encryption->encrypt("undangan"), 'enkrip')); ?>"><?php echo $undangan["jumlah"]; ?></a></td>
                            <?php } else { ?>
                            <td style="text-align: center;"><?php echo $undangan["jumlah"]; ?></td>
                            <?php } ?>
                            <td><?php echo $this->lang->line('Negosiasi Pengadaan'); ?></td>
                            <?php if($negosiasi["jumlah"] > 0){ ?>
                            <td style="text-align: center; background-color: moccasin;"><a href="<?php echo site_url('pengadaan/lists/'.$this->umum->forbidden($this->encryption->encrypt("negosiasi"), 'enkrip')); ?>"><?php echo $negosiasi["jumlah"]; ?></a></td>
                            <?php } else { ?>
                            <td style="text-align: center;"><?php echo $negosiasi["jumlah"]; ?></td>
                            <?php } ?>
                            <tr>
                                <td><?php echo $this->lang->line('Penawaran yang Sudah Dikirim'); ?></td>
                                <?php if($penawaran_dikirim["jumlah"] > 0){ ?>
                                <td style="text-align: center; background-color: moccasin;"><a href="<?php echo site_url('pengadaan/lists/'.$this->umum->forbidden($this->encryption->encrypt("dikirim"), 'enkrip')); ?>"><?php echo $penawaran_dikirim["jumlah"]; ?></a></td>
                                <?php } else { ?>
                                <td style="text-align: center;"><?php echo $penawaran_dikirim["jumlah"]; ?></td>
                                <?php } ?>
                                <td><?php echo $this->lang->line('Award Announcement'); ?></td>
                                <?php if($award["jumlah"] > 0){ ?>
                                <td style="text-align: center; background-color: paleturquoise;"><a href="<?php echo site_url('pengadaan/lists/'.$this->umum->forbidden($this->encryption->encrypt("award"), 'enkrip')); ?>"><?php echo $award["jumlah"]; ?></a></td>
                                <?php } else { ?>
                                <td style="text-align: center;"><?php echo $award["jumlah"]; ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('Pengadaan yang Menunggu Penawaran'); ?></td>
                                <?php if($menunggu_penawaran["jumlah"] > 0){ ?>
                                <td style="text-align: center; background-color: moccasin;"><a href="<?php echo site_url('pengadaan/lists/'.$this->umum->forbidden($this->encryption->encrypt("kirimpenawaran"), 'enkrip')); ?>"><?php echo $menunggu_penawaran["jumlah"]; ?></a></td>
                                <?php } else { ?>
                                <td style="text-align: center;"><?php echo $menunggu_penawaran["jumlah"]; ?></td>
                                <?php } ?>
                                <td><?php echo $this->lang->line('Pengadaan yang Sedang Dievaluasi'); ?></td>
                                <?php if($penawaran_dievaluasi["jumlah"] > 0){ ?>
                                <td style="text-align: center; background-color: moccasin;"><a href="<?php echo site_url('pengadaan/lists/'.$this->umum->forbidden($this->encryption->encrypt("penawarandievaluasi"), 'enkrip')); ?>"><?php echo $penawaran_dievaluasi["jumlah"]; ?></a></td>
                                <?php } else { ?>
                                <td style="text-align: center;"><?php echo $penawaran_dievaluasi["jumlah"]; ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                            <td>Aanwijzing Online</td>
                                <?php if($aanwijzing_online > 0){ ?>
                                <td style="text-align: center; background-color: moccasin;"><a href="<?php echo site_url('pengadaan/lists/'.$this->umum->forbidden($this->encryption->encrypt("aanwijzingonline"), 'enkrip')); ?>"><?php echo $aanwijzing_online; ?></a></td>
                                <?php } else { ?>
                                <td style="text-align: center;"><?php echo $aanwijzing_online; ?></td>
                                <?php } ?>
                                <td>E-Auction</td>
                                <?php if($eauction > 0){ ?>
                                <td style="text-align: center; background-color: moccasin;"><a href="<?php echo site_url('pengadaan/lists/'.$this->umum->forbidden($this->encryption->encrypt("eauction"), 'enkrip')); ?>"><?php echo $eauction; ?></a></td>
                                <?php } else { ?>
                                <td style="text-align: center;"><?php echo $eauction; ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                            <td>BAST</td>
                                <?php if($bast > 0){ ?>
                                <td style="text-align: center; background-color: moccasin;"><a href="<?php echo site_url('kontrak'); ?>"><?php echo $bast; ?></a></td>
                                <?php } else { ?>
                                <td style="text-align: center;"><?php echo $bast; ?></td>
                                <?php } ?>
                                <td>Tagihan</td>
                                <?php if($tagihan > 0){ ?>
                                <td style="text-align: center; background-color: moccasin;"><a href="<?php echo site_url('kontrak'); ?>"><?php echo $tagihan; ?></a></td>
                                <?php } else { ?>
                                <td style="text-align: center;"><?php echo $tagihan; ?></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5>Catatan</h5>
          </div>
          <div class="ibox-content">
            <ul>
               <li><?php echo $this->lang->line('Kami menjamin setiap penawaran/transaksi yang anda lakukan dalam aplikasi ini terjaga kerahasiannya, di mana tidak ada pihak satupun (termasuk buyer) yang berhak menginformasikan penawaran anda sampai penawaran/lelang dibuka.'); ?></li>
               <li><?php echo $this->lang->line('Sangatlah disarankan untuk mengirimkan penawaran Anda sesegera mungkin, di mana Anda masih diberi kesempatan untuk melakukan verifikasi pada penawaran tersebut sampai saat penutupan.'); ?></li>
               <li><?php echo $this->lang->line('Aplikasi akan secara otomatis keluar (log out) bila browser Anda tidak melakukan aktivitas lebih dari 60 menit. Untuk lebih menjamin keamanannya, disarankan untuk mengganti password Anda setiap 30-60 hari.'); ?></li>
           </ul>
       </div>
   </div>
</div>
</div>