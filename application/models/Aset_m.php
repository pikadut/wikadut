<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aset_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getAcquisition($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("ast_acquisition_header a");

	}

	public function getDisposal($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("ast_disposal_header a");

	}

	public function getMaintenance($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("ast_maintenance_header a");

	}

	public function getAudit($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("ast_audit_header a");

	}


	public function getAuditReport($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("audit_id",$header);

		}


		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("ast_audit_result_header a");

	}

	public function getRelocation($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("ast_relocation_header a");

	}

	public function getAuditUser($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("audit_id",$header);

		}


		if(!empty($id)){

			$this->db->where("id",$id);

		}

		$this->db->join("adm_warehouse b","b.id_war=a.lokasi_id","left")
		->join("adm_district d","d.district_id=a.lokasi_id","left")
		->join("adm_ship e","e.id_ship=a.lokasi_id","left");

		return $this->db->get("ast_audit_panitia a");

	}


	public function urutDisposal($tahun = ""){

		return $this->generateUrut("nomor","ast_disposal_header","DMAA.RMV");

	}

	public function urutRelocation($tahun = ""){

		return $this->generateUrut("nomor","ast_relocation_header","DMAA.RLO");

	}

	public function urutMaintenance($tahun = ""){

		return $this->generateUrut("nomor","ast_maintenance_header","DMAA.MTN");

	}

	public function urutAudit($tahun = ""){

		return $this->generateUrut("nomor","ast_audit_header","DMAA.SO");

	}

	public function urutAcquisition(){

		return $this->generateUrut("nomor","ast_acquisition_header","DMAA");

	}

	public function generateUrut($field_id,$table_name,$prefix){

		$userdata = $this->Administration_m->getLogin();

		$y = $this->Administration_m->getDistrict($userdata['district_id'])->row()->district_prefix;

		$x = "/".$prefix."/".$y."/".romanic_number(date("m"))."/ASDP-".date('Y');

		$this->db->like($field_id, $x,false);

		$this->db->select("COUNT($field_id) as urut");

		$get = $this->db->get($table_name)->row()->urut;

		return urut_id($get+1,3).$x;

	}
		//haqim
		// public function generateBarcode($id,$kode_barang){
		public function generateBarcode($kode_barang,$id=''){
		//end

		$userdata = $this->Administration_m->getLogin();

		$digits = 5;
		$number =rand(pow(10, $digits-1), pow(10, $digits)-1);
		$id = $number;

		$x = $id.".".$kode_barang.".";

		$this->db->like("barcode", $kode_barang,false);

		$this->db->select("COUNT(id) as urut");

		$get = $this->db->get("ast_acquisition_item")->row()->urut;

		return $x.urut_id($get+1,3);

	}


	public function insertAcquisition($input){

		if (!empty($input)){

			$this->db->insert("ast_acquisition_header",$input);

			return $this->db->insert_id();

		}

	}

	public function insertAudit($input){

		if (!empty($input)){

			$this->db->insert("ast_audit_header",$input);

			return $this->db->insert_id();

		}

	}


	public function insertRelocation($input){

		if (!empty($input)){

			$this->db->insert("ast_relocation_header",$input);

			return $this->db->insert_id();

		}

	}

	public function insertMaintenance($input){

		if (!empty($input)){

			$this->db->insert("ast_maintenance_header",$input);

			return $this->db->insert_id();

		}

	}

	public function updateMaintenance($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('ast_maintenance_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateRelocation($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('ast_relocation_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateAudit($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('ast_audit_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateAcquisition($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('ast_acquisition_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function rollbackcomment($id,$lastActivity){
		return $this->db
		->where(array("id"=>$id))
		->update("ast_comment",array(
			"respon" => null,
			"nama" => null,
			"updated_date" => null,
			"komentar" => null,
			"dokumen" => null,
			"updated_by" => null,
			"activity_id"=>$lastActivity
			));
	}

	public function deleteAcquisitionItemDist($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("acquisition_id",$header);

			}

			$this->db->delete('ast_acquisition_dist');

			return $this->db->affected_rows();

		}

	}

	public function insertAcquisitionItemDist($input){

		if (!empty($input)){

			$this->db->insert("ast_acquisition_dist",$input);

			return $this->db->insert_id();
		}

	}

	public function insertRelocationItem($input){

		if (!empty($input)){

			$this->db->insert("ast_relocation_item",$input);

			return $this->db->insert_id();
		}

	}

	public function insertAuditUser($input){

		if (!empty($input)){

			$this->db->insert("ast_audit_panitia",$input);

			return $this->db->insert_id();
		}

	}

	public function deleteRelocationItem($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("relocation_id",$header);

			}

			$this->db->delete('ast_relocation_item');

			return $this->db->affected_rows();

		}

	}

	public function deleteAuditUser($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("audit_id",$header);

			}

			$this->db->delete('ast_audit_panitia');

			return $this->db->affected_rows();

		}

	}

	public function deleteAcquisitionItem($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("acquisition_id",$header);

			}

			$this->db->delete('ast_acquisition_item');

			return $this->db->affected_rows();

		}

	}

	public function insertAcquisitionItem($input){

		if (!empty($input)){

			$this->db->insert("ast_acquisition_item",$input);

			return $this->db->insert_id();
		}

	}

	public function getRelocationItem($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("a.relocation_id",$header);

		}

		if(!empty($id)){

			$this->db->where("a.id",$id);

		}

		$this->db->join("ast_aset_header b","b.id=a.aset_id");

		return $this->db->get("ast_relocation_item a");

	}

	public function getAuditItem($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("x.audit_id",$header);

		}

		if(!empty($id)){

			$this->db->where("x.id",$id);

		}

		$this->db->join("ast_audit_result_item x","a.id=x.aset_id","left");

		return $this->getHeader();

	}

	public function deleteAuditItem($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("audit_id",$header);

			}

			$this->db->delete('ast_audit_result_item');

			return $this->db->affected_rows();

		}

	}

		public function deleteAuditReport($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("audit_id",$header);

			}

			$this->db->delete('ast_audit_result_header');

			return $this->db->affected_rows();

		}

	}

	public function insertAuditItem($input){

		if (!empty($input)){

			$this->db->insert("ast_audit_result_item",$input);

			return $this->db->insert_id();
		}

	}

		public function insertAuditReport($input){

		if (!empty($input)){

			$this->db->insert("ast_audit_result_header",$input);

			return $this->db->insert_id();
		}

	}

	public function getAcquisitionItem($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("acquisition_id",$header);

		}

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("ast_acquisition_item a");

	}

	public function getAcquisitionItemDist($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("acquisition_id",$header);

		}

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("ast_acquisition_dist a");

	}

	public function getMaintenanceItem($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("disposal_id",$header);

		}

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("ast_maintenance_item a");

	}

	public function insertDisposal($input){

		if (!empty($input)){

			$this->db->insert("ast_disposal_header",$input);

			return $this->db->insert_id();

		}

	}

	public function updateDisposal($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('ast_disposal_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function deleteDisposalItem($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("disposal_id",$header);

			}

			$this->db->delete('ast_disposal_item');

			return $this->db->affected_rows();

		}

	}

	public function deleteMaintenanceItem($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("maintenance_id",$header);

			}

			$this->db->delete('ast_maintenance_item');

			return $this->db->affected_rows();

		}

	}

	public function insertMaintenanceItem($input){

		if (!empty($input)){

			$this->db->insert("ast_maintenance_item",$input);

			return $this->db->insert_id();
		}

	}

	public function insertDisposalItem($input){

		if (!empty($input)){

			$this->db->insert("ast_disposal_item",$input);

			return $this->db->insert_id();
		}

	}

	public function getDisposalItem($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("disposal_id",$header);

		}

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		$default_select = "a.id, a.nama_barang, a.uom as nama_satuan,bastb_code as bastb, harga_perolehan,tanggal_perolehan, a.keterangan as keterangan_pencatatan,gudang_id as id_gudang, name_war as nama_gudang,a.kategori,a.kondisi,composition as komponisasi, c.district_id as id_kantor, c.district_name as nama_kantor ,status_aset as status,dept_name as nama_dept, 
		CASE status_aset
		WHEN 1 THEN 'Aktif' 
		ELSE 'Tidak Aktif'
		END as nama_status,

		CASE jenis
		WHEN 'BA' THEN 'Bangunan' 
		WHEN 'AA' THEN 'Alat Angkutan' 
		WHEN 'TA' THEN 'Tanah' 
		WHEN 'JE' THEN 'Jembatan' 
		WHEN 'ME' THEN 'Mesin' 
		WHEN 'JA' THEN 'Jaringan' 
		WHEN 'AB' THEN 'Alat Berat' 
		ELSE ''
		END as nama_jenis,

		CASE tipe
		WHEN 'N' THEN 'Komponen' 
		WHEN 'NK' THEN 'Non Komponen' 
		ELSE ''
		END as nama_tipe,
			umur_ekonomis,
		kode_barcode as barcode,a.longitude,a.latitude,a.kategori as nama_kategori,a.kode_kategori as id_kategori,jenis,nilai_buku,akumulasi_penyusutan,tipe,status_hapus,e.year as umur_ekonomis,CONCAT(e.name,' (',e.year,' tahun)') as nama_umur_ekonomis,a.created_date as tanggal_dibuat, a.updated_date as tanggal_diubah,lampiran as attachment";
		$this->db->select($default_select);
		$this->db->join("ast_disposal_item x","x.aset_id = a.id");
		$this->db->join("adm_economic_year e","e.id=a.umur_ekonomis","left");
		$this->db->join("adm_warehouse b","b.id_war=a.gudang_id","left");
		$this->db->join("adm_district c","c.district_id=a.district_id","left");
		$this->db->join("adm_dept d","d.dept_id=a.dept_id","left");

		return $this->db->get("ast_aset_header a");

	}

	public function getJoinByCommentType($type = ""){

		switch ($type) {

			case 'maintenance':
			$table = "ast_maintenance_header";
			$field_join = "maintenance_id";
			$kode_field = "nomor";
			$pekerjaan_field = "b.keterangan";
			break;

			case 'relocation':
			$table = "ast_relocation_header";
			$field_join = "relocation_id";
			$kode_field = "nomor";
			$pekerjaan_field = "b.keterangan";
			break;

			case 'disposal':
			$table = "ast_disposal_header";
			$field_join = "disposal_id";
			$kode_field = "nomor";
			$pekerjaan_field = "b.keterangan";
			break;

			//hlmifzi
			case 'aset_berkala':
			$table = "ast_acquisition_header";
			$field_join = "acquisition_id";
			$kode_field = "nomor";
			$pekerjaan_field = "b.keterangan";
			break;
			//end

			case 'audit':
			$table = "ast_audit_header";
			$field_join = "audit_id";
			$kode_field = "nomor";
			$pekerjaan_field = "b.keterangan";
			break;

			default:
			$table = "ast_acquisition_header";
			$field_join = "acquisition_id";
			$kode_field = "nomor";
			$pekerjaan_field = "b.keterangan";
			break;

		}

		return array("table"=>$table,"field"=>$field_join,"desc_field"=>$pekerjaan_field,"code_field"=>$kode_field);

	}


	public function getPekerjaan($type = "",$id = "",$dept_name = ""){

		$a = $this->getJoinByCommentType($type);

		//hlmifzi

		if($type == "aset_berkala" && (stripos($dept_name, "UMUM") !== FALSE || stripos($dept_name, "ASET") !== FALSE)){

			$this->db->select("b.id as id_pekerjaan, ".$a['code_field']." as kode_pekerjaan, DATE_FORMAT(a.created_date,'%d/%m/%Y %H:%i') as tanggal_pekerjaan,'Pembuatan Aset Berkala' as aktifitas_pekerjaan, ".$a['desc_field']." as nama_pekerjaan");

				$this->db->join($a['table']." b","b.id=a.".$a['field']);
				$this->db->join("ast_acquisition_item c","c.acquisition_id=b.id");	
				
				if(stripos($dept_name, "UMUM") !== FALSE){
					$this->db->where("b.jenis_asdp", 8);
				} else {
					$this->db->where("b.jenis_asdp !=", 8);
				}

				$this->db->where("b.isAsetBerkala", 1);
				$this->db->where("c.pemegang is not null");

				$this->db->group_by('b.keterangan');

			$x = $this->db->get("ast_comment a");
		//end
		} else if ($type != "aset_berkala"){

		$select = "a.id as id_pekerjaan, ".$a['code_field']." as kode_pekerjaan, DATE_FORMAT(a.created_date,'%d/%m/%Y %H:%i') as tanggal_pekerjaan, awa_name as aktifitas_pekerjaan, ".$a['desc_field']." as nama_pekerjaan";

		$this->db->select($select);

		$this->db->join($a['table']." b","b.id=a.".$a['field']);

		if(!empty($id)){

			$this->db->where("a.id",$id);

		}

		$this->db->join("adm_wkf_activity c","c.awa_id=a.activity_id","left");

		$this->db->where("COALESCE(respon,'')","");

		$this->db->where("COALESCE(awa_finish,0)",0);

		$this->db->order_by("a.id","desc");

		$x = $this->db->get("ast_comment a");

		}

		return $x;

	}

	public function getMonitor($type = "",$id = ""){

		$a = $this->getJoinByCommentType($type);

		if($type == "aset_berkala"){

			$this->db->select("b.id as id_monitor, ".$a['code_field']." as kode_monitor, DATE_FORMAT(a.created_date,'%d/%m/%Y %H:%i') as tanggal_monitor,'Selesai Pembuatan Aset Berkala' as aktifitas_monitor, ".$a['desc_field']." as nama_monitor");

				$this->db->join($a['table']." b","b.id=a.".$a['field']);
				$this->db->join("ast_acquisition_item c","c.acquisition_id=b.id");	

				$this->db->where("b.isAsetBerkala is not null");
				$this->db->where("c.pemegang is not null");

				$this->db->group_by('b.keterangan');

			$x = $this->db->get("ast_comment a");
		//end
		} else {
		$select = "a.id as id_monitor, ".$a['code_field']." as kode_monitor, DATE_FORMAT(a.created_date,'%d/%m/%Y %H:%i') as tanggal_monitor, (SELECT awa_name FROM adm_wkf_activity WHERE awa_id=activity_id) as aktifitas_monitor, ".$a['desc_field']." as nama_monitor";

		$this->db->select($select);

		$this->db->join("ast_comment a","b.id=a.".$a['field'],"inner");
		$this->db->join("adm_pos x","x.pos_id=a.position_id","left");

		if(!empty($id)){

			$this->db->where("a.id",$id);

		}

		$this->db->where("COALESCE(respon,'')","");

		$this->db->order_by("a.id","desc");

		$x = $this->db->get($a['table']." b");
		}
		return $x;
	}

	public function getHeader($id = "",$all = false){

		$acquisition_id = $this->session->userdata("acquisition_id");

		$activity = $this->session->userdata("activity");

		/*menambahkan diffdate, tahun_closed hlmifzi*/
		$default_select = "a.id, a.nama_barang, a.uom as nama_satuan,bastb_code as bastb, harga_perolehan,tanggal_perolehan, a.keterangan as keterangan_pencatatan,gudang_id as id_gudang, name_war as nama_gudang,a.kategori,a.kondisi as kondisi,composition as komponisasi, c.district_id as id_kantor, c.district_name as nama_kantor ,status_aset as status,d.dept_name as nama_dept, f.dept_name as dept_asal,tahun_closed,

			TIMESTAMPDIFF(month, tanggal_perolehan , now()) AS range_date,

		CASE status_aset
		WHEN 1 THEN 'Aktif' 
		ELSE 'Tidak Aktif'
		END as nama_status,

		CASE jenis
		WHEN 'BA' THEN 'Bangunan' 
		WHEN 'AA' THEN 'Alat Angkutan' 
		WHEN 'TA' THEN 'Tanah' 
		WHEN 'JE' THEN 'Jembatan' 
		WHEN 'ME' THEN 'Mesin' 
		WHEN 'JA' THEN 'Jaringan' 
		WHEN 'AB' THEN 'Alat Berat' 
		ELSE ''
		END as nama_jenis,

		CASE jenis_asdp
		WHEN '1' THEN 'Tanah dan DLKP-DLKR' 
		WHEN '2' THEN 'Software Sistem dan Aplikasi' 
		WHEN '3' THEN 'Permesinan dan Kelistrikan' 
		WHEN '4' THEN 'Peralatan Pelabuhan' 
		WHEN '5' THEN 'Peralatan Kerja' 
		WHEN '6' THEN 'Peralatan Kantor' 
		WHEN '7' THEN 'Konstruksi Kapal dan Komponenisasi'
		WHEN '8' THEN 'Kendaraan Operasional' 
		WHEN '9' THEN 'Instalasi' 
		WHEN '10' THEN 'Hardware dan Jaringan' 
		WHEN '11' THEN 'Fasilitas Dermaga' 
		WHEN '12' THEN 'Bangunan Rumah Dinas' 
		WHEN '13' THEN 'Bangunan Pelabuhan' 
		WHEN '14' THEN 'Bangunan Kantor Perusahaan'  
		WHEN '15'THEN 'Akomodasi dan Perlengkapan Kapal'
		ELSE ''

		END as nama_jenis_asdp,

		CASE tipe
		WHEN 'K' THEN 'Komponen' 
		WHEN 'NK' THEN 'Non Komponen' 
		ELSE ''
		END as nama_tipe,

		kode_barcode as barcode,a.longitude,a.latitude,a.kategori as nama_kategori,a.kode_kategori as id_kategori,jenis,nilai_buku,akumulasi_penyusutan,tipe,status_hapus,a.umur_ekonomis,CONCAT(e.name,' (',e.year,' tahun)') as nama_umur_ekonomis,a.created_date as tanggal_dibuat, a.updated_date as tanggal_diubah,lampiran_hapus,pemegang";

		$this->db->select($default_select,false);

		if(!empty($id)){
			$this->db->where("a.id",$id);
		}

		if(!$all){
			$this->db->where("COALESCE(status_hapus,'')",'');
		}

		$this->db->join("adm_economic_year e","e.id=a.umur_ekonomis","left");
		$this->db->join("adm_warehouse b","b.id_war=a.gudang_id","left");
		$this->db->join("adm_district c","c.district_id=a.district_id","left");
		$this->db->join("adm_dept d","d.dept_id=a.dept_id","left");
		$this->db->join("adm_employee_pos f","f.employee_id=a.created_by","left"); // add departement asal


		if(!empty($acquisition_id)){
			if(in_array($activity, array(4000))){
				$default_select = " a.nama_barang,merk,a.part_number,uom as nama_satuan";
			}
			$this->db->join("ast_acquisition_item f","a.id=f.acquisition_id","left");
			$this->db->where("f.acquisition_id",$acquisition_id);
		}


		$x = $this->db->get("ast_aset_header a");
		return $x;

	}

	public function getHeaderDistinct($id = ""){

	}

	public function insertHeader($input){

		if (!empty($input)){

			$this->db->insert("ast_aset_header",$input);

			return $this->db->insert_id();
		}

	}

	public function insertHeaderLog($input){

		if (!empty($input)){

			$this->db->insert("ast_aset_header",$input);

			return $this->db->insert_id();
		}

	}

	public function updateHeader($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('ast_aset_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function distributeHeader(
		$type = "",$from_id,$to_id,$kode_barang,$merk,$part_number,$jumlah,$input = array()
		){
		$check = $this->db
		->where(array("part_number"=>$part_number,"merk"=>$merk,"kode_barang"=>$kode_barang,$type=>$from_id))
		->order_by("created_date","asc")
		->get("ast_aset_header")->result_array();

		$userdata = $this->Administration_m->getLogin();

		$arrange = array();
		$d = array();
		foreach ($check as $key => $value) {
			if($jumlah > 0){
				$stock = $value['jumlah_barang'];
				$abis = ($stock-$jumlah < 0);
				$pengurangan = ($abis) ? $stock : $jumlah;
				$arrange[$value['id']] = array("id"=>$value['id'],"jumlah"=>$pengurangan,"stock"=>$stock,"abis"=>$abis);
				$d[$value['id']] = $value;
				$jumlah -= $pengurangan;
			//echo $value['id']." STOK : ".$stock." MINTA ".$arrange[$value['id']]." SISA : ".$jumlah."<br/>";
			}
		//echo $jumlah." = ".$value['id']."<br/>";
		}

		foreach ($arrange as $key => $value) {

			$where = array("id"=>$value['id']);
			$update = array("updated_date"=>date("Y-m-d H:i:s"),"updated_by"=>$userdata['id']);

			$jumlah = $value['jumlah'];
			$sisa = $value['stock']-$jumlah;

			if($abis || $sisa == 0){
				$update = array($type=>$from_id);
				$this->db->where($where)->update("ast_aset_header",$update);
			//echo $this->db->last_query()."\n";
			} else {

				$update = array("jumlah_barang"=>$sisa);
				$this->db->where($where)->update("ast_aset_header",$update);
			//echo $this->db->last_query()."\n";
				$i = $d[$value['id']];
				$i['merk'] = $merk;
				$i['part_number'] = $part_number;
				$i['jumlah_barang'] = $jumlah;
				$i['tanggal_perolehan'] = date("Y-m-d H:i:s");
				$i[$type] = $to_id;
				$i = array_merge($i,$input);
				unset($i['id']);
				$this->db->insert("ast_aset_header",$i);
			//echo $this->db->last_query()."\n";

			}

		}

	}

	public function combineHeader(
		$district_id = "",
		$gudang_id = "",
		$kode_barang = "",
		$nama_barang = "",
		$jumlah_barang = "",
		$uom = "",
		$keterangan = "",
		$merk = "",
		$part_number = "",
		$harga_satuan = "",
		$employee_id = "",
		$barcode = "",
		$others = array()
		){

		$check = array(
			"c.district_id"=>$district_id,
			"a.gudang_id"=>$gudang_id,
			"a.kode_barang"=>$kode_barang,
			"a.merk"=>$merk,
			"a.part_number"=>$part_number,
			);

		$this->db->where($check);

		$c = $this->getHeader()->row_array();

		if(!empty($c)){

			$input = array(
				"updated_date"=>date("Y-m-d H:i:s"),
				"updated_by"=>$employee_id,
				"jumlah_barang"=>$c['jumlah_barang']+$jumlah_barang,
				"tanggal_perolehan"=>date("Y-m-d H:i:s"),
				"harga_satuan"=>$harga_satuan,
				"barcode"=>$barcode
				);

			$input = array_merge($input,$others);

			$act = $this->updateHeader($c['id'],$input);

		} else {

			$input = array(
				"created_date"=>date("Y-m-d H:i:s"),
				"created_by"=>$employee_id,
				"jumlah_barang"=>$jumlah_barang,
				"tanggal_perolehan"=>date("Y-m-d H:i:s"),
				"harga_satuan"=>$harga_satuan,
				"uom"=>$uom,
				"district_id"=>$district_id,
				"gudang_id"=>$gudang_id,
				"kode_barang"=>$kode_barang,
				"keterangan"=>$keterangan,
				"merk"=>$merk,
				"part_number"=>$part_number,
				"nama_barang"=>$nama_barang,
				"status_aset"=>1,
				"jumlah_barang_so"=>$jumlah_barang,
				"keterangan_so"=>$keterangan,
				"barcode"=>$barcode
				);

			$input = array_merge($input,$others);

			$act = $this->insertHeader($input);

		}

		return $act;

	}

	public function insertComment($input = array()){

		$userdata = $this->Administration_m->getLogin();

		$input['created_date'] = date("Y-m-d H:i:s");
		$input['created_by'] = $userdata['employee_id'];

		if(isset($input['respon'])){
			$input['respon'] = $this->Workflow_m->getResponseName($input['respon']);
		} else {
			$input['respon'] = null;
		}

		$x = array("audit_id","maintenance_id","relocation_id","acquisition_id","disposal_id","contract_id");

		$where = array(
			"position_id"=>$input['position_id'],
			"activity_id"=>$input['activity_id'],
			"respon"=>null
			);

		foreach ($x as $key => $value) {
			if(isset($input[$value])){
				$where[$value] = $input[$value];
			}
		}

		$check = $this->db->where($where)->get("ast_comment")->row_array();

		if(empty($check)){
			$this->db->insert("ast_comment",$input);
			$id = $this->db->insert_id();
		} else {
			$id = $check['id'];	
		}


		return $id;

	}

	public function getComment($id = ""){

		$this->db->select("id as comment_id,
			created_date as comment_date,
			updated_date as comment_end_date,
			nama as comment_name,
			respon as response,
			komentar as comments,
			activity_id as activity,
			position,
			position_id,
			dokumen as attachment, 
			(SELECT awa_name FROM adm_wkf_activity WHERE awa_id=activity_id) as activity_name,
			disposal_id,
			acquisition_id,
			audit_id,
			maintenance_id,
			relocation_id,
			contract_id,
			DATE_FORMAT(created_date,'%d/%m/%Y %H:%i') as created_date_format");

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		$this->db->order_by("id","desc");

		return $this->db->get("ast_comment");

	}
//hlmifzi
	public function getCommentAsetBerkala($id = ""){

		$this->db->select("id as comment_id,
			created_date as comment_date,
			updated_date as comment_end_date,
			nama as comment_name,
			respon as response,
			komentar as comments,
			activity_id as activity,
			position,
			position_id,
			dokumen as attachment, 
			(SELECT awa_name FROM adm_wkf_activity WHERE awa_id=activity_id) as activity_name,
			acquisition_id,
			DATE_FORMAT(created_date,'%d/%m/%Y %H:%i') as created_date_format");

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		$this->db->order_by("id","desc");

		return $this->db->get("ast_aset_berkala_comment");

	}
	//end

	public function getHierarchyParent($userPos){
		$userdata = $this->Administration_m->getLogin();
		$getdata = $this->db
		->join("vw_pos","pos_id=hap_pos_code",'inner')
		->where("hap_pos_code = (select hap_pos_parent from vw_prc_hierarchy_approval_4 where hap_pos_code = ".$userPos.")")
		->where("hap_district",$userdata['district_id'])
		->get("vw_prc_hierarchy_approval_4")
		->row_array();
		$nextPosCode = $getdata['hap_pos_code'];
		$nextPosName = $getdata['hap_pos_name'];
		return array("code"=>$nextPosCode,"name"=>$nextPosName);
	}

	public function getTableCodeName($code_field,$name_field,$table,$where = array()){

		if(!empty($where)){
			$this->db->where($where);
		}

		$getdata = $this->db
		->select($code_field." as code,".$name_field." as name")
		->get($table);

		if(empty($getdata->num_rows()) && !empty($where)){

			if(isset($where['dept_id'])){
				unset($where['dept_id']);
			}

			$getdata = $this->db
			->select($code_field." as code,".$name_field." as name")
			->where($where)
			->get($table);
		}


		return $getdata->row_array();

	}

	public function aset_comment_complete(
		$response = "",
		$comment = "",
		$attachment = "",
		$comment_id = 0,
		$employee_id = "",
		$employee_id_target = null
		) {

		if(!empty($comment_id)){

			$userdata = $this->Administration_m->getLogin();

			if(is_numeric($response)){
				$response_real = $this->Workflow_m->getResponseName($response);
				$response = url_title($response_real,"_",true);
			} else {
				$response_real = $response;
				$response = url_title($response,"_",true);
			}

			$ast_comment = $this->getComment($comment_id)->row_array();

			$disposal_id = "";

			$contract_id = "";

			$audit_id = "";

			$maintenance_id = "";

			$relocation_id = "";

			$acquisition_id = "";

			$lastPosCode = "";

			$lastPosName = "";

			if(!empty($ast_comment)){

				$disposal_id = $ast_comment['disposal_id'];

				$contract_id = $ast_comment['contract_id'];

				$audit_id = $ast_comment['audit_id'];

				$maintenance_id = $ast_comment['maintenance_id'];

				$relocation_id = $ast_comment['relocation_id'];

				$acquisition_id = $ast_comment['acquisition_id'];

				$lastPosCode = $ast_comment['position_id'];

				$lastPosName = $ast_comment['position'];

				$activity = $ast_comment['activity'];

			}

			$activity_comment = $this->Workflow_m->getActivity($activity)->row_array();

			$name = $userdata['complete_name'];
			$message = "";

			$nextPosCode = $lastPosCode;
			$nextPosName = $lastPosName;
			$lastActivity = $activity;
			$nextActivity = $lastActivity;
			$anyIncompleteComment = (empty($ast_comment['updated_by']));

			$dirkeu = "KEPALA ANGGARAN";

			if($anyIncompleteComment){

				$update = $this->db
				->where(array("id"=>$comment_id))
				->update("ast_comment",array(
					"respon" => $response_real,
					"nama" => $name,
					"updated_date" => date("Y-m-d H:i:s"),
					"komentar" => $comment,
					"dokumen" => $attachment,
					"updated_by" => $employee_id,
					));

				switch ($activity) {

					case 9000:

					$data = $this->getAcquisition($acquisition_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 9001;

						$w = array("job_title"=>"MANAJER ASET");

						if(!empty($data['dept_id'])){
							$w['dept_id'] = $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						//echo $this->db->last_query();

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					}

					break;

					case 9001:

					$data = $this->getAcquisition($acquisition_id)->row_array();

					if($response == url_title('Setuju',"_",true)){

						switch ($userdata['job_title']) {
							case 'MANAJER ASET':
							$n = "VP ASET";
							break;
							case 'VP ASET':
							$n = "PIC ASET";
							$nextActivity = 9002;
							break;
							default:

							break;
						}

						$w = array("job_title"=>$n);

						if(!empty($data['dept_id'])){
							$w['dept_id'] = $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					} else {

						$w = array("employee_id"=>$data['created_by'],
							"job_title"=>"PIC ASET");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $data['created_by'];

						$nextActivity = 9000;

					}

					break;

					case 9002:

					$data = $this->getAcquisition($acquisition_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 9003;

					}

					break;

					case 9003:

					$data = $this->getAcquisition($acquisition_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 9004;

						$w = array("job_title"=>"PIC USER");

						if(!empty($data['dept_id'])){
							$w['dept_id'] = $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					}

					break;

					case 9004:

					$data = $this->getAcquisition($acquisition_id)->row_array();

					if($response == url_title('Penerimaan valid',"_",true)){

						$x = $this->db->where(
							array(
								"district_id"=>$userdata['district_id'],
								//"alokasi_dept"=>$userdata['dept_id'],
								"acquisition_id"=>$acquisition_id,
								))->update("ast_acquisition_item",array("status"=>1));

						$nullcomment = $this->db
						->where("acquisition_id",$acquisition_id)
						->where("nama",null)
						->get("ast_comment")->num_rows();

						$nextActivity = (empty($nullcomment)) ? 9005 : null;

					} else if($response == url_title('Revisi penerimaan',"_",true)) {

						$this->db->where("acquisition_id",$acquisition_id)->where("nama",null)
						->delete("ast_comment");

						$w = array("employee_id"=>$data['created_by'],
							"job_title"=>"PIC ASET");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $data['created_by'];

						$nextActivity = 9000;

					}

					break;

					case 9100:

					$data = $this->getDisposal($disposal_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 9101;

						$w = array("job_title"=>"MANAJER USER");

						if(!empty($data['dept_id'])){
							$w['dept_id'] = $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					}

					break;

					case 9101:

					$data = $this->getDisposal($disposal_id)->row_array();

					if($response == url_title('Setuju',"_",true)){

						switch ($userdata['job_title']) {
							case 'MANAJER USER':
							$n = "VP USER";
							break;
							case 'VP USER':
							$n = "VP ASET";
							break;
							case 'VP ASET':
							$n = "MANAJER ASET";
							$nextActivity = 9102;
							break;
							default:

							break;
						}

						$w = array("job_title"=>$n);

						if(!empty($data['dept_id'])){
							$w['dept_id'] = $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					} else {

						$w = array("employee_id"=>$data['created_by'],
							"job_title"=>"PIC USER");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $data['created_by'];

						$nextActivity = 9100;

					}

					break;

					case 9102:

					$data = $this->getDisposal($disposal_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 9103;

						$employee_id_target = $data['pic_id'];

						$w = array("job_title"=>"PIC ASET");

						if(!empty($data['dept_id'])){
							$w['dept_id'] = $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					}

					break;

					case 9103:

					if($response == url_title('Simpan dan Selesai',"_",true)){

						$nextActivity = 9104;

					} 

					break;

					case 9200:

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 9201;

					}

					break;

					case 9201:

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 9202;

					}

					break;

					case 9202:

					$data = $this->getAudit($audit_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 9203;

						$w = array("job_title"=>"VP ASET");

						if(!empty($data['dept_id'])){
							$w['dept_id'] = $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$nullcomment = $this->db->where("audit_id",$audit_id)->where("nama",null)
						->get("ast_comment")->num_rows();

						$nextActivity = (empty($nullcomment)) ? 9203 : null;

					}

					break;

					case 9203:

					if($response == url_title('Setuju dan Selesai',"_",true)){

						$nextActivity = 9204;	

					} else {

						$nextActivity = 9202;

					}

					break;

					case 9300:

					$data = $this->getMaintenance($maintenance_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 9301;

						$w = array("job_title"=>"MANAJER USER");

						if(!empty($data['dept_id'])){
							$w['dept_id'] = $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					}

					break;

					case 9301:

					$data = $this->getMaintenance($maintenance_id)->row_array();

					if($response == url_title('Setuju',"_",true)){

						switch ($userdata['job_title']) {
							case 'MANAJER USER':
							$n = "VP USER";
							break;
							case 'VP USER':
							$n = "VP ASET";
							break;
							case 'VP ASET':
							if(empty($data['tipe'])){
								$n = "PIC ASET";
								$nextActivity = 9302;
							} else {
								$n = "MANAJER ASET";
							}
							break;
							case 'MANAJER ASET':
							$n = "PIC ASET";
							$nextActivity = 9302;
							break;
							default:

							break;

						}

						$w = array("job_title"=>$n);

						if(!empty($data['dept_id'])){
							$w['dept_id'] = $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					} else {

						$w = array("employee_id"=>$data['created_by'],
							"job_title"=>"PIC USER");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $data['created_by'];

						$nextActivity = 9300;

					}

					break;

					case 9302:

					if($response == url_title('Simpan dan Selesai',"_",true)){

						$nextActivity = 9303;	

					}

					break;

					case 9400:

					$data = $this->getRelocation($relocation_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 9401;

						$n = ($data['tipe'] == 2) ? "MANAJER ASET" : "MANAJER USER";

						$w = array("job_title"=>$n);

						if(!empty($data['dept_id'])){
							$w['dept_id'] = $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					}

					break;

					case 9401:

					$data = $this->getRelocation($relocation_id)->row_array();

					$w = array();

					if($response == url_title('Setuju',"_",true)){

						//if($data['tipe'] == 2){
							
							$prefix = $userdata['job_title'].$userdata['district_id'];

							//echo $prefix;

							$n = "";

							switch ($prefix) {
								case 'MANAJER ASET'.$data['district_id']:
								$n = "VP ASET";
								if(!empty($data['district_id'])){
									$w['district_id'] = $data['district_id'];
								}
								if(!empty($data['dept_id'])){
									$w['dept_id'] = $data['dept_id'];
								}
								break;
								case 'MANAJER USER'.$data['district_id']:
								$n = "VP USER";
								if(!empty($data['district_id'])){
									$w['district_id'] = $data['district_id'];
								}
								if(!empty($data['dept_id'])){
									$w['dept_id'] = $data['dept_id'];
								}
								break;
								case 'VP USER'.$data['district_id']:
								$n = "VP ASET";
								if(!empty($data['district_tujuan'])){
									$w['district_id'] = $data['district_tujuan'];
								}
								if(!empty($data['dept_tujuan'])){
									$w['dept_id'] = $data['dept_tujuan'];
								}
								break;
								case 'VP ASET'.$data['district_tujuan']:
								$n = "MANAJER ASET";
								if(!empty($data['district_tujuan'])){
									$w['district_id'] = $data['district_tujuan'];
								}
								if(!empty($data['dept_tujuan'])){
									$w['dept_id'] = $data['dept_tujuan'];
								}
								//haqim
								$nextActivity = 9402;
								//end
								break;
								case 'MANAJER ASET'.$data['district_tujuan']:
								$n = "PIC ASET";
								if(!empty($data['district_tujuan'])){
									$w['district_id'] = $data['district_tujuan'];
								}
								if(!empty($data['dept_tujuan'])){
									$w['dept_id'] = $data['dept_tujuan'];
								}
								//haqim
								$nextActivity = 9403;
								//end
								break;
								default:
								break;
							}

						/*} else {

							switch ($userdata['job_title']) {

								case 'MANAJER USER':

								$n = "VP USER";
								if(empty($data['tipe']) && $data['jenis'] == 'B'){
									//$n = "VP ASET";
								} 

								break;

								case 'VP ASET':

								$nextActivity = 9402;
								$n = "MANAJER ASET";

								break;

								case $dirkeu:

								$nextActivity = 9402;
								$n = "MANAJER ASET";

								break;

								case 'VP USER':

								$n = "VP ASET";

								if($data['tipe'] != 1){
									$nextActivity = 9402;
								}

								if($data['jenis'] == 'K'){
									$n = $dirkeu;
									$nextActivity = 9402;
									if(date("Y")-$data['tahun'] >=5){
										$n = "DIREKTUR USER";
										$nextActivity = 9401;
									}
								}

								break;

								case 'DIREKTUR USER':

								$n = $dirkeu;
								$nextActivity = 9402;

								break;

								default:

								break;

							}							

							if(!empty($data['dept_id'])){
								$w['dept_id'] = $data['dept_id'];
							}

							if(!empty($data['district_id']) && $data['tipe'] == 1){
								$w['district_id'] = $data['district_id'];
							}

						}*/

						$w["job_title"] = $n;

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						//print_r($data);
						//print_r($w);
						//print_r($getdata);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					} else {

						$employee_id_target = $data['created_by'];

						$w = array(
							"employee_id"=>$data['created_by'],
							"job_title"=>"PIC USER"
							);

						if($data['tipe'] == 2){
							$w['job_title'] = "PIC ASET";
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);
						//print_r($userdata['job_title']);
						//print_r($w);
						//print_r($getdata);
						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$nextActivity = 9400;

					}

					break;

					case 9402:

					$data = $this->getRelocation($relocation_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						if($data['jenis'] != 'B'){

							switch ($userdata['job_title']) {
								case $dirkeu:
								$n = "VP ASET";
								break;
								case 'VP ASET':
								$n = "MANAJER ASET";
								break;
								case 'MANAJER ASET':
								$n = 'PIC ASET';
								$nextActivity = 9403;
								break;
								default:
								break;
							}

						} else {
							$nextActivity = 9403;
							$n = "PIC ASET";
						}

						$w = array("job_title"=>$n);

						if($data['tipe'] == 2){

							if(!empty($data['district_tujuan'])){
								$w['district_id'] = $data['district_tujuan'];
							}

						} else {

							if(!empty($data['dept_id'])){
								$w['dept_id'] = $data['dept_id'];
							}

							if(!empty($data['district_id'])){
								$w['district_id'] = $data['district_id'];
							}

						}

						if($n == "PIC ASET" && !empty($data['pic_id'])){
							$employee_id_target = $data['pic_id'];
						}

						if($n == "MANAJER ASET" && !empty($data['manager_id'])){
							$employee_id_target = $data['manager_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					}

					break;

					case 9403:

					if($response == url_title('Simpan dan Selesai',"_",true)){

						$nextActivity = 9404;	

					}

					break;

					default:

					$this->rollbackcomment($comment_id,$lastActivity);
					return array("message"=>"Aktifitas tidak ditemukan. Proses tidak berjalan");

					break;

				}

				if(empty($nextPosCode)){

					$this->rollbackcomment($comment_id,$lastActivity);

					return array("message"=>"Posisi tidak ditemukan. Proses tidak berjalan");
				}

				$ret = array(
					"message"=>$message,
					"nextposcode"=>$nextPosCode,
					"nextposname"=>$nextPosName,
					"lastposcode"=>$lastPosCode,
					"lastposname"=>$lastPosName,
					"nextactivity"=>$nextActivity,
					"anyincompletecomment"=>$anyIncompleteComment,
					"response"=>$response
					);

				if(!empty($nextActivity)){

					$xa = array();
					$xa[] = url_title('Simpan dan Lanjut',"_",true);
					$xa[] = url_title('Revisi',"_",true);

					if($nextActivity == 9202 && in_array($response,$xa)){

						$this->db->where("posisi_user",2);
						$opname_anggota = $this->getAuditUser($audit_id)
						->result_array();
						///echo $this->db->last_query();

						if(empty($opname_anggota)){

							$this->rollbackcomment($comment_id,$lastActivity);
							return array("message"=>"Anggota opname tidak ditemukan. Proses tidak berjalan");

						} else {

							foreach ($opname_anggota as $key => $value) {

								$getdata = $this->getTableCodeName(
									"pos_id",
									"pos_name",
									"user_login_rule",
									array("employee_id"=>$value['employee_id']));

								$nextPosCode = $getdata['code'];
								$nextPosName = $getdata['name'];

								$input = array(
									"contract_id"=>$contract_id,
									"audit_id"=>$audit_id,
									"position_id"=>$nextPosCode,
									"position"=>$nextPosName,
									"activity_id"=>$ret['nextactivity'],
									"user_id"=>$value['employee_id'],
									"nama"=>$value['nama']
									);

								$this->insertComment($input);

							}

					}

					}else if($nextActivity == 9004 && $response != url_title('Simpan sebagai Draft',"_",true)){

						$this->db->select("district_id,dept_id")->distinct()
						->where("district_id !=",0)->where("COALESCE(status,'')",'');
						$acq_item = $this->getAcquisitionItem($acquisition_id)
						->result_array();
						//district_id 1 //dept_id 25

						foreach ($acq_item as $key => $value) {

							$w = array("job_title"=>"PIC USER");

							if(!empty($value['dept_id'])){
								//tadinya di comment //haqim
								$w['dept_id'] = $value['dept_id'];
								//end
							}

							if(!empty($value['district_id'])){
								$w['district_id'] = $value['district_id'];
							}

							$getdata = $this->getTableCodeName(
								"pos_id",
								"pos_name",
								"vw_pos",
								$w);

							$nextPosCode = $getdata['code'];
							$nextPosName = $getdata['name'];

							$input = array(
								"contract_id"=>$contract_id,
								"audit_id"=>$audit_id,
								"position_id"=>$nextPosCode,
								"position"=>$nextPosName,
								"acquisition_id"=>$acquisition_id,
								"activity_id"=>$ret['nextactivity'],
								);

							$this->insertComment($input);

						}

					} else {

						$input = array(
							"contract_id"=>$contract_id,
							"audit_id"=>$audit_id,
							"maintenance_id"=>$maintenance_id,
							"relocation_id"=>$relocation_id,
							"acquisition_id"=>$acquisition_id,
							"disposal_id"=>$disposal_id,
							"position_id"=>$ret['nextposcode'],
							"position"=>$ret['nextposname'],
							"activity_id"=>$ret['nextactivity'],
							"user_id"=>$employee_id_target
							);

						$this->insertComment($input);


					}

				}

				return $ret;

			}

		} else {
			$this->rollbackcomment($comment_id,$lastActivity);
			return array("message"=>"Komentar tidak ditemukan. Proses tidak berjalan");

		}

	}

	public function insertHistoryOpname($data){

		$this->db->insert('ast_opname_history', $data);

		return $this->db->affected_rows();
	}

	public function getOpnameHistory($id){
		$this->db->where('aset_id', $id);

		return $this->db->get('ast_opname_history');
	}

	//hlmifzi
	public function getKantorAll(){


		$this->db->order_by("district_name","asc");

		return $this->db->get("adm_district")->result();

	}

	public function getDept(){

 			$this->db->order_by('dept_name', 'asc');
            $this->db->join('adm_district', 'adm_dept.district_id = adm_district.district_id');
            return $this->db->get('adm_dept')->result();

	}

	public function getJenisAsdp(){

 			$this->db->order_by('jenis', 'asc');
            return $this->db->get('adm_jenis_asdp')->result();

	}

	public function getKapalAsdp(){

 			$this->db->order_by('name_ship', 'asc');
            return $this->db->get('adm_ship')->result();

	}

	//end

	//hlmifzi
	public function do_upload($name) {

        /*
			menggunakan config upload di construct controller
        */
 		
        if(!$this->upload->do_upload($name)) //upload and validate
        {

            $this->upload->display_errors(); //show ajax error

        }
        return $this->upload->data('file_name');
    }

}