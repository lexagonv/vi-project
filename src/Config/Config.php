<?php
namespace App\Config;

use Symfony\Component\Config\FileLocator;

class Config implements ConfigInterface
{
    private $config = [];
    private $loader;
    private $locator;

    public function __construct($directory)
    {
        $directories = [
            BASEPATH . '/' . $directory
        ];

        $this->setLocator($directories);
        $this->setLoader();
    }

    public function addConfig($file)
    {
        $configValues = $this->loader->load($this->locator->locate($file));
        if ($configValues) {
            foreach ($configValues as $key => $value) {
                $this->config[$key] = $value;
            }
        }
    }

    /**
     * @param $keyValue
     * @return mixed|null
     */
    public function get($keyValue)
    {
        list($key, $value) = explode('.', $keyValue);

        if ($key && isset($this->config[$key])) {
            if ($value && $this->config[$key][$value]) {
                return $this->config[$key][$value];
            } else {
                return $this->config[$key];
            }
        }

        return null;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setLoader()
    {
        $this->loader = new YamlConfigLoader($this->locator);
    }

    /**
     * @param $directory
     */
    public function setLocator($directory)
    {
        $this->locator = new FileLocator($directory);
    }
}