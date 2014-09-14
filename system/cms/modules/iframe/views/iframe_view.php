<!DOCTYPE html>
<html>
    <head>
        <title>test title</title>
        <base href="<?php echo base_url(); ?>" />
        <link rel="stylesheet" type="text/css" href="./public_html/xp/xpcms/css/xpcms.css" />
        <link href="http://labs.abeautifulsite.net/archived/jquery-contextMenu/demo/jquery.contextMenu.css" rel="stylesheet" type="text/css" />
        <script src="public_html/xp/xp_cms/js/jquery.js"></script>
        <script src="./public_html/xp/xpcms/js/contextmenu.js"></script>
        <style type="text/css">			
            #myDiv {
                    width: 150px;
                    border: solid 1px #2AA7DE;
                    background: #6CC8EF;
                    text-align: center;
                    padding: 4em .5em;
                    margin: 1em;
                    float: left;
            }

            #myList {
                    margin: 1em;
                    float: left;
            }

            #myList ul {
                    padding: 0px;
                    margin: 0em 1em;
            }

            #myList li {
                    width: 100px;
                    border: solid 1px #2AA7DE;
                    background: #6CC8EF;
                    padding: 5px 5px;
                    margin: 2px 0px;
                    list-style: none;
            }

            #options {
                    clear: left;
            }

            #options input {
                    font-family: Verdana, Arial, Helvetica, sans-serif;
                    font-size: 11px;
                    width: 150px;
            }
	</style>
    </head>
    <body>
        <header>header test</header>
        <?php //$this->load->controller('admin/admin/index');?>
        <div id="maincontent">
            <div id="mainleft">
                <p>baidu</p>
                <p>cctv</p>
                <p>china</p>
                <p>php100</p>
            </div>
            <script>
                (function($) {
                    $('#mainleft p').css('cursor', 'pointer');
                    $('#mainleft p').click(function() {
                        var title = $(this).text();
                        $('#mainright iframe').attr('src', 'http://www.' + title + '.com');
                    });
                })(jQuery);
            </script>
            <div id="mainright">
                <iframe src="<?php echo base_url(); ?>xpcms"></iframe>
            </div>       
        </div>
        <footer>
            <div id="myList">
                <ul>
                    <li>Item 1</li>
                    <li>Item 2</li>
                    <li>Item 3</li>
                    <li>Item 4</li>
                    <li>Item 5</li>
                    <li>Item 6</li>
                </ul>
            </div>
            <ul id="myMenu" class="contextMenu">
                <li class="edit"><a href="#edit">Edit</a></li>
                <li class="cut separator"><a href="#cut">Cut</a></li>
                <li class="copy"><a href="#copy">Copy</a></li>
                <li class="paste"><a href="#paste">Paste</a></li>
                <li class="delete"><a href="#delete">Delete</a></li>
                <li class="quit separator"><a href="#quit">Quit</a></li>
            </ul>
            <script type="text/javascript">
                $(document).ready(function() {
                    // Show menu when #myDiv is clicked
                    $("#mainleft p").contextMenu({
                        menu: 'myMenu'
                    },
                    function(action, el, pos) {
                        alert(
                                'Action: ' + action + '\n\n' +
                                'Element ID: ' + $(el).attr('id') + '\n\n' +
                                'X: ' + pos.x + '  Y: ' + pos.y + ' (relative to element)\n\n' +
                                'X: ' + pos.docX + '  Y: ' + pos.docY + ' (relative to document)'
                                );
                    });

                    // Show menu when a list item is clicked
                    $("#myList ul li").contextMenu({
                        menu: 'myMenu'
                    },
                    function(action, el, pos) {
                        alert(
                                'Action: ' + action + '\n\n' +
                                'Element text: ' + $(el).text() + '\n\n' +
                                'X: ' + pos.x + '  Y: ' + pos.y + ' (relative to element)\n\n' +
                                'X: ' + pos.docX + '  Y: ' + pos.docY + ' (relative to document)'
                                );
                    });

                    // Disable menus
                    $("#disableMenus").click(function() {
                        $('#myDiv, #myList UL LI').disableContextMenu();
                        $(this).attr('disabled', true);
                        $("#enableMenus").attr('disabled', false);
                    });

                    // Enable menus
                    $("#enableMenus").click(function() {
                        $('#myDiv, #myList UL LI').enableContextMenu();
                        $(this).attr('disabled', true);
                        $("#disableMenus").attr('disabled', false);
                    });

                    // Disable cut/copy
                    $("#disableItems").click(function() {
                        $('#myMenu').disableContextMenuItems('#cut,#copy');
                        $(this).attr('disabled', true);
                        $("#enableItems").attr('disabled', false);
                    });

                    // Enable cut/copy
                    $("#enableItems").click(function() {
                        $('#myMenu').enableContextMenuItems('#cut,#copy');
                        $(this).attr('disabled', true);
                        $("#disableItems").attr('disabled', false);
                    });

                });

            </script>
        </footer>
    </body>
</html>

