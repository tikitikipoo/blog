<?php
/**
 * Created by JetBrains PhpStorm.
 * User: tikitikipoo
 * Date: 13/06/22
 * Time: 5:57
 * To change this template use File | Settings | File Templates.
 */

namespace cypher;


/**
 * Class SplClassLoader
 * @package cypher
 */
class SplClassLoader {


    /**
     * 読み込み先ディレクトリ
     *
     * @var array
     */
    protected $dir;

    public function __construct(array $dir = array())
    {
        $this->dir = $dir;
    }

    /**
     * 読み込み先ディレクトリ追加
     *
     * @param $dir
     */
    public function registerDir( $dir)
    {
        $this->dir[] = $dir;
    }

    /**
     * 自動読み込み処理登録
     */
    public function register()
    {
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * autoload
     *
     * @param $className
     * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
     */
    public function loadClass($className)
    {
        $className = ltrim($className, '\\');
        $fileName = '';
        $namespace = '';
        if ($lastNsPos = strrpos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }

        $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

        foreach ($this->dir as $dir) {
            //var_dump($dir . $fileName);
            if (file_exists($dir . $fileName)) {
                require $dir . $fileName;
            }
        }
    }
}
