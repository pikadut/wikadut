angular.module('inventory', ["angucomplete-alt"])
.config(['$locationProvider', function($locationProvider) {
  $locationProvider.html5Mode(true);
}])
.run(function($rootScope,$http) {

  $rootScope.list_kantor = [{id:"",name:"Pilih"}];

  $rootScope.list_dept = [{id:"",name:"Pilih"}];

  $rootScope.last_progress = null;

  $rootScope.urlpickercontract = null;

  $rootScope.tipekontrak = null;

  $http({
    method: 'GET',
    url: 'index.php/administration/data_daftar_kantor?limit=9999',
  }).then(function successCallback(response) {

    var mydata = response.data.rows;

    if(mydata){
     angular.forEach(mydata, function(value, key) {
      $rootScope.list_kantor.push({id:value.district_id,name:value.district_name});
    });
   }

 }, function errorCallback(response) {

 });


  $http({
    method: 'GET',
    url: 'index.php/administration/data_divisi_departemen?limit=9999',
  }).then(function successCallback(response) {

    var mydata = response.data.rows;

    if(mydata){
     angular.forEach(mydata, function(value, key) {
      $rootScope.list_dept.push({id:value.dept_id,name:value.dep_code+" - "+value.dept_name});
    });
   }

 }, function errorCallback(response) {

 });


})
.controller('form_header', ['$scope','$http','$rootScope','helper','$sce','$timeout', 
  function($scope,$http,$rootScope,helper,$sce,$timeout) {
    $scope.data = {
      no_kontrak:'',
      nama_vendor:'',
      no_inv:'AUTO NUMBER',
      ket_inv:'',
      tipe_inv:'',
      jenis_inv:'',
      no_progress:null,
      tgl_inv:new Date(),
      nama_tipe_inv:'',
      list_tipe_inv:[]
    };

    $rootScope.list_item_progress = [];

    angular.element("#no_progress").change(function(){
      var isi = this.value;
      if(isi !== null && $rootScope.last_progress != isi){
        $scope.getprogress(isi);
      }

    });

    $scope.getprogress = function(no_progress){

      $http.get("index.php/contract/data_progress/inv/"+no_progress).then(function(res){

        var header = res.data.header;
        var item = res.data.item;

        $rootScope.tipekontrak = res.data.type;

        if(header){
          $scope.data.no_kontrak = header.contract_number;
          var x = "<a href='index.php/contract/lihat_progress_"+$rootScope.tipekontrak+"/"+res.data.progress_id+"' target='_blank'>"+header.progress_number+" - "+header.progress_description+"</a>";
          $scope.data.progress = $sce.trustAsHtml(x);
          $scope.data.nama_vendor = header.vendor_name;
          $rootScope.last_progress = res.data.progress_id;
         
          console.log(header);
        }

         $rootScope.urlpickercontract = ($rootScope.tipekontrak == "wo") ? 
         "index.php/contract/picker_progress_wo" : "index.php/contract/picker_item_milestone";

        if(item){

          $rootScope.list_item_progress = [];

          angular.forEach(item, function(value, key) {

            var isi = {
              id:value.id,
              kode:value.kode,
              deskripsi:value.deskripsi,
              jumlah:value.jumlah,
              satuan:value.satuan,
              harga_satuan:value.harga_satuan,
              order_minimum:value.order_minimum,
              order_maksimum:value.order_maksimum,
            };

            $rootScope.list_item_progress.push(isi);

          });

        }

      });

    }

    $scope.reload_type = function(){

      $scope.data.list_tipe_inv = [
      {id: '', name: 'Pilih'},
      {id: 'SP', name: 'Sparepart'},
      {id: 'NSP', name: 'Non Sparepart'},
      {id: 'TKT', name: 'Tiket'}
      ];

      if($scope.data.tipe_inv == 'SP'){
        $scope.data.list_jenis_inv = [
        //{id: '', name: 'Pilih'},
        {id: 'P', name: 'Persediaan'},
        ];
        $scope.data.jenis_inv = "P";
      } else {
        $scope.data.list_jenis_inv = [
        {id: '', name: 'Pilih'},
        {id: 'BM', name: 'BHP Murni'},
        {id: 'BP', name: 'BHP Persediaan'},
        ];
      }

    }

    $http.get("index.php/inventory/get_header_acquisition").then(function(res){

      var d = res.data;

      if(d != null){

        d.tgl_inv = new Date(d.tgl_inv);

        $scope.data = d;

        $timeout(function(){

          $scope.reload_type();

          $scope.data.nama_tipe_inv = helper.fetchdata($scope.data.list_tipe_inv,$scope.data.tipe_inv);
          $scope.data.nama_jenis_inv = helper.fetchdata($scope.data.list_jenis_inv,$scope.data.jenis_inv);

          $scope.data.no_inv = ($scope.data.no_inv) ? $scope.data.no_inv : "AUTO NUMBER";
          
          $scope.getprogress("");

        },500);

      }

    });


  }])

.controller('form_header_dist', ['$scope','$http', function($scope,$http) {

  $scope.data = {
    no_distribusi:'AUTO NUMBER',
    keterangan:'',
  };

  $http.get("index.php/inventory/get_header_distribution").then(function(res){

    var d = res.data;

    if(d != null){
      $scope.data = d;
      $scope.data.no_distribusi = (d.no_distribusi) ? d.no_distribusi : "AUTO NUMBER";
    }

  });

}])

.controller('form_header_opname', ['$scope','$http', function($scope,$http) {

  $scope.data = {
    no_opname:'AUTO NUMBER',
    keterangan:'',
  };

  $http.get("index.php/inventory/get_header_opname").then(function(res){

    var d = res.data;

    if(d != null){
      d.tgl_mulai = new Date(d.tgl_mulai);
      d.tgl_selesai = new Date(d.tgl_selesai);
      $scope.data = d;
      $scope.data.no_opname = (d.no_opname) ? d.no_opname : "AUTO NUMBER";
    }

  });

}])

.controller('form_header_adj', ['$scope','$http', function($scope,$http) {

  $scope.data = {
    no_penyesuaian:'AUTO NUMBER',
    keterangan:'',
  };

  $http.get("index.php/inventory/get_header_adjustment").then(function(res){

    var d = res.data;

    if(d != null){
      $scope.data = d;
      $scope.data.no_penyesuaian = (d.no_penyesuaian) ? d.no_penyesuaian : "AUTO NUMBER";
    }

  });

}])


.controller('form_head_pr', ['$scope','$http', function($scope,$http) {

  $scope.data = {
    no_permintaan:'AUTO NUMBER',
    keterangan:'',
  };

  $http.get("index.php/inventory/get_header_request").then(function(res){

    var d = res.data;

    if(d != null){

      $scope.data = d;

      $scope.data.no_permintaan = (d.no_permintaan) ? d.no_permintaan : "AUTO NUMBER";

    }

  });

  $scope.reload_var = function(){

    var dept_id = $scope.data.dept_dari;
    var district_id = $scope.data.kantor_dari;

    if(dept_id){
      $http.get("index.php/inventory/set_session/pr_dept_id/"+dept_id);
    }

    if(district_id){
      $http.get("index.php/inventory/set_session/pr_district_id/"+district_id);
    }
    
  }

}])

.controller('form_tim_opname', ['$scope','$http','helper', function($scope,$http,helper) {

  $scope.data = {
    posisi_id_inp:"",
    petugas_name_inp:"",
    petugas_id_inp:"",
    keterangan_inp:"",
    current_opname_inp:"",
    posisi_nama_inp:"",
    list_posisi_pelaksana: [
    {id:"",name:"Pilih"},
    {id:'0', name:'Ketua'},
    {id:'1', name:'Sekretaris'},
    {id:'2', name:'Anggota'}
    ],
    list_petugas: [],
    list_tim_opname : [
    ],
  };

  var param = "";
  $scope.data.list_petugas = [{id:"",name:"Pilih"}];

  $http({
    method: 'GET',
    url: 'index.php/administration/data_user_list?limit=9999&'+param,
  }).then(function successCallback(response) {

    var mydata = response.data.rows;

    if(mydata){
      $scope.data.list_petugas = [{id:"",name:"Pilih"}];
      angular.forEach(mydata, function(value, key) {
        $scope.data.list_petugas.push({id:value.employee_id,name:value.complete_name});
      });
      $scope.data.list_petugas = _.uniqBy($scope.data.list_petugas, 'id');
    }

  }, function errorCallback(response) {

  });

  $http.get("index.php/inventory/get_opname_pelaksana").then(function(res){

    var d = res.data;

    if(d != null){

      angular.forEach(d, function(value, key) {
        d[key].posisi_nama = helper.fetchdata($scope.data.list_posisi_pelaksana,value.posisi);
      });

      $scope.data.list_tim_opname = d;

    }

  });

  $scope.hapuspetugas = function(){
    $scope.data.petugas_name_inp = "";
    $scope.data.petugas_id_inp = "";
    $scope.data.keterangan_inp = "";
    $scope.data.current_opname_inp = "";
    $scope.data.posisi_id_inp = "";
    $scope.data.posisi_nama_inp = "";
  }

  $scope.tambahpetugas = function(){

    var k = 0;

    angular.forEach($scope.data.list_tim_opname, function(value, key) {
      k += (value.posisi == '0') ? 1 : 0;
    });

    if($scope.data.petugas_id_inp == ""){
      alert("Pilih pelaksana");
    } else if($scope.data.posisi_id_inp == ""){
     alert("Pilih posisi");
   } else if(k > 0 && $scope.data.posisi_id_inp == '0'){
    alert("Ketua hanya satu");
  } else {

    var posisi_nama = helper.fetchdata($scope.data.list_posisi_pelaksana,$scope.data.posisi_id_inp);
    var nama = helper.fetchdata($scope.data.list_petugas,$scope.data.petugas_id_inp);
    var id = ($scope.data.current_opname_inp == "") ? $scope.data.list_tim_opname.length+1 : $scope.data.current_opname_inp;

    var isi = {
      id:id,
      userid:$scope.data.petugas_id_inp,
      nama:nama,
      posisi:$scope.data.posisi_id_inp,
      posisi_nama:posisi_nama,
      keterangan:$scope.data.keterangan_inp,
    };

    $scope.data.list_tim_opname.push(isi);

    $scope.hapuspetugas();

  }

}

$scope.ubahpetugas = function(item,i){

  var itemx = $scope.data.list_tim_opname[i];
  item.splice(i, 1);

  $scope.data.petugas_name_inp = itemx.nama;
  $scope.data.petugas_id_inp = itemx.userid;
  $scope.data.keterangan_inp = itemx.keterangan;
  $scope.data.current_opname_inp = itemx.id;
  $scope.data.posisi_id_inp = itemx.posisi;
  $scope.data.posisi_nama_inp = itemx.posisi_nama;

}

}])

.controller('detail', ['$scope','$http', '$location','$sce', function($scope,$http,$location,$sce) {

  var url = $location.path();

  var id = url.substr(url.lastIndexOf('/') + 1);

  $http.get("index.php/inventory/data_inventory?id="+id).then(function(res){

    var d = res.data.rows[0];
 d.tanggal_dibuat = (d.tanggal_dibuat && d.tanggal_dibuat != "0000-00-00 00:00:00") ?  new Date(d.tanggal_dibuat) : null;
    d.tanggal_diubah = (d.tanggal_diubah && d.tanggal_diubah != "0000-00-00 00:00:00") ? new Date(d.tanggal_diubah) : null;
    d.tanggal_perolehan = (d.tanggal_perolehan && d.tanggal_perolehan != "0000-00-00 00:00:00") ? new Date(d.tanggal_perolehan) : null;
    d.nama_status = $sce.trustAsHtml(d.nama_status);
    $scope.data = d;

  });

}])

.controller('form_item_opname', ['$scope','$http', function($scope,$http) {

  $scope.data = {
    kode_brg:"",
    nama_brg:"",
    jumlah_brg:"",
    aktual_brg:"",
    keterangan_brg:"",
    current_brg:"",
    index:"",
    attr:"B",
    list_item_opname : [
     //{id: '1', kode_brg: '51000200000003',nama_brg:"Tinta printer hp D2566 color (60)",stok_brg:220,so_brg:20,satuan_brg:"PCS",kantor_brg:"Departmen Rumah Tangga",gudang_brg:"Gudang Rumah Tangga Pusat A",keterangan_brg:"A"},
     ],
   };

   $http.get("index.php/inventory/get_header_opname").then(function(res){

    var d = res.data;

    if(d != null){
      $scope.data.attr = d.attr;
    }

  });

   $http.get("index.php/inventory/data_item_inventory?limit=9999").then(function(res){

    var d = res.data;

    $scope.data.list_item_opname = d.rows;

  });


   $scope.simpan = function(){

    var index = $scope.data.index;

    $scope.data.list_item_opname[index].so_brg = $scope.data.aktual_brg;
    $scope.data.list_item_opname[index].keterangan_brg = $scope.data.keterangan_brg;

    $scope.hapus();

  }

  $scope.hapus = function(){
    $scope.data.kode_brg = "";
    $scope.data.nama_brg = "";
    $scope.data.jumlah_brg = "";
    $scope.data.aktual_brg = "";
    $scope.data.keterangan_brg = "";
    $scope.data.current_brg = "";
    $scope.data.barcode = "";
    $scope.data.index = "";
  }

  $scope.ubah = function(item,i){

    var itemx = $scope.data.list_item_opname[i];

    $scope.data.index = i;
    $scope.data.kode_brg = itemx.kode_brg;
    $scope.data.nama_brg = itemx.nama_brg;
    $scope.data.jumlah_brg = itemx.stok_brg;
    $scope.data.stok_brg = itemx.stok_brg;
    $scope.data.current_brg = itemx.id;
    $scope.data.aktual_brg = itemx.so_brg;
    $scope.data.satuan_brg = itemx.satuan_brg;
    $scope.data.kantor_brg = itemx.kantor_brg;
    $scope.data.gudang_brg = itemx.gudang_brg;
    $scope.data.keterangan_brg = itemx.keterangan_brg;
    $scope.data.barcode = itemx.barcode;

  }

}])

.controller('form_lampiran', ['$scope', function($scope) {
  $scope.data = {
    kategori_dokumen:"",
    list_kategori_dokumen: [
    {id: '', name: 'Pilih'},
    {id: 'SP', name: 'Sparepart'},
    {id: 'NSP', name: 'Non Sparepart'},
    {id: 'TKT', name: 'Tiket'}
    ],
  };
}])

.controller('form_atr_opname', ['$rootScope','$scope','$http','helper','$timeout', function($rootScope,$scope,$http,helper,$timeout) {
  $scope.data = {
    gudang:"",
    attr:"",
    gudang_nama:"",
    attr_nama:"",
    list_gudang: [
    {id: '', name: 'Pilih'},
    ],
    list_attr: [
    {id: '', name: 'Pilih'},
    /*{id: 'B', name: 'Blind'},*/
    {id: 'O', name: 'Open'},
    ],
  };

  $http.get("index.php/inventory/get_header_opname").then(function(res){

    var d = res.data;

    if(d != null){
      $scope.data.gudang = d.gudang_id;
      $scope.data.attr = d.attr;
    }

  });

  $scope.reloadgudang = function(){

    $scope.data.list_gudang = [{id:"",name:"Pilih"}];

    $http({
      method: 'GET',
      url: 'index.php/administration/data_gudang?limit=9999',
    }).then(function successCallback(response) {

      var mydata = response.data.rows;

      if(mydata){
       angular.forEach(mydata, function(value, key) {
        var x = (parseInt(value.type_war) == 0) ? "Kantor" : "Kapal";
        $scope.data.list_gudang.push({id:value.id_war,name:value.name_war+" - "+x});
      });
     }

   }, function errorCallback(response) {

   });

  }

  $scope.reloadgudang();

}])

.controller('form_item_gudang', ['$rootScope','$scope','$http','helper','$timeout', function($rootScope,$scope,$http,helper,$timeout) {
  $scope.data = {
    gudang:"",
    kantor:"",
    gudang_nama:"",
    kantor_nama:"",
    list_gudang: [
    {id: '', name: 'Pilih'},
    ],
    list_kantor: [
    {id: '', name: 'Pilih'},
    ],
    list_item_gudang : [],
    kode:"",
    deskripsi:"",
    jumlah:"",
    satuan:"",
    harga_satuan:"",
    keterangan:"",
    jumlah_masuk:"",
    barcode:"",
    list_jumlah:{},
    list_batas:{},
  };

  $http.get("index.php/inventory/get_gudang_item_penyimpanan").then(function(res){

    var d = res.data;

    if(d != null){

      angular.forEach(d, function(value, key) {
        if(!$scope.data.list_jumlah[value.kode]){
          $scope.data.list_jumlah[value.kode] = 0;
        }
        if(!$scope.data.list_batas[value.kode]){
          $scope.data.list_batas[value.kode] = 0;
        }
        $scope.data.list_batas[value.kode] = moneytoint(value.jumlah);
        $scope.data.list_jumlah[value.kode] = moneytoint(value.jumlah_masuk);
      });

      $scope.data.list_item_gudang = d;

    }

  });

  $scope.reloadgudang = function(){

    $scope.data.list_gudang = [{id:"",name:"Pilih"}];

    $http({
      method: 'GET',
      url: 'index.php/administration/data_gudang?limit=9999&kantor='+$scope.data.kantor,
    }).then(function successCallback(response) {

      var mydata = response.data.rows;

      if(mydata){
       angular.forEach(mydata, function(value, key) {
        var x = (parseInt(value.type_war) == 0) ? "Kantor" : "Kapal";
        $scope.data.list_gudang.push({id:value.id_war,name:value.name_war+" - "+x});
      });
     }

   }, function errorCallback(response) {

   });

  }


  $scope.hapus_item = function(){

    $scope.data.kode = "";
    $scope.data.deskripsi = "";
    $scope.data.jumlah = "";
    $scope.data.satuan = "";
    $scope.data.harga_satuan = "";
    $scope.data.keterangan = "";
    $scope.data.jumlah_masuk = "";
    $scope.data.gudang = "";
    $scope.data.kantor = "";
    $scope.data.id = "";
    $scope.data.barcode = "";

  }

  $scope.reset_jumlah = function(){
    angular.forEach($scope.data.list_item_gudang, function(value, key) {
      $scope.data.list_jumlah[value.kode] = 0;
    });

    angular.forEach($scope.data.list_item_gudang, function(value, key) {
      $scope.data.list_jumlah[value.kode] += moneytoint(value.jumlah_masuk);
    });
    //console.log($scope.data);
  }

  $scope.tambah_item = function(){

    $scope.data.kantor_nama = helper.fetchdata($rootScope.list_kantor,$scope.data.kantor);

    $scope.data.gudang_nama = helper.fetchdata($scope.data.list_gudang,$scope.data.gudang);

    var id = $scope.data.id;

    var isi = {
      id:id,
      kode:$scope.data.kode,
      deskripsi:$scope.data.deskripsi,
      jumlah:$scope.data.jumlah,
      satuan:$scope.data.satuan,
      harga_satuan:$scope.data.harga_satuan,
      keterangan:$scope.data.keterangan,
      jumlah_masuk:$scope.data.jumlah_masuk,
      kantor_nama:$scope.data.kantor_nama,
      kantor:$scope.data.kantor,
      gudang_nama:$scope.data.gudang_nama,
      gudang:$scope.data.gudang,
      barcode:$scope.data.barcode
    };

    var nilaimasuk = moneytoint($scope.data.jumlah_masuk);

    var cek = parseInt($scope.data.list_batas[isi.kode]) - 
    (parseInt($scope.data.list_jumlah[isi.kode])+parseInt(nilaimasuk));

    //console.log(nilaimasuk);
    //console.log($scope.data.list_batas);
    //console.log($scope.data.list_jumlah);

    if(!$scope.data.deskripsi){

      alert("Deskripsi tidak boleh kosong");

    } else if(!$scope.data.kantor){

      alert("Pilih kantor");

    } else if(!$scope.data.gudang){

      alert("Pilih gudang");

    } else if(cek < 0){

      alert("Jumlah stok tidak boleh minus");

    } else {

      angular.forEach($scope.data.list_item_gudang, function(value, key) {
        if(value.kode+value.kantor+value.gudang == isi.kode+isi.kantor+isi.gudang){
          $scope.data.list_item_gudang.splice(key, 1);
        }
      });

      $scope.data.list_item_gudang.push(isi);
      $scope.reset_jumlah();
      $scope.hapus_item();

    }

  }

  $scope.ubah_item = function(item,i){

    var itemx = $scope.data.list_item_gudang[i];
    $scope.data.list_item_gudang.splice(i, 1);

    $scope.data.id = itemx.id;
    $scope.data.kode = itemx.kode;
    $scope.data.deskripsi = itemx.deskripsi;
    $scope.data.jumlah = itemx.jumlah;
    $scope.data.satuan = itemx.satuan;
    $scope.data.harga_satuan = itemx.harga_satuan;
    $scope.data.keterangan = itemx.keterangan;
    $scope.data.kantor = itemx.kantor;
    $scope.data.barcode = itemx.barcode;
    $scope.data.jumlah_masuk = itemx.jumlah_masuk;

    if(!$scope.data.list_jumlah[itemx.kode]){
      $scope.data.list_jumlah[itemx.kode] = 0;
    } else {
      $scope.data.list_jumlah[itemx.kode] -= moneytoint($scope.data.jumlah_masuk);
    }

    if(!$scope.data.list_batas[itemx.kode]){
      $scope.data.list_batas[itemx.kode] = 0;
    }

    $scope.data.list_batas[itemx.kode] = moneytoint($scope.data.jumlah);

    //console.log($scope.data.list_batas);
    //console.log($scope.data.list_jumlah);

    $scope.reloadgudang();

    $timeout(function(){
      $scope.data.gudang = itemx.gudang;
      

    },500);

  }

  $scope.ambil_item = function(){

    var id = $scope.data.kode;

    $http({
      method: 'GET',
      url: 'index.php/inventory/data_item_inventory?id='+id,
    }).then(function successCallback(response) {

      var mydata = response.data.rows[0];

      if(mydata){

        $scope.data.id = mydata.id;

        $scope.data.kode = mydata.kode;
        $scope.data.deskripsi = mydata.deskripsi;

        if(!$scope.data.list_jumlah[mydata.kode]){
          $scope.data.list_jumlah[mydata.kode] = 0;
        }

        $scope.data.jumlah = mydata.jumlah;
        $scope.data.list_batas[mydata.kode] = moneytoint($scope.data.jumlah);
        $scope.data.satuan = mydata.satuan;
        $scope.data.harga_satuan = mydata.harga_satuan;
        $scope.data.keterangan = mydata.keterangan;

        //console.log($scope.data);

      }

    }, function errorCallback(response) {

    });

  }

}])

.controller('form_pic', ['$scope','$http', function($scope,$http) {
  $scope.data = {
    lokasi:"",
    pic:"",
    kantor:"",
    dept:"",
    list_pic: [],
    list_kantor: [],
    list_dept: [],
  };

  $http.get("index.php/inventory/get_header_distribution").then(function(res){

    var d = res.data;

    $scope.data.kantor = d.district_id_tujuan;

    $scope.data.dept = d.dept_id_tujuan;

    $scope.data.pic = d.pic_id;

    $scope.data.lokasi = (parseInt(d.dept_id_tujuan) == 0) ? "k" : "d";

    $scope.reloadpic();

  });

  $scope.reloadpic = function(){

    var job_title = "PIC_INV";

    if($scope.data.lokasi == 'k'){
      job_title = "PETUGAS_GUDANG";
      $scope.data.dept = "";
    } else {
      $scope.data.kantor = "";
    }

    var dept_id = "";

    if($scope.data.dept != ''){
      dept_id = $scope.data.dept;
    } 

    var district_id = "";

    if($scope.data.kantor != ''){
      district_id = $scope.data.kantor;
    } 
    
    var param = "job_title="+job_title+"&district_id="+district_id+"&dept_id="+dept_id;
    $scope.data.list_pic = [{id:"",name:"Pilih"}];

    $http({
      method: 'GET',
      url: 'index.php/administration/data_user_list?limit=9999&'+param,
    }).then(function successCallback(response) {

      var mydata = response.data.rows;

      if(mydata){
        $scope.data.list_pic = [{id:"",name:"Pilih"}];
        angular.forEach(mydata, function(value, key) {
          $scope.data.list_pic.push({id:value.employee_id,name:value.complete_name});
        });
        $scope.data.list_pic = _.uniqBy($scope.data.list_pic, 'id');
      }

    }, function errorCallback(response) {

    });

  }

}])
.controller('form_comment', ['$scope', function($scope) {
  $scope.data = {
   list_action: [
   {id: '1', name: 'Simpan Sebagai Draft'},
   {id: '2', name: 'Simpan dan Selesai'},
   ],
   aksi_komentar:"1",
   list_comment: [
   {mulai: new Date("2017-01-01 04:04:04"), selesai: new Date("2017-01-01 04:04:04"), 
   nama:'Aldo Rifki Putra',posisi:'Programmer',aktifitas:'Menunggu Persetujuan',respon:'Setuju',komentar:'Lanjutkan'},
   ],
 };
}])
.controller('form_item_inv', ['$scope','$http','$rootScope', function($scope,$http,$rootScope) {

  $scope.data = {
    kode:"",
    deskripsi:"",
    jumlah:"",
    satuan:"",
    harga_satuan:"",
    keterangan:"",
    merk:"",
    part_number:"",
    tipe:"INV",
    merk_pick:{title:""},
    part_number_pick:{title:""},
  };

  $scope.hapus_item = function(){

    $scope.data.kode = "";
    $scope.data.deskripsi = "";
    $scope.data.jumlah = "";
    $scope.data.satuan = "";
    $scope.data.harga_satuan = "";
    $scope.data.keterangan = "";
    $scope.data.merk = "";
    $scope.data.part_number = "";
    $scope.data.merk_pick.title = "";
    $scope.data.part_number_pick.title = "";

  }

  $scope.pilihtipeitem = function(x){
    $scope.data.tipe = x;
  }

  $scope.tambah_item = function(){

    var id = $scope.data.id;

    var merk = "";
    if(typeof $scope.data.merk_pick !== 'undefined'){
      merk = (typeof $scope.data.merk_pick.title !== 'undefined') ? $scope.data.merk_pick.title : $scope.data.merk_pick.originalObject;
    }

    var part_number = "";
    if(typeof $scope.data.part_number_pick !== 'undefined'){
      part_number = (typeof $scope.data.part_number_pick.title !== 'undefined') ? $scope.data.part_number_pick.title : $scope.data.part_number_pick.originalObject;
    } 

    var isi = {
      id:id,
      kode:$scope.data.kode,
      deskripsi:$scope.data.deskripsi,
      jumlah:$scope.data.jumlah,
      satuan:$scope.data.satuan,
      harga_satuan:$scope.data.harga_satuan,
      keterangan:$scope.data.keterangan,
      merk:merk,
      part_number:part_number,
    };

    angular.forEach($scope.data.list_item, function(value, key) {
      if(value.kode+value.merk+value.part_number == isi.kode+isi.merk+isi.part_number){
        $scope.data.list_item.splice(key, 1);
      }
    });

    if($scope.data.deskripsi == ""){

      alert("Deskripsi tidak boleh kosong");

    }else if(parseInt($scope.data.jumlah) == 0){

      alert("Jumlah tidak boleh kosong");

    } else {

      $scope.$broadcast('angucomplete-alt:clearInput', 'part_number_inp');

      $scope.$broadcast('angucomplete-alt:clearInput', 'merk_inp');

      $scope.data.list_item.push(isi);

      $scope.hapus_item();

    }

  }

  $scope.ubah_item = function(item,i){

    var itemx = $scope.data.list_item[i];
    item.splice(i, 1);

    $scope.data.kode = itemx.kode;
    $scope.data.deskripsi = itemx.deskripsi;
    $scope.data.jumlah = itemx.jumlah;
    $scope.data.satuan = itemx.satuan;
    $scope.data.harga_satuan = itemx.harga_satuan;
    $scope.data.keterangan = itemx.keterangan;
    $scope.data.merk_pick = {title:itemx.merk};
    $scope.data.part_number_pick = {title:itemx.part_number};
    $scope.$broadcast('angucomplete-alt:changeInput', 'merk_inp', itemx.merk);
    $scope.$broadcast('angucomplete-alt:changeInput', 'part_number_inp', itemx.part_number);

  }

  $scope.ambil_item = function(){

    var id = $scope.data.kode;

    //alert($scope.data.tipe+" - "+id);

    //if($rootScope.last_progress){

      if($scope.data.tipe == "INV"){

        $http({
          method: 'GET',
          url: 'index.php/inventory/data_inventory?id='+id,
        }).then(function successCallback(response) {

          var mydata = response.data.rows[0];

          if(mydata){
            $scope.data.kode = mydata.kode_barang;
            $scope.data.deskripsi = mydata.nama_barang;
            $scope.data.jumlah = mydata.jumlah_barang;
            $scope.data.satuan = mydata.nama_satuan;
            $scope.data.harga_satuan = mydata.harga_perolehan;
            $scope.data.keterangan = "";
            $scope.data.merk_pick = {title:mydata.merk};
            $scope.data.part_number_pick = {title:mydata.part_number};
            $scope.$broadcast('angucomplete-alt:changeInput', 'merk_inp', mydata.merk);
            $scope.$broadcast('angucomplete-alt:changeInput', 'part_number_inp', mydata.part_number);
          }

        }, function errorCallback(response) {

        });

      } else if($scope.data.tipe == "PRC") {

        var url = "index.php/procurement/data_item_proc";

        $http({
          method: 'GET',
          url: url+'?id='+id,
        }).then(function successCallback(response) {

          var mydata = response.data.rows[0];

          if(mydata){
            $scope.data.kode = mydata.kode;
            $scope.data.deskripsi = mydata.deskripsi;
            $scope.data.jumlah = mydata.jumlah;
            $scope.data.satuan = mydata.satuan;
            $scope.data.harga_satuan = mydata.harga_satuan;
            $scope.data.keterangan = "";
            $scope.data.merk_pick = {title:""};
            $scope.data.part_number_pick = {title:""};
          }

        }, function errorCallback(response) {

        });

      }else if($scope.data.tipe == "BRG") {

    var url = "index.php/commodity/data_mat_catalog/approved";

    $http({
      method: 'GET',
      url: url+'?id='+id,
    }).then(function successCallback(response) {

      var mydata = response.data.rows[0];
      console.log(mydata);

      if(mydata){
        $scope.data.kode = mydata.mat_catalog_code;
        $scope.data.deskripsi = String(mydata.short_description).replace(/<[^>]+>/gm, '');
        $scope.data.jumlah = mydata.jumlah;
        $scope.data.satuan = mydata.uom;
        $scope.data.harga_satuan = mydata.total_price;
        $scope.data.keterangan = mydata.long_description;
        $scope.data.merk_pick = {title:""};
            $scope.data.part_number_pick = {title:""};

      }

    }, function errorCallback(response) {

    });

  } else {

        var url = ($rootScope.tipekontrak == "wo") ? 
        "index.php/contract/data_progress_wo" : 
        "index.php/contract/data_item_milestone";

        $http({
          method: 'GET',
          url: url+'?id='+id,
        }).then(function successCallback(response) {

          var mydata = response.data.rows[0];

          if(mydata){
            $scope.data.kode = mydata.kode;
            $scope.data.deskripsi = mydata.deskripsi;
            $scope.data.jumlah = mydata.jumlah;
            $scope.data.satuan = mydata.satuan;
            $scope.data.harga_satuan = mydata.harga_satuan;
            $scope.data.keterangan = "";
            $scope.data.merk_pick = {title:""};
            $scope.data.part_number_pick = {title:""};
          }

        }, function errorCallback(response) {

        });

      }

    //}

  }

  $http.get("index.php/inventory/data_item_inventory?limit=9999").then(function(res){

    var d = res.data;

    $scope.data.list_item = d.rows;

  });

}])

.controller('form_item_pr_inv', ['$scope','$http','$rootScope', function($scope,$http,$rootScope) {

  $scope.data = {
    kode:"",
    deskripsi:"",
    jumlah:"",
    satuan:"",
    harga_satuan:"",
    keterangan:"",
    merk:"",
    part_number:"",
    tgl_butuh:null,
    merk_pick:{title:""},
    part_number_pick:{title:""},
  };

  $scope.hapus_item = function(){

    $scope.data.kode = "";
    $scope.data.deskripsi = "";
    $scope.data.jumlah = "";
    $scope.data.satuan = "";
    $scope.data.harga_satuan = "";
    $scope.data.keterangan = "";
    $scope.data.merk = "";
    $scope.data.part_number = "";
    $scope.data.tgl_butuh = null;
    $scope.data.merk_pick.title = "";
    $scope.data.part_number_pick.title = "";

  }

  $scope.pilihtipeitem = function(x){
    $scope.data.tipe = x;
  }

  $scope.tambah_item = function(){

    var id = $scope.data.id;

    var merk = "";
    if(typeof $scope.data.merk_pick !== 'undefined'){
      merk = (typeof $scope.data.merk_pick.title !== 'undefined') ? $scope.data.merk_pick.title : $scope.data.merk_pick.originalObject;
    }

    var part_number = "";
    if(typeof $scope.data.part_number_pick !== 'undefined'){
      part_number = (typeof $scope.data.part_number_pick.title !== 'undefined') ? $scope.data.part_number_pick.title : $scope.data.part_number_pick.originalObject;
    }

    var isi = {
      id:id,
      kode:$scope.data.kode,
      deskripsi:$scope.data.deskripsi,
      jumlah:$scope.data.jumlah,
      satuan:$scope.data.satuan,
      harga_satuan:$scope.data.harga_satuan,
      keterangan:$scope.data.keterangan,
      tgl_butuh:$scope.data.tgl_butuh,
      merk:merk,
      part_number:part_number,
    };

    angular.forEach($scope.data.list_item, function(value, key) {
      if(value.kode+value.merk+value.part_number == isi.kode+isi.merk+isi.part_number){
        $scope.data.list_item.splice(key, 1);
      }
    });

    if($scope.data.deskripsi == ""){

      alert("Deskripsi tidak boleh kosong");

    }else if(parseInt($scope.data.jumlah) == 0){

      alert("Jumlah tidak boleh kosong");

    } else {

      $scope.$broadcast('angucomplete-alt:clearInput', 'part_number_inp');

      $scope.$broadcast('angucomplete-alt:clearInput', 'merk_inp');

      $scope.data.list_item.push(isi);

      $scope.hapus_item();

    }

  }

  $scope.ubah_item = function(item,i){

    var itemx = $scope.data.list_item[i];
    item.splice(i, 1);

    $scope.data.kode = itemx.kode;
    $scope.data.deskripsi = itemx.deskripsi;
    $scope.data.jumlah = itemx.jumlah;
    $scope.data.satuan = itemx.satuan;
    $scope.data.harga_satuan = itemx.harga_satuan;
    $scope.data.keterangan = itemx.keterangan;
    $scope.data.tgl_butuh = itemx.tgl_butuh;
    $scope.data.merk_pick = {title:itemx.merk};
    $scope.data.part_number_pick = {title:itemx.part_number};
    $scope.$broadcast('angucomplete-alt:changeInput', 'merk_inp', itemx.merk);
    $scope.$broadcast('angucomplete-alt:changeInput', 'part_number_inp', itemx.part_number);

  }

  $scope.ambil_item = function(){

    var id = $scope.data.kode;

    $http({
      method: 'GET',
      url: 'index.php/inventory/data_inventory?id='+id,
    }).then(function successCallback(response) {

      var mydata = response.data.rows[0];

      if(mydata){
        $scope.data.kode = mydata.kode_barang;
        $scope.data.deskripsi = mydata.nama_barang;
        $scope.data.jumlah = mydata.jumlah_barang;
        $scope.data.satuan = mydata.nama_satuan;
        $scope.data.harga_satuan = mydata.harga_perolehan;
        $scope.data.tgl_butuh = new Date();
        $scope.data.keterangan = "";
        $scope.data.merk_pick.title = mydata.merk;
        $scope.data.part_number_pick.title = mydata.part_number;
        $scope.$broadcast('angucomplete-alt:changeInput', 'merk_inp', mydata.merk);
        $scope.$broadcast('angucomplete-alt:changeInput', 'part_number_inp', mydata.part_number);
      }

    }, function errorCallback(response) {

    });

  }

  $http.get("index.php/inventory/data_item_inventory?limit=9999").then(function(res){

    var d = res.data;

    angular.forEach(d.rows, function(value, key) {
      value.tgl_butuh = new Date(value.tgl_butuh);
      d.rows[key] = value;
    });
    //console.log(d);
    $scope.data.list_item = d.rows;

  });

}])

.factory('helper', [function() {

 return {
  fetchdata : function(data,id){
    var x = "";
    angular.forEach(data, function(value, key) {
      if(value.id == id){

        x = value.name;
      }
    });
    return x;
  }
}

}])
.controller('form_item_adj', ['$scope','$http','$rootScope','helper', function($scope,$http,$rootScope,helper) {

  $scope.data = {
    id:"",
    kode:"",
    deskripsi:"",
    stok:"",
    penyesuaian:"",
    batas:"",
    keterangan:"",
    merk:"",
    part_number:"",
    status:"",
  };

  $scope.data.list_status_inv = [
  {id: '', name: 'Pilih'},
  {id: '0', name: 'Nonaktif'},
  {id: '1', name: 'Aktif'},
  ];

  $scope.hapus_item = function(){

    $scope.data.id = "";
    $scope.data.kode = "";
    $scope.data.deskripsi = "";
    $scope.data.stok = "";
    $scope.data.penyesuaian = "";
    $scope.data.batas = "";
    $scope.data.keterangan = "";
    $scope.data.merk = "";
    $scope.data.part_number = "";
    $scope.data.status = "";

  }

  $scope.tambah_item = function(){

    var id = $scope.data.id;

    var isi = {
      id:id,
      kode:$scope.data.kode,
      deskripsi:$scope.data.deskripsi,
      stok:$scope.data.stok,
      penyesuaian:$scope.data.penyesuaian,
      batas:$scope.data.batas,
      keterangan:$scope.data.keterangan,
      merk:$scope.data.merk,
      part_number:$scope.data.part_number,
      status:$scope.data.status,
    };

    isi.status_name = helper.fetchdata($scope.data.list_status_inv,isi.status);

    angular.forEach($scope.data.list_item, function(value, key) {
      if(value.kode+value.merk+value.part_number == isi.kode+isi.merk+isi.part_number){
        $scope.data.list_item.splice(key, 1);
      }
    });

    if($scope.data.deskripsi == ""){

      alert("Deskripsi tidak boleh kosong");

    }else if(parseInt($scope.data.stok) == 0){

      alert("Stok tidak boleh kosong");

      //add new required stok penyesuaian
    }else if($scope.data.penyesuaian == ""){

      alert("Stok penyesuaian tidak boleh kosong");
      //end
      
    }else if($scope.data.status == null){

      alert("Pilih status");

    } else {

      $scope.data.list_item.push(isi);

      $scope.hapus_item();

    }

  }

  $scope.ubah_item = function(item,i){

    var itemx = $scope.data.list_item[i];
    item.splice(i, 1);

    $scope.data.id = itemx.id;
    $scope.data.kode = itemx.kode;
    $scope.data.deskripsi = itemx.deskripsi;
    $scope.data.stok = itemx.stok;
    $scope.data.penyesuaian = itemx.penyesuaian;
    $scope.data.batas = itemx.batas;
    $scope.data.keterangan = itemx.keterangan;
    $scope.data.merk = itemx.merk;
    $scope.data.part_number = itemx.part_number;
    $scope.data.status = itemx.status;

  }

  $scope.ambil_item = function(){

    var id = $scope.data.kode;

    $http({
      method: 'GET',
      url: 'index.php/inventory/data_inventory?id='+id,
    }).then(function successCallback(response) {

      var mydata = response.data.rows[0];

      if(mydata){
        $scope.data.id = id;
        $scope.data.kode = mydata.kode_barang;
        $scope.data.deskripsi = mydata.nama_barang;
        $scope.data.stok = mydata.jumlah_barang;
        $scope.data.batas = mydata.batas_barang;
        $scope.data.keterangan = mydata.keterangan;
        $scope.data.status = mydata.status_barang;
        $scope.data.merk = mydata.merk;
        $scope.data.part_number = mydata.part_number;

      }

    }, function errorCallback(response) {

    });


  }

  $http.get("index.php/inventory/data_item_inventory?limit=9999").then(function(res){

    var d = res.data;

    $scope.data.list_item = d.rows;

  });

}])
;