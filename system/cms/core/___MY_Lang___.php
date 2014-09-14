<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * URI Language Identifier
 *
 * Adds a language identifier prefix to all site_url links
 *
 * inspired by Wiredesignz
 * and Luis <luis@piezas.org.es>
 *
 * tz@eb-zuerich.ch fuer codeigniter 2.0
 * rklein@klik-info.ch for CodeIgniter 2.1, 20120101
 */
class MY_Lang extends CI_Lang
{
    private $polyglotUrls = array();
    public function __construct()
    {
        parent::__construct();
    }

    public function getpolyglotUrls()
    {
        return $this->polyglotUrls;
    }

}
