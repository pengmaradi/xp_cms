<?php 
    $num = count($feMenu);        
    for($i = 0; $i < $num; $i ++){
        $titles[] = $feMenu[$i]['title'];
        $descriptions[] = $feMenu[$i]['description'];
        $urls[] = $feMenu[$i]['url'];
        echo '<li class="list" rel="'.$urls[$i].'" title="'.$descriptions[$i].'">'.$titles[$i].
                '<span class="delete">X</span></li>'.PHP_EOL;
    }       
?>
