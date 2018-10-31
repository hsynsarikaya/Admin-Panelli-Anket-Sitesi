<?php 
include '../netting/baglan.php';

if(isset($_GET['p'])){

	if($_GET['p'] =='aday_sira' ){
		if(is_array($_POST['item'])){

			foreach ($_POST['item'] as $key => $value) {
				$ayarkaydet=$db->prepare("UPDATE cbaday SET aday_sira=:aday_sira WHERE cbaday_id={$value}",array($key,$value));
				$update=$ayarkaydet->execute(array(
					'aday_sira' => $key
				));
			}

			$returnMsg=array('islemSonuc'=>true,'islemMsj'=>'Güncellendi');
		}
		else {
			$returnMsg=array('islemSonuc'=>false,'islemMsj'=>'Güncellenemedi');
		}

	}

}
if(isset($returnMsg)){
	echo json_encode($returnMsg);
}

?>