<?php echo $this->session->flashdata('flash_message'); ?>
<div id="flash_message"></div>
<h4 class="widgettitle">Data Tabel Rambu Lalu Lintas <a href="<?php echo site_url('traffic/'); ?>" class="btn btn-inverse pull-right" style="margin-top: -7px;"><i class="iconfa-plus icon-white"> </i> Tambah</a></h4>
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
            <th class="head1">Gambar</th>
            <th class="head0">Jenis Rambu</th>
            <th class="head1">Nama Rambu</th>
            <th class="head0">Kode Rambu</th>
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
                    <td>
                        <?php if ($value->foto == true) {
                            ?>
                            <img height="33" width="33" src="<?php echo base_url() . $value->foto_thumb; ?>">
                            <br>
                        <?php } ?>
                    </td> 
                    <td> <?php
                        if ($value->id_jenis_rambu == 1) {
                            echo 'Peringatan';
                        } else if ($value->id_jenis_rambu == 2) {
                            echo 'Larangan';
                        } else if ($value->id_jenis_rambu == 3) {
                            echo 'Perintah';
                        } else if ($value->id_jenis_rambu == 4) {
                            echo 'Petunjuk';
                        }
                        ?>
                    </td>
                    <td><?php echo $value->nama_rambu; ?></td>
                    <td><?php echo $value->kode_rambu ?></td>                                                  
                    <td class="center">
                        <a href="<?php echo site_url('traffic/get_sign/' . $value->id_rambu); ?>" class="btn btn-info btn-circle"><i class="iconfa-pencil"></i></a> 
                        <a onclick="actDel(<?php echo $value->id_rambu; ?>)" class="btn btn-danger btn-circle"><i class="iconfa-remove"></i></a>
                    </td>
                </tr>
                <?php
                $i++;
            }  //ngatur nomor urut
        }
        ?>
    </tbody>
</table>
<script type="text/javascript">
    function actDel(object) {
        alertify.confirm("Apa anda yakin ingin menghapus data ini ?", function (e) {
            if (e) {
                $.ajax({
                    type: "post",
                    url: "<?php echo base_url(); ?>traffic/delete_sign",
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