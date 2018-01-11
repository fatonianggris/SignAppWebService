
<ul class="nav nav-tabs nav-stacked">
    <li class="nav-header">Navigasi</li>
    <li class="<?php if ($nav == 'Beranda') echo 'active'; ?>"><a href="<?php echo site_url('dashboard'); ?>"><span class="iconfa-laptop"></span> Beranda</a></li>

    <li class="dropdown <?php if (@$act == 'projek') echo 'active'; ?>"><a href="javascript:;"><span class="iconfa-hdd"></span> Manajemen Projek</a>
        <ul <?php if (@$act == 'projek') echo 'style="display: block"'; ?>>
            <li class="<?php if ($nav == 'Input Projek Baru') echo 'active'; ?>"><a href="<?php echo site_url('project/') ?>">Tambah Projek Baru</a></li>
            <li class="<?php if ($nav == 'Daftar Data Projek') echo 'active'; ?>"><a href="<?php echo site_url('project/list_project/') ?>">Daftar Data Projek</a></li>
        </ul>
    </li>
    <li class="dropdown <?php if (@$act == 'petugas') echo 'active'; ?>"><a href="javascript:;"><span class="iconfa-user"></span> Manajemen Petugas</a>
        <ul <?php if (@$act == 'petugas') echo 'style="display: block"'; ?>>
            <li class="<?php if ($nav == 'Tambah Petugas Baru') echo 'active'; ?>"><a href="<?php echo site_url('user/') ?>">Tambah Petugas Baru</a></li>
            <li class="<?php if ($nav == 'Daftar Data Petugas') echo 'active'; ?>"><a href="<?php echo site_url('user/list_user/') ?>">Daftar Data Petugas</a></li>
        </ul>
    </li>    
    <li class="dropdown <?php if (@$act == 'rambu') echo 'active'; ?>"><a href="javascript:;"><span class="iconfa-warning-sign"></span> Manajemen Rambu</a>
        <ul <?php if (@$act == 'rambu') echo 'style="display: block"'; ?>>
            <li class="<?php if ($nav == 'Tambah Data Rambu Lalu Lintas') echo 'active'; ?>"><a href="<?php echo site_url('traffic/'); ?>">Tambah Rambu Lalu Lintas Baru</a></li>
            <li class="<?php if ($nav == 'Daftar Rambu Lalu Lintas') echo 'active'; ?>"><a href="<?php echo site_url('traffic/list_sign') ?>">Daftar Data Rambu Lalu Lintas</a></li>          
        </ul>
    </li>
</ul>
