<?php
/**
 * User: ben
 * Date: 19/7/8
 * Time: 14:00
 */

namespace App;

use Noodlehaus\Config;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Tinify;

/**
 * Class main
 *
 * @package App
 */
class Main
{
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Logger|string
     */
    protected $log;

    /**
     * main constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->config = Config::load(__DIR__ . '/../config/app.php');
        $this->log = new Logger('app');
        $this->log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG));
    }

    /**
     * @return null
     */
    public function run()
    {
        Tinify\setKey($this->config['TINIFY_API_KEY']);
        $dirs = scandir('images');
        foreach ($dirs as $dir) {
            Tinify\fromFile("images/{$dir}")->toFile("images/{$dir}");
        }
        return null;
    }
}
