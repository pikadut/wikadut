<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Login extends CI_Model {
		
		public function do_login($email, $password){
			
			$login = "http://vendor.pengadaan.com:8888/RESTSERVICE/vndheader.json?token=123456&act=1&vndHeader.emailAddress=".$email."&vndHeader.password=".$password."&buyerId=8";
			 
			$jsonfile = file_get_contents($login);
			$arrays = json_decode($jsonfile, true);

			if(!empty($arrays["listVndHeader"][0]["vendorId"]) && !empty($arrays["listVndHeader"][0]["emailAddress"]) && $arrays["listVndHeader"][0]["status"] == '9'){
				
				//Cek Apakah User baru atau bukan
				$result = $this->db->query("select email_address, reg_status_name from vw_vnd_header where vendor_id = ".$arrays["listVndHeader"][0]["vendorId"]);
				if($result->num_rows() > 0){ //User terdaftar
				$result = $result->row_array();
					
					//$db_modified = $this->db->query("select modified_date from vnd_header where vendor_id = ".$arrays["listVndHeader"][0]["vendorId"])->row_array();
					//$db_modified = $this->db->query("SELECT EXTRACT(EPOCH FROM TIMESTAMP '".$db_modified["modified_date"]."' - INTERVAL '7 hour') as modified_date")->row_array();
					$modified_date = $arrays["listVndHeader"][0]["modifiedDate"]["time"]/1000;
					
					if(date("Y-m-d H:i:s",$modified_date) != date("Y-m-d H:i:s")){
						//vendor tidak update
						//cek vendor aktif atau tidak
						$stats = $this->db->query("select reg_isactivate from vnd_header where vendor_id = ".$arrays["listVndHeader"][0]["vendorId"])->row_array();
						if($stats["reg_isactivate"] == '1'){
							if($result["reg_status_name"] == 'Active'){
								return 1;
							}
							else if($result["reg_status_name"] == 'Suspended'){
								return 10;
							}
							else if($result["reg_status_name"] == 'Blacklist'){
								return 11;
							}
							else{
								return 12;
							}
						}
						else{
							return 9;
						}
					}else{
						//vendor update
						//update header
						if($arrays["listVndHeader"][0]["finClass"] == '1'){
							$klasifikasi = 'K';
						}
						else if($arrays["listVndHeader"][0]["finClass"] == '2'){
							$klasifikasi = 'M';
						}
						else if($arrays["listVndHeader"][0]["finClass"] == '3'){
							$klasifikasi = 'B';
						}
						else{
							if(strtolower($arrays["listVndHeader"][0]["siupType"]) == 'kecil'){
								$klasifikasi = 'K';
							}
							else if(strtolower($arrays["listVndHeader"][0]["siupType"]) == 'menengah'){
								$klasifikasi = 'M';
							}
							else if(strtolower($arrays["listVndHeader"][0]["siupType"]) == 'besar'){
								$klasifikasi = 'B';
							}
							else{
								$klasifikasi = 'undefined';
							}
						}
						
						$this->db->trans_begin();
						$create_date = $arrays["listVndHeader"][0]["creationDate"]["time"]/1000;
					$modified_date = $arrays["listVndHeader"][0]["modifiedDate"]["time"]/1000;
					$query = "UPDATE vnd_header set 
					vendor_name = '".$arrays["listVndHeader"][0]["vendorName"]."', 
					email_address = '".$arrays["listVndHeader"][0]["emailAddress"]."', 
					npwp_pkp = '".$arrays["listVndHeader"][0]["npwpPkp"]."', 
					fin_class = '".$klasifikasi."', 
					creation_date = '".date("Y-m-d H:i:s",$create_date)."', 
					modified_date = '".date("Y-m-d H:i:s",$modified_date)."', 
					reg_isactivate = 0, 
					address_street = '".$arrays["listVndHeader"][0]["addressStreet"]."' where vendor_id = ".$arrays["listVndHeader"][0]["vendorId"];
						$result = $this->db->query($query); //update header vendor
						
						if($this->db->affected_rows($result) > 0){
							//update barang&jasa
							$barang = "http://vendor.pengadaan.com:8888/RESTSERVICE/vndproduct.json?token=123456&vendorId=".$arrays["listVndHeader"][0]["vendorId"]."&act=1";
							$jsonfile = file_get_contents($barang);
							$product = json_decode($jsonfile, true);
							
							$affected_rowss = 0;
							$totals = 0;
							
							$this->db->query("DELETE FROM vnd_product WHERE vendor_id = ".$arrays["listVndHeader"][0]["vendorId"]);
							
							foreach($product["listVndProduct"] as $row){
							$insert_barang = $this->db->query("INSERT INTO vnd_product ( product_id, vendor_id, product_name, product_code, product_description, brand, source, type, islisted ) VALUES ( ".$row["productId"].", ".$row["vndHeader"].", '".$row["productName"]."', '".str_replace(".", "", $row["productCode"])."', '".$row["productDescription"]."', '".$row["brand"]."', '".strtoupper($row["source"])."', '".strtoupper($row["type"])."', '".$row["isListed"]."' )");
								
								if($this->db->affected_rows($insert_barang) > 0){
									$affected_rowss = $affected_rowss + $this->db->affected_rows($insert_barang);
								}
								$totals++;
							}
							
							if($affected_rowss == $totals){
								//berhasil update barang
								$this->db->trans_commit();
								return 2;
							}
							else{
								//gagal update barang
								$this->db->trans_rollback();
								return 3;
							}
						}
						else{
							//gagal update header vendor
							$this->db->trans_rollback();
							return 4;
						}
					}
				}
				else{ // User Belum terdaftar
					if($arrays["listVndHeader"][0]["finClass"] == '1'){
						$klasifikasi = 'K';
					}
					else if($arrays["listVndHeader"][0]["finClass"] == '2'){
						$klasifikasi = 'M';
					}
					else if($arrays["listVndHeader"][0]["finClass"] == '3'){
						$klasifikasi = 'B';
					}
					else{
						if(strtolower($arrays["listVndHeader"][0]["siupType"]) == 'kecil'){
							$klasifikasi = 'K';
						}
						else if(strtolower($arrays["listVndHeader"][0]["siupType"]) == 'menengah'){
							$klasifikasi = 'M';
						}
						else if(strtolower($arrays["listVndHeader"][0]["siupType"]) == 'besar'){
							$klasifikasi = 'B';
						}
						else{
							$klasifikasi = 'undefined';
						}
					}
					
					//start code hlmifzi
					$this->db->trans_begin();
					$create_date = $arrays["listVndHeader"][0]["creationDate"]["time"]/1000;
					$addressDomisiliExpDate = $arrays["listVndHeader"][0]["addressDomisiliExpDate"]["time"]/1000;
					$modified_date = $arrays["listVndHeader"][0]["modifiedDate"]["time"]/1000;
					$query = "INSERT into vnd_header (vendor_id, vendor_name, email_address, npwp_pkp, fin_class, creation_date, modified_date, reg_isactivate, address_street, address_domisili_exp_date) values(".$arrays["listVndHeader"][0]["vendorId"].", '".$arrays["listVndHeader"][0]["vendorName"]."', '".$arrays["listVndHeader"][0]["emailAddress"]."', '".strtoupper($arrays["listVndHeader"][0]["npwpPkp"])."', '".$klasifikasi."','".date("Y-m-d H:i:s",$create_date)."', '".date("Y-m-d H:i:s",$modified_date)."', 0, '".$arrays["listVndHeader"][0]["addressStreet"]."', '".date("Y-m-d H:i:s",$addressDomisiliExpDate)."')";
					$result = $this->db->query($query); //insert header vendor baru

					//end
					
					if($this->db->affected_rows($result) > 0){
						//insert barang vendor baru
						$barang = "http://vendor.pengadaan.com:8888/RESTSERVICE/vndproduct.json?token=123456&vendorId=".$arrays["listVndHeader"][0]["vendorId"]."&act=1";
						$jsonfile = file_get_contents($barang);
						$product = json_decode($jsonfile, true);
						
						$affected_rowss = 0;
						$totals = 0;
						foreach($product["listVndProduct"] as $row){
							$jumlah = $this->db->query("select product_id from vnd_product where product_id = ".$row["productId"])->num_rows();
							if($jumlah > 0){
								$insert_barang = $this->db->query("UPDATE vnd_product SET vendor_id = ".$row["vndHeader"].", product_name = '".$row["productName"]."', product_code = '".str_replace(".", "", $row["productCode"])."', product_description = '".$row["productDescription"]."', brand = '".$row["brand"]."', source = '".strtoupper($row["source"])."', type = '".strtoupper($row["type"])."', islisted = '".$row["isListed"]."' WHERE product_id = ".$row["productId"]);
							}
							else{
								$insert_barang = $this->db->query("INSERT INTO vnd_product ( product_id, vendor_id, product_name, product_code, product_description, brand, source, type, islisted ) VALUES ( ".$row["productId"].", ".$row["vndHeader"].", '".$row["productName"]."', '".str_replace(".", "", $row["productCode"])."', '".$row["productDescription"]."', '".$row["brand"]."', '".strtoupper($row["source"])."', '".strtoupper($row["type"])."', '".$row["isListed"]."' )");
							}
							
							if($this->db->affected_rows($insert_barang) > 0){
								$affected_rowss = $affected_rowss + $this->db->affected_rows($insert_barang);
							}
							$totals++;
						}
						
						if($affected_rowss == $totals){
							//berhasil insert barang vendor baru
							$this->db->trans_commit();
							return 5;
						}
						else{
							//gagal insert barang vendor baru
							$this->db->trans_rollback();
							return 6;
						}
						
					}
					else{
						// gagal insert header vendor baru
						$this->db->trans_rollback();
						return 7;
					}
					
				}
			}
			else{
				//data kosong. username/password salah atau sedang tidak aktif
				return 8;
			}
		}
	}				