<?php
/**
 * Abstract VK authentitication adapter.
 *
 * The base implementation of the provider,
 * provides basic methods for handling user authentication VK social network.
 *
 * @category   Ulrika
 * @package    Ulrika_Auth
 * @subpackage Ulrika_Auth_Adapter_Vk
 *
 * @author     Pavel Gopanenko <pavelgopanenko@gmail.com>
 * @license    FreeBSD License
 * @version    Release: @package_version@
 * @link       https://github.com/pavelgopanenko/Zend-Framework-Vk-Auth/wiki/Ulrika_Auth_Adapter_Vk
 * @since      Class available since Release 1.0.0
 */
abstract class Ulrika_Auth_Adapter_Vk_Abstract implements Zend_Auth_Adapter_Interface
{
    private $_config;

    /**
     * Return VK application identity.
     * @return string
     * @throws RuntimeException Application identity not found.
     */
    protected function _getAppId()
    {
        if (!isset($this->_config['appId'])) {
            throw new RuntimeException('Parameter "appId" not exists in config.');
        }

        return $this->_config['appId'];
    }

    /**
     * Return VK application secret.
     * @return string
     * @throws RuntimeException Application secret not found.
     */
    protected function _getSecret()
    {
        if (!isset($this->_config['secret'])) {
            throw new RuntimeException('Parameter "secret" not exists in config.');
        }

        return $this->_config['secret'];
    }


    private $_request;

    /**
     * Return request instance.
     * @return Zend_Controller_Request_Abstract
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Set request instance where contains auth parameters.
     * @param Zend_Controller_Request_Abstract $request
     */
    public function setRequest(Zend_Controller_Request_Abstract $request)
    {
        $this->_request = $request;
    }

    /**
     * Contructor.
     * @param array|ArrayAccess|Zend_Config $config VK social network application configuration.
     * @throws InvalidArgumentException Config type argument not support
     */
    public function __construct($config = null)
    {
        if ($config instanceof Zend_Config) {
            $config = $config->toArray();
        } elseif (!is_array($config) && !($config instanceof ArrayAccess)) {
            throw new \InvalidArgumentException('Config parameter must be array or Zend_Config instance.');
        }

        $this->_config = $config;
    }

    /**
     * (non-PHPdoc)
     * @see Zend_Auth_Adapter_Interface::authenticate()
     */
    public function authenticate()
    {
        if (null === ($request = $this->getRequest())) {
            throw new \LogicException('Not set http-request instance.');
        }

        return $this->_handleAuthRequest($request);
    }

    /**
     * Vk http-request with auth params handler.
     * @param Zend_Controller_Request_Abstract $request
     * @return Zend_Auth_Result
     */
    abstract protected function _handleAuthRequest(Zend_Controller_Request_Abstract $request);
}
