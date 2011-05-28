<?php

class Tests_Ulrika_Auth_Adapter_Vk_IframeTest extends PHPUnit_Framework_TestCase
{
    const APP_ID = 123;
    const APP_SECRET = 'test';

    const VIEWER_ID = 809998;
    const ACCESS_TOKEN = 'some_access_token';

    /**
     * @param array $params
     * @return Ulrika_Auth_Adapter_Vk_Iframe
     */
    protected function createTestAdapter(array $params)
    {
        $request = new Zend_Controller_Request_HttpTestCase();
        $request->setParams($params);

        $config = array('appId'  => self::APP_ID,
                        'secret' => self::APP_SECRET);
        $adapter = new Ulrika_Auth_Adapter_Vk_Iframe($config);
        $adapter->setRequest($request);
        return $adapter;
    }

    public function testAdapter()
    {
	    $authKey  = md5(self::APP_ID . '_' . self::VIEWER_ID . '_' . self::APP_SECRET);
	    $accessToken = '123test';

	    $params = array('api_id'    => self::APP_ID,
                        'viewer_id' => self::VIEWER_ID,
                        'auth_key'  => $authKey,
                        'access_token' => self::ACCESS_TOKEN);

	    $adapter = $this->createTestAdapter($params);

	    $this->assertInstanceOf('Zend_Auth_Adapter_Interface', $adapter);

	    return $adapter;
    }

    /**
     * @depends testAdapter
     */
	public function testAuthenticateValid($adapter)
	{
	    $result = $adapter->authenticate();

		$this->assertInstanceOf('Zend_Auth_Result', $result);
        $this->assertTrue($result->isValid());

        $identity = $result->getIdentity();

		$this->assertInstanceOf('Ulrika_Auth_Identity_Vk', $identity);
        $this->assertEquals(self::ACCESS_TOKEN, $identity->getAccessToken());
        $this->assertEquals((string) self::VIEWER_ID, (string) $identity);
	}

	public function testAuthenticateInvalid()
	{
	    $params = array('api_id'    => self::APP_ID,
                        'viewer_id' => self::VIEWER_ID,
                        'auth_key'  => 'another_wrong_auth_key',
                        'access_token' => self::ACCESS_TOKEN);

	    $adapter = $this->createTestAdapter($params);
	    $result = $adapter->authenticate();

	    $this->assertFalse($result->isValid());
	}
}
