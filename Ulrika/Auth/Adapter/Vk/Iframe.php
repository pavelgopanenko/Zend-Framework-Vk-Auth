<?php
/**
 * Implementation of authentication for iframe application.
 *
 * @category   Ulrika
 * @package    Ulrika_Auth
 * @subpackage Ulrika_Auth_Adapter_Vk
 *
 * @author     Pavel Gopanenko <pavelgopanenko@gmail.com>
 * @license    FreeBSD License
 * @version    Release: @package_version@
 * @link       https://github.com/pavelgopanenko/Zend-Framework-Vk-Auth/wiki/Ulrika_Auth_Adapter_Vk_Iframe
 * @since      Class available since Release 1.0.0
 * @see        http://vk.com/developers.php?o=-1&p=%CF%F0%E8%EB%EE%E6%E5%ED%E8%FF%20%C2%CA%EE%ED%F2%E0%EA%F2%E5
 */
class Ulrika_Auth_Adapter_Vk_Iframe extends Ulrika_Auth_Adapter_Vk_Abstract
{
    /**
     * (non-PHPdoc)
     * @see Ulrika_Auth_Adapter_Vk_Abstract::_handleAuthRequest()
     */
    protected function _handleAuthRequest(Zend_Controller_Request_Abstract $request)
    {
        $apiId    = $request->getParam('api_id');
        $viewerId = $request->getParam('viewer_id');
        $authKey  = $request->getParam('auth_key');

        $identity = null;
        $messages = array();

        if (!$apiId || !$viewerId || !$authKey) {

            $code = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
            $messages = array('Required parameters were not found.');

        } elseif ($this->_getAppId() != $apiId) {

            $code = Zend_Auth_Result::FAILURE;
            $messages = array('Authentication is another application.');

        } else if (md5($this->_getAppId() . '_' . $viewerId  . '_' . $this->_getSecret()) !== $authKey) {

            $code = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $messages = array('Auth key invalid.');

        } else {

            $code = Zend_Auth_Result::SUCCESS;
            $identity = new Ulrika_Auth_Identity_Vk($viewerId, $request->getParam('access_token'));
        }

        return new Zend_Auth_Result($code, $identity, $messages);
    }
}
