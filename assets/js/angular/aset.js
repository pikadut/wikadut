angular.module('aset', ["angucomplete-alt",'ui.tree'])
.config(['$locationProvider', function($locationProvider) {
//$locationProvider.html5Mode(true);
}])
.run(function($rootScope,$http) {

  $rootScope.list_kantor = [{id:"",name:"Pilih"}];

  $rootScope.list_dept = [{id:"",name:"Pilih"}];

  $rootScope.list_divisi = [];//tambah

  $rootScope.list_kapal = [{id:"",name:"Pilih"}];

  $rootScope.list_umur_ekonomis = [{id:"",name:"Pilih"}];

  //daftar gudang 
  $rootScope.list_gudang = [{id:"",name:"Pilih"}];
  //end

  $rootScope.list_kondisi = [{id:"",name:"Pilih"},{id:"B",name:"Baik"},{id:"R",name:"Rusak"},
  {id:"RS",name:"Rusak Sekali"},{id:"H",name:"Hilang"}];

  $rootScope.last_progress = 1;

  $rootScope.tipe = null;

  $rootScope.list_gudang = [{id:"",name:"Pilih"}];

  $rootScope.reloaddept = function(x){

    $rootScope.list_dept = [{id:"",name:"Pilih"}];

    $http.get("index.php/aset/set_session/district_id/"+x);

    $http({
      method: 'GET',
      url: 'index.php/administration/data_divisi_departemen?limit=9999&kantor='+x,
    }).then(function successCallback(response) {

     var mydata = response.data.rows;

     if(mydata){
       angular.forEach(mydata, function(value, key) {
        $rootScope.list_dept.push({id:value.dept_id,name:value.dep_code+" - "+value.dept_name});
        $rootScope.list_divisi.push({id:value.dept_id,name:value.dept_name});//tambah
      });
     }

     $rootScope.list_gudang = [{id:"",name:"Pilih"}];
     var param = "kantor="+x;
     $http({
      method: 'GET',
      url: 'index.php/administration/data_gudang?limit=9999&'+param,
    }).then(function successCallback(response) {

      var mydata = response.data.rows;

      if(mydata){
       angular.forEach(mydata, function(value, key) {
        var x = (parseInt(value.type_war) == 0) ? "Kantor" : "Kapal";
        $rootScope.list_gudang.push({id:value.id_war,name:value.name_war+" - "+x});
      });
     }

   }, function errorCallback(response) {

   });

  }, function errorCallback(response) {

  });

  }


  $rootScope.default_komponisasi = [];
  $rootScope.default_komponisasi_value = [];

  $http({
    method: 'GET',
    url: 'index.php/administration/tree_komponisasi_template',
  }).then(function successCallback(response) {

    $rootScope.default_komponisasi = response.data.tree;
    $rootScope.default_komponisasi_value = response.data.value;

  }, function errorCallback(response) {

  });
//daftar gudang
$http({
    method: 'GET',
    url: 'index.php/administration/data_gudang',
  }).then(function successCallback(response) {

    var mydata = response.data.rows;

    if(mydata){
     angular.forEach(mydata, function(value, key) {
      $rootScope.list_gudang.push({id:value.id_war,name:value.name_war});
    });
   }

 }, function errorCallback(response) {

 });

  //end

  $http({
    method: 'GET',
    url: 'index.php/aset/data_umur_ekonomis/active?limit=9999',
  }).then(function successCallback(response) {

    var mydata = response.data.rows;

    if(mydata){
     angular.forEach(mydata, function(value, key) {
      $rootScope.list_umur_ekonomis.push({id:value.id,name:value.name+" ("+value.year+" tahun)"});
    });
   }

 }, function errorCallback(response) {

 });

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
    url: 'index.php/administration/data_kapal?limit=9999',
  }).then(function successCallback(response) {

    var mydata = response.data.rows;

    if(mydata){
     angular.forEach(mydata, function(value, key) {
      $rootScope.list_kapal.push({id:value.id_ship,name:value.name_ship+' - '+value.district_name});
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
      $rootScope.list_divisi.push({id:value.dept_id,name:value.dept_name});//tambah
    });
   }

 }, function errorCallback(response) {

 });


})

.controller('detail', ['$scope','$http', '$location','$sce', function($scope,$http,$location,$sce) {

  var id = window.location.href.substr(window.location.href.lastIndexOf('/') + 1);

  $scope.reloadmap = function(){
   var uluru = {lat: parseFloat($scope.data.latitude), lng: parseFloat($scope.data.longitude)};
   var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
    center: uluru
  });
   var marker = new google.maps.Marker({
    position: uluru,
    map: map
  });
 }

 $http.get("index.php/aset/data_aset?id="+id).then(function(res){

  var d = res.data.rows[0];
  d.tanggal_dibuat = (d.tanggal_dibuat && d.tanggal_dibuat != "0000-00-00 00:00:00") ?  new Date(d.tanggal_dibuat) : null;
  d.tanggal_diubah = (d.tanggal_diubah && d.tanggal_diubah != "0000-00-00 00:00:00") ? new Date(d.tanggal_diubah) : null;
  d.tanggal_perolehan = (d.tanggal_perolehan && d.tanggal_perolehan != "0000-00-00 00:00:00") ? new Date(d.tanggal_perolehan) : null;
  d.nama_status = $sce.trustAsHtml(d.nama_status);
  $scope.data = d;
  $scope.reloadmap();

});




}])

.controller('form_tree_komponisasi', ['$scope','$http','$rootScope','helper','$sce','$timeout', 
  function($scope,$http,$rootScope,helper,$sce,$timeout) {

    $scope.komponisasi = {};
    $scope.val = {};

    $('#komponisasimodal').on('show.bs.modal', function (e) {
    }).on('hide.bs.modal', function (e) {

      $rootScope.$apply(function () {
        var index = _.findIndex($rootScope.list_item_progress, ['kode', $rootScope.current_komponisasi]);
        $rootScope.list_item_progress[index].komponisasi = angular.toJson($scope.val);
        $rootScope.current_komponisasi = null;
      });

    })

    $rootScope.$watch('current_komponisasi', function (newValue, oldValue) {

      $scope.data = $rootScope.default_komponisasi;
      $scope.komponisasi = _.find($rootScope.list_item_progress, ['kode', newValue]);

      try{
        $scope.val = angular.fromJson($scope.komponisasi.komponisasi);
        if(!$scope.val){
          $scope.val = $rootScope.default_komponisasi_value;
        }
      }catch(e) {
        $scope.val = $rootScope.default_komponisasi_value;
      }

    });

    $scope.remove = function (scope) {
      scope.remove();
    };

    $scope.toggle = function (scope) {
      scope.toggle();
    };

    $scope.moveLastToTheBeginning = function () {
      var a = $scope.data.pop();
      $scope.data.splice(0, 0, a);
    };

    $scope.percent = function(scope){
      var nodeData = scope.$modelValue;
      var persen = prompt("Persentase : ", $scope.val[nodeData.id]);
      if(parseFloat(persen) >= 0 && parseFloat(persen) <= 100){
        $scope.val[nodeData.id] = parseFloat(persen);
      } else {
        alert("Persentase harus diantara 0 - 100");
      }
    }

    $scope.year = function (scope) {
      var nodeData = scope.$modelValue;
      console.log(nodeData);
      nodeData.nodes.push({
        id: nodeData.id * 10 + nodeData.nodes.length,
        title: nodeData.title + '.' + (nodeData.nodes.length + 1),
        nodes: []
      });
    };

    $scope.collapseAll = function () {
      $scope.$broadcast('angular-ui-tree:collapse-all');
    };

    $scope.expandAll = function () {
      $scope.$broadcast('angular-ui-tree:expand-all');
    };

  }])


.controller('form_item_penghapusan', ['$scope','$http','$rootScope','helper','$sce','$timeout', 
  function($scope,$http,$rootScope,helper,$sce,$timeout) {

    $scope.data = {};

    $scope.data.list_item = [];

    $scope.ambil_item = function(){

      var id = $scope.data.kode_item;

      var i = _.findIndex($scope.data.list_item, ['id', id]);

      if(i < 0){

        $http({
          method: 'GET',
          url: 'index.php/aset/data_aset?id='+id,
        }).then(function successCallback(response) {

          var mydata = response.data.rows[0];

          if(mydata){

            $scope.data.item = mydata;

          }

        }, function errorCallback(response) {

        });

      } else {
        $scope.data.kode_item = null;
        alert("Item sudah dipilih");
      }

    }


    $scope.hapus_item = function(){

     $scope.data.kode_item = null;
     $scope.data.attachment = null;
     $scope.data.item = {};

   }

   $scope.lihat_komponisasi = function(i){
    $rootScope.current_komponisasi = i;
  }

   $scope.roleInit = function(role) {//tambah
    $scope.role = role;//tambah
  }//tambah

  $scope.tambah_item = function(){
    $scope.data.item.attachment = $scope.data.attachment;

    if($scope.role == 'PIC USER' || $scope.role == 'MANAJER ASET' || $scope.role == 'PIC ASET'){//tambah  
      
      if(!($scope.data.kode_item && $scope.data.attachment)){//tambah
        
        if(!$scope.data.kode_item){
          alert("Item tidak boleh kosong");
          }
          if(!$scope.data.attachment){//tambah
          alert("Lampiran tidak boleh kosong");//tambah
          }

      }else {//tambah
          $scope.data.list_item.push($scope.data.item);//tambah
          $scope.hapus_item();//tambah
      }

    }else{//tambah   
      
        if(!$scope.data.kode_item){
          alert("Item tidak boleh kosong");
          
          }else{

        $scope.data.list_item.push($scope.data.item);
        $scope.hapus_item();
      }
    }

  }

  $scope.ubah_item = function(itemx){

    var i = _.findIndex($scope.data.list_item, ['id', itemx.id]);

    $scope.data.item      = itemx;
    $scope.data.kode_item = itemx.id;

    console.log(itemx);

    _.remove($scope.data.list_item, function(n) {
      return itemx.id == n.id;
    });

    $("#nama_item").focus();

  }

  $http.get("index.php/aset/data_item_aset?limit=9999").then(function(res){

    var d = res.data;

    $scope.data.list_item = d.rows;

  });


}])

.controller('form_item_pencatatan', ['$scope','$http','$rootScope','helper','$sce','$timeout', 
  function($scope,$http,$rootScope,helper,$sce,$timeout) {


    $scope.data = {
      no_kontrak:'',
      nama_vendor:'',
      nomor:'AUTO NUMBER',
      keterangan:'',
      tipe:'',
      jenis:'',
      no_progress:null,
      tanggal:new Date(),
      nama_tipe:'',
      list_tipe:[],
      kode_item:null,
      kategori_item:null,
      nama_item:null,
      divisi_item:null,
      divisi_nama_item:null,
      kantor_item:null,
      kantor_nama_item:null,
      kapal_item:null,
      kapal_nama_item:null,
      umur_ekonomis_item:null,
      //daftar gudang
      gudang_item:null,
      //end
      umur_ekonomis_nama_item:null,
      //daftar gudang
      gudang_nama_item:null,
      //end
      longitude_item:null,
      latitude_item:null,
      gambar_item:null,
      id_item:null,
      masa_pakai_item:null,
      harga:null,
      pemegang:null
    };

    $rootScope.$watch('tipe' ,function(newval,oldval){
      $scope.data.tipe = newval;
    });

    $scope.remove_item = function(i){

      var itemx = $rootScope.list_item_progress[i];
      $rootScope.list_item_progress.splice(i, 1);

    }

    $scope.pilihtipeitem = function(x){
      $scope.data.tipe = x;
    }

    $scope.hapus_item = function(){

     $scope.data.id_item = null;
     $scope.data.kode_item = null;
     $scope.data.kategori_item = null;
     $scope.data.nama_item = null;
     $scope.data.divisi_item = null;
     $scope.data.divisi_nama_item = null;
     $scope.data.umur_ekonomis_item = null;
     //daftar gudang
     $scope.data.gudang_item = null;
     //end
     $scope.data.umur_ekonomis_nama_item = null;
     //daftar gudang
     $scope.data.gudang_nama_item = null;
     //end
     $scope.data.longitude_item = null;
     $scope.data.latitude_item = null;
     $scope.data.gambar_item = null;
     $scope.data.umur_ekonomis_item = null;
     $scope.data.barcode_item = null;
     $scope.data.kantor_item = null;
     $scope.data.kapal_item = null;
     $scope.data.pemegang = null;

   }



   $scope.additem = function(){

    $scope.data.kantor_nama_item = helper.fetchdata($rootScope.list_kantor,$scope.data.kantor_item);
    $scope.data.kapal_nama_item = helper.fetchdata($rootScope.list_kapal,$scope.data.kapal_item);
    $scope.data.divisi_nama_item = helper.fetchdata($rootScope.list_dept,$scope.data.divisi_item);
    $scope.data.umur_ekonomis_nama_item = helper.fetchdata($rootScope.list_umur_ekonomis,$scope.data.umur_ekonomis_item);
    //daftar gudang
    $scope.data.gudang_nama_item = helper.fetchdata($rootScope.list_gudang,$scope.data.gudang_item);
    //end
    var isi = {
      id:$scope.data.id_item,
      kode:$scope.data.kode_item,
      kategori:$scope.data.kategori_item,
      nama:$scope.data.nama_item,
      umur_ekonomis:$scope.data.umur_ekonomis_item,
      //daftar gudang
       gudang:$scope.data.gudang_item,
      //end
      umur_ekonomis_nama:$scope.data.umur_ekonomis_nama_item,
      //daftar gudang
       gudang_nama:$scope.data.gudang_nama_item,
      //end
      divisi:$scope.data.divisi_item,
      divisi_nama:$scope.data.divisi_nama_item,
      longitude:$scope.data.longitude_item,
      latitude:$scope.data.latitude_item,
      kantor:$scope.data.kantor_item,
      kantor_nama:$scope.data.kantor_nama_item,
      kapal:$scope.data.kapal_item,
      kapal_nama:$scope.data.kapal_nama_item,
      gambar:$scope.data.gambar_item,
      barcode:$scope.data.barcode_item,
      harga:$scope.data.harga,
      pemegang:$scope.data.pemegang
    };

    if(!isi.kode){
      alert("Item tidak boleh kosong");
    } else {
      $rootScope.list_item_progress[isi.id] = isi;
      $scope.hapus_item();
    }
   }

   $scope.tambah_item = function(){

    if($scope.data.kapal_item){

//ini
      $http({
        method: 'GET',
        url: 'index.php/administration/data_kapal?id='+$scope.data.kapal_item+'&limit=9999',
      }).then(function successCallback(response) {

        var mydata = response.data.rows;

        $scope.data.kantor_item = mydata[0].district_id;
        $scope.additem();

      }, function errorCallback(response) {

      });

    } else {

      $scope.additem();

    }

  }

  $scope.ubah_komponisasi = function(item,i){
    $rootScope.current_komponisasi = i;
  }

  $scope.ubah_item = function(item,i){

    var itemx = _.find($rootScope.list_item_progress, ['kode', i]);
    var i = _.findIndex($rootScope.list_item_progress, ['kode', i]);

    $scope.data.id_item = i;
    $scope.data.kode_item=itemx.kode;
    $scope.data.kategori_item=itemx.kategori;
    $scope.data.nama_item=itemx.nama;
    $scope.data.divisi_item=itemx.divisi;
    $scope.data.divisi_nama_item=itemx.divisi_nama;
    $scope.data.kantor_item=itemx.kantor;
    $scope.data.kantor_nama_item=itemx.kantor_nama;
    $scope.data.kapal_item=itemx.kapal;
    $scope.data.kapal_nama_item=itemx.kapal_nama;
    $scope.data.longitude_item=itemx.longitude;
    $scope.data.latitude_item=itemx.latitude;
    $scope.data.gambar_item=itemx.gambar;
    $scope.data.umur_ekonomis_item=itemx.umur_ekonomis;
    //daftar gudang
    $scope.data.gudang_item=itemx.gudang;
    //end
    $scope.data.umur_ekonomis_nama_item=itemx.umur_ekonomis_nama;
     //daftar gudang
    $scope.data.gudang_nama_item=itemx.gudang_nama;
    //end
    $scope.data.barcode_item=itemx.barcode;
    $scope.data.harga = itemx.harga;
    $scope.data.pemegang = itemx.pemegang;

    $scope.data.lokasi = "ktr";
    if(itemx.kapal){
      $scope.data.lokasi = "kpl";
    }

    $("#nama_item").focus();

  }

  $scope.ambil_item = function(){

    var id = $scope.data.kode_item;

//if($rootScope.last_progress){

  if($scope.data.tipe == "AST"){

    $http({
      method: 'GET',
      url: 'index.php/aset/data_aset?id='+id,
    }).then(function successCallback(response) {

      var mydata = response.data.rows[0];
      console.log(mydata);

      if(mydata){
        $scope.data.kode = mydata.kode_barang;
        $scope.data.deskripsi = mydata.nama_barang;
        $scope.data.jumlah = mydata.jumlah_barang;
        $scope.data.satuan = mydata.nama_satuan;
        $scope.data.harga_satuan = mydata.harga_perolehan;
        $scope.data.keterangan = "";

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
      console.log(mydata);

      if(mydata){
        $scope.data.kode = mydata.kode;
        $scope.data.deskripsi = mydata.deskripsi;
        $scope.data.jumlah = mydata.jumlah;
        $scope.data.satuan = mydata.satuan;
        $scope.data.harga_satuan = mydata.harga_satuan;
        $scope.data.keterangan = "";

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
    }

  }, function errorCallback(response) {

  });

}

//}

}

$scope.insert_item = function(){

  var jumlah = moneytoint($scope.data.jumlah_penerimaan);

  for (var i = 1; i <= jumlah; i++) {

    var maxid = _.maxBy($rootScope.list_item_progress, 'id');

    maxid = (parseInt(maxid)) ? parseInt(maxid) : 1;

    var kode = $rootScope.last_progress+"-"+$scope.data.kode+"-"+i;

    var isi = {
      id:maxid,
      kode:kode,
      kode_barang:$scope.data.kode,
      kategori:null,
      nama:$scope.data.deskripsi,
      harga:moneytoint($scope.data.harga_satuan),
      divisi:null,
      divisi_nama:null,
      kantor:null,
      kantor_nama:null,
      longitude:null,
      latitude:null,
      gambar:null,
      umur_ekonomis:null,
      barcode:null,
      komponisasi:$rootScope.default_komponisasi_value,
    };

    $rootScope.list_item_progress.push(isi);

  }

  $rootScope.list_item_progress = _.uniqBy($rootScope.list_item_progress, 'kode');

  $scope.data.harga = null;
  $scope.data.kode = null;
  $scope.data.deskripsi = null;
  $scope.data.jumlah = null;
  $scope.data.satuan = null;
  $scope.data.harga_satuan = null;
  $scope.data.keterangan = null;
  $scope.data.jumlah_penerimaan = null;

}

}])

.controller('form_head_pencatatan', ['$scope','$http','$rootScope','helper','$sce','$timeout', 
  function($scope,$http,$rootScope,helper,$sce,$timeout) {
  

    $scope.data = {
      no_kontrak:'',
      nama_vendor:'',
      nomor:'AUTO NUMBER',
      keterangan:'',
      tipe:'',
      jenis:'',
      //hlmifzi
      jenis_asdp:'',
      isAsetBerkala:'',
      //end
      no_progress:null,
      tanggal:new Date(),
      nama_tipe:'',
      list_tipe:[],
      kode_item:null,
      kategori_item:null,
      nama_item:null,
      divisi_item:null,
      divisi_nama_item:null,
      kantor_item:null,
      kantor_nama_item:null,
      umur_ekonomis_item:null,
      //daftar gudang
      gudang_item:null,
      //end
      umur_ekonomis_nama_item:null,
      //daftar gudang
      gudang_nama_item:null,
      //end
      longitude_item:null,
      latitude_item:null,
      gambar_item:null,
      id_item:null,
      lama_pakai:0
    };

    $scope.$watch('tipe' ,function(newval,oldval){
      $rootScope.tipe = newval;
    });

    $rootScope.list_item_progress = [];

    angular.element("#no_progress").change(function(){
      var isi = this.value;
      alert(isi);
      if(isi !== null && $rootScope.last_progress != isi){
        $scope.getprogress(isi);
      }

    });

/*
$scope.hitungpenyusutan = function(){
  $scope.data.penyusutan = 0;
  var totalbulan = monthDiff(new Date($scope.data.tanggal),new Date($scope.data.masa_pakai));
  $scope.data.lama_pakai = (isNaN(totalbulan)) ? 0 : totalbulan;
  if($scope.data.jenis != 'TA'){
    var perolehan = moneytoint($scope.data.contract_amount);
    
    var penyusutan = perolehan - (perolehan/totalbulan);
    
    //$scope.data.penyusutan = (isNaN(penyusutan)) ? 0 : inttomoney(penyusutan);
  } 
}*/

$scope.getprogress = function(no_progress){

 $http.get("index.php/aset/data_item_aset").then(function(res){

  var d = res.data;

  $http.get("index.php/contract/data_progress/ast/"+no_progress).then(function(res){

    var header = res.data.header;
    var item = res.data.item;

    $rootScope.tipekontrak = res.data.type;

    if(header){
      $scope.data.no_kontrak = header.contract_number;
      var x = "<a href='index.php/contract/lihat_progress_"+$rootScope.tipekontrak+"/"+res.data.progress_id+"' target='_blank'>"+header.progress_number+" - "+header.progress_description+"</a>";
      $scope.data.progress = $sce.trustAsHtml(x);
      $scope.data.nama_vendor = header.vendor_name;
      $rootScope.last_progress = res.data.progress_id;
      $scope.data.contract_amount = header.contract_amount;
      if(!$scope.data.tanggal){
        $scope.data.tanggal = new Date(header.created_date);
      }
    }

    if(d.total == 0){

     if(item && $rootScope.tipekontrak == "wo"){

      $rootScope.list_item_progress = [];


      angular.forEach(item, function(value, key) {

        var jumlah = moneytoint(value.jumlah);

        for (var i = 1; i <= jumlah; i++) {

          var kode = res.data.progress_id+"-"+value.id+"-"+i;

          var isi = {
            id:value.id,
            kode:kode,
            kode_barang:value.kode,
            kategori:null,
            nama:value.deskripsi,
            harga:moneytoint(value.harga_satuan),
            divisi:null,
            divisi_nama:null,
            kantor:null,
            kantor_nama:null,
            longitude:null,
            latitude:null,
            gambar:null,
            umur_ekonomis:null,
            barcode:null,
            pemegang:null,
            komponisasi:$rootScope.default_komponisasi_value,
          };

          $rootScope.list_item_progress.push(isi);

        }

      });

      $rootScope.list_item_progress = _.uniqBy($rootScope.list_item_progress, 'kode');

    }

    $rootScope.list_item_progress_head = item;

  } else {

    angular.forEach(d.rows, function(value, key) {

      var umur_ekonomis_nama = helper.fetchdata($rootScope.list_umur_ekonomis,value.umur_ekonomis);
      var kapal_nama = helper.fetchdata($rootScope.list_kapal,value.ship_id);
      var divisi_nama = helper.fetchdata($rootScope.list_dept,value.dept_id);
      //daftar gudang
      var gudang_nama = helper.fetchdata($rootScope.list_gudang,value.name_war);
      //end
      var kantor_nama = helper.fetchdata($rootScope.list_kantor,value.district_id);

      var isi = {
        id:value.id,
        kode:value.id,
        kode_barang:value.kode,
        kategori:value.nama_kategori,
        nama:value.deskripsi,
        kapal:value.ship_id,
        kapal_nama:kapal_nama,
        divisi:value.dept_id,
        divisi_nama:divisi_nama,
        kantor:value.district_id,
        kantor_nama:kantor_nama,
        longitude:value.longitude,
        latitude:value.latitude,
        gambar:value.photo,
        //daftar gudang
        gudang:value.gudang,
        gudang_nama:gudang_nama,
        //end
        umur_ekonomis:value.umur_ekonomis,
        umur_ekonomis_nama:umur_ekonomis_nama,
        barcode:value.barcode,
        komponisasi:value.komposisi,
        harga:value.harga_satuan,
        pemegang:value.pemegang,
        //daftar gudang
        gudang_nama:value.name_war,
        //end
      };

      $rootScope.list_item_progress.push(isi);

    });

    $rootScope.list_item_progress_head = d.rows;

  }

  $rootScope.list_item_progress = _.uniqBy($rootScope.list_item_progress, 'kode');

});

});

}

$scope.reload_type = function(){

  $scope.data.list_tipe = [
  {id: '', name: 'Pilih'},
  {id: 'K', name: 'Komponen'},
  {id: 'NK', name: 'Non Komponen'},
  ];

  $scope.data.list_jenis = [
  {id: '', name: 'Pilih'},
  {id: 'BA', name: 'Bangunan'},
  {id: 'AA', name: 'Alat Angkutan'},
  {id: 'TA', name: 'Tanah'},
  {id: 'JE', name: 'Jembatan'},
  {id: 'ME', name: 'Mesin'},
  {id: 'JA', name: 'Jaringan'},
  {id: 'AB', name: 'Alat Berat'},
  ];

  //hlmifzi
   $scope.data.list_jenis_asdp = [
  {id: '', name: 'Pilih'},
  {id: '1', name: 'Tanah dan DLKP-DLKR',id_jenis:'BA'},
  {id: '2', name: 'Software Sistem dan Aplikasi', id_jenis:'BA'},
  {id: '3', name: 'Permesinan dan Kelistrikan',  id_jenis:'BA'},
  {id: '4', name: 'Peralatan Pelabuhan', id_jenis:'BA'},
  {id: '5', name: 'Peralatan Kerja', id_jenis:'BA'},
  {id: '6', name: 'Peralatan Kantor', id_jenis:'BA'},
  {id: '7', name: 'Konstruksi Kapal dan Komponenisasi', id_jenis:'BA'},
  {id: '8', name: 'Kendaraan Operasional', id_jenis:'BA'},
  {id: '9', name: 'Instalasi', id_jenis:'BA'},
  {id: '10', name: 'Hardware dan Jaringan', id_jenis:'BA'},
  {id: '11', name: 'Fasilitas Dermaga', id_jenis:'BA'},
  {id: '12', name: 'Bangunan Rumah Dinas', id_jenis:'BA'},
  {id: '13', name: 'Bangunan Pelabuhan', id_jenis:'BA'},
  {id: '14', name: 'Bangunan Kantor Perusahaan', id_jenis:'BA'},
  {id: '15', name: 'Akomodasi dan Perlengkapan Kapal', id_jenis:'BA'},
  {id: '16', name: 'Kendaraan Fasilitas Pendukung Pelabuhan', id_jenis:'BA'},
  ];
  //end

}

$http.get("index.php/aset/get_head_acquisition").then(function(res){

  var d = res.data;

  if(d != null){

    d.tanggal = (d.tanggal) ? new Date(d.tanggal) : null;

    $scope.data = d;

    $timeout(function(){

      $scope.reload_type();

      $rootScope.tipe = d.tipe;

      $scope.data.nama_tipe = helper.fetchdata($scope.data.list_tipe,d.tipe);
      $scope.data.nama_jenis = helper.fetchdata($scope.data.list_jenis,d.jenis);
      //hlmifzi
      $scope.data.nama_jenis_asdp = helper.fetchdata($scope.data.list_jenis_asdp,d.jenis_asdp);
      //end

      $scope.data.nomor = ($scope.data.nomor) ? $scope.data.nomor : "AUTO NUMBER";

    //$scope.hitungpenyusutan();

    $scope.getprogress("");


  },500);

  }

});


}])

.controller('form_head_mutasi', ['$scope','$http','helper','$rootScope', '$timeout',
  function($scope,$http,helper,$rootScope,$timeout) {

    $scope.data = {
      nomor:'AUTO NUMBER',
      keterangan:'',
      jenis:'',
      kantor:'',
      dept:'',
      kapal:'',
      list_jenis: [
      {id:"",name:"Pilih"},
      {id:'K', name:'Kapal'},
      {id:'B', name:'Barang'},
      ],
    };

    $scope.pilihgudang = function(){
      $rootScope.gudang = $scope.data.gudang;
    }

    $http.get("index.php/aset/get_head_relocation").then(function(res){

      var d = res.data;

      if(d != null){

        $scope.data = d;

        $scope.data.nomor = (d.nomor) ? d.nomor : "AUTO NUMBER";

        if(parseInt(d.tipe) == 2){
          $scope.data.list_jenis = [
          {id:"",name:"Pilih"},
          {id:'B', name:'Barang'},
          ];
          $scope.data.jenis = 'B';
        } else {
          $scope.data.list_jenis = [
          {id:"",name:"Pilih"},
          {id:'K', name:'Kapal'},
          {id:'B', name:'Barang'},
          ];
          $scope.data.jenis = d.jenis;
        }

        //var param = "job_title=PIC ASET"+"&district_id="+d.kantor+"&dept_id="+d.dept;
        var param = "job_title=PIC ASET&district_id="+d.kantor;
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
            $scope.data.nama_petugas = helper.fetchdata($scope.data.list_petugas,parseInt(d.pic_id));
          }

        }, function errorCallback(response) {

        });
        $rootScope.reloaddept(d.kantor);
        $timeout(function(){

          $scope.data.nama_dept = helper.fetchdata($rootScope.list_dept,parseInt(d.dept));
          $scope.data.nama_kantor = helper.fetchdata($rootScope.list_kantor,parseInt(d.kantor));
          $scope.data.nama_kapal = helper.fetchdata($rootScope.list_kapal,d.kapal);
          $scope.data.nama_jenis = helper.fetchdata($scope.data.list_jenis,d.jenis);
          $scope.data.nama_gudang = helper.fetchdata($rootScope.list_gudang,d.gudang);

        },1000);

      }

    });

  }])

.controller('form_head_opname', ['$scope','$http','$rootScope','$timeout', 'helper',
  function($scope,$http,$rootScope,$timeout,helper) {

    $scope.data = {
      nomor:'AUTO NUMBER',
      keterangan:'',
      judul:'',
      pelaksana:'',
      status:'',

    };

    $http.get("index.php/aset/get_head_opname").then(function(res){

      var d = res.data;

      if(d != null){

       $timeout(function(){
        d.tgl_mulai = new Date(d.tgl_mulai);
        d.tgl_selesai = new Date(d.tgl_selesai);
        d.list_attr = [
        {id: '', name: 'Pilih'},
        {id: 'B', name: 'Blind'},
        {id: 'O', name: 'Open'},
        ];
        d.nomor = (d.nomor) ? d.nomor : "AUTO NUMBER";
        d.nama_attr = helper.fetchdata(d.list_attr,d.attr);
        console.log(d);
        $scope.data = d;
        
      },1000);

       var dist = (parseInt(d.district_id) == 1) ? "" : d.district_id;
       var param = "district_id="+dist;
       $rootScope.list_petugas = [{id:"",name:"Pilih"}];

       $http({
        method: 'GET',
        url: 'index.php/administration/data_user_list?limit=9999&'+param,
      }).then(function successCallback(response) {

        var mydata = response.data.rows;

        if(mydata){
          $rootScope.list_petugas = [{id:"",name:"Pilih"}];
          angular.forEach(mydata, function(value, key) {
            $rootScope.list_petugas.push({id:value.employee_id,name:value.complete_name+" - "+value.job_title}); //rev district_name diubah jadi job_title
          });
          $rootScope.list_petugas = _.uniqBy($rootScope.list_petugas, 'id');
        }

      }, function errorCallback(response) {

      });

      $rootScope.list_gudang = [{id:"",name:"Pilih"}];
      var param = "kantor="+d.district_id;
      $http({
        method: 'GET',
        url: 'index.php/administration/data_gudang?limit=9999&'+param,
      }).then(function successCallback(response) {

        var mydata = response.data.rows;

        if(mydata){
         angular.forEach(mydata, function(value, key) {
          var x = (parseInt(value.type_war) == 0) ? "Kantor" : "Kapal";
          $rootScope.list_gudang.push({id:value.id_war,name:value.name_war+" - "+x});
        });
       }

     }, function errorCallback(response) {

     });

    }

  });

  }])

.controller('form_head_penghapusan', ['$scope','$http','$timeout','helper', 
  function($scope,$http,$timeout,helper) {

    $scope.data = {
      nomor:'AUTO NUMBER',
      keterangan:'',
      usulan:'',
    };

    $http.get("index.php/aset/get_head_disposal").then(function(res){

      var d = res.data;

      if(d != null){

        $scope.data = d;
        $scope.data.nomor = (d.nomor) ? d.nomor : "AUTO NUMBER";

    //var param = "job_title=PIC ASET"+"&district_id="+d.district_id+"&dept_id="+d.dept_id;
    var param = "job_title=PIC ASET"+"&district_id="+d.district_id;
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
        $scope.data.nama_petugas = helper.fetchdata($scope.data.list_petugas,d.id_petugas);
      }

    }, function errorCallback(response) {

    });



  }

});

  }])


.controller('form_head_kondisi', ['$scope','$http','$timeout','helper','$rootScope', 
  function($scope,$http,$timeout,helper,$rootScope) {

    $scope.data = {
      nomor:'',
      keterangan:'',
      mitra:'',
      kondisi:'',
      tanggal:'',
    };

    $scope.ambil_item = function(){

      var id = $scope.data.aset_id;

      $http({
        method: 'GET',
        url: 'index.php/aset/data_aset?id='+id,
      }).then(function successCallback(response) {

        var mydata = response.data.rows[0];

        if(mydata){
         $scope.data.barang = mydata;
       }

     }, function errorCallback(response) {

     });

    }

    $http.get("index.php/aset/get_head_maintenance").then(function(res){

      var d = res.data;

      if(d != null){

        d.tanggal = new Date(d.tanggal);

        $scope.data = d;

        $scope.data.biaya = d.biaya;

        $scope.data.nomor = (d.nomor) ? d.nomor : "AUTO NUMBER";

        $timeout(function(){
         $scope.data.nama_kondisi = helper.fetchdata($rootScope.list_kondisi,$scope.data.kondisi);
         $scope.ambil_item();
       },100);

      }

    });


  }])

.controller('form_tim_opname', ['$scope','$http','helper','$rootScope','$timeout', 
  function($scope,$http,helper,$rootScope,$timeout) {

    $scope.data = {
      posisi_id_inp:"",
      petugas_name_inp:"",
      petugas_id_inp:"",
      keterangan_inp:"",
      current_opname_inp:"",
      posisi_nama_inp:"",
      lokasi:"",
      lokasi_nama:"",
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

    $http.get("index.php/aset/get_audit_pelaksana").then(function(res){

      var d = res.data;

      if(d != null){

        $timeout(function(){

          angular.forEach(d, function(value, key) {

            value.posisi_nama = helper.fetchdata($scope.data.list_posisi_pelaksana,value.posisi);
            var lid = value.lokasi_id;
            value.lokasi = value.lokasi_tipe;
            if(value.lokasi_tipe == "gdg"){
              value.lokasi_tipe = "Gudang";
              value.lokasi_nama = helper.fetchdata($rootScope.list_gudang,lid);
              console.log(value.lokasi_nama);
              console.log(lid);
            } else if(value.lokasi_tipe == "ktr"){
              value.lokasi_tipe = "Kantor";
              value.lokasi_nama = helper.fetchdata($rootScope.list_kantor,lid);
            } else {
              value.lokasi_tipe = "Kapal";
              value.lokasi_nama = helper.fetchdata($rootScope.list_kapal,lid);
            }
            console.log(value);
            d[key] = value;

          });

          console.log(d);

          $rootScope.list_tim_opname = d;

        },1000);

      }

    });


    $scope.reloadlokasi = function(){
      $scope.data.gudang = "";
      $scope.data.kantor = "";
      $scope.data.kapal = ""
    }

    $scope.hapuspetugas = function(){
      $scope.data.petugas_name_inp = "";
      $scope.data.petugas_id_inp = "";
      $scope.data.keterangan_inp = "";
      $scope.data.current_opname_inp = "";
      $scope.data.posisi_id_inp = "";
      $scope.data.posisi_nama_inp = "";
      $scope.data.lokasi = "";
      $scope.data.lokasi_nama = "";
    }

    $scope.tambahpetugas = function(){

      var k = 0;

      angular.forEach($rootScope.list_tim_opname, function(value, key) {
        k += (value.posisi == '0') ? 1 : 0;
      });

      if($scope.data.petugas_id_inp == ""){
        alert("Pilih pelaksana");
      } else if($scope.data.posisi_id_inp == ""){
       alert("Pilih posisi");
     }else if($scope.data.gudang == "" && $scope.data.kantor == "" && $scope.data.kapal == ""){
       alert("Pilih gudang / kantor / kapal");
     } else if(k > 0 && $scope.data.posisi_id_inp == '0'){
      alert("Ketua hanya satu");
    } else {

      var posisi_nama = helper.fetchdata($scope.data.list_posisi_pelaksana,$scope.data.posisi_id_inp);
      var nama = helper.fetchdata($rootScope.list_petugas,$scope.data.petugas_id_inp);
      var id = ($scope.data.current_opname_inp == "") ? $rootScope.list_tim_opname.length+1 : $scope.data.current_opname_inp;

      var lokasi_nama = "";
      var lokasi_id = null;
      var lokasi_tipe = "";

      if($scope.data.lokasi == "gdg"){
        lokasi_tipe = "Gudang";
        lokasi_id = $scope.data.gudang;
        lokasi_nama = helper.fetchdata($rootScope.list_gudang,$scope.data.gudang);
      } else if($scope.data.lokasi == "ktr"){
        lokasi_tipe = "Kantor";
        lokasi_id = $scope.data.kantor;
        lokasi_nama = helper.fetchdata($rootScope.list_kantor,$scope.data.kantor);
      } else {
        lokasi_tipe = "Kapal";
        lokasi_id = $scope.data.kapal;
        lokasi_nama = helper.fetchdata($rootScope.list_kapal,$scope.data.kapal);
      }

      var isi = {
        id:id,
        userid:$scope.data.petugas_id_inp,
        nama:nama,
        posisi:$scope.data.posisi_id_inp,
        posisi_nama:posisi_nama,
        lokasi_nama:lokasi_nama,
        lokasi:$scope.data.lokasi,
        lokasi_id:lokasi_id,
        lokasi_tipe:lokasi_tipe,
        keterangan:$scope.data.keterangan_inp,
      };

      $rootScope.list_tim_opname.push(isi);

      $scope.hapuspetugas();

    }

  }

  $scope.ubahpetugas = function(item,i){

    var itemx = $rootScope.list_tim_opname[i];
    item.splice(i, 1);

    $scope.data.petugas_name_inp = itemx.nama;
    $scope.data.petugas_id_inp = itemx.userid;
    $scope.data.keterangan_inp = itemx.keterangan;
    $scope.data.current_opname_inp = itemx.id;
    $scope.data.posisi_id_inp = itemx.posisi;
    $scope.data.posisi_nama_inp = itemx.posisi_nama;
    $scope.data.lokasi = itemx.lokasi;
    $scope.data.lokasi_nama = itemx.lokasi_nama;

    if(itemx.lokasi == "gdg"){
      $scope.data.gudang = itemx.lokasi_id;
    } else if(itemx.lokasi == "ktr"){
      $scope.data.kantor = itemx.lokasi_id;
    } else {
      $scope.data.kapal = itemx.lokasi_id;
    }

  }

}])
.controller('form_item_opname', ['$scope','$http','helper','$rootScope', function($scope,$http,helper,$rootScope) {

  $scope.data = {
    list_item_opname : [],
  };

  $http.get("index.php/aset/data_item_aset").then(function(res){

    var d = res.data;

   
    $scope.data.list_item_opname = d.rows; 
    

  });


  $scope.simpan = function(){

    var index = $scope.data.index;

    $scope.data.list_item_opname[index] = $scope.data.input;

    $scope.hapus();

  }

  $scope.hapus = function(){
    $scope.data.input = {};
  }

  $scope.ubah = function(item,i){
    $scope.data.index = i;
    $scope.data.input = item;
    console.log(item);
  }

}])

.controller('form_laporan_opname', ['$rootScope','$scope','$http','helper','$timeout', function($rootScope,$scope,$http,helper,$timeout) {

  $scope.data = {
    input:{},
    list_item: [],
  };

  $http.get("index.php/aset/get_laporan_opname").then(function(res){

    var d = res.data;

    console.log(d);

    if(d != null){
      $scope.data.list_item = d;
    }

  });


  $scope.ubah_item = function(item,i){

    var itemx = $scope.data.list_item[i];
    $scope.data.list_item.splice(i, 1);

  }

  $scope.hapus_item = function(){

    $scope.data.input = {};

  }

  $scope.tambah_item = function(){

    var gbr = $scope.data.input.gambar;

    var isi = $scope.data.input.keterangan;

    if(!gbr){

      alert("Gambar harus diupload");

    } else if(!isi){

      alert("Isi keterangan");

    } else {

      $scope.data.list_item.push($scope.data.input);

      $scope.hapus_item();

    }

  }

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

  $http.get("index.php/aset/get_gudang_item_penyimpanan").then(function(res){

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

    $rootScope.list_gudang = [{id:"",name:"Pilih"}];

    $http({
      method: 'GET',
      url: 'index.php/administration/data_gudang?limit=9999&kantor='+$scope.data.kantor,
    }).then(function successCallback(response) {

      var mydata = response.data.rows;

      if(mydata){
       angular.forEach(mydata, function(value, key) {
        var x = (parseInt(value.type_war) == 0) ? "Kantor" : "Kapal";
        $rootScope.list_gudang.push({id:value.id_war,name:value.name_war+" - "+x});
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

  $scope.data.gudang_nama = helper.fetchdata($rootScope.list_gudang,$scope.data.gudang);

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

  $http.get("index.php/aset/get_header_distribution").then(function(res){

    var d = res.data;

    $scope.data.kantor = d.district_id_tujuan;

    $scope.data.dept = d.dept_id_tujuan;

    $scope.data.pic = d.pic_id;

    $scope.data.lokasi = (parseInt(d.dept_id_tujuan) == 0) ? "k" : "d";

    $scope.reloadpic();

  });

  $scope.reloadpic = function(){

    var job_title = "PIC";

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
.controller('form_item_mutasi', ['$scope','$http','$rootScope', function($scope,$http,$rootScope) {

  $scope.data = {
    kode:"",
    deskripsi:"",
    jumlah:"",
    satuan:"",
    harga_satuan:"",
    keterangan:"",
    merk:"",
    part_number:"",
    tipe:"AST",
  };

  $scope.hapus_item = function(){

    $scope.data.barang = {};
    $scope.data.aset_id = null;

  }

  $scope.pilihtipeitem = function(x){
    $scope.data.tipe = x;
  }

  $scope.tambah_item = function(){

    var id = parseInt($scope.data.aset_id);

    var isi = $scope.data.barang;

    if(!id){

      alert("Barang harus dipilih");

    } else {

      $scope.data.list_item.push(isi);

      console.log($scope.data.list_item);

      $scope.hapus_item();

    }

  }

  $scope.ubah_item = function(item,i){

    var itemx = $scope.data.list_item[i];
    item.splice(i, 1);

  }

  $scope.ambil_item = function(){

    var id = $scope.data.aset_id;

    $http({
      method: 'GET',
      url: 'index.php/aset/data_aset?id='+id,
    }).then(function successCallback(response) {

      var mydata = response.data.rows[0];

      if(mydata){
       $scope.data.barang = mydata;
     }

   }, function errorCallback(response) {

   });

  }

  $http.get("index.php/aset/data_item_aset").then(function(res){

    var d = res.data;

    $scope.data.list_item = d.rows;

  });

}])

.controller('form_item_pr', ['$scope','$http','$rootScope', function($scope,$http,$rootScope) {

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
      url: 'index.php/aset/data_aset?id='+id,
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

  $http.get("index.php/aset/data_item_aset?limit=9999").then(function(res){

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

  $scope.data.list_status = [
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

    isi.status_name = helper.fetchdata($scope.data.list_status,isi.status);

    angular.forEach($scope.data.list_item, function(value, key) {
      if(value.kode+value.merk+value.part_number == isi.kode+isi.merk+isi.part_number){
        $scope.data.list_item.splice(key, 1);
      }
    });

    if($scope.data.deskripsi == ""){

      alert("Deskripsi tidak boleh kosong");

    }else if(parseInt($scope.data.stok) == 0){

      alert("Stok tidak boleh kosong");

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
      url: 'index.php/aset/data_aset?id='+id,
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

  $http.get("index.php/aset/data_item_aset?limit=9999").then(function(res){

    var d = res.data;

    $scope.data.list_item = d.rows;

  });

}])
;

