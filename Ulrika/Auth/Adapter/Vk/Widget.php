<?php
/**
 * Implementation of authentication from widget parameters.
 *
 * @category   Ulrika
 * @package    Ulrika_Auth
 * @subpackage Ulrika_Auth_Adapter_Vk
 *
 * @author     Pavel Gopanenko <pavelgopanenko@gmail.com>
 * @license    FreeBSD License
 * @version    Release: @package_version@
 * @link       https://github.com/pavelgopanenko/Zend-Framework-Vk-Auth/wiki/Ulrika_Auth_Adapter_Vk_Widget
 * @since      Class available since Release 1.0.0
 * @see        http://vk.com/developers.php?o=-1&p=Auth
 */
class Ulrika_Auth_Adapter_Vk_Widget extends Ulrika_Auth_Adapter_Vk_Abstract
{
    /**
     * (non-PHPdoc)
     * @see Ulrika_Auth_Adapter_Vk_Abstract::_handleAuthRequest()
     */
    protected function _handleAuthRequest(Zend_Controller_Request_Abstract $request)
    {
        $uid  = $request->getParam('uid');
        $hash = $request->getParam('hash');

        $identity = null;
        $messages = array();

        if (!$uid || !$hash) {
            $code = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
            $messages = array('Required parameters were not found.');
        }

        if (md5($this->_getAppId() . $uid  . $this->_getSecret()) !== $hash) {
            $code = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $messages = array('Hash key invalid.');
        } else {
            $code = Zend_Auth_Result::SUCCESS;
            $identity = new Ulrika_Auth_Identity_Vk($uid);
        }

        return new Zend_Auth_Result($code, $identity, $messages);
    }
}
