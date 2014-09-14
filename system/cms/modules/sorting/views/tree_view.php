<!DOCTYPE html>
<html>
    <head>
        <meta charset=UTF-8>
        <title>NestedTree</title>
        <base href="<?php echo base_url(); ?>" />
        <link type="text/css" media="all" rel="stylesheet" href="public_html/xp/xp_cms/css/nestedtree.css">
        <link type="text/css" media="all" rel="stylesheet" href="public_html/xp/xp_cms/css/userguide.css"/>
        <script src="public_html/xp/xp_cms/js/jquery.js"></script>
        <script src="public_html/xp/xp_cms/js/jquery.ui.js"></script>    
        <script src="public_html/xp/xp_cms/js/jquery.jtree.js" ></script>
        <script src="public_html/xp/xp_cms/js/json2.js" ></script>

        <script>

            //<![CDATA[
            var listroot = "#root";
            var baseurl = '<?php echo base_url(); ?>';

            function debug(s) {
                if (typeof console != "undefined" && typeof console.debug != "undefined") {
                    console.log(s);
                } else {
                    alert(s);
                }
            }


            var fetchIt = function(c) {
                if (c.nodeName == 'LI') {
                    if ($(c).data('meta').index != $(listroot + ' li').index(c)) {
                        var meta = getTreeAction(c);
                        meta.left = $(c).data('meta').left;
                        ajaxTree(meta);
                    }
                }
            };

            var ajaxTree = function(m) {
                $.post(
                        baseurl + "sorting/rearrangeTree/",
                        m,
                        function(d) {
                            $(listroot).animate({backgroundColor: '#FF9933'}, 550).animate({backgroundColor: '#FFFFFF'}, 550);
                            listRecursive(1, 2, listroot);
                            //debug(d);		
                        }
                );
            };

            var getTreeAction = function(c) {
                var meta = {nleft: 1, action: 'append'};
                var prev = $(c).prev();
                if (prev.length > 0 && $(prev).data('meta') != undefined) {
                    meta.nleft = $(prev).data('meta').left;
                    meta.action = 'insert';
                }
                else if (c.parentNode != undefined && c.parentNode.parentNode != undefined && $(c.parentNode.parentNode).data('meta') != undefined) {
                    meta.nleft = $(c.parentNode.parentNode).data('meta').left;
                }
                return meta;
            };

            var deleteItem = function(b) {
                var LI = $(b.parentNode);
                if ((LI.data('meta').right - LI.data('meta').left) > 1) {
                    LI.before(LI.find('ul li'));
                }
                //ajaxTree( { left:LI.data('meta').left, action:'delete'});
                LI.remove();
            };

            var listRecursive = function(left, right, c) {
                $(c).children('li').each(function(i, li) {
                    left = right;
                    right++;
                    $(li).data('meta', {left: left, right: right, index: $(listroot + ' li').index(li)});
                    if ($(li).find('ul').length > 0) {
                        $(li).data('meta').right = listRecursive(left, right, $(li).find('ul')[0]);
                        right = $(li).data('meta').right;
                    }
                    right++;
                })
                return right;
            }

            $(document).ready(function() {
                $(listroot).jTree({
                    showHelper: true,
                    hOpacity: 0.5,
                    hBg: "#FCC",
                    hColor: "#222",
                    pBorder: "1px dashed #CCC",
                    pBg: "#EEE",
                    pColor: "#222",
                    pHeight: "20px",
                    snapBack: 1200,
                    childOff: 20,
                    mouseUp: fetchIt,
                    deleteIt: deleteItem
                });
                listRecursive(1, 2, listroot);
            });
            //]]>
        </script>
    </head>
    <body style="cursor: default;">
        <h3>Page sorting</h3>
        <div style="margin:40px;float:left;width:200px;" id="navigation">
            <?php echo MPTtreeToUl($treeData, ''); ?>
        </div>
        <div style="margin:40px;float:left;font-size:8px;">
            <?php //debug($treeData); ?>
        </div>
        <script>
            (function($) {
                $('#root .delete').hide();
            })(jQuery);
        </script>
    </body>
</html>
