<?php

$cwd = getcwd();
chdir(__DIR__);

define('ENVIRONMENT', isset($_SERVER['ENV']) ? $_SERVER['ENV'] : 'development');

$goRoot             = '../../';
$system_path        = $goRoot . 'vendor/cirevolution/system/src/System';
$application_folder = $goRoot . 'app';
$doc_root           = $goRoot . 'public';

if (realpath($system_path) !== false) {
    $system_path = realpath($system_path) . '/';
}
$system_path = rtrim($system_path, '/') . '/';

define('BASEPATH', str_replace("\\", "/", $system_path));
define('FCPATH', $doc_root . '/');
define('APPPATH', $application_folder . '/');
define('ROOOTPATH', $goRoot);
define('VIEWPATH', $application_folder . '/views/');

require(BASEPATH . 'Core/Common.php');

if (file_exists(ROOOTPATH . 'config/' . ENVIRONMENT . '/constants.php')) {
    require(ROOOTPATH . 'config/' . ENVIRONMENT . '/constants.php');
} else {
    require(ROOOTPATH . 'config/constants.php');
}

$charset = strtoupper(config_item('charset'));
ini_set('default_charset', $charset);

if (extension_loaded('mbstring')) {
    define('MB_ENABLED', TRUE);
    // mbstring.internal_encoding is deprecated starting with PHP 5.6
    // and it's usage triggers E_DEPRECATED messages.
    @ini_set('mbstring.internal_encoding', $charset);
    // This is required for mb_convert_encoding() to strip invalid characters.
    // That's utilized by CI_Utf8, but it's also done for consistency with iconv.
    mb_substitute_character('none');
} else {
    define('MB_ENABLED', FALSE);
}

// There's an ICONV_IMPL constant, but the PHP manual says that using
// iconv's predefined constants is "strongly discouraged".
if (extension_loaded('iconv')) {
    define('ICONV_ENABLED', TRUE);
    // iconv.internal_encoding is deprecated starting with PHP 5.6
    // and it's usage triggers E_DEPRECATED messages.
    @ini_set('iconv.internal_encoding', $charset);
} else {
    define('ICONV_ENABLED', FALSE);
}

$GLOBALS['CFG'] = & load_class('Config', 'Core');
$GLOBALS['UNI'] = & load_class('Utf8', 'Core');
$GLOBALS['SEC'] = & load_class('Security', 'Core');

load_class('Loader', 'Core');
load_class('Router', 'Core');
load_class('Input', 'Core');
load_class('Lang', 'Core');

require(BASEPATH . 'Core/Controller.php');

function &get_instance()
{
    return Controller::get_instance();
}

chdir($cwd);

return new Controller();
