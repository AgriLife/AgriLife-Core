<?php

class Test_PeopleAPI extends WP_UnitTestCase {

	private $client;
	private $successfulResponse;
	private $failedResponse;

	private $getUnitsHash = 'MR1ac6DLFjce4q9zl6M9Kw==';
	private $badGetUnitsHash = 'this is a bad hash';

	public function setUp() {

		parent::setUp();

		$enc_value = new stdClass();
		$enc_value->columnList = array(
			'unitid',
			'unitnumber',
			'unitname',
			'parentunitid',
			'districtid',
			'regionid',
			'districtname',
			'regionname',
			'uniturl',
			'unitphonenumber',
			'unitfaxnumber',
			'unitemailaddress',
			'address1',
			'address2',
			'city',
			'state',
			'zipcode',
			'mailing_address1',
			'mailing_address2',
			'mailing_mailstop',
			'mailing_city',
			'mailing_state',
			'mailing_zipcode',
			'qCounties',
		);

		$first_county = new stdClass();
		$first_county->columnList = array(
			'isprimarycounty',
			'countyid',
			'countyname',
		);
		$first_county->data = array(
			0 => array(
				1,
				21,
				'Brazos',
			),
		);

		$second_county = new stdClass();
		$second_county->columnList = array(
			'isprimarycounty',
			'countyid',
			'countyname',
		);
		$second_county->data = array(
			0 => array(
				1,
				1,
				'Anderson',
			),
		);

		$enc_value->data = array(
			0 => array(
				310,
				890,
				'4-H and Youth Development',
				'',
				13,
				5,
				'Campus',
				'Campus/Military',
				'http://texas4-h.tamu.edu',
				'979.845.1211',
				'979.845.6495',
				'texas4h@ag.tamu.edu',
				'4180 State Highway 6',
				'',
				'College Station',
				'TX',
				'77845',
				'Texas A&M University',
				'2473 TAMU',
				2473,
				'College Station',
				'TX',
				'77843-2473',
				$first_county,
			),
			1 => array(
				1,
				1,
				'Anderson County Office',
				258,
				5,
				2,
				'East',
				'East Region',
				'http://anderson.agrilife.org',
				'903.723.3735',
				'903.723.2810',
				'anderson-tx@tamu.edu',
				'101 E. Oak St',
				'',
				'Palestine',
				'TX',
				'75801-2820',
				'','','','','','',
				$second_county,
			),
		);

		$result = new stdClass();
		$result->enc_type = 0;
		$result->enc_value = $enc_value;

		$this->successfulResponse = array(
			'ResultCode' => '200',
			'ResultMessages' => 'Success',
			'ResultQuery' => $result,
		);

		$this->failedResponse = array(
			'ResultCode' => '310',
			'ResultMessages' => 'Bad data',
			'ResultQuery' => '',
		);


	}

	public function test_BadHashThrowsException() {

		$this->setExpectedException( 'Exception', 'The hash provided was not encoded properly' );
		$client = $this->getMockFromWsdl( dirname(__FILE__) . '/ALP.wsdl' );
		$api = new AgriLife\Core\PeopleAPI( $client );
		$api->get_units( $this->badGetUnitsHash, 2 );

	}

	public function test_GoodResponseParses() {

		$client = $this->getMockFromWsdl( dirname(__FILE__) . '/ALP.wsdl' );
		$client->expects( $this->any() )
			->method('getUnits')
			->will( $this->returnValue( $this->successfulResponse ) );

		$api = new AgriLife\Core\PeopleAPI( $client );
		$units = $api->get_units( $this->getUnitsHash, '2' );

		foreach( $units as $key => $data ) {
			$data = $this->successfulResponse['ResultQuery']->enc_value->data[$key];
			$this->assertAttributeEquals( $data[0], 'id', $units[$key] );
			$this->assertAttributeEquals( $data[1], 'number', $units[$key] );
			$this->assertAttributeEquals( $data[2], 'name', $units[$key] );
			$this->assertAttributeEquals( $data[3], 'parentunitid', $units[$key] );
			$this->assertAttributeEquals( $data[4], 'districtid', $units[$key] );
			$this->assertAttributeEquals( $data[5], 'regionid', $units[$key] );
			$this->assertAttributeEquals( $data[6], 'districtname', $units[$key] );
			$this->assertAttributeEquals( $data[7], 'regionname', $units[$key] );
			$this->assertAttributeEquals( $data[8], 'url', $units[$key] );
			$this->assertAttributeEquals( $data[9], 'phone', $units[$key] );
			$this->assertAttributeEquals( $data[10], 'fax', $units[$key] );
			$this->assertAttributeEquals( $data[11], 'email', $units[$key] );
			$this->assertAttributeEquals( $data[12], 'address1', $units[$key] );
			$this->assertAttributeEquals( $data[13], 'address2', $units[$key] );
			$this->assertAttributeEquals( $data[14], 'city', $units[$key] );
			$this->assertAttributeEquals( $data[15], 'state', $units[$key] );
			$this->assertAttributeEquals( $data[16], 'zip', $units[$key] );
			$this->assertAttributeEquals( $data[17], 'mailingaddress1', $units[$key] );
			$this->assertAttributeEquals( $data[18], 'mailingaddress2', $units[$key] );
			$this->assertAttributeEquals( $data[19], 'mailstop', $units[$key] );
			$this->assertAttributeEquals( $data[20], 'mailingcity', $units[$key] );
			$this->assertAttributeEquals( $data[21], 'mailingstate', $units[$key] );
			$this->assertAttributeEquals( $data[22], 'mailingzip', $units[$key] );
			$this->assertAttributeEquals( $data[23]->data[0][2], 'county', $units[$key] );
		}

	}

	public function test_FailedResponseReturnsFalse() {

		$client = $this->getMockFromWsdl( dirname( __FILE__ ) . '/ALP.wsdl' );
		$client->expects( $this->any() )
			->method( 'getUnits' )
			->will( $this->returnValue( $this->failedResponse ) );

		$api = new AgriLife\Core\PeopleAPI( $client );
		$units = $api->get_units( $this->getUnitsHash, '2' );

		$this->assertFalse( $units );

	}

}