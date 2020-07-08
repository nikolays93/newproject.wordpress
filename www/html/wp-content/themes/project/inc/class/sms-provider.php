<?php

class SMS_Provider {
	public $to;
	public $text;
	public $from = '';
	public $test = 0;
	public $translit = 0;
	public $partner_id = 1;

	public function __construct() {
		$this->from = apply_filters( 'theme_sms_from_number', '' );
	}

	public function set_to( $phone ) {
		$this->to = preg_replace( '/\D/', '', $phone );

		if ( '8' === substr( $this->to, 0, 1 ) ) {
			$this->to = '7' . substr( $this->to, 1 );
		}

		return $this;
	}

	public function set_text( $text ) {
		$this->text = $text;

		return $this;
	}

	public function set_from( $phone ) {
		$this->from = $phone;

		return $this;
	}
}
