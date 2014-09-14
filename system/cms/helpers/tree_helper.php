<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MPTtreeToUl rekursive list helper
 *
 * Returns a string with ul, li and links
 *
 */
function MPTtreeToUl($menues, $url = 'xpcms/') {
    $str = '<ul id="root" class="tree">' . PHP_EOL;
    $str .= _ulHelper($menues, $url);
    $str .= '</ul>' . PHP_EOL;
    return $str;
}

function _ulHelper($menues, $url = '') {    
    $str = '';
    if(count($menues) != 0) {
        foreach ($menues as $menuitem) {
            $str .= '<li class="list" rel="' . $menuitem['url'] . '" id="item_' . $menuitem['uid'] . '" data-uid="' . $menuitem['uid'] . '" title="'.$menuitem['description'].'" data-lft="' . $menuitem['lft'] . '" data-rgt="' . $menuitem['rgt'] . '">'. PHP_EOL;
            $str .=     '<span class="addPageContent">'.$menuitem['title'] . '</span>'.PHP_EOL;
            $str .= '<span class="delete" title="delete this">X</span>' . PHP_EOL;
            
            if (isset($menuitem['children'])) {
                $str .= '<ul>' . PHP_EOL;
                $str .= _ulHelper($menuitem['children']);
                $str .= '</ul>' . PHP_EOL;
            }
            $str .= '</li>' . PHP_EOL;
        }
    }
    
    return $str;
}


/**
 * MPTtreeToUl for frontend  rekursive list helper
 *
 * Returns a string with ul, li and links
 *
 */
function MPTtreeToUlFE($menues, $url = '') {
    $str = '<ul id="xpcms-menu" class="frontend nav navbar-nav">' . PHP_EOL;
    $str .= _ulHelperFE($menues, $url);
    $str .= '</ul>' . PHP_EOL;
    return $str;
}

function _ulHelperFE($menues, $url = '') {    
    $str = '';

    foreach ($menues as $menuitem) {
        //echo $menuitem['url']; die('hier');
        $str .= '<li class="list" id="item_' . $menuitem['uid'] . '" data-uid="' . $menuitem['uid'] . '" title="'.$menuitem['description'].'">'. PHP_EOL;
        $str .=     '<a href="home/' . $url . $menuitem['url'] . '" title="'.$menuitem['description'].'">' . $menuitem['title'] . '</a>'.PHP_EOL;
        
        if (isset($menuitem['children'])) {
            //class="nav navbar-nav"
            $str .= '<ul class="child">' . PHP_EOL;
            $str .= _ulHelperFE($menuitem['children']);
            $str .= '</ul>' . PHP_EOL;
        }
        $str .= '</li>' . PHP_EOL;
    }

    
    return $str;
}


