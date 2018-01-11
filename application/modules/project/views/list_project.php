<?php echo $this->session->flashdata('flash_message'); ?>
<div id="flash_message"></div>
<h4 class="widgettitle">Data Tabel Projek 
    <a href="<?php echo site_url('project/'); ?>" class="btn btn-inverse pull-right" style="margin-top: -7px;"><i class="iconfa-plus icon-white"> </i> Tambah</a>

</h4>
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
            <th class="head1">Nama Projek</th>
            <th class="head0">Nama Daerah</th>
            <th class="head1">Status Projek</th> 
            <th class="head0">P. Lapangan</th> 
            <th class="head1">Total Data</th>  
            <th class="head0">Masa Projek</th> 
            <th class="head1">Aksi</th>  
        </tr>
    </thead>
    <tbody>  
        <?php
        if (!empty($project)) {
            $i = 1;
            foreach ($project as $key => $value) {
                ?>
                <tr class="gradeA">  
                    <td><?php echo $i; ?></td>               
                    <td><?php echo ucwords($value->nama_projek) ?></td>                   
                    <td><?php echo $value->nama_daerah; ?></td>
                    <td>
                        <?php
                        if ($value->status_projek == 0) {
                            echo '<span class="label label-warning">Proses survei</span>';
                        } else if ($value->status_projek == 1) {
                            echo '<span class="label label-important">Survei selesai</span>';
                        } else if ($value->status_projek == 2) {
                            echo '<span class="label label-info">Proses lapangan</span>';
                        } else {
                            echo '<span class="label label-success">Projek selesai</span>';
                        }
                        ?>
                    </td> 
                    <td>
                        <?php
                        if (empty($value->nama_plapangan)) {
                            echo 'Belum ditentukan';
                        } else {
                            echo ucwords($value->nama_plapangan);
                        }
                        ?>
                    </td>   
                    <td><span class="badge badge-info"><?php echo $value->total_data; ?></span></td> 
                    <td><?php echo $value->tgl_mulai; ?> s/d <?php echo $value->tgl_selesai; ?></td>
                    <td class="center">
                        <a href="<?php echo site_url('project/get_project/' . $value->id_projek); ?>" class="btn btn-info btn-circle"><i class="iconfa-pencil"></i></a>
                        <a href="<?php echo site_url('project/create_report/' . $value->id_projek); ?>" target="_blank" class="btn btn-inverse btn-circle"><i class="iconfa-print"></i></a>
                        <a href="<?php echo site_url('project/list_job/' . $value->id_projek); ?>" class="btn btn-de btn-circle"><i class="iconfa-search"></i></a>
                        <a onclick="actDel(<?php echo $value->id_projek; ?>)" class="btn btn-danger btn-circle"><i class="iconfa-remove"></i></a>
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
                    url: "<?php echo base_url(); ?>project/delete_project",
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