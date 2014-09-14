<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8>
        <base href="<?php echo base_url(); ?>" />
        <!-- link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
        <link rel="stylesheet" href="public_html/xp/xp_cms/css/colorpicker.css" />
        
        <script src="public_html/xp/xp_cms/js/jquery.js"></script>
        <script src="public_html/xp/xp_cms/js/jquery.ui.js"></script>
        <script src="public_html/xp/xp_cms/js/colorpicker.js"></script>
        -->
        <script>
            /* *** *
             function hexFromRGB(r, g, b) {
             var hex = [
             r.toString(16),
             g.toString(16),
             b.toString(16)
             ];
             $.each(hex, function(nr, val) {
             if (val.length === 1) {
             hex[ nr ] = "0" + val;
             }
             });
             return hex.join("").toUpperCase();
             }
             function refreshSwatch() {
             var red = $("#red").slider("value"),
             green = $("#green").slider("value"),
             blue = $("#blue").slider("value"),
             hex = hexFromRGB(red, green, blue);
             $("#swatch").css("background-color", "#" + hex);
             }
             $(function() {
             $("#red, #green, #blue").slider({
             orientation: "horizontal",
             range: "min",
             max: 255,
             value: 127,
             slide: refreshSwatch,
             change: refreshSwatch
             });
             $("#red").slider("value", 255);
             $("#green").slider("value", 140);
             $("#blue").slider("value", 60);
             });
             // * * * */
        </script>
    </head>
    <body >
        <div id="colorpicker">
            <?php
            // $this->load->controller('femenu/index');
            ?>
            <!--
            <p class="ui-state-default ui-corner-all ui-helper-clearfix" style="padding: 4px;">
                <span class="ui-icon ui-icon-pencil" style="float: left; margin: -2px 5px 0 0;"></span>
                Colorpicker
            </p>
            <div id="red"></div>
            <div id="green"></div>
            <div id="blue"></div>
            <div id="swatch" class="ui-widget-content ui-corner-all"></div>
            
            -->
            <div>
                <input id="colorpickerField1" type="text" name="colorpicker">
                <button id="dochange"> Change Background </button>
            </div>
            <?php
            //$this->load->controller('admin/index');
            //echo Modules::run( 'admin/index' );
            //  $this->load->controller('fileupload/index');
            //echo Modules::run('fileupload');
            ?>
            <script>
                jQuery(function($) {
                    $('#colorpickerField1').ColorPicker({
                        onSubmit: function(hsb, hex, rgb, el) {
                            $(el).val(hex);
                            $(el).ColorPickerHide();
                        },
                        onBeforeShow: function() {
                            $(this).ColorPickerSetColor(this.value);
                        }
                    });
                    $('#dochange').click(function() {
                        //save the color
                        $('#colorpickerField1').css('background-color', '#' + $('#colorpickerField1').val());
                        return false;
                    });
                    $('#colorpicker_submit').click(function() {
                       // alert('clolr: ' + $('#colorpickerField1').val());
                    });
                    
                });

            </script>
        </div>
    </body>
</html>