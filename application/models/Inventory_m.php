<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getAcquisition($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("inv_acquisition_header a");

	}

	public function getDistribution($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("inv_distribution_header a");

	}

	public function getRequest($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("inv_request_header a");

	}

	public function getStockOpname($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("inv_stockopname_header a");

	}

	public function getAdjustment($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("inv_adjustment_header a");

	}

	public function getStockOpnameUser($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("opname_id",$header);

		}


		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("inv_stockopname_panitia a");

	}


	public function urutDistribution($tahun = ""){

		return $this->generateUrut("nomor_distribusi","inv_distribution_header","INV.DIST");

	}

	public function urutAdjustment($tahun = ""){

		return $this->generateUrut("nomor_penyesuaian","inv_adjustment_header","INV.ADJ");

	}

	public function urutStockOpname($tahun = ""){

		return $this->generateUrut("nomor_so","inv_stockopname_header","INV.SO");

	}

	public function urutAcquisition(){

		return $this->generateUrut("nomor","inv_acquisition_header","BMG");

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

	public function urutRequest(){

		return $this->generateUrut("nomor_permintaan","inv_request_header","INV");

	}

	public function insertAcquisition($input){

		if (!empty($input)){

			$this->db->insert("inv_acquisition_header",$input);

			return $this->db->insert_id();

		}

	}

	public function insertStockOpname($input){

		if (!empty($input)){

			$this->db->insert("inv_stockopname_header",$input);

			return $this->db->insert_id();

		}

	}

	public function insertAdjustment($input){

		if (!empty($input)){

			$this->db->insert("inv_adjustment_header",$input);

			return $this->db->insert_id();

		}

	}

	public function insertRequest($input){

		if (!empty($input)){

			$this->db->insert("inv_request_header",$input);

			return $this->db->insert_id();

		}

	}

	public function updateRequest($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('inv_request_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateAdjustment($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('inv_adjustment_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateStockOpname($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('inv_stockopname_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateAcquisition($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('inv_acquisition_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function deleteAcquisitionItemDist($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("acquisition_id",$header);

			}

			$this->db->delete('inv_acquisition_dist');

			return $this->db->affected_rows();

		}

	}

	public function insertAcquisitionItemDist($input){

		if (!empty($input)){

			$this->db->insert("inv_acquisition_dist",$input);

			return $this->db->insert_id();
		}

	}

	public function insertAdjustmentItem($input){

		if (!empty($input)){

			$this->db->insert("inv_adjustment_item",$input);

			return $this->db->insert_id();
		}

	}

	public function insertStockOpnameUser($input){

		if (!empty($input)){

			$this->db->insert("inv_stockopname_panitia",$input);

			return $this->db->insert_id();
		}

	}

	public function deleteAdjustmentItem($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("adjustment_id",$header);

			}

			$this->db->delete('inv_adjustment_item');

			return $this->db->affected_rows();

		}

	}

	public function deleteStockOpnameUser($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("opname_id",$header);

			}

			$this->db->delete('inv_stockopname_panitia');

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

			$this->db->delete('inv_acquisition_item');

			return $this->db->affected_rows();

		}

	}

	public function insertAcquisitionItem($input){

		if (!empty($input)){

			$this->db->insert("inv_acquisition_item",$input);

			return $this->db->insert_id();
		}

	}

	public function getAdjustmentItem($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("a.adjustment_id",$header);

		}

		if(!empty($id)){

			$this->db->where("a.id",$id);

		}

		$this->db->join("inv_inventory_header b","b.id=a.inv_id");

		return $this->db->get("inv_adjustment_item a");

	}

	public function getOpnameItem($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("a.opname_id",$header);

		}

		if(!empty($id)){

			$this->db->where("b.id",$id);

		}

		$this->db->join("inv_stockopname_item a","b.id=a.inv_id","left");

		return $this->db->get("inv_inventory_header b");

	}

	public function deleteOpnameItem($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("opname_id",$header);

			}

			$this->db->delete('inv_stockopname_item');

			return $this->db->affected_rows();

		}

	}

	public function insertOpnameItem($input){

		if (!empty($input)){

			$this->db->insert("inv_stockopname_item",$input);

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

		return $this->db->get("inv_acquisition_item a");

	}

	public function getAcquisitionItemDist($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("acquisition_id",$header);

		}

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("inv_acquisition_dist a");

	}

	public function getRequestItem($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("request_id",$header);

		}

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("inv_request_item a");

	}

	public function insertDistribution($input){

		if (!empty($input)){

			$this->db->insert("inv_distribution_header",$input);

			return $this->db->insert_id();

		}

	}

	public function updateDistribution($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('inv_distribution_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function deleteDistributionItem($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("distribution_id",$header);

			}

			$this->db->delete('inv_distribution_item');

			return $this->db->affected_rows();

		}

	}

	public function deleteRequestItem($header,$id = ""){

		if(!empty($header) || !empty($id)){

			if(!empty($id)){

				$this->db->where("id",$id);

			}

			if(!empty($header)){

				$this->db->where("request_id",$header);

			}

			$this->db->delete('inv_request_item');

			return $this->db->affected_rows();

		}

	}

	public function insertRequestItem($input){

		if (!empty($input)){

			$this->db->insert("inv_request_item",$input);

			return $this->db->insert_id();
		}

	}

	public function insertDistributionItem($input){

		if (!empty($input)){

			$this->db->insert("inv_distribution_item",$input);

			return $this->db->insert_id();
		}

	}

	public function getDistributionItem($header = "",$id = ""){

		if(!empty($header)){

			$this->db->where("distribution_id",$header);

		}

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("inv_distribution_item a");

	}

	public function getJoinByCommentType($type = ""){

		switch ($type) {

			case 'distribution':
			$table = "inv_distribution_header";
			$field_join = "distribution_id";
			$kode_field = "nomor_distribusi";
			$pekerjaan_field = "keterangan";
			break;
			
			case 'opname':
			$table = "inv_stockopname_header";
			$field_join = "opname_id";
			$kode_field = "nomor_so";
			$pekerjaan_field = "judul_so";
			break;

			case 'request':
			$table = "inv_request_header";
			$field_join = "request_id";
			$kode_field = "nomor_permintaan";
			$pekerjaan_field = "keterangan";
			break;

			case 'adjustment':
			$table = "inv_adjustment_header";
			$field_join = "adjustment_id";
			$kode_field = "nomor_penyesuaian";
			$pekerjaan_field = "keterangan";
			break;

			default:
			$table = "inv_acquisition_header";
			$field_join = "acquisition_id";
			$kode_field = "nomor";
			$pekerjaan_field = "keterangan";
			break;

		}

		return array("table"=>$table,"field"=>$field_join,"desc_field"=>$pekerjaan_field,"code_field"=>$kode_field);

	}


	public function getPekerjaan($type = "",$id = ""){

		$a = $this->getJoinByCommentType($type);

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

		return $this->db->get("inv_comment a");

	}

	public function getMonitor($type = "",$id = ""){

		$a = $this->getJoinByCommentType($type);

		$select = "a.id as id_monitor, ".$a['code_field']." as kode_monitor, DATE_FORMAT(a.created_date,'%d/%m/%Y %H:%i') as tanggal_monitor, (SELECT awa_name FROM adm_wkf_activity WHERE awa_id=activity_id) as aktifitas_monitor, ".$a['desc_field']." as nama_monitor";

		$this->db->select($select);

		$this->db->join("inv_comment a","b.id=a.".$a['field'],"inner");

		if(!empty($id)){

			$this->db->where("a.id",$id);

		}

		$this->db->where("COALESCE(respon,'')","");

		$this->db->order_by("a.id","desc");

		return $this->db->get($a['table']." b");

	}

	public function getHeader($id = ""){

		$acquisition_id = $this->session->userdata("acquisition_id");

		$activity = $this->session->userdata("activity");

		$default_select = "a.id,a.kode_barang,a.nama_barang,bastb_code as bastb, a.jumlah_barang, uom as nama_satuan, harga_perolehan,tanggal_perolehan,a.created_date as tanggal_dibuat, a.updated_date as tanggal_diubah, a.keterangan as keterangan_pencatatan,gudang_id as id_gudang, name_war as nama_gudang,a.merk,a.part_number,tanggal_perolehan,batas_barang,c.district_id as id_kantor, c.district_name as nama_kantor, d.dept_id as id_dept, dept_name as nama_dept,status_barang as status, a.tipe, CASE status_barang
		WHEN 1 THEN 'Aktif' 
		ELSE 'Tidak Aktif'
		END as nama_status,barcode"; //y add f.tipe
		
		if(!empty($acquisition_id)){
			if(in_array($activity, array(4000))){
				$default_select = "a.kode_barang,a.nama_barang,merk,a.part_number,uom as nama_satuan";
			} else {
				$this->db->join("inv_acquisition_item e","e.id=a.inv_item_acquisition");
				$this->db->where("e.acquisition_id",$acquisition_id);
			}
		}

		$this->db->select($default_select,false);

		if(!empty($id)){
			$this->db->where("a.id",$id);
		}

		$this->db->join("adm_warehouse b","b.id_war=a.gudang_id","left");
		$this->db->join("adm_district c","c.district_id=a.district_id","left");
		$this->db->join("adm_dept d","d.dept_id=a.dept_id","left");
		return $this->db->get("inv_inventory_header a");

	}

	public function getHeaderDistinct($id = ""){

	}

	public function insertHeader($input){

		if (!empty($input)){

			$this->db->insert("inv_inventory_header",$input);

			return $this->db->insert_id();
		}

	}

	public function updateHeader($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('id',$id)->update('inv_inventory_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function distributeHeader(
		$type = "",$from_id,$to_id,$kode_barang,$merk,$part_number,$jumlah,$input = array()
		){
		$check = $this->db
		->where(array("part_number"=>$part_number,"merk"=>$merk,"kode_barang"=>$kode_barang,$type=>$from_id))
		->order_by("created_date","asc")
		->get("inv_inventory_header")->result_array();

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
				$this->db->where($where)->update("inv_inventory_header",$update);
				//echo $this->db->last_query()."\n";
			} else {

				$update = array("jumlah_barang"=>$sisa);
				$this->db->where($where)->update("inv_inventory_header",$update);
				//echo $this->db->last_query()."\n";
				$i = $d[$value['id']];
				$i['merk'] = $merk;
				$i['part_number'] = $part_number;
				$i['jumlah_barang'] = $jumlah;
				$i['tanggal_perolehan'] = date("Y-m-d H:i:s");
				$i[$type] = $to_id;
				$i = array_merge($i,$input);
				unset($i['id']);
				$this->db->insert("inv_inventory_header",$i);
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
		$harga_perolehan = "",
		$employee_id = "",
		$barcode = "",
		$tipe = "", //y tambah tipe inv
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
				"harga_perolehan"=>$harga_perolehan,
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
				"harga_perolehan"=>$harga_perolehan,
				"uom"=>$uom,
				"district_id"=>$district_id,
				"gudang_id"=>$gudang_id,
				"kode_barang"=>$kode_barang,
				"keterangan"=>$keterangan,
				"merk"=>$merk,
				"part_number"=>$part_number,
				"nama_barang"=>$nama_barang,
				"status_barang"=>1,
				"jumlah_barang_so"=>$jumlah_barang,
				"keterangan_so"=>$keterangan,
				"barcode"=>$barcode,
				"tipe"=>$tipe //y tambah tipe inv
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

		$x = array("opname_id","distribution_id","adjustment_id","acquisition_id","request_id","contract_id");

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

		$check = $this->db->where($where)->get("inv_comment")->row_array();

		if(empty($check)){
			$this->db->insert("inv_comment",$input);
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
			request_id,
			contract_id,
			opname_id,
			distribution_id,
			adjustment_id,
			acquisition_id,
			DATE_FORMAT(created_date,'%d/%m/%Y %H:%i') as created_date_format");

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		$this->db->order_by("id","desc");

		return $this->db->get("inv_comment");

	}

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

	public function inventory_comment_complete(
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

			$inv_comment = $this->getComment($comment_id)->row_array();

			$request_id = "";

			$contract_id = "";

			$opname_id = "";

			$distribution_id = "";

			$adjustment_id = "";

			$acquisition_id = "";

			$lastPosCode = "";

			$lastPosName = "";

			if(!empty($inv_comment)){

				$request_id = $inv_comment['request_id'];

				$contract_id = $inv_comment['contract_id'];

				$opname_id = $inv_comment['opname_id'];

				$distribution_id = $inv_comment['distribution_id'];

				$adjustment_id = $inv_comment['adjustment_id'];

				$acquisition_id = $inv_comment['acquisition_id'];

				$lastPosCode = $inv_comment['position_id'];

				$lastPosName = $inv_comment['position'];

				$activity = $inv_comment['activity'];

			}

			$activity_comment = $this->Workflow_m->getActivity($activity)->row_array();

			$name = $userdata['complete_name'];
			$message = "";
			
			$nextPosCode = $lastPosCode;
			$nextPosName = $lastPosName;
			$lastActivity = $activity;
			$nextActivity = $lastActivity;
			$anyIncompleteComment = (empty($inv_comment['updated_by']));

			if($anyIncompleteComment){

				$update = $this->db
				->where(array("id"=>$comment_id))
				->update("inv_comment",array(
					"respon" => $response_real,
					"nama" => $name,
					"updated_date" => date("Y-m-d H:i:s"),
					"komentar" => $comment,
					"dokumen" => $attachment,
					"updated_by" => $employee_id,
					));

				switch ($activity) {

					case 7003:

					$data = $this->getStockOpname($opname_id)->row_array();

					if($response == url_title('Setuju',"_",true)){

						switch ($userdata['job_title']) {
							case 'PETUGAS GUDANG':
							$n = "MANAJER GUDANG";
							$nextActivity = 7003;
							break;
							case 'MANAJER GUDANG':
							$n = "KEPALA INVENTORY";
							$nextActivity = 7003;
							break;
							case "KEPALA INVENTORY":
							$n = "KEPALA INVENTORY";
							$nextActivity = 7004;
							break;
							default:
								# code...
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

						//echo $this->db->last_query();

					} else {

						$nextActivity = 7002;
						
					}

					break;

					case 7002:

					$data = $this->getStockOpname($request_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 7003;

						$w = array("job_title"=>"PETUGAS GUDANG");

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

						$nextActivity = 7002;
						
					}

					break;


					case 7001:

					$data = $this->getStockOpname($request_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextActivity = 7002;

					} else {

						$w = array("job_title"=>"MANAJER GUDANG");

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

						$nextActivity = 7001;
						
					}

					break;

					case 7000:

					$data = $this->getStockOpname($request_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$w = array("job_title"=>"MANAJER GUDANG");

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

						$nextActivity = 7001;

					} else {

						$w = array("employee_id"=>$data['created_by'],
							"job_title"=>"KEPALA INVENTORY");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $data['created_by'];
						
						$nextActivity = 7000;
						
					}

					break;

					case 6000:

					$data = $this->getRequest($request_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$w = array("job_title"=>"MANAJER GUDANG");

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

						$nextActivity = 6001;

					} else {

						$w = array("employee_id"=>$data['created_by'],
							"job_title"=>"PETUGAS GUDANG");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $data['created_by'];
						
						$nextActivity = 6000;
						
					}

					break;

					case 6001:

					$data = $this->getRequest($request_id)->row_array();

					if($response == url_title('Setuju',"_",true)){

						switch ($userdata['job_title']) {
							case 'MANAJER GUDANG':
							$n = "KEPALA INVENTORY";
							$nextActivity = 6001;
							break;
							case 'KEPALA INVENTORY':
							$n = "KEPALA INVENTORY";
							$nextActivity = 6004;
							break;
							default:
								# code...
							break;
						}

						$w = array("job_title"=>$n);

						if(!empty($data['dept_id'])){
							$w['dept_id'] = ($nextActivity == 6004) ? 
							$data['dept_tujuan_id'] : $data['dept_id'];
						}

						if(!empty($data['district_id'])){
							$w['district_id'] = ($nextActivity == 6004) ? 
							$data['district_tujuan_id'] : $data['district_id'];
						}

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						//echo $this->db->last_query();

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					} else {

						$w = array("employee_id"=>$data['created_by'],"job_title"=>"PETUGAS GUDANG");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $data['created_by'];
						
						$nextActivity = 6000;
						
					}

					break;

					case 6002:

					$data = $this->getRequest($request_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$w = array("job_title"=>'MANAJER USER');

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

						$nextActivity = 6003;

					} else {

						$w = array("employee_id"=>$data['created_by'],"job_title"=>"PIC USER");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $data['created_by'];
						
						$nextActivity = 6002;
						
					}

					break;

					case 6003:

					$data = $this->getRequest($request_id)->row_array();

					if($response == url_title('Setuju',"_",true)){

						switch ($userdata['job_title']) {
							case 'MANAJER USER':
							$n = "VP USER";
							$nextActivity = 6003;
							break;
							case 'VP USER':
							$n = "KEPALA INVENTORY";
							$nextActivity = 6004;
							break;
							default:
								# code...
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

						//echo $this->db->last_query();

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

					} else {

						$w = array("employee_id"=>$data['created_by'],"job_title"=>"PIC USER");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $data['created_by'];
						
						$nextActivity = 6002;
						
					}

					break;

					case 6004:

					$data = $this->getRequest($request_id)->row_array();

					$w = array("job_title"=>"MANAJER GUDANG");

					if(!empty($data['dept_id'])){
						$w['dept_id'] = $data['dept_id'];
					}

					if(!empty($data['district_id'])){
						$w['district_id'] = $data['district_tujuan_id'];
					}

					$getdata = $this->getTableCodeName(
						"pos_id",
						"pos_name",
						"user_login_rule",
						$w);

					$nextPosCode = $getdata['code'];
					$nextPosName = $getdata['name'];

					$nextActivity = 6005;

					break;


					case 6005:

					$data = $this->getRequest($request_id)->row_array();

					$w = array("job_title"=>"PETUGAS GUDANG");

					if(!empty($data['dept_id'])){
						$w['dept_id'] = $data['dept_id'];
					}

					if(!empty($data['district_id'])){
						$w['district_id'] = $data['district_tujuan_id'];
					}

					$getdata = $this->getTableCodeName(
						"pos_id",
						"pos_name",
						"user_login_rule",
						$w);

					$nextPosCode = $getdata['code'];
					$nextPosName = $getdata['name'];

					$nextActivity = 6006;

					break;

					case 5000:

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$getdata = $this->getHierarchyParent($userdata['pos_id']);

						if(!empty($getdata['code'])){

							$nextPosCode = $getdata['code'];
							$nextPosName = $getdata['name'];

							$nextActivity = 5001;

						}

					} else {

						$employee_id_target = $employee_id;
						
						$nextActivity = 5000;
						
					}

					break;

					case 5001:

					$distribution = $this->getDistribution($distribution_id)->row_array();
					
					if($response == url_title('Setuju dan Lanjut',"_",true)){

						$getdata = $this->getHierarchyParent($userdata['pos_id']);

						if(!empty($getdata['code'])){

							$nextPosCode = $getdata['code'];
							$nextPosName = $getdata['name'];

							$nextActivity = 5001;

						} else {

							$employee_id_target = $distribution['pic_inv'];

							$w = array("employee_id"=>$employee_id_target);

							if(!empty($distribution['district_id_tujuan'])){
								$w['district_id'] = $distribution['district_id_tujuan'];
							}

							if(!empty($distribution['dept_id_tujuan'])){
								$w['dept_id'] = $distribution['dept_id_tujuan'];
							}

							$getdata = $this->getTableCodeName(
								"pos_id",
								"pos_name",
								"user_login_rule",
								$w);

							$nextPosCode = $getdata['code'];
							$nextPosName = $getdata['name'];

							$nextActivity = 5002;

						}

					} else {

						$w = array("employee_id"=>$distribution['created_by'],"job_title"=>"PETUGAS GUDANG");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $distribution['created_by'];

						$nextActivity = 5000;
						
					}

					break;

					case 5002:

					$data = $this->getDistribution($distribution_id)->row_array();

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$w = array("employee_id"=>$data['created_by'],"job_title"=>"PETUGAS GUDANG");

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"user_login_rule",
							$w);

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$employee_id_target = $data['created_by'];

						$nextActivity = 5003;

					}

					break;

					case 5003:
					
					if($response == url_title('Simpan dan Selesai',"_",true)){

						$nextActivity = 5004;

					} else {
						
						$nextActivity = 5000;
						
					}

					break;

					case 8000:

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"adm_pos",
							array(
								"job_title"=>"MANAJER GUDANG",
								//"dept_id"=>$userdata['dept_id'],
								"district_id"=>$userdata['district_id']
								));

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$nextActivity = 8001;

					} else {

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"adm_pos",
							array(
								"job_title"=>"PETUGAS GUDANG",
								//"dept_id"=>$userdata['dept_id'],
								"district_id"=>$userdata['district_id']
								));

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];
						
						$nextActivity = 8000;
						
					}

					break;

					case 8001:

					if($response == url_title('Setuju',"_",true)){

						switch ($userdata['job_title']) {
							case 'MANAJER GUDANG':
							$n = "KEPALA INVENTORY";
							$nextActivity = 8001;
							break;
							case 'KEPALA INVENTORY':
							$n = "KEPALA INVENTORY";
							$nextActivity = 8002;
							break;
							default:
								# code...
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

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"adm_pos",
							array(
								"job_title"=>"PETUGAS GUDANG",
								//"dept_id"=>$userdata['dept_id'],
								"district_id"=>$userdata['district_id']
								));

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];
						
						$nextActivity = 8000;
						
					}

					break;

					case 4000:

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$getdata = $this->getHierarchyParent($userdata['pos_id']);

						if(!empty($getdata['code'])){

							$nextPosCode = $getdata['code'];
							$nextPosName = $getdata['name'];

							$nextActivity = 4001;

						}

					}

					break;

					case 4001:
					
					if($response == url_title('Setuju dan Lanjut',"_",true)){

						$getdata = $this->getHierarchyParent($userdata['pos_id']);

						if(!empty($getdata['code'])){

							$nextPosCode = $getdata['code'];
							$nextPosName = $getdata['name'];

							$nextActivity = 4001;

						} else {

							$getdata = $this->getTableCodeName(
								"pos_id",
								"pos_name",
								"adm_pos",
								array(
									"job_title"=>"PETUGAS GUDANG",
									//"dept_id"=>$userdata['dept_id'],
									"district_id"=>$userdata['district_id']
									));

							$nextPosCode = $getdata['code'];
							$nextPosName = $getdata['name'];

							$nextActivity = 4002;

						}

					} else {

						$getdata = $this->getTableCodeName(
							"pos_id",
							"pos_name",
							"adm_pos",
							array(
								"job_title"=>"PETUGAS GUDANG",
								//"dept_id"=>$userdata['dept_id'],
								"district_id"=>$userdata['district_id']
								));

						$nextPosCode = $getdata['code'];
						$nextPosName = $getdata['name'];

						$nextActivity = 4000;
						
					}

					break;

					case 4002:
					
					if($response == url_title('Simpan dan Selesai',"_",true)){

						$nextActivity = 4003;

					}

					break;
					
					default:
					return array("message"=>"Aktifitas tidak ditemukan. Proses tidak berjalan");
					break;

				}

				if(empty($nextPosCode)){
					return array("message"=>"Posisi tidak berlanjut. Proses tidak berjalan");
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

					if($nextActivity == 7002){

						$this->db->where("posisi_user",2);
						$opname_anggota = $this->getStockOpnameUser($opname_id)->result_array();

						if(empty($opname_anggota)){

							return array("message"=>"Anggota opname tidak ditemukan. Proses tidak berjalan");

						} else {

							foreach ($opname_anggota as $key => $value) {

								$getdata = $this->getTableCodeName(
									"pos_id",
									"pos_name",
									"user_login_rule",
									array("employee_id"=>$value['user_id']));

								$nextPosCode = $getdata['code'];
								$nextPosName = $getdata['name'];

								$input = array(
									"contract_id"=>$contract_id,
									"opname_id"=>$opname_id,
									"position_id"=>$nextPosCode,
									"position"=>$nextPosName,
									"activity_id"=>$ret['nextactivity'],
									"user_id"=>$value['user_id'],
									"nama"=>$value['user_name']
									);

								$comment = $this->insertComment($input);

							}

						}

					} else {

						$input = array(
							"contract_id"=>$contract_id,
							"opname_id"=>$opname_id,
							"distribution_id"=>$distribution_id,
							"adjustment_id"=>$adjustment_id,
							"acquisition_id"=>$acquisition_id,
							"request_id"=>$request_id,
							"position_id"=>$ret['nextposcode'],
							"position"=>$ret['nextposname'],
							"activity_id"=>$ret['nextactivity'],
							"user_id"=>$employee_id_target
							);

						$comment = $this->insertComment($input);

					}

				}

				return $ret;

			}

		} else {

			return array("message"=>"Komentar tidak ditemukan. Proses tidak berjalan");

		}


	}

}