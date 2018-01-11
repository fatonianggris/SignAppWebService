<?php echo $this->session->flashdata('flash_message'); ?>
<div class="row-fluid">
    <div class="widget">
        <h4 class="widgettitle">Formulir Petugas
            <a href="<?php echo site_url('user/list_user') ?>" style=" margin-top: -7px;" class="btn btn-inverse pull-right" ><i class="iconfa-eye-open icon-white"></i> List Petugas</a>
        </h4>
        <div class="widgetcontent">
            <form class="stdform" action="<?php echo site_url('user/edit_user/' . $setting[0]->id_user); ?>" enctype="multipart/form-data" method="post" />
            <p>
                <label>Nama Petugas*</label>
                <span class="field"><input type="text" name="nama_petugas" class="input-xxlarge" value="<?php echo $setting[0]->nama_petugas; ?>" placeholder="input nama petugas" /></span>
            </p>
            <p>
                <label>Username*</label>
                <span class="field"><input type="text" name="username" value="<?php echo $setting[0]->username; ?>" class="input-xlarge" placeholder="input username" /></span>
            </p>             
            <p>
                <label>Email</label>
                <span class="field"><input type="text" name="email" class="input-xlarge" value="<?php echo $setting[0]->email; ?>" placeholder="input email" /></span>
            </p> 

            <p>
                <label>Posisi*</label>
                <span class="field">
                    <select name="posisi" class="uniformselect">
                        <option value="<?php echo $setting[0]->id_posisi; ?>" />
                        <?php
                        if ($setting[0]->id_posisi == 1) {
                            echo 'Survei';
                        } else if ($setting[0]->id_posisi == 2) {
                            echo 'Audit';
                        } else if ($setting[0]->id_posisi == 3) {
                            echo 'Lapangan';
                        }
                        ?>
                        <option value="1" />Survei
                        <option value="2" />Audit
                        <option value="3" />Lapangan   
                    </select>
                </span>
            </p>

            <p>
                <label>Nomor HP/Telp</label>
                <span class="field"><input type="text" name="no_telp" class="input-xlarge" value="<?php echo $setting[0]->no_telp; ?>" placeholder="input nomor telepon" /></span>
            </p> 
            <p>
                <label>Alamat</label>
                <span class="field"><textarea id="autoResizeTA" cols="80" name="alamat" rows="5" class="span6" style="resize: vertical"><?php echo $setting[0]->alamat; ?></textarea></span> 
            </p> 
            <p>
                <label>Password Baru</label>
                <span class="field"><input type="password" name="password" class="input-xlarge" placeholder="input password" /></span>
            </p>
            <p>
                <label>Konfirmasi Password Baru</label>
                <span class="field"><input type="password" name="cf_passwd" class="input-xlarge" placeholder="konfirmasi password" /></span>
            </p>
            <div class="par">
                <label>Unggah Foto</label>
                <div class="fileupload fileupload-new" data-provides="fileupload">                   
                    <div class="input-append">
                        <?php if ($setting[0]->foto == true) {
                            ?>
                            <img src="<?php echo base_url() . $setting[0]->foto_thumb; ?>">
                            <br>
                        <?php } ?>
                        <div class="uneditable-input span3">
                            <i class="iconfa-file fileupload-exists"></i>
                            <span class="fileupload-preview"></span>
                        </div>
                        <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                            <span class="fileupload-exists">Change</span>
                            <input type="text" name="image" value="<?php echo $setting[0]->foto; ?>" style="display:none" />
                            <input type="text" name="image_thumb" value="<?php echo $setting[0]->foto_thumb; ?>" style="display:none" />
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
    </div>