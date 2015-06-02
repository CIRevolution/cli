<?php
/**
 * Part of CodeIgniter Cli
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/codeigniter-cli
 */

$installer = new Installer();
$installer->install();

class Installer
{
    protected $roots = '../../../';

    public static function install()
    {
        self::recursiveCopy('vendor/cirevolution/cli/config', $this->roots.'config');
        
        @mkdir('tmp', 0755);
        @mkdir('tmp/log', 0755);
        
        self::copy('vendor/cirevolution/cli/cli', $this->roots.'cli');
        self::copy('vendor/cirevolution/cli/instance.php', $this->roots.'app/console/instance.php');
        
        chmod('cli', 0755);
    }

    private static function copy($src, $dst)
    {
        $success = copy($src, $dst);
        if ($success) {
            echo 'copied: ' . $dst . PHP_EOL;
        }
    }

    /**
     * Recursive Copy
     *
     * @param string $src
     * @param string $dst
     */
    private static function recursiveCopy($src, $dst)
    {
        @mkdir($dst, 0755);
        
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($src, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );
        
        foreach ($iterator as $file) {
            if ($file->isDir()) {
                @mkdir($dst . '/' . $iterator->getSubPathName());
            } else {
                $success = copy($file, $dst . '/' . $iterator->getSubPathName());
                if ($success) {
                    echo 'copied: ' . $dst . '/' . $iterator->getSubPathName() . PHP_EOL;
                }
            }
        }
    }
}
