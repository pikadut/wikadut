<div class="wrapper wrapper-content animated fadeIn">
  <div class="row m-t-lg">
    <div class="col-lg-12">

      <?php if(empty($header)){ ?> 

      <center><h1>Info KPI Vendor</h1></center>

      <?php } else { ?>

      <div class="tabs-container">

        <div class="tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1">Data Utama</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2">Data Legal</a></li>
            <li class=""><a data-toggle="tab" href="#tab-3">Pengurus Perusahaan</a></li>
            <li class=""><a data-toggle="tab" href="#tab-4">Data Keuangan</a></li>
            <li class=""><a data-toggle="tab" href="#tab-5">Barang/Jasa</a></li>
            <li class=""><a data-toggle="tab" href="#tab-6">SDM</a></li>
            <li class=""><a data-toggle="tab" href="#tab-7">Sertifikasi</a></li>
            <li class=""><a data-toggle="tab" href="#tab-8">Fasilitas/Peralatan</a></li>
            <li class=""><a data-toggle="tab" href="#tab-9">Pengalaman Proyek</a></li>
            <li class=""><a data-toggle="tab" href="#tab-10">Data Tambahan</a></li>
            <li class=""><a data-toggle="tab" href="#tab-11">Checklist Dokumen</a></li>
            <li class=""><a data-toggle="tab" href="#tab-11">Dokumen Pendukung</a></li>
            <li class=""><a data-toggle="tab" href="#tab-11">Daftar Komentar</a></li>
          </ul>
          
          <div class="tab-content ">
            <div id="tab-1" class="tab-pane active">
              <div class="panel-body">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    Nama Perusahaan
                  </div>
                  <div style="padding: 15px;">
                    <table class="table">

                      <tr>
                        <th>Prefiks</th>
                        <td><?php echo $header['prefix']; ?></td>
                      </tr>
                      <tr>
                        <th>Prefiks Lainnya</th>
                        <td><?php echo $header['prefix_other']; ?></td>
                      </tr>
                      <tr>
                        <th>Nama Perusahaan</th>
                        <td><?php echo $header['vendor_name']; ?></td>
                      </tr>
                      <tr>
                        <th>Sufiks</th>
                        <td><?php echo $header['suffix']; ?></td>
                      </tr>
                      <tr>
                        <th>Sufiks Lainnya</th>
                        <td><?php echo $header['suffix_other']; ?></td>
                      </tr>
                      <tr>
                        <th>Tipe Perusahaan</th>
                        <td>
                          <ol>
                            <?php foreach($tipe as $row) { 
                              echo "<li>".$row['company_type']."</li>"?>
                              <?php } ?>
                            </ol>
                          </td>
                        </tr>
                        <tr>
                          <th>Email Registrasi</th>
                          <td><?php echo $header['email_address']; ?></td>
                        </tr>
                      </table>
                    </div>
                  </div>

                  <div class="panel panel-primary">
                    <div class="panel-heading">
                      Kontak Perusahaan
                    </div>
                    <div style="padding: 15px;">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Jenis</th>
                              <th>Alamat</th>
                              <th>Kota</th>
                              <th>Negara</th>
                              <th>Telp Kantor-1</th>
                              <th>Telp Kantor-2</th>
                              <th>Fax</th>
                              <th>Website</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php 
                            $i = 1;
                            foreach($alamat as $row) { ?>
                            <tr>
                              <td><?php echo $i ?></td>
                              <td><?php echo $row["type"] ?></td>
                              <td><?php echo $row["address"] ?></td>
                              <td><?php echo $row["city"] ?></td>
                              <td><?php echo $row["country"] ?></td>
                              <td><?php echo $row["telephone1_no"] ?></td>
                              <td><?php echo $row["telephone2_no"] ?></td>
                              <td><?php echo $row["fax"] ?></td>
                              <td><?php echo $row["website"] ?></td>
                            </tr>
                            <?php
                            $i++;
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    Kontak Person
                  </div>
                  <div style="padding: 15px;">
                    <table class="table">

                      <tr>
                        <th>Nama</th>
                        <td><?php echo $header['contact_name']; ?></td>
                      </tr>
                      <tr>
                        <th>Jabatan</th>
                        <td><?php echo $header['contact_pos']; ?></td>
                      </tr>
                      <tr>
                        <th>Nomor Telepon</th>
                        <td><?php echo $header['contact_phone_no']; ?></td>
                      </tr>
                      <tr>
                        <th>Alamat Email</th>
                        <td><?php echo $header['contact_email']; ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                
              </div>
              
            </div>
            <div id="tab-2" class="tab-pane">
              <div class="panel-body">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    Akta Pendirian
                  </div>
                  <div style="padding: 15px;">
                    <div class="table-responsive">
                      <table class="table table-striped table-bordered table-hover dataTables-example" >
                        <thead>
                          <tr>
                            <th>No Akta</th>
                            <th>Jenis Akta</th>
                            <th>Tanggal Pembuatan</th>
                            <th>Notaris</th>
                            <th>Alamat</th>
                            <th>Pengesahan Kehakiman</th>
                            <th>Berita Negara</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $i = 1;
                          foreach($akta as $row) { ?>
                          <tr>
                            <td><?php echo $row["akta_no"] ?></td>
                            <td><?php echo $row["akta_type"] ?></td>
                            <td><?php echo date(DEFAULT_FORMAT_DATETIME,time($row["date_creation"]['time'])); ?></td>
                            <td><?php echo $row["notaris_name"] ?></td>
                            <td><?php echo $row["notaris_address"] ?></td>
                            <td><?php echo date(DEFAULT_FORMAT_DATETIME,time($row["pengesahan_hakim"]['time'])); ?></td>
                            <td><?php echo date(DEFAULT_FORMAT_DATETIME,time($row["berita_acara_ngr"]['time'])); ?></td>
                          </tr>
                          <?php
                          $i++;
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="panel panel-primary">
                <div class="panel-heading">
                  Domisili Perusahaan
                </div>
                <div style="padding: 15px;">
                 <table class="table">

                  <tr>
                    <th>Nomor Domisili</th>
                    <td><?php echo $header['address_domisili_no']; ?></td>
                  </tr>
                  <tr>
                    <th>Tanggal Domisili</th>
                    <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($header['address_domisili_date']['time'])); ?></td>
                  </tr>
                  <tr>
                    <th>Kadaluarsa</th>
                    <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($header['address_domisili_exp_date']['time'])) ?></td>
                  </tr>
                  <tr>
                    <th>Alamat Perusahaan</th>
                    <td><?php echo $header['address_street']; ?></td>
                  </tr>
                  <tr>
                    <th>Kota</th>
                    <td><?php echo $header['address_city']; ?></td>
                  </tr>
                  <tr>
                    <th>Provinsi</th>
                    <td><?php echo $header['addres_prop']; ?></td>
                  </tr>
                  <tr>
                    <th>Kode Pos</th>
                    <td><?php echo $header['address_postcode']; ?></td>
                  </tr>
                  <tr>
                    <th>Negara</th>
                    <td><?php echo $header['address_country']; ?></td>
                  </tr>
                  <tr>
                    <th>Nomor Telepon</th>
                    <td><?php echo $header['address_phone_no']; ?></td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="panel panel-primary">
              <div class="panel-heading">
                Nilai Pokok Wajib Pajak (NPWP)
              </div>
              <div style="padding: 15px;">
                <table class="table">

                  <tr>
                    <th>Nomor</th>
                    <td><?php echo $header['npwp_no']; ?></td>
                  </tr>
                  <tr>
                    <th>Alamat (Sesuai NPWP)</th>
                    <td><?php echo $header['npwp_address']; ?></td>
                  </tr>
                  <tr>
                    <th>Kota</th>
                    <td><?php echo $header['npwp_city']; ?></td>
                  </tr>
                  <tr>
                    <th>Provinsi</th>
                    <td><?php echo $header['npwp_prop']; ?></td>
                  </tr>
                  <tr>
                    <th>Kode Pos</th>
                    <td><?php echo $header['npwp_postcode']; ?></td>
                  </tr>
                  <tr>
                    <th>PKP</th>
                    <td><?php echo $header['npwp_pkp']; ?></td>
                  </tr>
                  <tr>
                    <th>Nomor PKP</th>
                    <td><?php echo $header['npwp_pkp_no']; ?></td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="panel panel-primary">
              <div class="panel-heading">
                Jenis Mitra Kerja
              </div>
              <div style="padding: 15px;">
                <table class="table">

                  <tr>
                    <th>Mitra Kerja</th>
                    <td><?php echo $header['vendor_type']; ?></td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="panel panel-primary">
              <div class="panel-heading">
                Surat Izin Usaha Perusahaan (SIUP)
              </div>
              <div style="padding: 15px;">
                <table class="table">

                  <tr>
                    <th>Dikeluarkan Oleh</th>
                    <td><?php echo $header['siup_issued_by']; ?></td>
                  </tr>
                  <tr>
                    <th>Nomor</th>
                    <td><?php echo $header['siup_no']; ?></td>
                  </tr>
                  <tr>
                    <th>Jenis SIUP</th>
                    <td><?php echo $header['siup_type']; ?></td>
                  </tr>
                  <tr>
                    <th>Berlaku Mulai</th>
                    <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($header['siup_from']['time']))?></td>
                  </tr>
                  <tr>
                    <th>Berlaku Sampai</th>
                    <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($header['siup_to']['time']))?></td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="panel panel-primary">
              <div class="panel-heading">
                Izin Lain Lain
              </div>
              <div style="padding: 15px;">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Jenis Izin</th>
                        <th>Dikeluarkan Oleh</th>
                        <th>Nomor</th>
                        <th>Berlaku Mulai</th>
                        <th>Sampai</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                      $i = 1;
                      foreach($izin_lain as $row) { ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row["type"] ?></td>
                        <td><?php echo $row["issued_by"] ?></td>
                        <td><?php echo $row["no"] ?></td>
                        <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($row["start_date"]['time']))?></td>
                        <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($row["end_date"]['time']))?></td>
                      </tr>
                      <?php
                      $i++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="panel panel-primary">
            <div class="panel-heading">
              Tanda Daftar Perusahaan (TDP)
            </div>
            <div style="padding: 15px;">
              <table class="table">

                <tr>
                  <th>Dikeluarkan Oleh</th>
                  <td><?php echo $header['tdp_issued_by']; ?></td>
                </tr>
                <tr>
                  <th>Nomor</th>
                  <td><?php echo $header['tdp_no']; ?></td>
                </tr>
                <tr>
                  <th>Berlaku Mulai</th>
                  <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($header['tdp_from']['time']))?></td>
                </tr>
                <tr>
                  <th>Berlaku Sampai</th>
                  <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($header['tdp_to']['time']))?></td>
                </tr>
              </table>
            </div>
          </div>

          <div class="panel panel-primary">
            <div class="panel-heading">
              Surat Keagenan/Distributorship
            </div>
            <div style="padding: 15px;">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example" >
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Dikeluarkan Oleh</th>
                      <th>Nomor</th>
                      <th>Berlaku Mulai</th>
                      <th>Sampai</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $i = 1;
                    foreach($agent_importir as $row) { if($row["type"] == "AGENT") {?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $row["issued_by"] ?></td>
                      <td><?php echo $row["no"] ?></td>
                      <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($row["created_date"]['time']))?></td>
                      <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($row["expired_date"]['time']))?></td>
                    </tr>
                    <?php
                    $i++;
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>


      <div class="panel panel-primary">
        <div class="panel-heading">
          Angka Pengenal Importir
        </div>
        <div style="padding: 15px;">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example" >
              <thead>
                <tr>
                  <th>No</th>
                  <th>Dikeluarkan Oleh</th>
                  <th>Nomor</th>
                  <th>Berlaku Mulai</th>
                  <th>Sampai</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $i = 1;
                foreach($agent_importir as $row) { if($row["type"] == "IMPORTIR") {?>
                <tr>
                  <td><?php echo $i; ?></td>
                  <td><?php echo $row["issued_by"] ?></td>
                  <td><?php echo $row["no"] ?></td>
                  <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($row["created_date"]['time']))?></td>
                  <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($row["expired_date"]['time']))?></td>
                </tr>
                <?php
                $i++;
              }
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>
</div>
<div id="tab-3" class="tab-pane">
  <div class="panel-body">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Dewan Komisaris
      </div>
      <div style="padding: 15px;">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>KTP</th>
                <th>NPWP</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach($board as $row) {  if($row["type"] == "BOC") {?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row["name"] ?></td>
                <td><?php echo $row["pos"]; ?></td>
                <td><?php echo $row["telephone_no"] ?></td>
                <td><?php echo $row["email_address"] ?></td>
                <td><?php echo $row["ktp_no"] ?></td>
                <td><?php echo $row["npwp_no"] ?></td>
              </tr>
              <?php
              $i++;
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    Dewan Direksi
  </div>
  <div style="padding: 15px;">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Telepon</th>
            <th>Email</th>
            <th>KTP</th>
            <th>NPWP</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach($board as $row) {  if($row["type"] == "BOD") {?>
          <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row["name"] ?></td>
            <td><?php echo $row["pos"]; ?></td>
            <td><?php echo $row["telephone_no"] ?></td>
            <td><?php echo $row["email_address"] ?></td>
            <td><?php echo $row["ktp_no"] ?></td>
            <td><?php echo $row["npwp_no"] ?></td>
          </tr>
          <?php
          $i++;
        }
      }
      ?>
    </tbody>
  </table>
</div>
</div>
</div>
</div>
</div>
<div id="tab-4" class="tab-pane">
  <div class="panel-body">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Rekening Bank
      </div>
      <div style="padding: 15px;">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>No.Rekening</th>
                <th>Pemegang Rekening</th>
                <th>Nama Bank</th>
                <th>Cabang Bank</th>
                <th>Alamat</th>
                <th>Valuta</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach($bank as $row) { ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row["account_no"] ?></td>
                <td><?php echo $row["account_name"]; ?></td>
                <td><?php echo $row["bank_name"] ?></td>
                <td><?php echo $row["bank_branch"] ?></td>
                <td><?php echo $row["address"] ?></td>
                <td><?php echo $row["currency"] ?></td>
              </tr>
              <?php
              $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading">
      Modal Sesuai Data Terakhir
    </div>
    <div style="padding: 15px;">
      <table class="table">

        <tr>
          <th>Modal Dasar</th>
          <td><?php echo ($header['fin_akta_mdl_dsr_curr']); ?><?php echo inttomoney($header['fin_akta_mdl_dsr']); ?></td>
        </tr>
        <tr>
          <th>Modal Setor</th>
          <td><?php echo ($header['fin_akta_mdl_str_curr']); ?><?php echo inttomoney($header['fin_akta_mdl_str']);?></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="panel panel-primary">
    <div class="panel-heading">
      Informasi Laporan Keuangan
    </div>
    <div style="padding: 15px;">
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example" >
          <thead>
            <tr>
              <th>No</th>
              <th>Tahun Laporan</th>
              <th>Jenis Laporan</th>
              <th>Total Nilai Aset</th>
              <th>Hutang Perusahaan</th>
              <th>Pendapatan Kotor</th>
              <th>Laba Bersih</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $i = 1;
            foreach($financial as $row) { ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo $row["fin_rpt_year"]; ?></td>
              <td><?php echo $row["fin_rpt_type"]; ?></td>
              <td><?php echo ($row["fin_rpt_currency"]); ?><?php echo inttomoney($row["fin_rpt_asset_value"]); ?></td>
              <td><?php echo ($row["fin_rpt_currency"]); ?><?php echo inttomoney($row["fin_rpt_hutang"]); ?></td>
              <td><?php echo ($row["fin_rpt_currency"]); ?><?php echo inttomoney($row["fin_rpt_revenue"]); ?></td>
              <td><?php echo ($row["fin_rpt_currency"]); ?><?php echo inttomoney($row["fin_rpt_netincome"]); ?></td>
            </tr>
            <?php
            $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    Klasifikasi Perusahaan
  </div>
  <div style="padding: 15px;">
    <table class="table">

      <tr>
        <th>Klasifikasi Perusahaan</th>
        <td><?php if($header['fin_class'] == "3") { echo "BESAR"; } else if($header['fin_class'] == "2"){ echo "MENENGAH"; } else if($header['fin_class'] == "1"){ echo "KECIL"; } ?></td>
      </tr>
    </table>
  </div>
</div>
</div>
</div>
<div id="tab-5" class="tab-pane">
  <div class="panel-body">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Barang yang Bisa Dipasok
      </div>
      <div style="padding: 15px;">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis Komoditas</th>
                <th>Nama Barang</th>
                <th>Merk</th>
                <th>Sumber</th>
                <th>Tipe</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach($barang as $row) { if($row["type"] == "M") { ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row["product_description"]; ?></td>
                <td><?php echo $row["product_name"] ?></td>
                <td><?php echo $row["brand"] ?></td>
                <td><?php echo $row["source"] ?></td>
                <td><?php echo $row["type"] ?></td>
              </tr>
              <?php
              $i++;
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    Jasa yang Bisa Dipasok
  </div>
  <div style="padding: 15px;">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
          <tr>
            <th>No</th>
            <th>Jenis Komoditas</th>
            <th>Nama Barang</th>
            <th>Merk</th>
            <th>Sumber</th>
            <th>Tipe</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach($barang as $row) { if($row["type"] == "S") { ?>
          <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row["product_description"]; ?></td>
            <td><?php echo $row["product_name"] ?></td>
            <td><?php echo $row["brand"] ?></td>
            <td><?php echo $row["source"] ?></td>
            <td><?php echo $row["type"] ?></td>
          </tr>
          <?php
          $i++;
        }
      }
      ?>
    </tbody>
  </table>
</div>
</div>
</div>
</div>
</div>
<div id="tab-6" class="tab-pane">
  <div class="panel-body">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Tenaga Ahli Utama
      </div>
      <div style="padding: 15px;">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Pendidikan Terakhir</th>
                <th>Pengalaman</th>
                <th>Status</th>
                <th>Kewarganegaraan</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach($sdm as $row) { if($row["type"] == "PRIMER") { ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["last_education"] ?></td>
                <td><?php echo $row["year_exp"] ?></td>
                <td><?php echo $row["emp_status"] ?></td>
                <td><?php echo $row["emp_type"] ?></td>
              </tr>
              <?php
              $i++;
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    Tenaga Ahli Pendukung
  </div>
  <div style="padding: 15px;">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Pendidikan Terakhir</th>
            <th>Pengalaman</th>
            <th>Status</th>
            <th>Kewarganegaraan</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach($sdm as $row) { if($row["type"] == "SUPPORT") { ?>
          <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["last_education"] ?></td>
            <td><?php echo $row["year_exp"] ?></td>
            <td><?php echo $row["emp_status"] ?></td>
            <td><?php echo $row["emp_type"] ?></td>
          </tr>
          <?php
          $i++;
        }
      }
      ?>
    </tbody>
  </table>
</div>
</div>
</div>
</div>
</div>
<div id="tab-7" class="tab-pane">
  <div class="panel-body">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Keterangan Sertifikasi
      </div>
      <div style="padding: 15px;">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Nama Sertifikat</th>
                <th>Nomor Sertifikat</th>
                <th>Dikeluarkan Oleh</th>
                <th>Berlaku Mulai</th>
                <th>Berlaku Sampai</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach($sertifikasi as $row) { ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row["type"]; ?></td>
                <td><?php echo $row["cert_name"] ?></td>
                <td><?php echo $row["cert_no"] ?></td>
                <td><?php echo $row["issued_by"] ?></td>
                <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($row["valid_from"]['time'])) ?></td>
                <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($row["valid_to"]['time'])) ?></td>
              </tr>
              <?php
              $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
<div id="tab-8" class="tab-pane">
  <div class="panel-body">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Keterangan Fasilitas/Peralatan
      </div>
      <div style="padding: 15px;">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Nama Peralatan</th>
                <th>Spesifikasi</th>
                <th>Kuantitas</th>
                <th>Tahun Pembuatan</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach($fasilitas as $row) { ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row["category"]; ?></td>
                <td><?php echo $row["equip_name"] ?></td>
                <td><?php echo $row["spec"] ?></td>
                <td><?php echo $row["year_made"] ?></td>
                <td><?php echo $row["quantity"] ?></td>
              </tr>
              <?php
              $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
<div id="tab-9" class="tab-pane">
  <div class="panel-body">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Pekerjaan
      </div>
      <div style="padding: 15px;">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Nama Proyek</th>
                <th>Keterangan Proyek</th>
                <th>Nilai</th>
                <th>No Kontrak</th>
                <th>Tanggal Dimulai</th>
                <th>Tanggal Selesai</th>
                <th>Contact Person</th>
                <th>No Kontak</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach($pengalaman as $row) { ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row["client_name"]; ?></td>
                <td><?php echo $row["project_name"] ?></td>
                <td><?php echo $row["description"] ?></td>
                <td><?php echo ($row["currency"]) ?><?php echo inttomoney($row["amount"]); ?></td>
                <td><?php echo $row["contract_no"] ?></td>
                <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($row["start_date"]['time'])) ?></td>
                <td><?php echo date(DEFAULT_FORMAT_DATETIME,strtotime($row["end_date"]['time'])) ?></td>
                <td><?php echo $row["contact_person"] ?></td>
                <td><?php echo $row["contact_no"] ?></td>
              </tr>
              <?php
              $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</div>
<div id="tab-10" class="tab-pane">
  <div class="panel-body">
    <div class="panel panel-primary">
      <div class="panel-heading">
        Prinsipal
      </div>
      <div style="padding: 15px;">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Negara</th>
                <th>Kode Pos</th>
                <th>Kualifikasi</th>
                <th>Hubungan</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach($tambahan as $row) { if($row["type"] == "PRINCIPAL") { ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["address"] ?></td>
                <td><?php echo $row["city"] ?></td>
                <td><?php echo $row["country"] ?></td>
                <td><?php echo $row["post_code"] ?></td>
                <td><?php echo $row["qualification"] ?></td>
                <td><?php echo $row["relationship"] ?></td>
              </tr>
              <?php
              $i++;
            }
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    Afiliasi
  </div>
  <div style="padding: 15px;">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Negara</th>
            <th>Kode Pos</th>
            <th>Kualifikasi</th>
            <th>Hubungan</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach($tambahan as $row) { if($row["type"] == "AFFILIATE") { ?>
          <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["address"] ?></td>
            <td><?php echo $row["city"] ?></td>
            <td><?php echo $row["country"] ?></td>
            <td><?php echo $row["postCode"] ?></td>
            <td><?php echo $row["qualification"] ?></td>
            <td><?php echo $row["relationship"] ?></td>
          </tr>
          <?php
          $i++;
        }
      }
      ?>
    </tbody>
  </table>
</div>
</div>
</div>
<div class="panel panel-primary">
  <div class="panel-heading">
    Subkontraktor
  </div>
  <div style="padding: 15px;">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-hover dataTables-example" >
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Kota</th>
            <th>Negara</th>
            <th>Kode Pos</th>
            <th>Kualifikasi</th>
            <th>Hubungan</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $i = 1;
          foreach($tambahan as $row) { if($row["type"] == "SUBCONTRACTOR") { ?>
          <tr>
            <td><?php echo $i ?></td>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["address"] ?></td>
            <td><?php echo $row["city"] ?></td>
            <td><?php echo $row["country"] ?></td>
            <td><?php echo $row["postCode"] ?></td>
            <td><?php echo $row["qualification"] ?></td>
            <td><?php echo $row["relationship"] ?></td>
          </tr>
          <?php
          $i++;
        }
      }
      ?>
    </tbody>
  </table>
</div>
</div>
</div>
</div>
</div>

<div id="tab-11" class="tab-pane">
  <div class="panel-body">
    <div class="panel panel-primary">
      <div class="panel-heading">
      Dokumen
      </div>
      <div style="padding: 15px;">

        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover dataTables-example" >
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>File</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach($dokumen as $row) { ?>
              <tr>
                <td><?php echo $i ?></td>
                <td><?php echo $row["vnd_suppdoc_desc"]; ?></td>
                <td><a href="<?php echo $url_doc."/".$row["vnd_suppdoc_filename"] ?>" target="_blank"><?php echo $row["vnd_suppdoc_filename"] ?></a></td>
              </tr>
              <?php
              $i++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</div>
</div>

</div>

</div>

</div>

<?php } ?>

</div>
</div>
</div>


<script>
  $(document).ready(function() {
    $('.dataTables-example').DataTable({
      "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    });
  });
</script>