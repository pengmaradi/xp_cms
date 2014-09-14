<?php

/**
 * Navigation_model
 *
 * version 0.6 (c) KLIK! 2009-04-21
 */
class Mymenu_model extends CI_Model
{
    /**
     *
     * @var string
     */
    private $mTableName = 'fe_pages';
    /**
     *
     * @return array
     */
    public function getNavItems()
    {
        //die('just debug');
        $this->db->select('*')
                ->from($this->mTableName)
                ->where('hidden', 0)
                ->where('deleted', 0)
                ->order_by('uid');

        $result = $this->db->get();

        if ($result->num_rows() > 0)
        {
            $titles = array();
            foreach ($result->result() as $row)
            {
                if ($row->endtime > time() OR $row->endtime == 0 )
                {
                    $titles[] = $row->title;
                }

            }

        }
        return $titles;
    }

}
/**
 * INSERT INTO `xp_cms`.`pages` (`uid`, `title`, `keyword`, `description`, `author`, `author_email`, `subtitle`, `crdate`, `starttime`, `endtime`, `hidden`, `deleted`, `last_updated`, `nav_title`, `nav_hidden`, `layout`, `sys_language`, `url`) VALUES ('', 'home', 'homepage', 'the page of the homesit', 'xiaoling', 'pengmaradi@gmail.com', 'my home', UNIX_TIMESTAMP(), UNIX_TIMESTAMP(), NULL, '0', '0', NULL, 'home', NULL, NULL, '1,2,3', 'home.html');
 */
/* End of file navigation_model.php */
/* Location: ./application/models/navigation_model.php */

