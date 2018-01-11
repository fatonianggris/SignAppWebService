<?php echo $this->session->flashdata('flash_message'); ?>
<div class="row-fluid">
    <div class="widget">
        <h4 class="widgettitle">Formulir Rambu Lalu Lintas
            <a href="<?php echo site_url('traffic/list_sign') ?>" style=" margin-top: -7px;" class="btn btn-inverse pull-right" ><i class="iconfa-eye-open icon-white"></i> List Rambu</a>
        </h4>
        <div class="widgetcontent">
            <form class="stdform" action="<?php echo site_url('traffic/add_sign'); ?>" enctype="multipart/form-data" method="post" />
            <p>
                <label>Jenis Rambu*</label>
                <span class="field">
                    <select name="jenis_rambu" class="uniformselect">
                        <option value="" />Pilih salah satu
                        <option value="1" />Peringatan
                        <option value="2" />Larangan
                        <option value="3" />Perintah
                        <option value="4" />Petunjuk
                    </select>
                </span>
            </p> 
            <p>
                <label>Kode Rambu*</label>
                <span class="field"><input type="text" name="kode_rambu" class="input-medium" placeholder="input kode rambu" /></span>
            </p>
            <p>
                <label>Nama Rambu*</label>
                <span class="field"><textarea id="autoResizeTA" cols="80" name="nama_rambu" rows="2" class="span7" style="resize: vertical"></textarea></span> 
            </p>     
            <div class="par">
                <label>Unggah Foto</label>
                <div class="fileupload fileupload-new" data-provides="fileupload">
                    <div class="input-append">
                        <div class="uneditable-input span3">
                            <i class="iconfa-file fileupload-exists"></i>
                            <span class="fileupload-preview"></span>
                        </div>
                        <span class="btn btn-file"><span class="fileupload-new">Select file</span>
                            <span class="fileupload-exists">Change</span>
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