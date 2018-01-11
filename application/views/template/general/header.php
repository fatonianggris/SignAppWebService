<?php $user = $this->session->userdata('signapps'); ?>
<div class="logo">
   <img src ="<?php echo base_url()?>assets/images/sign_apps_desk.png" alt = "icon_web" width="200px" height="200px" />
</div>
<div class="headerinner">
    <ul class="headmenu">  
        <li class="odd">
            <a class="dropdown-toggle" href="<?php echo site_url('dashboard/signmap'); ?>">
                <span class="head-icon iconfa-map-marker"></span>
                <span class="headmenu-label">Peta Rambu</span>
            </a>
        </li>
        <li class="right">
            <div class="userloggedinfo">
                <?php if (!empty($user[0]->foto)) { ?>
                    <img src = "<?php echo base_url() . $user[0]->foto; ?>" alt = "<?php echo base_url() . $user[0]->foto; ?>" />
                <?php } else { ?>
                    <img src = "<?php echo base_url() ?>/uploads/no_image.jpg" alt = "no image" />
                <?php } ?>
                <div class = "userinfo">
                    <h5><?php echo ucwords($user[0]->username);
                ?> <small>- <?php echo $user[0]->email; ?></small></h5>
                    <ul>
                        <li><a href="<?php echo site_url('user/get_user/' . $user[0]->id_user) ?>">Edit Profil</a></li>                        
                        <li><a href="<?php echo site_url('auth/do_logout'); ?>">Keluar</a></li>                        
                    </ul>
                </div>
            </div>
        </li>
    </ul><!--headmenu-->
</div>