<!DOCTYPE html>
<html>
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.default.css" type="text/css" />

        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-1.9.1.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>

    <body class="loginpage">
        <div class="loginpanel">
            <div class="loginpanelinner">
                <div class="animate2 bounceIn" style="margin-top: -80px; color: white;"><h1 style="text-align: center;"><b>Sign Apps</b></h1></div>
                <div class="logo animate0 bounceIn"><img src ="<?php echo base_url()?>assets/images/sign_apps_pic.png" alt = "icon_web" width="180px" height="180px" /></div>
                <form id="login" action="<?php echo base_url(); ?>auth/do_login" method="post" />
                <?php echo $this->session->flashdata('flash_message'); ?>
                <div class="inputwrapper animate1 bounceIn">
                    <input type="text" name="username" id="username" placeholder="Masukkan username" required />
                </div>
                <div class="inputwrapper animate2 bounceIn">
                    <input type="password" name="password" id="password" placeholder="Masukkan password" required />
                </div>
                <div class="inputwrapper animate3 bounceIn">
                    <button name="submit">Sign In</button>
                </div>
                <div class="inputwrapper animate4 bounceIn">
                    <label><input type="checkbox" class="remember" name="signin" /> Keep me sign in</label>
                </div>

                </form>
            </div><!--loginpanelinner-->
        </div><!--loginpanel-->

        <div class="loginfooter">
            <p>&copy; 2013. Shamcey Admin Template. All Rights Reserved.</p>
        </div>

    </body>
</html>
