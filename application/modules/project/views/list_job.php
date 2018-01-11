<?php echo $this->session->flashdata('flash_message'); ?>
<div id="flash_message"></div>
<h4 class="widgettitle">Data Tabel Tugas
    <a onclick="actDelAll(<?php echo $id; ?>)" style=" margin-top: -7px;" class="btn btn-danger pull-right" ><i class="iconfa-remove icon-white"> </i> Hapus Semua</a>
    <a href="<?php echo site_url('project/create_report/' . $id); ?>" target="_blank" style="margin-top: -7px; margin-right: 5px;" class="btn pull-right" ><i class="iconfa-file-alt icon-white"> </i> Cetak PDF</a>
    <a href="<?php echo site_url('project/input_job/' . $id); ?>" class="btn btn-inverse pull-right" style="margin-top: -7px; margin-right: 5px; "><i class="iconfa-plus icon-white"> </i> Tambah</a>
</h4>
<table id="dyntable" class="table table-bordered table-condensed">
    <colgroup>
        <col class="con0" style="align: center; width: 4%" />
        <col class="con1" />
        <col class="con0" />
        <col class="con1" />
        <col class="con0" />
        <col class="con1" />

    </colgroup>
    <thead>
        <tr>          
            <th class="head0">No</th>
            <th class="head1">Nama Rambu</th>
            <th class="head0">Nama Jalan</th>
            <th class="head1">Status Pasang</th> 
            <th class="head0">Status Rambu</th>  
            <th class="head1">Aksi</th>  
        </tr>
    </thead>
    <tbody>  
        <?php
        if (!empty($job)) {
            $i = 1;
            foreach ($job as $key => $value) {
                ?>
                <tr class="gradeA">  
                    <td><?php echo $i; ?></td>               
                    <td><?php echo substr($value->nama_rambu,0,45); ?></td>                   
                    <td><?php echo substr(ucwords($value->lokasi_jalan),0,45); ?></td>
                    <td>
                        <?php
                        if ($value->status_pasang == 1) {
                            if ($value->status_rambu == 1) {
                                echo '<span class="label label-success">Terpasang</span>';
                            } else {
                                echo '<span class="label label-success">Terawat</span>';
                            }
                        } else {
                            if ($value->status_rambu == 1) {
                                echo '<span class="label label-important">Belum terpasang</span>';
                            } else {
                                echo '<span class="label label-important">Belum terawat</span>';
                            }
                        }
                        ?>
                    </td>         
                    <td>
                        <?php
                        if ($value->status_rambu == 1) {
                            echo 'Pemasangan';
                        } else {
                            echo 'Perawatan';
                        }
                        ?>
                    </td>    
                    <td class="center">
                        <a href="<?php echo site_url('project/get_job/' . $value->id_tugas); ?>" class="btn btn-info btn-circle"><i class="iconfa-pencil"></i></a>
                        <a href="#myModal<?php echo $value->id_tugas; ?>" class="btn btn-de btn-circle" data-toggle="modal"><i class="iconfa-search"></i></a>                  
                        <a onclick="actDel(<?php echo $value->id_tugas; ?>)" class="btn btn-danger btn-circle"><i class="iconfa-remove"></i></a>
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
if (!empty($job)) {
    foreach ($job as $key => $value) {
        ?>
        <div  id="myModal<?php echo $value->id_tugas; ?>" aria-hidden="false" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade in">
            <div class="modal-header">
                <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
                <h3 id="myModalLabel">Deskripsi Tugas</h3>
            </div>
            <div class="modal-body">
                <h4 class="widgettitle2"></h4>
                <div class="widgetcontent nopadding">
                    <form class="stdform stdform2" method="post" action="forms.html" />
                    <p>
                        <label>Lokasi Jalan</label>
                        <span class="field"><?php echo ucwords($value->lokasi_jalan); ?></span>
                    </p>
                    <p>
                        <label>Petugas Lapangan</label>
                        <span class="field">
                            <?php
                            if (empty($value->nama_plapangan)) {
                                echo 'Belum ditentukan';
                            } else {
                                echo ucwords($value->nama_plapangan);
                            }
                            ?>
                        </span>
                    </p>
                    <p>
                        <label>Petugas Survei</label>
                        <span class="field"><?php echo ucwords($value->nama_penyurvei); ?></span>
                    </p>
                    <p>
                        <label>Sisi Jalan</label>
                        <span class="field"><?php echo ucwords($value->sisi_jalan); ?></span>
                    </p>
                    <p>
                        <label>Status Rambu</label>
                        <span class="field">
                            <?php
                            if ($value->status_rambu == 1) {
                                echo 'Pemasangan';
                            } else if ($value->status_rambu == 2) {
                                echo 'Perawatan';
                            }
                            ?>
                        </span>
                    </p>
                    <p>
                        <label>Jenis Rambu</label>
                        <span class="field">
                            <?php
                            if ($job[0]->id_jenis_rambu == 1) {
                                echo 'Peringatan';
                            } else if ($job[0]->id_jenis_rambu == 2) {
                                echo 'Larangan';
                            } else if ($job[0]->id_jenis_rambu == 3) {
                                echo 'Perintah';
                            } else if ($job[0]->id_jenis_rambu == 4) {
                                echo 'Petunjuk';
                            }
                            ?>
                        </span>
                    </p>    
                    <p>
                        <label>Kode Rambu</label>
                        <span class="field"><?php echo $value->kode_rambu; ?></span>
                    </p>
                    <p>
                        <label>Nama Rambu</label>
                        <span class="field"><?php echo $value->nama_rambu; ?></span>
                    </p>
                    <p>
                        <label>Lebar Jalan</label>
                        <span class="field"><?php echo $value->lebar_jalan; ?> Meter</span>
                    </p>
                    <p>
                        <label>Lebar Bahu</label>
                        <span class="field"><?php echo $value->lebar_bahu_jalan; ?> Meter</span>
                    </p>
                    <p>
                        <label>Latitude</label>
                        <span class="field"><?php echo $value->lat; ?></span>
                    </p>
                    <p>
                        <label>Longtitude</label>
                        <span class="field"><?php echo $value->long; ?></span>
                    </p>
                    <p>
                        <label>Status pasang/rawat</label>
                        <span class="field">
                            <?php
                            if ($value->status_pasang == 1) {
                                if ($value->status_rambu == 1) {
                                    echo 'Terpasang';
                                } else {
                                    echo 'Terawat';
                                }
                            } else {
                                if ($value->status_rambu == 1) {
                                    echo 'Belum terpasang';
                                } else {
                                    echo 'Belum terawat';
                                }
                            }
                            ?>
                        </span>
                    </p>
                    <p>
                        <label>Keterangan Rambu</label>
                        <span class="field">
                            <?php
                            if ($value->keterangan == '') {
                                echo "-";
                            } else {
                                echo $value->keterangan;
                            }
                            ?>
                        </span>
                    </p>
                    <p>
                        <label>Foto
                            <small> <b>*scroll untuk memperbesar</b></small>    
                        </label>
                        <span class=" field img-container">
                            <?php if (!empty($value->foto)) { ?>
                                <img src = "<?php echo base_url() . $value->foto; ?>" alt = "<?php echo $value->foto; ?>" />
                            <?php } else { ?>
                                <img src = "<?php echo base_url() ?>/uploads/no_image.jpg" alt = "no image" />
        <?php } ?>                            
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
                    url: "<?php echo base_url(); ?>project/delete_job",
                    data: {id: object},
                    success: function (msg)
                    {
                        data = msg.split('|');
                        $('#flash_message').html(data[1]);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    },
                    error: function (msg)
                    {
                        data = msg.split('|');
                        $('#flash_message').html(data[0]);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }
                });
            }
        });
    }
    function actDelAll(object) {
        alertify.confirm("Apa anda yakin ingin menghapus semua data ini ?", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>project/delete_all_job/<?php echo $id; ?>",
                                        data: {id: object},
                                        success: function (msg)
                                        {
                                            data = msg.split('|');
                                            $('#flash_message').html(data[1]);
                                            setTimeout(function () {
                                                location.reload();
                                            }, 1000);
                                        },
                                        error: function (msg)
                                        {
                                            data = msg.split('|');
                                            $('#flash_message').html(data[0]);
                                            setTimeout(function () {
                                                location.reload();
                                            }, 1000);
                                        }
                                    });
                                }
                            });
                        }
</script>