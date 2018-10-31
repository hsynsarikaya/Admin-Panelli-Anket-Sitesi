<?php  require_once 'header.php';


$ayarsor=$db->prepare("SELECT * FROM ayar where ayar_id=:id");
$ayarsor->execute(array(
    'id' => htmlspecialchars($_GET['ayar_id'])
));

$ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC);

?>




<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-9">
            <h1 class="page-header">Site ayarı Düzenleme Formu</h1>

        </div>
        <div style="margin-top: 40px;" class="col-lg-3" align="right">
            <a href="ayarlar.php"><button class="btn btn-danger">Geri Dön</button></a>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Başlık</div>
                <div class="panel-body">

                    <form id="uploadform" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <div id="mesaj"></div>
                        </div>
                        
                        
                        <div class="form-group">
                            <label>Ayar Adı</label>
                            <input type="text" class="form-control" name="ayar_ad"  value="<?php echo $ayarcek['ayar_ad'] ?>">
                            <small  class="form-text text-muted">Site Ayar Adı.</small>
                        </div>
                        <div class="form-group">
                            <label>Ayar Turu</label>
                            <input type="text" class="form-control" name="ayar_tur"  value="<?php echo $ayarcek['ayar_tur'] ?>">
                            <small  class="form-text text-muted">Site ayar türü.</small>
                        </div>
                        <input type="hidden" name="ayarduzenle">
                        <input type="hidden" name="ayar_id" value="<?php echo $_GET['ayar_id'] ?>">
                        

                        <div align="right">
                            <button class="btn btn-success">Güncelle</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Bilgilendirme</div>
                <div class="panel-body">

                    <p>Ayar Bilgilerini eksiksiz olarak doldurmasınız.</p>
                </div>

            </div>
        </div>
        <!-- /.row -->

        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<?php  require_once 'footer.php'; ?>

<script type="text/javascript">

    $(document).ready(function(e){

        $("#uploadform").on('submit',(function(e){


            $.ajax({

                url:"../netting/islem.php",
                type:"POST",
                data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                success: function(data){

                    veri = JSON.parse(data);
                    swal("",veri.message,veri.status)

                }

            });
            return false;

        }));




        $("#file").change(function(){

            var reader= new FileReader();
            reader.onload = imageload;
            reader.readAsDataURL(this.files[0]);

        });

        function imageload(e){

            $("#adayresim").attr('src',e.target.result);

        }

    });
    
</script>