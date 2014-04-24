<?php
namespace AgriLife\Core;

/**
 * Class PeopleAPI
 * @package AgriLife\Core
 */
class PeopleAPI {

	/**
	 * @var \SoapClient
	 */
	private $client;

	/**
	 * @var string
	 */
	private $hash;

	/**
	 * @param \SoapClient $client
	 */
	public function __construct( \SoapClient $client ) {

		$this->set_client( $client );

	}

	/**
	 * Sets the hash
	 *
	 * @param string $hash
	 *
	 * @throws \Exception If the hash isn't a Base64-encoded string
	 */
	public function set_hash( $hash ) {

		if ( base64_encode( base64_decode( $hash ) ) != $hash ) {
			throw new \Exception( 'The hash provided was not encoded properly' );
		} else {
			$this->hash = $hash;
		}

	}

	/**
	 * Returns the hash
	 *
	 * @return string
	 */
	public function get_hash() {

		return $this->hash;

	}

	/**
	 * Sets the SoapClient object
	 *
	 * @param $client
	 */
	protected function set_client( $client ) {

		$this->client = $client;

	}

	/**
	 * Returns the SoapClient
	 *
	 * @return SoapClient
	 */
	public function get_client() {

		return $this->client;

	}

	/**
	 * Retrieves the units from the web service and sends them to the parser
	 * @param string $hash
	 * @param int $entity_id
	 *
	 * @return array|bool Array of unit objects of successful, false if unsuccessful
	 */
	public function get_units( $hash, $entity_id ) {

		$this->set_hash( $hash );

		$all_units = $this->client->getUnits( 3, $this->hash, null, $entity_id, null, null, null, null );

		if ( '200' != $all_units['ResultCode'] ) {
			// @todo Have a log message here
			return false;
		}

		$payload = $all_units['ResultQuery']->enc_value->data;

		$parsed = $this->parse_units( $payload );

		return $parsed;

	}

	/**
	 * Parses the terribly structured array of units from AgriLife People
	 *
	 * @param array $raw_units
	 *
	 * @return array Array of unit objects
	 */
	protected function parse_units( $raw_units ) {

		$parsed_units = array();

		foreach ( $raw_units as $u ) {
			$unit = new \stdClass();
			$unit->id = $u[0];
			$unit->number = $u[1];
			$unit->name = $u[2];
			$unit->parentunitid = $u[3];
			$unit->districtid = $u[4];
			$unit->regionid = $u[5];
			$unit->districtname = $u[6];
			$unit->regionname = $u[7];
			$unit->url = $u[8];
			$unit->phone = $u[9];
			$unit->fax = $u[10];
			$unit->email = $u[11];
			$unit->address1 = $u[12];
			$unit->address2 = $u[13];
			$unit->city = $u[14];
			$unit->state = $u[15];
			$unit->zip = $u[16];
			$unit->mailingaddress1 = $u[17];
			$unit->mailingaddress2 = $u[18];
			$unit->mailstop = $u[19];
			$unit->mailingcity = $u[20];
			$unit->mailingstate = $u[21];
			$unit->mailingzip = $u[22];

			// Some units don't have county data
			$county_data = $u[23]->data;
			if ( array_key_exists( 0, $county_data ) ) {
				$unit->county = $county_data[0][2];
			} else {
				$unit->county = null;
			}

			array_push( $parsed_units, $unit );
		}

		return $parsed_units;

	}

}