<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- BEGIN SCRIPT HEADER-->
        <!-- Favicons-->
        <?php
        $this->load->view('template/general/script_header');
        ?>
    </head>
    <body>
        <div class="mainwrapper">
            <!-- BEGIN HEADER -->
            <div class="header">
                <?php
                $this->load->view('template/general/header');
                ?>
            </div>
            <!-- BEGIN SIDEBAR -->
            <div class="leftpanel">
                <div class="leftmenu">    
                    <?php
                    $this->load->view('template/general/sidebar');
                    ?>
                </div>
            </div>

            <!-- BEGIN PAGE CONTENT-->
            <div class="rightpanel">
                <ul class="breadcrumbs">
                    <li><a href="#"><i class="iconfa-home"></i></a> <span class="separator"></span></li>
                    <li><?php echo $nav; ?></li>
                    <li class="right">
                        <a onclick="history.back()" href=""><i class="iconfa-arrow-left"></i> Previous Page</a>       
                    </li>
                </ul>
                <div class="pageheader">                    
                    <div class="pageicon">
                        <?php if ($nav == 'Tambah Tugas Baru' or $nav == 'Tambah Projek Baru' or $nav == 'Edit Tugas' or $nav == 'Tambah Petugas Baru' or $nav == 'Tambah Rambu Lalu Lintas' or $nav == 'Edit Rambu Lalu Lintas' or $nav == 'Edit Projek') { ?>
                            <span class="iconfa-pencil"></span>
                        <?php } else if ($nav == 'Beranda') { ?>
                            <span class="iconfa-laptop"></span>
                        <?php } else if ($nav == 'Daftar Data Tugas' or $nav == 'Daftar Data Projek' or $nav == 'Daftar Data Petugas' or $nav == 'Daftar Data Rambu Lalu Lintas') { ?>
                            <span class="iconfa-table"></span>
                        <?php } else if ($nav == 'Pengaturan Akun') { ?>
                            <span class="iconfa-cog"></span>
                        <?php } else if ($nav == 'Laporan Tugas') { ?>
                            <span class="iconfa-book"></span>
                        <?php } else if ($nav == 'Peta Rambu') { ?>
                            <span class="iconfa-map-marker"></span>
                        <?php } ?>
                    </div>
                    <div class="pagetitle">
                        <h5>Features Summary</h5>
                        <h1><?php echo $nav; ?></h1>
                    </div>
                </div><!--pageheader-->
                <div class="maincontent">
                    <div class="maincontentinner">
                        <?php
                        echo $contents;
                        ?>
                        <div class="footer">
                            <?php
                            $this->load->view('template/general/footer');
                            ?>
                        </div><!--footer-->
                    </div>     
                </div>
            </div>     
        </div>
        <!-- BEGIN SCRIPT FOOTER-->
        <?php
        $this->load->view('template/general/script_footer');
        ?>
    </body>
</html>