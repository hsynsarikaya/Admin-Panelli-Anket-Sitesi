
<?php
ob_start();
session_start();
require_once 'baglan.php';

require_once '../pages/fonksiyon.php';
//Kullanıcı giriş ekranı boş olma durumu başlangıç
if (isset($_POST['login'])) {
	if (empty($_POST['kullanici_mail']) or empty($_POST['kullanici_password'])) {
		$data ['status']="error";
		$data ['message']="Mail veya şifre boş olamaz";
		echo json_encode($data);
		exit;
	}
	//Kullanıcı kontrol başlangıç
	$kullanicisor=$db->prepare("SELECT * FROM kullanici where kullanici_mail=:mail and kullanici_password=:password");
	$kullanicisor->execute(array(
		'mail' => $_POST['kullanici_mail'],
		'password' =>md5($_POST['kullanici_password'])
	));


	$say=$kullanicisor->rowCount();

	if ($say>0) {

		$_SESSION['userkullanici_mail']=$_POST['kullanici_mail'];
		$data ['status']="success";
		$data ['message']="Giriş Başarılı";
		echo json_encode($data);

	}else{

		$data ['status']="error";
		$data ['message']="Kullanıcı Bulunamadı";
		echo json_encode($data);
		exit;

	}
//Kullanıcı kontrol son

}
//Kullanıcı giriş ekranı boş olma durumu son

//Aday ekle başlangıç
if (isset($_POST['adayekle'])) {

	if ($_FILES['file']['size']>1000000) {
		
		$data['status']="error";
		$data['message']="Resim boyutu 1mb 'dan büyük olamaz";
		echo json_encode($data);
		exit;

	}
	$izinli_uzantilar=array('jpg','png');
	$ext=strtolower(substr($_FILES['file']['name'],strpos($_FILES['file']['name'], '.')+1));
	if (in_array($ext, $izinli_uzantilar)===false) {
		$data['status']="error";
		$data['message']="Sadece jpg ve png uzantılı resimler";
		echo json_encode($data);
		exit;
	}

	$uploads_dir='../../img/adayresim';
	@$tmp_name=$_FILES['file']['tmp_name'];
	@$name=$_FILES['file']['name'];

	$uniq=uniqid();
	$refimgyol=substr($uploads_dir, 6)."/".$uniq.".".$ext;
	@move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");

	$kaydet=$db->prepare("INSERT INTO cbaday SET
		cbaday_adsoyad=:adsoyad,
		cbaday_resimyol=:resimyol
		");
	$insert=$kaydet->execute(array(

		'adsoyad' => htmlspecialchars($_POST['cbaday_adsoyad']),
		'resimyol' => $refimgyol

	));
	if ($insert) {
		$data['status']="success";
		$data['message']="Kayıt Başarılı";
		echo json_encode($data);
		exit;
	}else{
		$data['status']="error";
		$data['message']="Kayıt Başarısız";
		echo json_encode($data);
		exit;
	}
}
//Aday ekle son



//Aday Düzenle başlangıç
if (isset($_POST['adayduzenle'])) {

	if ($_FILES['file']['size']>1000000) {
		
		$data['status']="error";
		$data['message']="Resim boyutu 1mb 'dan büyük olamaz";
		echo json_encode($data);
		exit;

	}
	$izinli_uzantilar=array('jpg','png');
	$ext=strtolower(substr($_FILES['file']['name'],strpos($_FILES['file']['name'], '.')+1));
	if (in_array($ext, $izinli_uzantilar)===false) {
		$data['status']="error";
		$data['message']="Sadece jpg ve png uzantılı resimler";
		echo json_encode($data);
		exit;
	}
	$uploads_dir='../../img/adayresim';
	@$tmp_name=$_FILES['file']['tmp_name'];
	@$name=$_FILES['file']['name'];
	$uniq=uniqid();
	$refimgyol=substr($uploads_dir, 6)."/".$uniq.".".$ext;
	@move_uploaded_file($tmp_name, "$uploads_dir/$uniq.$ext");
	$kaydet=$db->prepare("UPDATE  cbaday SET

		cbaday_adsoyad=:adsoyad,
		cbaday_resimyol=:resimyol
		WHERE cbaday_id={$_POST['cbaday_id']}");

	$update=$kaydet->execute(array(

		'adsoyad' => htmlspecialchars($_POST['cbaday_adsoyad']),
		'resimyol' => $refimgyol

	));
	if ($update) {

		unlink("../../{$_POST['eski_yol']}");
		$data['status']="success";
		$data['message']="Güncelleme Başarılı";
		echo json_encode($data);
		exit;

	}else{

		$data['status']="error";
		$data['message']="Güncelleme Başarısız";
		echo json_encode($data);
		exit;

	}
}
//Aday Düzenle son

//Aday Sil başlangıç
if ($_GET['adaysil']=="ok") {

	$sil=$db->prepare("DELETE from cbaday where cbaday_id=:id");
	$kontrol=$sil->execute(array(
		'id' => $_GET['cbaday_id']
	));

	if ($kontrol) {

		Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarili");

	}else{

		Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarisiz");

	}
}
//Aday Sil son




//Ayar Ekleme Başlangıç
if (isset($_POST['ayarekle'])) {

	
	if (strlen($_POST['ayar_ad'])==0 or strlen($_POST['ayar_tur'])==0) {
		
		$data['status']="error";
		$data['message']="Tüm alanlarını doldurmalısınız";
		echo json_encode($data);
		exit;
	}
	
	$kaydet=$db->prepare("INSERT INTO ayar SET
		ayar_ad=:ad,
		ayar_tur=:tur
		");
	$insert=$kaydet->execute(array(

		'ad' => htmlspecialchars($_POST['ayar_ad']),
		'tur' => htmlspecialchars($_POST['ayar_tur'])

	));
	if ($insert) {
		$data['status']="success";
		$data['message']="Kayıt Başarılı";
		echo json_encode($data);
		exit;
	}else{
		$data['status']="error";
		$data['message']="Kayıt Başarısız";
		echo json_encode($data);
		exit;
	}
}
//Ayar Ekleme Son

 //Ayar Silme Başlangıç
if ($_GET['ayarsil']=="ok") {

	$sil=$db->prepare("DELETE from ayar where ayar_id=:id");
	$kontrol= $sil->execute(array(
		'id' => $_GET['ayar_id']
	));

	if ($kontrol) {

		Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarili");

	}else{

		Header("Location:{$_SERVER['HTTP_REFERER']}?durum=basarisiz");

	}
}
//Ayar Silme Son

//Ayar Düzenle başlangıç
if (isset($_POST['ayarduzenle'])) {

	if (strlen($_POST['ayar_ad'])==0 or strlen($_POST['ayar_tur'])==0) {
		
		$data['status']="error";
		$data['message']="Tüm alanlarını doldurmalısınız";
		echo json_encode($data);
		exit;
	}
	
	$ayar_id=$_POST['ayar_id'];
	$kaydet=$db->prepare("UPDATE  ayar SET

		ayar_ad=:ad,
		ayar_tur=:tur
		WHERE ayar_id=$ayar_id");

	$update=$kaydet->execute(array(

		'ad' => htmlspecialchars($_POST['ayar_ad']),
		'tur' => htmlspecialchars($_POST['ayar_tur'])


	));
	if ($update) {

		
		$data['status']="success";
		$data['message']="Güncelleme Başarılı";
		echo json_encode($data);
		exit;

	}else{

		$data['status']="error";
		$data['message']="Güncelleme Başarısız";
		echo json_encode($data);
		exit;

	}
}
//Ayar Düzenle son

//mail ayarları
if (isset($_POST['oymail'])) {
	if (empty($_POST['kullanici_mail'])) {
		$data ['status']="error";
		$data ['message']="Geçerli bir mail adresi giriniz";
		echo json_encode($data);
		exit;
	}

	$oysor=$db->prepare("SELECT * FROM oy where oy_araci=:araci");
    $oysor->execute(array(
    	'araci' => $_POST['kullanici_mail']
    ));
    $say=$oysor->rowCount();
    if ($say>0) {
    	$data ['status']="info";
		$data ['message']="Daha önce oy kullandınız";
		echo json_encode($data);
		exit;
    }
    
 
	$mailKonu="CB Aday Mail Onay Şifreniz";
	$mesaj=rand(1000, 3000);
	$_SESSION['mailonaykodu']=$mesaj;
	$_SESSION['kullanici_mail']=$_POST['kullanici_mail'];
	mailgonder($_POST['kullanici_mail'],$mailKonu,$mesaj);
	$data ['status']="success";
	$data ['message']="Mail Onay Kodu Gönderilmiştir.Mailinizi Kontrol Edin.".$mesaj;
	$data['islemno']="1";
	echo json_encode($data);
	exit;
} 



if (isset($_POST['onaykodu'])) {
	if ($_SESSION['mailonaykodu']==$_POST['kullanici_onaykodu']) {

		$kaydet=$db->prepare("INSERT INTO oy SET
			cbaday_id=:id,
			oy_araci=:araci
			");
		$insert=$kaydet->execute(array(

			'id' => $_POST['cbaday_id'],
			'araci' => $_SESSION['kullanici_mail']

		));
		if ($insert) {
			$data['status']="success";
			$data['message']="Oy verme Başarılı";
			$data['islemno']="2";
			echo json_encode($data);
			exit;
		}else{
			$data['status']="error";
			$data['message']="Oy verme başarısız";
			echo json_encode($data);
			exit;
		}

		
	}else{
		$data ['status']="error";
		$data ['message']="Onay Kodu Hatalı.";
		echo json_encode($data);
		exit; 
	}
	
}
?>