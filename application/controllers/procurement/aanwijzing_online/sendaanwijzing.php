<?php 
$msg = $this->input->post('message');
				if(!empty($msg)){
					$parse = explode("#",$msg);
					$tipe = $parse[0];
					$kode = $tipe.'-'.$parse[1];
					$nama = htmlspecialchars($parse[2]);
					$pesan = htmlspecialchars($parse[3]);
					$waktu = date("Y-m-d H:i:s");
					$waktus = date("d/m/Y H:i");
					$i = $this->db->insert("adm_chat",array("datetime_ac"=>$waktu, "key_ac"=>$kode, "name_ac"=>$nama, 
						"message_ac"=>$pesan));
					if($tipe == 0){
						echo $tipe.'#'.$parse[1]."#".$nama."#".$pesan;
					} else {
						echo $tipe.'#'.$parse[1]."#".$nama."#".$pesan."<br/><small>(".$waktus.")</small>";
					}
				}