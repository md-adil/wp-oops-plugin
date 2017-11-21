<?php
/**
 * use your namespace instead
 */
namespace Adil\WPPlugin\Controllers;

/**
 * use your namespace instead
 */
use Adil\WPPlugin\Library\Config;

class Controller
{
    protected static $instances = [];
    protected static $configInstance;
    protected $config;
    protected $db;
    
    public function __construct()
    {
        global $wpdb;
        $this->db = $wpdb;
     
        $this->setConfig();
    }

    protected function setConfig()
    {
        if (!static::$configInstance) {
            $configs = require(__DIR__ . '/../configs/config.php');
            if (file_exists(__DIR__ . '/../configs/config.local.php')) {
                $configs = array_replace_recursive($configs, require(__DIR__ . '/../configs/config.local.php'));
            }
            static::$configInstance = new Config($configs);
        }
        $this->config = static::$configInstance;
    }
    
    protected function view($path, $args = [])
    {
        extract($args);
        require_once(__DIR__ . '/../views/' . $path);
    }

    public function redirect($path)
    {
        header("Location: " . $path);
    }

    public function redirectBack()
    {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }

    /**
     * @param $callable className@methodName
     */
    public static function resolve($callable)
    {
        return function () use ($prefix, $callable) {
            list($class, $method) = explode('@', $callable);
            $className =  __NAMESPACE__ . '\\' . $class;
            if (!isset(static::$instances[$className])) {
                static::$instances[$className] = new $className;
            }
            $response = call_user_func([static::$instances[$className], $method]);
            if (is_array($response)) {
                echo wp_send_json($response);
            } elseif ($response) {
                echo $response;
            }
        };
    }
}
