<?php  require_once 'header.php'; ?>

<head>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
</head>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-9">
            <h1 class="page-header">Cum. Bşk. Adayları</h1>

        </div>
        <div style="margin-top: 40px;" class="col-lg-3" align="right">
            <a href="aday-ekle.php"><button class="btn btn-success">Yeni Aday Ekle</button></a>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Başlık</div>
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Sıra No</th>
                                <th>Resim</th>
                                <th>Ad-Soyad</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="sortable">

                            <?php 
                            $cbadaysor=$db->prepare("SELECT * FROM cbaday order by aday_sira ASC");
                            $cbadaysor->execute();
                            $say=0;
                            while($adaycek=$cbadaysor->fetch(PDO::FETCH_ASSOC)){ $say++;
                                ?>

                                <tr id="item-<?php echo $adaycek['cbaday_id'] ?>" class="odd gradeX">
                                    <td width="90" align="center"><?php echo $say; ?></td>
                                    <td class="sortable" width="160"><img height="130" width="150" src="../../<?php echo $adaycek['cbaday_resimyol'] ?>"></td>
                                    <td><?php echo $adaycek['cbaday_adsoyad'] ?></td>
                                    <td width="20" class="center"><a href="aday-duzenle.php?cbaday_id=<?php echo $adaycek['cbaday_id']?>"><button class="btn btn-primary btn-xs ">Düzenle</button></a></td>
                                    <td width="20" class="center"><a href="../netting/islem.php?adaysil=ok&cbaday_id=<?php echo $adaycek['cbaday_id'] ?>"><button class="btn btn-danger btn-xs">Sil</button></a></td>
                                </tr>

                            <?php } ?>


                        </tbody>
                    </table>

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
    w
</script>

<!-- Sorttable Sıralama -->
<style type="text/css">
.sortable { cursor: move; }

</style>
<script type="text/javascript">

    $(function(){
        $("#sortable").sortable({
            revert:true,
            handle:".sortable",
            stop:function(event,ui){
                var data=$(this).sortable('serialize');
                $.ajax({
                    type:"POST",
                    dataType:"json",
                    data:data,
                    url:"ajaxadaysirala.php?p=aday_sira",
                    success:function(msg){
                        alert(msg.islemMsj);
                    }
                });
            }
        });
        $("#sortable").disableSelection();

    });
</script>