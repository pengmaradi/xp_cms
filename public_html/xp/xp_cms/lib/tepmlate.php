<!-- ###HEADER### begin -->
###BASEURL###
###ICON###
###JAVASCRIPT###
###CSS###
###TITLE###
<!-- ###HEADER### end -->

<!-- ###MAIN### begin -->

    <!-- ###ONECOL### begin -->
    <!-- ###ONECOL### end -->

    <!-- ###TWOCOL### begin -->
    <!-- ###TWOCOL### end -->

    <!-- ###THREECOL### begin -->
    <!-- ###THREECOL### end -->

<!-- ###MAIN### end -->

<!-- ###FOOTER### begin -->
###COPYRIGHT###
###ADDRESSE###
###CMSINFORMATION###
<!-- ###FOOTER### end -->
<?php
function makeinhalt($inhalt,$class = 'onecol', $div = 'div') {
    return $inhalt = '<'.$div.' class="'.$class.'>'. $inhalt .'</'. $div.'>';
}
?>
