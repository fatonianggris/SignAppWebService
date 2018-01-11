<script type="text/javascript">
    jQuery(document).ready(function () {
        // dynamic table
        jQuery('#dyntable').dataTable({
            "sPaginationType": "full_numbers",
            "aaSortingFixed": [[0, 'asc']],
            "fnDrawCallback": function (oSettings) {
                jQuery.uniform.update();
            }
        });
        //datepicker
        jQuery('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        jQuery('#datepicker2').datepicker({ dateFormat: 'yy-mm-dd' }).val();
        //select
        jQuery(".chzn-select").chosen();
        
        // tabbed widget
        jQuery('.tabbedwidget').tabs();
        // Textarea Autogrow
        jQuery('#autoResizeTA').autogrow();
    });
    
</script>
