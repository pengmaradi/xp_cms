<?php
echo $menu;
?>
<div id="maincontent">
    <div class="makepage">
        <ul>
            <li><a class="addnew" href="#">create a new page</a></li>
        </ul>
    </div>
    
    <div class="makeTree" style="display:none">
        <div class="formlist">
            <label for="pagetitle">page title</label>
            <input type="text" name="pagetitle" id="pagetitle"/>
            <span id="warnung" style="display: none">Max 15 string or it musst be alphabet or number!</span>
        </div>

        <div class="formlist">
            <label for="pagetype">page type</label>
            <?php
    echo '<select id="pagetype" name="pagetype">'.PHP_EOL;
    echo '<option value="0">select type</option>'.PHP_EOL;

    echo '<optgroup label="STANDART">'.PHP_EOL;
    $standart = array_combine($standarts['type'],$standarts['name']);
    foreach($standart as $key => $value){
        echo  '<option value="'.$key.'">'.$value.'</option>'.PHP_EOL;
    }
    echo '</optgroup>'.PHP_EOL;

    echo '<optgroup label="LISTS">'.PHP_EOL;
    $list = array_combine($lists['type'],$lists['name']);
    foreach($list as $key => $value){
        echo  '<option value="'.$key.'">'.$value.'</option>'.PHP_EOL;
    }
    echo '</optgroup>'.PHP_EOL;

    echo '<optgroup label="FORMS">'.PHP_EOL;
    $form = array_combine($forms['type'],$forms['name']);
    foreach($form as $key => $value){
        echo  '<option value="'.$key.'">'.$value.'</option>'.PHP_EOL;
    }
    echo '</optgroup>'.PHP_EOL;

    echo '<optgroup label="SPECIAL">'.PHP_EOL;
    $special = array_combine($specials['type'],$specials['name']);
    foreach($special as $key => $value){
        echo  '<option value="'.$key.'">'.$value.'</option>'.PHP_EOL;
    }
    echo '</optgroup>'.PHP_EOL;
    echo '</select>'.PHP_EOL;
?>
        </div>
        <div class="formlist">
            <button id="save">Save</button>
        </div>
        <div id="closeit">X</div>
        <div class="deco"></div>
    </div>
    
    <div class="pageTree">        
        <ul class="tree">
        </ul>
        <button id="write" style="display:none">Save</button>
    </div>
<script>
/*<![CDATA[*/
jQuery(function($){
    $('#closeit').click(function(){
        $(this).closest('.makeTree').slideToggle();
    });
    $('.addnew').click(function(){
        $('.makeTree').slideToggle();
        return false;
    });
    // check menu length and if is alphanumeric
    $('#pagetitle').keyup(function(){
        var page = $(this).val(), ml = page.length, num_appha_preg = /[a-zA-ZäöüÄÖÜ0-9_-]+/;
        if( ml > 20 || !num_appha_preg.test(page) ){
            $(this).addClass('hightlight');
            $('#warnung').slideToggle();
            $(this).val('');
        }else {
            $(this).removeClass('hightlight');
        }
    });
    // send and check the data
    $('#save').click(function(){
        var title = $('#pagetitle').val(), pagetype = $('#pagetype').val();
        if( title == '' ){
            $('#pagetitle')
            .addClass('hightlight')
            .focus();
            return false;
        } else {
            $('#pagetitle')
            .removeClass('hightlight')
        }

        if( pagetype == '0' ){
            $('#pagetype')
            .addClass('hightlight')
            .focus();
            return false;
        }else {
            $('#pagetype')
            .removeClass('hightlight');
        }
        // ajax save the data
        $.post(
            'xpcms/setMenu',
            {
                title:        title,
                content_type: pagetype
            },
            function(data){
                $('.tree').html(data);

        });

        //$('.tree').append('<li class="list" ref="'+ pagetype +'">'+ title + '<span class="delete">X</span></li>');
        $('#pagetitle').val('');
        $(this).closest('.makeTree').css('display','none');
    });
    
    $( ".tree" ).sortable();
    //$( ".tree" ).disableSelection();

});
/*]]>*/
</script>
<?php

?>

</div>


