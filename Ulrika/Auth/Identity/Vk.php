<?php
/**
 * User indedntity class.
 *
 * @category   Ulrika
 * @package    Ulrika_Auth
 * @subpackage Ulrika_Auth_Identity
 *
 * @author     Pavel Gopanenko <pavelgopanenko@gmail.com>
 * @license    FreeBSD License
 * @version    Release: @package_version@
 * @link       https://github.com/pavelgopanenko/Zend-Framework-Vk-Auth/wiki/Ulrika_Auth_Identity_Vk
 * @since      Class available since Release 1.0.0
 */
class Ulrika_Auth_Identity_Vk
{
    private $_uid;

    private $_accessToken;

    /**
     * Returns the token easy access to API.
     * @return string
     */
    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    /**
     * Constructor.
     * @param string|int $uid User identifier
     * @param string $accessToken Easy access to API token
     */
    public function __construct($uid, $accessToken = null)
    {
        $this->_uid = (int) $uid;
        $this->_accessToken = $accessToken;
    }

    public function __toString()
    {
        return (string) $this->_uid;
    }
}
