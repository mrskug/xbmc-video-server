<?php

/**
 * Description of LibraryUpdateListener
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 */
class LibraryUpdateListener
{
	const METHOD_ON_SCAN_STARTED = 'VideoLibrary.OnScanStarted';
	const METHOD_ON_SCAN_FINISHED = 'VideoLibrary.OnScanFinished';

	/**
	 * @var function event handler for METHOD_ON_SCAN_STARTED
	 */
	public $onScanStarted;

	/**
	 * @var function event handler for METHOD_ON_SCAN_FINISHED
	 */
	public $onScanFinished;

	/**
	 * @var Hoa\Websocket\Client the Websocket client
	 */
	private $_client;

	/**
	 * Class constructor
	 */
	public function __construct()
	{
		/* @var $backend Backend */
		$backend = Yii::app()->backendManager->getCurrent();
		$hostname = $backend->hostname;

		// Create the Websocket client
		$this->_client = new Hoa\Websocket\Client(
				new Hoa\Socket\Client('tcp://'.$hostname.':9090'));
		$this->_client->setHost(gethostname());
	}

	/**
	 * Listens for new events until the specified event is received
	 * @param string the event to wait for
	 */
	public function blockUntil($event)
	{
		// Trigger a library update when the socket has been opened
		$this->_client->on('open', function() {
			Yii::app()->controller->log('Scan triggered');
			Yii::app()->xbmc->sendNotification('VideoLibrary.Scan');
		});
		
		$this->_client->on('message', function(Hoa\Core\Event\Bucket $bucket) use ($event) {
			$response = $this->parseResponse($bucket);

			if ($response === null)
				return;

			// Handle events
			switch ($response->method)
			{
				case self::METHOD_ON_SCAN_STARTED:
					$this->onScanStarted->__invoke();
					break;
				case self::METHOD_ON_SCAN_FINISHED:
					$this->onScanFinished->__invoke();
					break;
			}
			
			if ($response->method !== $event)
				$this->_client->receive();
		});

		// Start listening (wait for one message)
		$this->_client->connect();
		$this->_client->receive();
	}

	/**
	 * @param Hoa\Core\Event\Bucket $bucket
	 * @return stdClass the response object, or null if the response is invalid
	 */
	private function parseResponse(Hoa\Core\Event\Bucket $bucket)
	{
		$data = $bucket->getData();
		$response = json_decode($data['message']);

		return isset($response->method) ? $response : null;
	}

}
