<ul id="mainnav">
<?php
$num = count($menuItems['urls']);
for($i = 0; $i < $num; $i++){
    printf('<li class="level_one"><a href="./home/%s" title="%s">%s</a></li>'.PHP_EOL ,$menuItems['urls'][$i],$menuItems['titles'][$i],$menuItems['titles'][$i]);
}
?>
</ul>
