<?php echo $this->session->flashdata('flash_message'); ?>
<?php $user = $this->session->userdata('signapps'); ?>
<div class="widget">
    <h4 class="widgettitle">Formulir Projek
        <a href="<?php echo site_url('project/list_project') ?>" style=" margin-top: -7px;" class="btn btn-inverse pull-right" ><i class="iconfa-eye-open icon-white"></i> List Projek</a>
    </h4>
    <div class="widgetcontent">
        <form class="stdform" action="<?php echo site_url('project/edit_project/' . $project[0]->id_projek); ?>" enctype="multipart/form-data" method="post" />
        <p>
            <label>Nama Projek*</label>
            <span class="field"><input type="text" name="nama_projek" class="input-xxlarge" value="<?php echo $project[0]->nama_projek ?>" placeholder="input nama projek" /></span>
        </p>
        <p>
            <label>Nama Daerah*</label>
            <span class="formwrapper">
                <select data-placeholder="Pilih nama daerah" name="nama_daerah" style="width:400px" class="chzn-select" tabindex="2">
                    <option value="<?php echo $project[0]->nama_daerah ?>" /> <?php echo $project[0]->nama_daerah ?>
                    <option value="Aceh">Aceh</option>
                    <option value="Sumatera Utara">Sumatera Utara</option>
                    <option value="Sumatera Barat">Sumatera Barat</option>
                    <option value="Riau">Riau</option>
                    <option value="Jambi">Jambi</option>
                    <option value="Sumatera Selatan">Sumatera Selatan</option>
                    <option value="Bengkulu">Bengkulu</option>
                    <option value="Lampung">Lampung</option>
                    <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
                    <option value="Kepulauan Riau">Kepulauan Riau</option>
                    <option value="Dki Jakarta">Dki Jakarta</option>
                    <option value="Jawa Barat">Jawa Barat</option>
                    <option value="Jawa Tengah">Jawa Tengah</option>
                    <option value="Di Yogyakarta">Di Yogyakarta</option>
                    <option value="Jawa Timur">Jawa Timur</option>
                    <option value="Banten">Banten</option>
                    <option value="Bali">Bali</option>
                    <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                    <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                    <option value="Kalimantan Barat">Kalimantan Barat</option>
                    <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                    <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                    <option value="Kalimantan Timur">Kalimantan Timur</option>
                    <option value="Kalimantan Utara">Kalimantan Utara</option>
                    <option value="Sulawesi Utara">Sulawesi Utara</option>
                    <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                    <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                    <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                    <option value="Gorontalo">Gorontalo</option>
                    <option value="Sulawesi Barat">Sulawesi Barat</option>
                    <option value="Maluku">Maluku</option>
                    <option value="Maluku Utara">Maluku Utara</option>
                    <option value="Papua Barat">Papua Barat</option>
                    <option value="Papua">Papua</option>                           
                </select>
            </span>
        </p>    
        <p>
            <label>Deskripsi*</label>
            <span class="field"><textarea id="autoResizeTA" cols="80" name="desc" rows="4" class="span5" style="resize: vertical"><?php echo $project[0]->deskripsi ?></textarea></span> 
        </p>
        <p>
            <label>Status Projek</label>
            <span class="formwrapper">
                <?php
                if ($project[0]->status_projek == 0) {
                    $check1 = 'checked="checked"';
                    $check3 = 'disabled="disabled"';
                } else if ($project[0]->status_projek == 2) {
                    $check2 = 'checked="checked"';
                } else if ($project[0]->status_projek == 3) {
                    $check3 = 'checked="checked"';
                } else {
                    $check5 = 'checked="checked"';
                }
                ?>
                <input type="radio" name="proses_prj" value="0" <?php echo @$check1; ?>/>Proses Survei &nbsp; -->
                <input type="radio" name="proses_prj" value="1" disabled="disabled" <?php echo @$check5; ?>/>Survei Selesai  &nbsp; -->
                <input type="radio" name="proses_prj" value="2" <?php echo @$check2; ?>/>Proses Lapangan (pasang/rawat)  &nbsp; -->
                <input type="radio" name="proses_prj" value="3" <?php echo @$check3; ?>/>Selesai
            </span>
        </p>
        <div class="par">
            <label>Projek Mulai</label>
            <div class="input-append" style="margin-right: 5px;">
                <input id="datepicker2" type="text" name="projek_mulai" class="span2" value="<?php echo $project[0]->tgl_mulai; ?>" />
                <span class="add-on"><i class="icon-calendar"></i></span>
            </div>
            s/d
            <div class="input-append" style="margin-left: 5px;">
                <input id="datepicker" type="text" name="projek_selesai" class="span2" value="<?php echo $project[0]->tgl_selesai; ?>" />
                <span class="add-on"><i class="icon-calendar"></i></span>
            </div>
        </div> 
        <p>
            <label>Petugas Survei</label>

            <span class="formwrapper">
                <select data-placeholder="Pilih petugas survei" name="psurvei" style="width:300px" class="chzn-select" tabindex="2">
                    <option value="<?php echo $project[0]->id_penyurvei ?>" /> <?php echo $project[0]->nama_penyurvei ?>
                    <?php
                    if (!empty($surworker)) {
                        foreach ($surworker as $key => $value) {
                            ?>
                            <option value="<?php echo $value->id_user; ?>" /><?php echo $value->nama_petugas; ?>
                            <?php
                        }
                    }
                    ?>
                </select>
            </span>
        </p>
        <p>
            <label>Petugas Lapangan</label>
            <span class="formwrapper">
                <select data-placeholder="Pilih petugas lapangan" name="plapangan" style="width:300px" class="chzn-select" tabindex="2">
                    <option value="<?php echo $project[0]->id_plapangan ?>" /> <?php echo $project[0]->nama_plapangan ?>
                    <?php
                    if (!empty($lapworker)) {
                        foreach ($lapworker as $key => $value) {
                            ?>
                            <option value="<?php echo $value->id_user; ?>" /><?php echo $value->nama_petugas; ?>
                            <?php
                        }
                    }
                    ?>
                </select>
            </span>
        </p>
        <p class="stdformbutton"> 
            <button type="reset" class="btn">Reset Button</button>
            <button class="btn btn-primary">Submit Button</button>
        </p>
        </form>
    </div><!--widgetcontent-->
</div><!--widget-->
