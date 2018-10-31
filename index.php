 <?php require_once 'header.php'; ?>
 
 <!-- Page Content -->
 <div class="container">

  <!-- Introduction Row -->
  <h1 class="my-4">CB
    <small>Cumhurbaşkanı Seçim Anketi</small>
  </h1>
  <p>Cumhurbaşkanlığı anket sistemi.</p>

  <!-- Team Members Row -->
  <div class="row">
    <div class="col-lg-12">
      <h2 class="my-4">Adaylar</h2>
    </div>

    <?php 
    $cbadaysor=$db->prepare("SELECT * FROM cbaday order by aday_sira asc");
    $cbadaysor->execute();
    
    while($adaycek=$cbadaysor->fetch(PDO::FETCH_ASSOC)){ 
      ?>

      <div class="col-lg-4 col-sm-6 text-center mb-4">
        <img width="150" class="rounded-circle img-fluid d-block mx-auto" src="<?php echo$adaycek['cbaday_resimyol']?>" alt="<?php echo $adaycek['cbaday_adsoyad']?>">
        <h3><?php echo $adaycek['cbaday_adsoyad']?></h3>
        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#oykutusu<?php echo $adaycek['cbaday_id'] ?>">Oy Ver</button>

      </div>

      <!-- Modal -->
      <div class="modal fade" id="oykutusu<?php echo $adaycek['cbaday_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Oyunu Kullan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="mailonaykodu<?php echo $adaycek['cbaday_id'] ?>" method="POST">
              <div class="modal-body">
                <p>Oy verme işleminizin geçerli sayılabilmesi için 4 haneli bir şifre gönderilecektir.Mail kutunuzun spam klasörünüde kontrol ediniz.</p>
                <p id="sonuc<?php echo $adaycek['cbaday_id']; ?>"></p>
                <div id="mailadres<?php echo $adaycek['cbaday_id']; ?>" class="form-group">
                  <label for="exampleFormControlInput1">Email Adresiniz</label>
                  <input type="email" class="form-control" name="kullanici_mail"  placeholder="Geçerli bir mail adresi giriniz">
                  <input id="oymails" type="hidden" name="oymail">
                  <input type="hidden" name="cbaday_id" value="<?php echo $adaycek['cbaday_id']?>">
                </div>

                <div id="onaykodu<?php echo $adaycek['cbaday_id']; ?>" class="form-group">
                  <label for="exampleFormControlInput1">Onay Kodunuz</label>
                  
                  <input type="text" class="form-control" name="kullanici_onaykodu"  placeholder="Gelen Onay Kodunu Giriniz">
                  <input type="hidden" name="onaykodu">

                  <input type="hidden" name="cbaday_id" value="<?php echo $adaycek['cbaday_id']?>">
                </div>

              </div>

              <div class="modal-footer">

                <button id="mailgonderbuton<?php echo $adaycek['cbaday_id']; ?>" type="submit" class="btn btn-primary">Doğrulama Kodu İste</button>
                <button id="dogrulamakodbuton<?php echo $adaycek['cbaday_id']; ?>" type="submit" class="btn btn-success">Oyunu Kullan</button>

              </div>
            </form>

          </div>
        </div>
      </div>
      <script type="text/javascript">
        $(document).ready(function(){
          $("#onaykodu<?php echo $adaycek['cbaday_id']; ?>").hide();
          $("#dogrulamakodbuton<?php echo $adaycek['cbaday_id']; ?>").hide();

        });
        $("#mailonaykodu<?php echo $adaycek['cbaday_id']; ?>").on('submit',(function(e){


          $.ajax({

            url:"admin/netting/islem.php",
            type:"POST",
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            success: function(data){
              veri=JSON.parse(data);
              swal("İşlem Sonucu",veri.message,veri.status)

              if (veri.islemno=="1") {
                $("#oymails").attr('disabled');
                $("#mailadres<?php echo $adaycek['cbaday_id']; ?>").hide();
                $("#mailadres<?php echo $adaycek['cbaday_id']; ?>").remove();
                $("#mailgonderbuton<?php echo $adaycek['cbaday_id']; ?>").hide();
                $("#onaykodu<?php echo $adaycek['cbaday_id']; ?>").show(); 
                $("#dogrulamakodbuton<?php echo $adaycek['cbaday_id']; ?>").show(); 
              }else if (veri.islemno=="2") {
                $("#onaykodu<?php echo $adaycek['cbaday_id']; ?>").remove();
                $("#dogrulamakodbuton<?php echo $adaycek['cbaday_id']; ?>").remove();  
                $("#sonuc<?php echo $adaycek['cbaday_id']; ?>").text("Oyunuz Başarıyla Kaydedildi.");
              }
            }

          });
          return false;

        }));

      </script>
    <?php } ?>

  </div>

</div>
<!-- /.container -->

<?php require_once 'footer.php'; ?>
