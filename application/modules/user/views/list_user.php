<?php echo $this->session->flashdata('flash_message'); ?>
<div id="flash_message"></div>
<h4 class="widgettitle">Data Tabel Petugas <a href="<?php echo site_url('user/'); ?>" class="btn btn-inverse pull-right" style="margin-top: -7px;"><i class="iconfa-plus icon-white"> </i> Tambah</a></h4>
<table id="dyntable" class="table table-bordered table-condensed">
    <colgroup>
        <col class="con0" style="align: center; width: 4%" />
        <col class="con1" />
        <col class="con0" />
        <col class="con1" />
        <col class="con0" />
        <col class="con1" />
        <col class="con0" />
    </colgroup>
    <thead>
        <tr>          
            <th class="head0">No</th>
            <th class="head1">Nama Petugas</th>
            <th class="head0">Email</th>
            <th class="head1">No HP</th>
            <th class="head0">Posisi</th>
            <th class="head1">Action</th>
        </tr>
    </thead>
    <tbody>  
        <?php
        if (!empty($list)) {
            $i = 1;
            foreach ($list as $key => $value) {
                ?>
                <tr class="gradeA">  
                    <td><?php echo $i; ?></td>
                    <td><?php echo ucwords($value->nama_petugas); ?></td>
                    <td><?php echo $value->email ?></td>                    
                    <td><?php echo $value->no_telp; ?></td>                  
                    <td>
                        <?php
                        if ($value->id_posisi == 1) {
                            echo 'Survei';
                        } else if ($value->id_posisi == 2) {
                            echo 'Audit';
                        } else if ($value->id_posisi == 3) {
                            echo 'Lapangan';
                        }
                        ?>
                    </td>
                    <td class="center">
                        <a href="<?php echo site_url('user/get_user/' . $value->id_user); ?>" class="btn btn-info btn-circle"><i class="iconfa-pencil"></i></a>
                        <a href="#myModal<?php echo $value->id_user; ?>" class="btn btn-de btn-circle" data-toggle="modal"><i class="iconfa-search"></i></a>
                        <a onclick="actDel(<?php echo $value->id_user; ?>)" class="btn btn-danger btn-circle"><i class="iconfa-remove"></i></a>
                    </td>
                </tr>
                <?php
                $i++;
            }  //ngatur nomor urut
        }
        ?>
    </tbody>
</table>
<?php
if (!empty($list)) {
    foreach ($list as $key => $value) {
        ?>
        <div  id="myModal<?php echo $value->id_user; ?>" aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                <h3 id="myModalLabel">Deskripsi Petugas</h3>
            </div>
            <div class="modal-body">
                <h4 class="widgettitle2"></h4>
                <div class="widgetcontent nopadding">
                    <form class="stdform stdform2" method="post" action="forms.html" />
                    <p>
                        <label>Nama Petugas</label>
                        <span class="field"><?php echo ucwords($value->nama_petugas); ?></span>
                    </p>

                    <p>
                        <label>Username</label>
                        <span class="field"><?php echo ucwords($value->username); ?></span>
                    </p>
                    <p>
                        <label>Email</label>
                        <span class="field"><?php echo $value->email; ?></span>
                    </p>
                    <p>
                        <label>Posisi Jabatan</label>
                        <span class="field">
                            <?php
                            if ($value->id_posisi == 1) {
                                echo 'Survei';
                            } else if ($value->id_posisi == 2) {
                                echo 'Audit';
                            } else if ($value->id_posisi == 3) {
                                echo 'Lapangan';
                            }
                            ?>
                        </span>
                    </p>                    
                    <p>
                        <label>No Telepon</label>
                        <span class="field"><?php echo $value->no_telp; ?></span>
                    </p>
                    <p>
                        <label>Alamat</label>
                        <span class="field"><?php echo $value->alamat; ?></span>
                    </p>     
                    <p>
                        <label>Foto
                            <small> <b>*scroll untuk memperbesar</b></small>    
                        </label>
                        <span class=" field img-container">
                            <img src="<?php echo base_url() . $value->foto; ?>" alt="Picture">
                        </span>

                    </p>
                    </form>
                </div><!--widgetcontent-->
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-inverse">Close</button>        
            </div>
        </div><!--#myModal-->
        <?php
    }
}
?>	
<script type="text/javascript">
    function actDel(object) {
        alertify.confirm("Apa anda yakin ingin menghapus data ini ?", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>user/delete_user",
                    data: {id: object},
                    success: function (msg)
                    {
                        data = msg.split('|');
                        $('#flash_message').html(data[1]);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                });
            }
        });
    }
</script>