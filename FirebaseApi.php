<?php

class FirebaseApi {

	private $urlEndpoint   = 'https://fcm.googleapis.com/fcm/send';
	private $serverKey     = '';	
	private $target        = [];
	private $option        = [];
	private $payload       = [];
	private $contentType = 'application/json';


	public function __construct () {

	}

	private function headerInitialization () {

		$header = array(
				'Authorization:key=' . $this->serverKey,
				'Content-Type:'.$this->contentType
			);

		return $header;
		

	}

	public function setServerKey ( $serverKey ) {

		$this->serverKey =  $serverKey;
		return $this;
	}

	public function setTarget( $key, $value = false ) {

		if ( is_array( $key ) ) {
			$this->target = array_merge( $this->target, $key );

		}
		else {
			$this->target[ $key ] = $value;
		}

		
	}

	public function setOption( $key, $value = false ) {

		if ( is_array( $key ) ) {
			$this->option = array_merge( $this->option, $key );

		}
		else {
			$this->option[ $key ] = $value;
		}

		
	}

	public function setPayload( $key, $value = false ) {

		if ( is_array( $key ) ) {
			$this->payload = array_merge( $this->payload, $key );

		}
		else {
			$this->payload[ $key ] = $value;
		}

		
	}

	public function exec() {
		$this->exec_run();
	}
	

	public function exec_run () {

		$ch = curl_init();		

		$message = array_merge( $this->target, $this->option, $this->payload );

		$options = array( 
				CURLOPT_URL            => $this->urlEndpoint,
				CURLOPT_HTTPHEADER     => $this->headerInitialization(),
				CURLOPT_POST           => true,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_POSTFIELDS     => json_encode( $message )
			);
		
		curl_setopt_array( $ch, $options );		

		$response = curl_exec( $ch );
		curl_close( $ch );

		return $response;
	}

	
}
