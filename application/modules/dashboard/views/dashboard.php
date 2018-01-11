<?php echo $this->session->flashdata('flash_message'); ?>
<div class="row-fluid">
    <div id="dashboard-left" class="span8"> 
        <ul class="shortcuts">
            <li class="events">
                <a >
                    <span class="shortcuts-icon iconsi-archive"></span>
                    <span class="shortcuts-label">Data Projek (<?php echo $beranda[0]->projek; ?>)</span>
                </a>
            </li>
            <li class="products">
                <a>
                    <span class="shortcuts-icon iconsi-archive"></span>
                    <span class="shortcuts-label">Data Tugas (<?php echo $beranda[0]->tugas; ?>)</span>
                </a>
            </li>
            <li class="archive">
                <a >
                    <span class="shortcuts-icon iconsi-archive"></span>
                    <span class="shortcuts-label">Data Pegawai (<?php echo $beranda[0]->user; ?>)</span>
                </a>
            </li>
            <li class="help">
                <a >
                    <span class="shortcuts-icon iconsi-help"></span>
                    <span class="shortcuts-label">Data Rambu (<?php echo $beranda[0]->rambu; ?>)</span>
                </a>
            </li>
            <li class="last images">
                <a >
                    <span class="shortcuts-icon iconsi-images"></span>
                    <span class="shortcuts-label">Total Data (<?php echo $beranda[0]->total_data; ?>)</span>
                </a>
            </li>
        </ul>
        <h4 class="widgettitle">Chart Data</h4>
        <div class="widgetcontent">
            <div id="piechart" style="height: 300px;"></div>
        </div><!--widgetcontent-->
        <br />
    </div><!--span8-->

    <div id="dashboard-right" class="span4">

        <h4 class="widgettitle">Kalendar</h4>
        <div class="widgetcontent nopadding">
            <div id="datepicker"></div>
        </div>
        <br />
    </div><!--span4-->
</div><!--row-fluid-->
<script>
    /**PIE CHART IN MAIN PAGE WHERE LABELS ARE INSIDE THE PIE CHART**/
    var data = [];
    data[0] = {label: " Total Projek " + (<?php echo $beranda[0]->projek; ?>), data: <?php echo $beranda[0]->projek; ?>};
    data[1] = {label: " Total Tugas " + (<?php echo $beranda[0]->tugas; ?>), data: <?php echo $beranda[0]->tugas; ?>};
    data[2] = {label: " Total User " + (<?php echo $beranda[0]->user; ?>), data: <?php echo $beranda[0]->user; ?>};
    data[3] = {label: " Total Rambu " + (<?php echo $beranda[0]->rambu; ?>), data: <?php echo $beranda[0]->rambu; ?>};
    jQuery.plot(jQuery("#piechart"), data, {
        colors: ['#680fb3', '#9ab30f'],
        series: {
            pie: {show: true}
        }
    });
</script>