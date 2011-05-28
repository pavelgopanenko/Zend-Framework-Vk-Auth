<?php

class Tests_Ulrika_Auth_Adapter_Vk_WidgetTest extends PHPUnit_Framework_TestCase
{
    const APP_ID = 123;
    const APP_SECRET = 'test';

    const UID = 809998;

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
        $adapter = new Ulrika_Auth_Adapter_Vk_Widget($config);
        $adapter->setRequest($request);
        return $adapter;
    }

    public function testAdapter()
    {
	    $hash  = md5(self::APP_ID . self::UID . self::APP_SECRET);
	    $params = array('uid'  => self::UID,
                        'hash' => $hash);

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
        $this->assertEquals((string) self::UID, (string) $identity);
    }

	public function testAuthenticateInvalid()
	{
	    $params = array('uid'  => self::UID,
                        'hash' => 'another_wrong_hash');

	    $adapter = $this->createTestAdapter($params);
	    $result = $adapter->authenticate();

	    $this->assertFalse($result->isValid());
	}
}
