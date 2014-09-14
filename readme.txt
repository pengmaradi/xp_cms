XP_CMS is a free open source software.
It is base with CodeIgniter
IMPORTANT
make sure that sysfolders (*) are writeable
* system/cms/cache
    system/cms/config/config.php
    system/cms/config/databasr.php
* public_html/css
    images/
    ui/
* installer/install.php

-- install 
  1  remove public   - files/
                    - images/
                    - videos/
  2  add installer   - install.php $install_folder = 'installer';
  3  change  system/cms/config   config.php 
                                 basel_url
  4  remove system/cms/config    database.php
   
                                $db['default']['hostname'] = '';
                                $db['default']['username'] = '';
                                $db['default']['password'] = '';
                                $db['default']['database'] = '';