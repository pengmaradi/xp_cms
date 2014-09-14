<?php

/**
 *
 * function for install
 * @param string $step
 *
 * @return void
 */
function setup($step) {
    switch ($step) {
        case 'welcome':
        default:
            // make sure the fils and sysfoldr are writeable
            $create_directories = array(
                'public_html/images',
                'public_html/images/thumbs',
                'public_html/files',
                'public_html/videos'
            );
            $writable_directories = array(
                'system/cms/cache',
                'system/cms/config',
                'public_html/css',
                'public_html/ui',
                'installer'
            );
            $writable_files = array(
                'system/cms/config/config.php',
                'system/cms/config/database.php',
                'installer/install.php'
            );
            $permissions = array();
            // linux
            //$abspath = str_replace('installer/index.php', '', __FILE__);
            // windows
            //$abspath = str_replace('installer\index.php', '', __FILE__);
            //die($abspath); //installer\index.php
            $abspath = '../';
            // create dir
            foreach ($create_directories as $newdir) {
                if(!file_exists($abspath.$newdir)) {
                    @mkdir($abspath.$newdir,0777);
                    @chmod($abspath.$newdir, 0777);
                } else {
                    @chmod($abspath.$newdir, 0777);
                }
            }

            foreach ($writable_directories as $dir) {
                @chmod($abspath . $dir, 0777);                
            }
            // write the base url to config.php
            $towriteConfig = '$config[\'base_url\'] = \''.$_SESSION['base_url'].'\';'." \r\n";
            $towriteConfig .= "/* End of file config.php */\r\n";
            $towriteConfig .= "/* Location: ./application/config/config.php */\r\n";
            $filename = '../'.$writable_files[0];
            $fp = fopen($filename,'a+');
            fwrite($fp,$towriteConfig);
            fclose($fp);

            foreach ($writable_files as $file) {
                $fo = fopen($abspath.$file, 'a+');
                if(!$fo) {
                    if(!@chmod($abspath . $file, 0666)) {
                        echo '<p style="color:red;">please make sure the file: '.$abspath . $file.' is writeable!</p>';
                        fclose($fo);
                        exit();
                    }
                }
                fclose($fo);
            }
            
            if (!isset($_POST['hostname'])) {
                echo createInstallForm::form($base_url);
            }
            
            break;
        case 'database':
            // set database
            $hostname = $_POST['hostname'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (empty($_POST['database'])) {
                $database = 'xp_cms';
            } else {
                $database = $_POST['database'];
            }

            $_SESSION['hostname'] = $hostname;
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['database'] = $database;
            
            $file = '../system/cms/config/database.php';
            if (file_exists($file)) {
                
                // configuration
                $sFileContent = file_get_contents($file);
                $aFileContentParts = explode('###', $sFileContent);
                $aFileContentParts[1] = '###
$db[\'default\'][\'hostname\'] = \'' . $hostname . '\';
$db[\'default\'][\'username\'] = \'' . $username . '\';
$db[\'default\'][\'password\'] = \'' . $password . '\';
$db[\'default\'][\'database\'] = \'' . $database . '\';
###';
                $sNewContent = implode('', $aFileContentParts);               

                file_put_contents($file, $sNewContent);
            } else {
                die($file . ' is not found');
            }
            // create datebase
// installDatabase::createTables($hostname,$username,$password);

            if (installDatabase::createTables($hostname, $username, $password, $database)) {
                
                if (!isset($_POST['admin'])) {
                    // create form for web admin

                    echo form::form_open($_SESSION['base_url'] . 'installer/?step=last');
                    echo form::form_input('text', 'admin');
                    echo form::form_input('password', 'password');
                    echo form::form_input('email', 'email');
                    echo form::form_input('text', 'realname');
                    echo form::form_input('submit', 'send');
                    echo form::form_close();
                }
            }

            break;
        case 'last':
            $webarray = array(
                'admin' => $_POST['admin'],
                'pass' => $_POST['password'],
                'email' => $_POST['email'],
                'realname' => $_POST['realname']
            );
            installDatabase::insertAdmin($_SESSION['hostname'], $_SESSION['username'], $_SESSION['password'], $_SESSION['database'], $webarray);
            echo '<p>Now it is finished. </p>';
            // change install string
            $installfile = './install.php';
            if (file_exists($installfile)) {
                $sFileContent = file_get_contents($installfile);
                $aFileContentParts = explode('###', $sFileContent);
                $aFileContentParts[1] = '###
$install_folder = \'\';
###';
                $sNewContent = implode('', $aFileContentParts);
                file_put_contents($installfile, $sNewContent);
            }
            // create a .htaccess file RewriteBase /path_to(/kurs/webprog20/xp)/project_name/

            echo '<p><a href="' . $_SESSION['base_url'] . 'xpcms/">Go to backend</a></p>';
            // Finally, destroy the session.            
            session_destroy();
            break;
    }
}

session_start();
// ???? PHP ??
error_reporting(E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR);
ignore_user_abort(true);
define('XPCMS', rtrim($_SERVER['SCRIPT_FILENAME'], 'install/index.php'));
// define install include path
define('XPCMS_PAGE_PATH', '../public_html/xp/xp_cms/');

$base_url = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('installer/index.php', '', $_SERVER['SCRIPT_NAME']);
$_SESSION['base_url'] = $base_url;
require_once (XPCMS_PAGE_PATH . 'header/header.phtml');
require_once (XPCMS_PAGE_PATH . 'header/head.phtml');
require_once (XPCMS_PAGE_PATH . 'header/installWelcome.phtml');
require_once (XPCMS_PAGE_PATH . 'lib/class.form.php');
require_once (XPCMS_PAGE_PATH . 'header/installDatabase.phtml');
require_once (XPCMS_PAGE_PATH . 'header/createInstallForm.phtml');

// when system is already installed, jump out
require_once ('./install.php');
if ($install_folder != 'installer') {
    define('TOCMS', str_replace('/installer', '', $_SERVER['REQUEST_URI']));
    header('Location: http://' . $_SERVER['HTTP_HOST'] . TOCMS);
}

if (isset($_GET['step']))
    $step = @$_GET['step'];

setup($step);
require_once (XPCMS_PAGE_PATH . 'footer/footer.phtml');
