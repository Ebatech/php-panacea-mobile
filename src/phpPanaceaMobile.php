<?php

namespace phpPanaceaMobile;

class phpPanaceaMobile
{
	/**
	* @const LIB_ERROR_TYPE can be exception or error
	*/
	const LIB_ERROR_TYPE = 'error';

	/**
	* @const holds the notify url
	*/
	const LIB_URL = 'https://push.panaceamobile.com/';

	/**
	* toggles on debugging
	*
	* @var bool
	*/
	public $debug = false;

	/**
	* needed api-key for communication
	*
	* @var bool|string
	*/
	protected $apikey = false;

	/**
	* thread to deliver messages in
	*
	* @var string
	*/
	public $thread = 'Default';


	/**
	* @param array $options
	*/
	function __construct($options = array())
	{
		if (!isset($options['apikey']))
			return $this->error('You must supply a API Key');
		else
			$this->apikey = $options['apikey'];

		if (isset($options['thread']))
			$this->thread = $options['thread'];

		if (isset($options['debug']))
			$this->debug = true;

		return true;
	}


	/**
	* @param     $device
	* @param     $message
	*
	* @return bool
	*/
	public function send($device, $message)
	{
		if($this->debug) echo "apikey: ".$this->apikey."\n";
		if($this->debug) echo "device: ".$device."\n";
		if($this->debug) echo "thread: ".$this->thread."\n";
		if($this->debug) echo "message: ".$message."\n";

		//build url
		$url = self::LIB_URL.
			"?action=push_public_outbound_message_send".
			"&api_key=".$this->apikey.
			"&device_id=".$device.
			"&thread_id=".$this->thread.
			"&message=".rawurlencode($message).
		"";

		if($this->debug) echo "url: ".$url."\n";

		$response = file_get_contents($url);

		if($this->debug) echo "response: ".$response."\n";

		$result = json_decode($response);

		if($this->debug) echo "result: ".print_r($result, true)."\n";

		if($result->status == 0 AND $result->message == "OK")
			return true;
		else
			return false;
	}


	/**
	* @param     $message
	* @param int $type
	*
	* @return bool
	* @throws Exception
	*/
	private function error($message, $type = E_USER_NOTICE)
	{
		if (self::LIB_ERROR_TYPE == 'error')
		{
			trigger_error($message, $type);
			return false;
		}
		else
		{
			throw new Exception($message, $type);
		}
	}

}
