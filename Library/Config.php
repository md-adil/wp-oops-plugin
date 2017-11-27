<?php
/**
 * use your namespace instead
 */
namespace Adil\WPPlugin\Library;

class Config
{
    protected $configs;

    public function __construct($configs)
    {
        $this->configs = $configs;
    }

    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return $this->configs;
        }

        if ($this->exists($key)) {
            return $this->configs[$key];
        }

        $array = $this->configs;
        foreach (explode('.', $key) as $segment) {
            if (isset($array[$segment])) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }
        return $array;
    }

    public function set($key, $value = null)
    {
        if (is_null($key)) {
            return $this->configs = $value;
        }

        if (is_array($key)) {
            $this->configs = array_merge($this->configs, $key);
        }
        $array = &$this->configs;
        $keys = explode('.', $key);
        while (count($keys) > 1) {
            $key = array_shift($keys);
            if (! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }
        $array[array_shift($keys)] = $value;
    }

    public function exists($key)
    {
        return array_key_exists($key, $this->configs);
    }
}

