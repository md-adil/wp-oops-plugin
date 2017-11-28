<?php
/**
 * use your namespace instead
 */
namespace /*[Namespace]*/Controllers;

/**
 * use your namespace instead
 */
use /*[Namespace]*/Library\Config;

class Controller
{
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
		$configs = require(__DIR__ . '/../configs/config.php');
		if (file_exists(__DIR__ . '/../configs/config.local.php')) {
			$configs = array_replace_recursive($configs, require(__DIR__ . '/../configs/config.local.php'));
		}
		$this->config = new Config($configs);
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
            $response = call_user_func([new $className, $method]);
            if (is_string($response)) {
                echo $response;
            } elseif ($response) {
                echo wp_send_json($response);
            }
        };
    }
}
