<?php  require_once 'header.php'; ?>




<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-9">
            <h1 class="page-header">Cum. Bşk. Adayı Ekleme Formu</h1>

        </div>
        <div style="margin-top: 40px;" class="col-lg-3" align="right">
            <a href="adaylar.php"><button class="btn btn-danger">Geri Dön</button></a>
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
                            <div><img id="adayresim" src="../../img/noimage.png" width="150" height="130"></div>
                        </div>
                        <div class="form-group">
                            <label">Aday Resmi Seçiniz</label>
                            <input id="file" type="file" name="file" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <label>Aday Ad Soyad</label>
                            <input type="text" class="form-control" name="cbaday_adsoyad"  placeholder="Aday Ad Soyad Giriniz">
                            <small  class="form-text text-muted">Adayın oylamada gözüken adını ve soyadını giriniz.</small>
                        </div>
                        <input type="hidden" name="adayekle">
                        <div align="right">
                            <button class="btn btn-success">Kaydet</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Bilgilendirme</div>
                <div class="panel-body">

                    <p>Aday Bilgilerini eksiksiz olarak doldurmasınız.</p>
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
                    swal("İşlem Sonucu",veri.message,veri.status)
                    
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