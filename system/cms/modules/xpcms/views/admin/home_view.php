<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title><?php echo $cmstitle; ?></title>
        <base href="<?php echo base_url();?>" />
        <link rel="shortcut icon" href="http://pengmaradi.szmay.com/pengmaradi/fileadmin/templates/img/pmLogo.png" />
        <link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" type="text/css" media="all" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="public_html/xp/xp_cms/css/contextMenu.css" />
        <link rel="stylesheet" href="public_html/xp/xp_cms/css/colorpicker.css" />
        <script src="public_html/xp/xp_cms/js/jquery.js"></script>
        <script src="public_html/xp/xp_cms/js/jquery.ui.js"></script>
        <script src="public_html/xp/xp_cms/js/ckeditor/ckeditor.js"></script>
        <script src="public_html/xp/xp_cms/js/jquery-timepicker.js"></script>
<?php
    foreach($css_files as $key => $value) {
        echo '<link rel="stylesheet" type="text/css" href="public_html/xp/xp_cms/css/'.$key.'.css" media="'.$value.'" />'.PHP_EOL;
    }
    if(is_array($js_files)) {
        include_once './system/cms/libraries/'.$js_files[0];
        echo '<script src="public_html/xp/xp_cms/js/'.$js_files[1].'"></script>';
    }
?>        
    </head>
    <body>
        <div class="main">

<script src="public_html/xp/xpcms/js/contextmenu.js"></script>
<?php
echo $menu;

?>

<div id="maincontent" class="home">    
    <div class="createNewPage left" title="Create a new page">Create a new page</div>
    <div class="error left home_erreo"></div>

    <!-- create new menu begin --> 
    <div id="makePageTree" style="display:none">
        <div class="box">
            <div class="formlist text">
                <label for="newpage">new page</label>
                <input type="text" name="newpage" id="newpage"/>
                <div id="warnung" style="display: none">Max 15 string or it musst be alphabet or number!</div>
            </div>        
            <div class="formlist">
                <button id="savenewpage" title="save">Save</button>
            </div>
            <div id="newcloseit">X</div>            
        </div>        
        <div class="deco"></div>
    </div>
    <!-- create new menu end --> 
    <!-- tree of the menu -->
    <div class="pageTree clear">        

        <?php
///////////////////
        echo MPTtreeToUl($feMenu, '');
//////////////////
        ?>

    </div>    
    <!-- tree of the menu -->
    <div class="reset_home">
        <?php $this->load->controller('reset_home');?>
    </div>
    <!-- create page type content -->
    <div id="makePageType" style="display:none">
        <div class="box">
            <div class="formlist text">
                <label for="pagetitle">page title</label>
                <input type="text" name="pagetitle" id="pagetitle"/>
                <span id="warnung" style="display: none">Max 15 string or it musst be alphabet or number!</span>
                <input type="hidden" class="puid" value=""/>
            </div>

            <div class="formlist select">
                <label for="pagetype">page type</label>
                <?php
                echo '<select id="pagetype" name="pagetype">' . PHP_EOL;
                echo '<option value="0">select type</option>' . PHP_EOL;

                echo '<optgroup label="STANDART">' . PHP_EOL;
                $standart = array_combine($standarts['type'], $standarts['name']);
                foreach ($standart as $key => $value) {
                    echo '<option value="' . $key . '">' . $value . '</option>' . PHP_EOL;
                }
                echo '</optgroup>' . PHP_EOL;

                echo '<optgroup label="LISTS">' . PHP_EOL;
                $list = array_combine($lists['type'], $lists['name']);
                foreach ($list as $key => $value) {
                    echo '<option value="' . $key . '">' . $value . '</option>' . PHP_EOL;
                }
                echo '</optgroup>' . PHP_EOL;

                echo '<optgroup label="FORMS">' . PHP_EOL;
                $form = array_combine($forms['type'], $forms['name']);
                foreach ($form as $key => $value) {
                    echo '<option value="' . $key . '">' . $value . '</option>' . PHP_EOL;
                }
                echo '</optgroup>' . PHP_EOL;

                echo '<optgroup label="SPECIAL">' . PHP_EOL;
                $special = array_combine($specials['type'], $specials['name']);
                foreach ($special as $key => $value) {
                    echo '<option value="' . $key . '">' . $value . '</option>' . PHP_EOL;
                }
                echo '</optgroup>' . PHP_EOL;
                echo '</select>' . PHP_EOL;
                ?>
            </div>
            <div class="formlist">
                <button id="createType" title="Create">Create</button>
            </div>
            <div id="closeit">X</div>
        </div>
        <div class="deco"></div>
    </div>
    <!-- create page type content -->

    <!-- create textcontent with ckeditor begin -->
    <div class="makecontent" style="display: none;">
        <?php
        // create ckeditor
        $this->load->controller('createpage/createpage', array('xpcms/home', 'Content'));
        ?>
    </div>
    <div class="backDeco"></div>
    <!-- create ckeditor end -->

    <!-- create text image begin -->
    <div class="makeTextImg" style="display: none;">
        <?php
        // create ckeditor
        $this->load->controller('createtextimg/createtextimg', array('xpcms/home', 'Only Picture'));
        ?>
    </div>
    <div class="backDeco"></div>
    <!-- create text image end -->

    <!-- create Form begin -->
    <div class="makeForm" style="display: none;">
        <?php
        // create form
        $this->load->controller('createform/createform', array('xpcms/home', 'Create Form'));
        ?>

    </div>
    <div class="backDeco"></div>
    <!-- create Form end -->
    <!--  
    
    //-->
    <!-- create makeFormLogin begin -->
    <div class="makeFormLogin" style="display: none;">
        <?php
        // create ckeditor
        $this->load->controller('createlogin/createlogin', array('xpcms/home', 'Login'));
        ?>
    </div>
    <div class="backDeco"></div>
    <!-- create makeFormLogin end -->
    <!-- create filelinks begin -->
    <div class="makeFileLinks" style="display: none;">
        <?php
        // create ckeditor
        $this->load->controller('creatfilelinks/creatfilelinks', array('xpcms/home', 'Files'));
        ?>
    </div>
    <div class="backDeco"></div>
    <!-- create filelinks end -->
    <!-- makeFormSearch begin -->
    <div class="makeFormSearch" style="display: none;">
        <?php
        // create ckeditor
        $this->load->controller('createsearch/createsearch', array('xpcms/home', 'Search Form'));
        ?>
    </div>
    <div class="backDeco"></div>
    <!-- create makeFormSearch end -->

    <!-- makeMedia begin -->
    <div class="makeMedia" style="display: none;">
        <?php
        $this->load->controller('createmedia/createmedia', array('xpcms/home', 'Slider'));
        ?>
    </div>
    <div class="backDeco"></div>
    <!-- create makeMedia end -->
    
    <!-- context menu begin -->
    <ul id="myMenu" class="contextMenu">
        <li class="copy"><a href="#makePageTree">Add new page</a></li>
        <li class="edit"><a href="#makePageType">Add page content</a></li>
        <li class="deltst"><a href="#deleted">Delete page</a></li>
        <li class="paste"><a href="#preview">Preview</a></li>
    </ul>
    <!-- context menu end -->   
</div>

<script>
    /*<![CDATA[*/
    // http://www.javascripttoolbox.com/
    jQuery(function($) {
        var num_appha_preg = /^[0-9a-zA-ZäöüÄÖÜ_ -]+$/;
        // craete menu tree
        $('.createNewPage').click(function() {
            $('#makePageTree').slideToggle();
        });
        // X click to close the form
        $('#newcloseit').click(function() {
            $(this).closest('#makePageTree').slideToggle();
        });
        // check menu length and if is alphanumeric
        $('#newpage').keyup(function() {
            var page = $(this).val(), ml = page.length;
            if (ml > 20 || !num_appha_preg.test(page)) {
                $(this).addClass('hightlight');
                $('#warnung').slideToggle();
                $(this).val('');
            } else {
                $(this).removeClass('hightlight');
            }
        });
        //
        // add a new and save the page (menu)
        //
        $('#savenewpage').click(function() {
            var page = $('#newpage').val();
            if (page == '' || !num_appha_preg.test(page)) {
                $('#newpage').addClass('hightlight').focus();
                return false;
            } else {
                $('#newpage').removeClass('hightlight');
                // send data
                $.post(
                    'xpcms/setMenu',
                    {title: page},
                    function(data) {
                        $('.error').text(data.msg);
                        if (data.success) {
                            location.reload();
                        }
                    }, 
                    'json'
                );
                $('#newpage').val('');
                $(this).closest('#makePageTree').css('display', 'none');
                //
            }

        });
        //
        // delete the page menu 
        //
        $('.tree .list').each(function() {
            var index = $(this).index();
            $(this).attr('data-index', index);
            $(this).click(function() {
                var position = $(this).attr('data-position');
                $(this).attr('newindex', position);
            });

            $(this).find('.delete').click(function() {
                // set menu in db hidden = 1
                var uid = $(this).parent().attr('data-uid'),
                        rgt = parseInt($(this).parent().attr('data-rgt')),
                        lft = parseInt($(this).parent().attr('data-lft'));
                if ((rgt - lft) == 1) {
                    $.post(
                        'xpcms/hiddenMenu',
                        {uid: uid},
                        function(data) {
                        if (data.success) {
                            location.reload();
                        }
                        $('.home_erreo').text(data.msg);
                    }, 'json');
                    $(this).closest('.list').hide();                     
                } else {
                    $('.home_erreo').text('this page can not delete.');
                    return flase;
                }
            });
        });
        //
        // sorting the menu
        //
        $(".tree").sortable({
            start: function(event, ui) {
                var currPos1 = ui.item.index();
                $(this).find(ui.item).attr('data-position', currPos1);
            },
            stop: function(event, ui) {
                var currPos3 = ui.item.index();
                $(this).find(ui.item).attr('data-position', currPos3);
                var counter = 0;
                $('ul.tree').find('li').each(function() {
                    $(this).attr('data-position', counter++);
                });
            }
        });
        //
        // add page type
        //
        $('.addPageContent').click(function() {
            //$('.makecontent').slideToggle();
            var title = $(this).text(), pid = $(this).parent().attr('data-uid');
            $('#pagetitle').val(title);
            $('#makePageType .puid').val(pid);
            $('#makePageType').slideToggle();
        });
        //
        // open the content type editor 
        //
        $('#createType').click(function() {
            var pagetitle = $('#pagetitle').val(),
                    type = parseInt($('#pagetype').val()),
                    uid = $('.puid').val(),
                    contents = 'pagetitle=' + pagetitle + '&uid=' + uid + '&type=' + type;
            
            ////$('').serialize();
            // when change menu text than update it
            $.post('xpcms/resetMenu', contents, function(data) {
                if (data.success) {
                    //alert(data.msg);
                } else {
                    return false;
                }

            }, 'json');
            switch (type) {
                // text
                case 1:
                    $('.makecontent, .backDeco').slideToggle();
                    $('.makecontent').addClass('contentEditor');
                    // set key pid !important!!
                    $('#pageid').val(uid);
                    break;
                    // images
                case 2:
                    $('.makeTextImg, .backDeco').slideToggle();
                    $('.makeTextImg').addClass('contentEditor');
                    // set key pid !important!!
                    $('#page_image_id').val(uid);
                    break;
                    // file links
                case 3:
                    $('.makeFileLinks, .backDeco').slideToggle();
                    $('.makeFileLinks').addClass('contentEditor');
                    // set key pid !important!!
                    $('#file-pid').val(uid);
                    break;
                    // form
                case 4:
                    $('.makeForm, .backDeco').slideToggle();
                    $('.makeForm').addClass('contentEditor');
                    // set key pid !important!!
                    $('#form-pid').val(uid);
                    break;
                    // login
                case 5:
                    $('.makeFormLogin, .backDeco').slideToggle();
                    $('.makeFormLogin').addClass('contentEditor');
                    // set key pid !important!!
                    $('#login-pid').val(uid);
                    break;
                    // search
                case 6:
                    $('.makeFormSearch, .backDeco').slideToggle();
                    $('.makeFormSearch').addClass('contentEditor');
                    // set key pid !important!!
                    $('#search-pid').val(uid);
                    break;
                    // media
                case 7:
                    $('.makeMedia, .backDeco').slideToggle();
                    $('.makeMedia').addClass('contentEditor');
                    // set key pid !important!!
                    $('#lightbox-pid').val(uid);
                    break;
                default:
                    break;
            }
            if (type != 0) {
                $(this).closest('#makePageType').slideToggle();
            }
        });

        // closeit
        $('#closeit').click(function() {
            $(this).closest('#makePageType').slideToggle();
        });
        $('.closeit').click(function() {
            $('.makecontent, .backDeco').hide();
            $('.makeTextImg, .backDeco').hide();
            $('.makeFileLinks, .backDeco').hide();
            $('.makeForm, .backDeco').hide();
            $('.makeFormLogin, .backDeco').hide();
            $('.makeFormSearch, .backDeco').hide();
            $('.makeMedia, .backDeco').hide();
        });
        //
        // save TEXT content  
        //
        $('#savecontent').click(function() {
            var begin = $('#setbegintime').val(),
                    end = $('#setendtime').val(),
                    title = $('.createtitle').val(),
                    content = CKEDITOR.instances.content.getData(),
                    pageid = $('#pageid').val(), // get from the hidde input or data-uid
                    content_type = 1,
                    pos = $('#pos').val();

            // CKEDITOR.replace( 'idname' );
            // var field = CKEDITOR.instances.idname.getData();

            // if no content return false
            if ($.trim(title) == '' || $.trim(content) == '') {
                return false;
            }
            $.post(
                    'xpcms/setContent',
                    {
                        begin: begin,
                        end: end,
                        title: title,
                        content: content,
                        pageid: pageid,
                        content_type: content_type,
                        pos: pos
                    }, function(data) {
                        if(data.success) {
                            location.reload();
                        }
                //alert(data);
                
                // close editor
                $('.makecontent, .backDeco').slideToggle();
            });

            return false;
        });
// CONTENT MENU
        // Show menu when a list item is clicked
        $(".pageTree ul li").contextMenu({
            menu: 'myMenu'
        },
        function(action, el, pos) {
            if (action == 'deleted') {
                $.post('xpcms/hiddenMenu',{uid: $(el).attr('data-uid')},function(data) {
                    //alert(data.msg);
                    //$(this).hide();
                }, 'json');
            }
            // preview
            if (action == 'preview') {
                //alert($(el).attr('rel'));
                window.open('home/'+$(el).attr('rel'));
            }
            $('#' + action).slideToggle();
            /*       
             //alert(
             'Action: ' + action + '\n\n' +
             'Element text: ' + $(el).text() + '\n\n' +
             'X: ' + pos.x + '  Y: ' + pos.y + ' (relative to element)\n\n' +
             'X: ' + pos.docX + '  Y: ' + pos.docY + ' (relative to document)'
             );
             */
        });
        
        $('.pageTree ').bind('mouseleave', clearError);
        function clearError() {
            $('.error').text('');
        }
       
    });

    /*]]>*/
</script>
