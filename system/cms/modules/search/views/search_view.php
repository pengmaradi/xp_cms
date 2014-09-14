<div class="search-form navbar-form navbar-right">
    <?php
    echo form_open($action, 'method="get" id="search" class="form-inline" role="form"');
    echo '<div class="form-group">'.PHP_EOL;
    echo form_input('s', '', 'id="search_val" class="form-control"');
    echo '</div>'.PHP_EOL.'<div class="form-group">'.PHP_EOL;
    echo form_submit('submit', 'search', 'id="search_submit" class="btn btn-default"');
    echo '</div>'.PHP_EOL;
    echo form_close();
    ?> 
</div>
<script>
(function($){    
    // search
    $('#search_submit').click(function(){
        var contents = $('#search').serialize();
        //alert(contents);
        $.post('search/get_result', contents, function(data){
            if(data.success) {
                if(data.result != '') {
                    $('.result').html(data.result);
                    $('.search-result').show(1000);
                }              
            }
        },'json');
        $('.close').click(function(){
            $(this).closest('.search-result').hide(1000);
       });
        return false;
    });
})(jQuery);
</script>
<div class="search-result">
    <div class="close">X</div>
    <div class="result">
    <?php
    if(count($result) != 0) {
        $num = count($result);
        $n_menu = count($menus);
        if ($num == $n_menu) {
            for ($i = 0; $i < $num; $i++) {
                echo '<p><a href="home/'.$menus[$i].'">' . $result[$i]['header'] .'</a>';
            }
        }
    }
    ?>        
    </div>
</div>

