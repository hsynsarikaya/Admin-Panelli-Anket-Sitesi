<?php  require_once 'header.php'; ?>

<head>
    <script type="text/javascript" src="../js/jquery-ui.js"></script>
</head>


<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-9">
            <h1 class="page-header">Site Ayarları</h1>
        </div>
        <div style="margin-top: 40px;" class="col-lg-3" align="right">
            <a href="ayar-ekle.php"><button class="btn btn-success">Yeni Ayar Ekle</button></a>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Site Ayarları</div>
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>Sıra No</th>
                                <th>Ayar Ad</th>
                                <th>Ayar Türü</th>
                                <th>Açıklama</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                            $ayarsor=$db->prepare("SELECT * FROM ayar order by ayar_id ASC");
                            $ayarsor->execute();
                            $say=0;
                            while($ayarcek=$ayarsor->fetch(PDO::FETCH_ASSOC)){ $say++;
                                ?>

                                <tr  class="odd gradeX">
                                    <td width="90" align="center"><?php echo $say; ?></td>
                                    <td><?php echo $ayarcek['ayar_ad'] ?></td>
                                    <td><?php echo $ayarcek['ayar_tur'] ?></td>
                                    <td width="110"><?php echo $ayarcek['ayar_aciklama'] ?></td>
                                    <td width="20" class="center"><a href="ayar-duzenle.php?ayar_id=<?php echo $ayarcek['ayar_id']?>"><button class="btn btn-primary btn-xs ">Düzenle</button></a></td>
                                    <td width="20" class="center"><a href="../netting/islem.php?ayarsil=ok&ayar_id=<?php echo $ayarcek['ayar_id'] ?>"><button class="btn btn-danger btn-xs">Sil</button></a></td>
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



