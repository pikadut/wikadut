<h3>A3. Detail Kinerja Komoditi : <?php echo $nama_barang ?></h3>
<table class="table table-bordered">
  <thead>
    <!-- hlmifzi -->
    <tr>
      <th width="64px">No</th>
      <th>Deskripsi Kinerja</th>
      <th>Jumlah Pengadaan</th>
      <th>Jml Sesuai</th>
      <th>Jml Tidak Sesuai</th>
      <th>Nilai</th>
      <th>Flag</th>
    </tr>
  </thead>

  <tbody>
    <?php foreach ($item as $key => $value){ ?>

    <tr <?php if(strlen($value['kode']) < 4) {?> style="color: #000; font-size: 30pt; font-weight: bold;"<?php }?>>
      <td><?php echo $value['kode'] ?></td>
      <td><?php echo $value['pertanyaan']?></td>


      <?php if(strlen($value['kode']) > 3) {?>
      <td class="text-center"><?php echo $value['jml_pengadaan']?></td>
      <td class="text-center"><?php echo $value['jml_answer_sesuai']?></td>
      <td class="text-center"><?php echo $value['jml_answer_tidak_sesuai']?></td>
      <td class="text-center"><?php echo $value['nilai']?> %</td>
      <td class="text-center">

        <?php if ($value['kode'] == 'c.2.7' && $value['nilai'] < 100) { ?>

            <img src="<?php echo base_url();?>/assets/img/flag_b.jpg"></td>

        <?php  } else if ($value['kode'] == 'c.2.9' && $value['nilai'] < 100) { ?>

            <img src="<?php echo base_url();?>/assets/img/flag_b.jpg"></td>

        <?php  } else if( $value['kode'] == 'a.1.1' && $value['jml_answer_tidak_sesuai'] >= 5){ ?>

            <img src="<?php echo base_url();?>/assets/img/flag_r.jpg"></td>

        <?php  } else if( $value['kode'] == 'c.1.1' && $value['jml_answer_tidak_sesuai'] >= 2){ ?>

            <img src="<?php echo base_url();?>/assets/img/flag_r.jpg"></td>
            
        <?php  } else if($value['kode'] == 'c.2.3' && $value['jml_answer_tidak_sesuai'] >= 2){ ?>

            <img src="<?php echo base_url();?>/assets/img/flag_r.jpg"></td>

        <?php  } else if( $value['nilai'] < 60){ ?>

           <img src="<?php echo base_url();?>/assets/img/flag_r.jpg"></td>  

        <?php } else { ?>
           <img src="<?php echo base_url();?>/assets/img/flag_g.jpg"></td>
        <?php  } ?>

        <?php } else { ?>
        <td colspan="5"></td>
        <?php } ?>

      </tr>
      <?php } ?>
    </tbody>
  </table>
