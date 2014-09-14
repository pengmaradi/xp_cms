<?php
echo $menu;
?>
<div id="maincontent">
    
    <div class="pageTree">        
        <ul class="tree">
<?php 
    $num = count($feMenu);        
    for($i = 0; $i < $num; $i ++){
        $titles[] = $feMenu[$i]['title'];
        $descriptions[] = $feMenu[$i]['description'];
        $urls[] = $feMenu[$i]['url'];
        echo '<li class="list" rel="'.$urls[$i].'" title="'.$descriptions[$i].'"><span class="addChildMenu" title="child page">+</span>'.$titles[$i].
                '<span class="delete" title="delete this">X</span></li>'.PHP_EOL;
    }       
?>
        </ul>
        <button id="write" style="display:none">Save</button>
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

</div>

<script>
/*<![CDATA[*/
(function($){
    $( '.tree .list' ).each(function(){
        var index = $(this).index();
        $(this).attr('data-index', index );
        $(this).click(function(){
            var position = $(this).attr('data-position')
            $(this).attr('newindex', position );
        });
        $(this).find('.delete').click(function(){
           $(this).closest('.list').hide(); 
        });
    });
    $( ".tree" ).sortable({
        start: function (event, ui) {
            var currPos1 = ui.item.index();
            $(this).find(ui.item).attr('data-position', currPos1 );
        },
         stop: function (event, ui) {
             var currPos3 = ui.item.index();
             $(this).find(ui.item).attr('data-position', currPos3 );
            var counter = 0; 
            $('ul.tree').find('li').each(function() {
                 $(this).attr('data-position', counter++);
                 
             });
        }        
    });
    $('.addChildMenu').click(function() {
    
    });
})(jQuery);
/*]]>*/
</script>