<div id="head">
    <h1 id="logo">xp_cms</h1>
    <ul class="maiNav">
<?php

foreach($menuItems as $key => $menu) {
    echo '<li><a href="xpcms/'.$menu.'" title="'.$menu.'">'.$menu.'</a></li>'.PHP_EOL;
}
?>
    </ul>
</div>

