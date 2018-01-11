
<div style="margin-right: 10px">

    <?php /* === THIS IS WHERE WE WILL ADD OUR MAP USING JS ==== */ ?>
    <div class="google-map-wrap" itemscope itemprop="hasMap" itemtype="http://schema.org/Map">
        <div id="google-map" class="google-map">
        </div><!-- #google-map -->        
    </div>
    <script>
        jQuery(document).ready(function ($) {

            /* Do not drag on mobile. */
            var is_touch_device = 'ontouchstart' in document.documentElement;

            var map = new GMaps({
                el: '#google-map',
                lat: '0.6119958',
                lng: '116.5276837',
                draggable: !is_touch_device
            });

            /* Map Bound */
            var bounds = [];

<?php foreach ($sign as $key => $value) { ?>
                var icon = {
                    url: '<?php echo base_url() . $value->foto_thumb; ?>', // url
                    scaledSize: new google.maps.Size(25, 25), // scaled size
                    origin: new google.maps.Point(0, 0), // origin
                    anchor: new google.maps.Point(0, 0) // anchor
                };
                /* Set Bound Marker */
                var latlng = new google.maps.LatLng(<?php echo $value->lat; ?>,<?php echo $value->long; ?>);
                bounds.push(latlng);
                /* Add Marker */
                map.addMarker({
                    lat: <?php echo $value->lat; ?>,
                    lng: <?php echo $value->long; ?>,
                    icon : icon,
                    infoWindow: {
                        content: '<?php echo $value->lokasi_jalan; ?>'
                    }
                });

<?php } //end foreach locations      ?>

            /* Fit All Marker to map */
            map.fitLatLngBounds(bounds);
            /* Make Map Responsive */
            var $window = $(window);
            function mapWidth() {
                var size = $('.google-map-wrap').width();
                $('.google-map').css({width: size + 'px', height: (size / 2) + 'px'});
            }
            mapWidth();
            $(window).resize(mapWidth);

        });
    </script>
</div><!-- .entry-content -->
