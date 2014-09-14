<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8>
        <base href="<?php echo base_url(); ?>" />
        <script src="public_html/xp/xp_cms/js/jquery.js"></script>
        <script src="public_html/xp/xp_cms/js/jquery.ui.js"></script>
        <!--
        <script src="public_html/xp/xp_cms/js/ckeditor/ckeditor.js"></script>
        -->
        <link rel="stylesheet" href="public_html/xp/xpcms/css/base.css" />   

        <script src="public_html/xp/xp_cms/js/jquery.js"></script>
        <script src="public_html/xp/xp_cms/js/jquery.ui.js"></script>        
        <script src="public_html/xp/xpcms/js/jquery.cookie.js"></script>
        <script src="public_html/xp/xpcms/js/jquery.slugify.js"></script>        
        <script src="public_html/xp/xpcms/js/plugin.js"></script>
        <script src="public_html/xp/xpcms/js/scripts.js"></script>        
        <script src="public_html/xp/xpcms/js/jquery.ui.nestedSortable.js"></script>

        <script type="text/javascript">
            pyro = {'lang': {}};
            var APPPATH_URI = "/xp_cms/system/cms/";
            var SITE_URL = "http://localhost/xp_cms/";
            var BASE_URL = "http://localhost/xp_cms/";
            var BASE_URI = "/xp_cms/system/cms/";
            var UPLOAD_PATH = "uploads/default/";
            var DEFAULT_TITLE = "xp_csm";
            pyro.admin_theme_url = "http://localhost/xp_cms/xpcms";
            pyro.apppath_uri = "/xp_cms/system/cms/";
            pyro.base_uri = "/xp_cms/system/cms/";
            pyro.lang.remove = "移除";
            pyro.lang.dialog_message = "确定要删除吗？这将是不可回复的。";
            pyro.csrf_cookie_name = "xpcms_csrf_cookie_name";
        </script>



    </head>
    <body>
        <div class="ckeditorform">
            
            <section rel="1" class="group-1 box">

                <div class="one_full">
                    <section class="item collapsed">
                        <div class="content">

                            <div class="one_half">
                                <div id="link-list">
                                    <ul class="sortable">
<?php
for($i = 0; $i < $num; $i ++) {
    echo '<li id="link_'.$menus[$i]['uid'].'"><div>';
    echo '<a href="'.$menus[$i]['url'].'" rel="'.$menus[$i]['uid'].'" alt="'.$menus[$i]['description'].'">'.$menus[$i]['title'].'</a></div>';
    echo '</li>';
}
?>
                                    </ul>
                                </div>
                            </div>



                        </div>
                    </section>
                </div>
            </section>

        </div>

        <script>
            (function($) {
                $(function() {
                    // generate a slug for new navigation groups
                    pyro.generate_slug('input[name="title"]', 'input[name="abbrev"]');
                    var open_sections = $.cookie('nav_groups');
                    if (open_sections) {
                        $('section[rel="' + open_sections + '"] .item')
                                .slideDown(600)
                                .removeClass('collapsed');
                    } else {
                        // show the first box with js to get around page jump
                        $('.box .item:first')
                                .slideDown(600)
                                .removeClass('collapsed');
                    }
         
                    // show and hide the sections
                    $('.box .title').click(function() {
                        window.scrollTo(0, 0);
                        if ($(this).next('section.item').hasClass('collapsed')) {
                            $('.box .item')
                                    .slideUp(600)
                                    .addClass('collapsed');

                            $.cookie('nav_groups', $(this).parent('.box').attr('rel'), {expires: 1});

                            $(this)
                                    .next('section.collapsed')
                                    .slideDown(600)
                                    .removeClass('collapsed');
                        }
                    });
                  
                    
        // load edit via ajax
                    $('a.ajax').live('click', function() {
                        // make sure we load it into the right one
                        var id = $(this).attr('rel');

                        if ($(this).hasClass('add')) {
                            // if we're creating a new one remove the selected icon from link in the tree
                            $('.group-' + id + ' #link-list a')
                                    .removeClass('selected');
                        }
                        // Load the form
                        $('div#link-details.group-' + id + '').load(
                                $(this).attr('href'),
                                '',
                                function() {
                                    $('div#link-details.group-' + id + '').fadeIn();
                                    // display the create/edit title in the header
                                    var title = $('#title-value-' + id).html();
                                    $('section.box .title h4.group-title-' + id).html(title);
                                    // Update Chosen
                                    pyro.chosen();
                                });
                        return false;
                    });
                    // submit create form via ajax
                    $('#nav-create button:submit').live(
                            'click',
                            function(e) {
                                e.preventDefault();
                                $.post(
                                        SITE_URL + 'admin/navigation/create',
                                        $('#nav-create').serialize(),
                                        function(message) {
                                            // if message is simply "success" then it's a go. Refresh!
                                            if (message == 'success') {
                                                window.location.href = window.location
                                            }
                                            else {
                                                $('.notification').remove();
                                                $('div#content-body').prepend(message);
                                                // Fade in the notifications
                                                $(".notification").fadeIn("slow");
                                            }
                                        });
                            });
                    // submit edit form via ajax
                    $('#nav-edit button:submit').live(
                            'click',
                            function(e) {
                                e.preventDefault();
                                $.post(
                                        SITE_URL + 'admin/navigation/edit/' + $('input[name="link_id"]').val(),
                                        $('#nav-edit').serialize(),
                                        function(message) {
                                            // if message is simply "success" then it's a go. Refresh!
                                            if (message == 'success') {
                                                window.location.href = window.location
                                            }
                                            else {
                                                $('.notification').remove();
                                                $('div#content-body').prepend(message);
                                                // Fade in the notifications
                                                $(".notification").fadeIn("slow");
                                            }
                                        });
                            });

                    // Pick a rule type, show the correct field
                    $('input[name="link_type"]').live(
                            'change',
                            function() {
                                $(this).parents('ul')
                                        .find('#navigation-' + $(this).val())
                                        // Show only the selected type
                                        .show()
                                        .siblings()
                                        .hide()
                                        // Reset values when switched
                                        .find('input:not([value="http://"]), select')
                                        .val('');
                                // Trigger default checked
                            }).filter(':checked')
                            .change();

                    // show link details
                    $('#link-list li a').livequery(
                            'click',
                            function() {
                                var id = $(this).attr('rel');
                                link_id = $(this).attr('alt');
                                $('.group-' + id + ' #link-list a').removeClass('selected');
                                $(this).addClass('selected');
                                // Load the details box in
                                $('div#link-details.group-' + id + '')
                                        .load(
                                        SITE_URL + 'admin/navigation/ajax_link_details/' + link_id,
                                        '',
                                        function() {
                                            $('div#link-details.group-' + id + '').fadeIn();
                                        });
                                // Remove the title from the form pane.
                                $('section.box .title h4.group-title-' + id).html('');
                                return false;
                            });
                    $('.box:visible ul.sortable')
                            .livequery(function() {
                        $item_list = $(this);
                        // xiaoling
                        $url = 'admin/order';
                        $cookie = 'open_links';
                        $data_callback = function(event, ui) {
                            // Grab the group id so we can update the right links
                            return {'group': ui.item.parents('section.box').attr('rel')};
                        }
                        // $post_callback is available but not needed here
                        // Get sortified
                        pyro.sort_tree($item_list, $url, $cookie, $data_callback);
                    });
                });
            })(jQuery);
        </script>

    </body>
</html>