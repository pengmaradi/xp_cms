<?php

if (!defined('BASEPATH')) {exit('No direct script access allowed');}

class Menu
{

    protected $menuData = array();
    protected $menuTemplate = 'menu_view'; // nested li-Liste
    protected $CI;

    public function __construct($params)
    {
        $this->CI = & get_instance();
    }

    public function setTemplate($mTpl)
    {
        $this->menuTemplate = $mTpl;
    }

    public function render()
    {
        $this->CI->load->model('Navigation_model', '', true);
        $menuItems = $this->CI->Navigation_model->getNavItems();
        $this->menuData['menuItems'] = $menuItems;

        return $this->CI->load->view($this->menuTemplate, $this->menuData, true);
    }



}