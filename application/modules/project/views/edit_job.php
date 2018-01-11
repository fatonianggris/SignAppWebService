<?php echo $this->session->flashdata('flash_message'); ?>
<style>
    .styled-select select{
        appearance:none;
        -moz-appearance:none; /* Firefox */
        -webkit-appearance:none;

    }
</style>
<div class="widget">
    <h4 class="widgettitle">Formulir Tugas
        <a href="<?php echo site_url('project/list_job/' . $job[0]->id_projek); ?>" style=" margin-top: -7px;" class="btn btn-inverse pull-right" ><i class="iconfa-eye-open icon-white"></i> List Tugas</a>
    </h4>
    <div class="widgetcontent">
        <form class="stdform" action="<?php echo site_url('project/edit_job/' . $job[0]->id_tugas); ?>" enctype="multipart/form-data" method="post" /> 
        <p>
            <label>Lokasi Jalan*</label>
            <span class="field"><input type="text" name="lokasi" value="<?php echo $job[0]->lokasi_jalan ?>" class="input-xxlarge" placeholder="input lokasi jalan" /></span>
        </p>
        <p>
            <label>Sisi Jalan*</label>
            <span class="field"><input type="text" name="sisi_jalan"  value="<?php echo $job[0]->sisi_jalan ?>" class="input-xxlarge" placeholder="input sisi jalan" /></span>
        </p>   
        <p>
            <label>Status Rambu*</label>
            <span class="field">
                <select name="status_rambu" class="uniformselect">
                    <option value="<?php echo $job[0]->status_rambu ?>" />
                    <?php
                    if ($job[0]->status_rambu == 1) {
                        echo 'Pemasangan';
                    } else if ($job[0]->status_rambu == 2) {
                        echo 'Perawatan';
                    }
                    ?>
                    <option value="1" />Pemasangan
                    <option value="2" />Perawatan                
                </select>
            </span>
        </p> 
        <p>
            <label>Jenis Rambu*</label>
            <span class="field">
                <select onchange="selectType(this.options[this.selectedIndex].value)" name="jenis_rambu" class="uniformselect">
                    <option value="<?php echo $job[0]->id_jenis_rambu ?>" />
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
                    <option value="1" />Peringatan
                    <option value="2" />Larangan
                    <option value="3" />Perintah
                    <option value="4" />Petunjuk
                </select>
            </span>
        </p> 
        <p>
            <label>Kode Rambu*</label>
            <span class="formwrapper">
                <select id="code_dropdown" onchange="selectCode(this.options[this.selectedIndex].value)" style="width:130px" name="kode_rambu" class="uniformselect">
                    <option value="<?php echo $job[0]->kode_rambu ?>"><?php echo $job[0]->kode_rambu ?></option>
                </select>
            </span>
        </p>
        <p>
            <label>Nama Rambu*</label>
            <span class="field styled-select">
                <select id="text" style="width:530px" name="nama_rambu" placeholder="asas" class="uniformselect" readonly>
                    <option value="<?php echo $job[0]->nama_rambu ?>"selected hidden><?php echo $job[0]->nama_rambu ?></option>
                </select>
            </span> 
        </p> 
        <p>
            <label>Lebar Jalan*</label>
            <span class="field"><input type="text" name="lebar_jalan" value="<?php echo $job[0]->lebar_jalan ?>" class="input-small" placeholder="input lebar" /></span>
            <small class="desc">Dalam satuan meter.</small>
        </p>
        <p>
            <label>Lebar Bahu Jalan*</label>
            <span class="field"><input type="text" name="lebar_bahu" value="<?php echo $job[0]->lebar_bahu_jalan ?>" class="input-small" placeholder="input lebar" /></span>
            <small class="desc">Dalam satuan meter.</small>
        </p>        
        <p>
            <label>Latitude*</label>
            <span class="field"><input type="text" name="lat" value="<?php echo $job[0]->lat ?>"class="input-medium" placeholder="input latitude" /></span>
        </p> 
        <p>
            <label>Longtitude*</label>
            <span class="field"><input type="text" name="long" value="<?php echo $job[0]->long ?>" class="input-medium" placeholder="input longtitude" /></span>
        </p>  
        <p>
            <label>Status Pasang/Rawat</label>
            <span class="formwrapper">
                <?php
                if ($job[0]->status_pasang == 1) {
                    $check1 = 'checked="checked"';
                } else {
                    $check2 = 'checked="checked"';
                }
                ?>
                <input type="radio" name="sts_pasang" value="1" <?php echo @$check1; ?>/> Terpasang/Terawat &nbsp; &nbsp;
                <input type="radio" name="sts_pasang" value="0" <?php echo @$check2; ?>/>Belum Terpasang/Terawat &nbsp; &nbsp;                
            </span>
        </p>
        <p>
            <label>Keterangan Rambu</label>
            <span class="field"><textarea name="keterangan" cols="80" rows="5" class="span5"><?php echo $job[0]->keterangan ?></textarea></span> 
        </p>
        <div class="par">
            <label>Unggah Foto</label>
            <div class="fileupload fileupload-new" data-provides="fileupload">
                <div class="input-append">
                    <?php if ($job[0]->foto == true) {
                        ?>
                        <img src="<?php echo base_url() . $job[0]->foto_thumb; ?>">
                        <br>
                    <?php } ?>
                    <div class="uneditable-input span3">
                        <i class="iconfa-file fileupload-exists"></i>
                        <span class="fileupload-preview"></span>
                    </div>
                    <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                        <span class="fileupload-exists">Change</span>
                        <input type="text" name="image" value="<?php echo $job[0]->foto; ?>" style="display:none" />
                        <input type="text" name="image_thumb" value="<?php echo $job[0]->foto_thumb; ?>" style="display:none" />
                        <input type="file" name="img" /></span>
                    <a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
                </div>
            </div>
        </div>
        <p class="stdformbutton"> 
            <button type="reset" class="btn">Reset Button</button>
            <button class="btn btn-primary">Submit Button</button>
        </p>
        </form>
    </div><!--widgetcontent-->
</div><!--widget-->
<script type="text/javascript">
    var sign = <?php echo $job[0]->id_jenis_rambu ?>;
    function selectType(sign_id) {
        if (sign_id != "") {
            sign = sign_id;
            loadData('code', sign_id);
            $("#code_dropdown").html("<option value=''>Pilih kode rambu</option>");
        }
    }
    loadData('code', sign);
    function selectCode(state_id) {
        if (state_id != "") {
            loadNama(sign, state_id);
        }
    }

    function loadData(loadType, loadId) {
        var dataString = 'loadType=' + loadType + '&loadId=' + loadId;

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>project/loadData",
            data: dataString,
            cache: false,
            success: function (result) {
                $("#" + loadType + "_dropdown").append(result);
            }
        });
    }

    function loadNama(loadType, loadId) {
        var dataString = 'loadType=' + loadType + '&loadId=' + loadId;

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>project/loadData",
            data: dataString,
            cache: false,
            success: function (result) {
                $("#text").html("");
                $("#text").append(result);
            }
        });
    }

</script>
