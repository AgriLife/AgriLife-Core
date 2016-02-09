<?php
namespace AgriLife\Core;

/**
 * Class PeopleAPI
 * @package AgriLife\Core
 */
class PeopleAPI {

	/**
	 * @var string
	 */
	private $hash;

	/**
	* Request API Data
	*
	* @param string $method
	* @param array $data
	*/
	protected function make_people_api_call( $method, $data ){

	  $url = 'https://agrilifepeople.tamu.edu/api/';

	  switch ($method){
	    
	    case "units" :
	      $data = array_merge( array(
	        'limit_to_active' =>  0,
	        'entity_id' => null,
	        'parent_unit_id' => null,
	        'search_string' => null,
	        'limited_units' => null,
	        'exclude_units' => null,
	      ), $data );
	      break;
	      
	    case "people" :
	      $data = array_merge( array(
	        'person_active_status' => null,
	        'restrict_to_public_only' => 1,
	        'search_specializations' => null,
	        'limited_units' => null,
	        'limited_entity' => null,
	        'limited_personnel' => null,
	        'limited_roles' => null,
	        'include_directory_profile' => 0,
	        'include_specializations' => 1,
	      ), $data );
	      break;
	      
	    default: 
	      exit("$function is not defined in the switch statement");
	  }

	  $url .= $method;

	  if (!empty($data))
	    $url = sprintf("%s?%s", $url, http_build_query($data));
	  
	  $curl = curl_init();
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	  curl_setopt($curl, CURLOPT_URL, $url);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  
	  $curl_response = curl_exec($curl);
	  if ($curl_response === false) {
	    $info = curl_getinfo($curl);
	    curl_close($curl);
	    
	    echo "<pre>Error occurred during curl exec.<br/>Additional info:<br/>";
	    echo "Curl Response:<br/>";
	    print_r($curl_response);
	    echo "Info:<br/>";
	    print_r($info);
	    die('</pre>');
	  }
	  
	  $response = array(
	    'url' => $url,
	    'json' => json_decode($curl_response, true),
	    'raw' => $curl_response,
	  );
	  
	  curl_close($curl);
	  
	  return $response;
	}

	/**
	 * Sets the hash
	 *
	 * @param string $hash
	 *
	 * @throws \Exception If the hash isn't a Base64-encoded string
	 */
	protected function set_hash( $hash ) {

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
	 * Retrieves the units from the web service and sends them to the parser
	 * @param string $hash
	 * @param int $entity_id
	 *
	 * @return array|bool Array of unit objects of successful, false if unsuccessful
	 */
	public function get_units( $hash, $entity_id ) {

		$this->set_hash( $hash );

		$data = array(
			'validation_key' => $hash,
			'site_id' => 3,
			'limited_units' => implode( ',', $entity_id ),
		);

		$apidata = $this->make_people_api_call( 'units', $data );
		$results = $apidata['json'];

		if ( $results['status'] == 200 ) {

			$payload = $results['units'];

			$parsed = $this->parse_units( $payload );

			return $parsed;

		} else {

			// @todo Have a log message here
			return false;

		}

	}

	public function get_people( $hash, $unitIDs ) {

		$this->set_hash( $hash );

		$data = array(
			'validation_key' => $hash,
			'site_id' => 3,
			'limited_units' => implode( ',', $unitIDs ),
		);

		$apidata = $this->make_people_api_call( 'people', $data );
		$results = $apidata['json'];

		if ( $results['status'] == 200 ) {

			$payload = $results['people'];
			$parsed = $this->parse_people( $payload );
			return $parsed;

		} else {

			return false;

		}

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
			$unit->id = $u['unit_id'];
			$unit->name = $u['unit_name'];
			$unit->parentunitid = $u['parent_unit_name'];
			$unit->districtid = $u['extension'][0]['district_id'];
			$unit->regionid = $u['extension'][0]['region_id'];
			$unit->districtname = $u['extension'][0]['district_name'];
			$unit->regionname = $u['extension'][0]['region_name'];
			$unit->url = $u['website'];
			$unit->phone = $u['phone_number'];
			$unit->fax = $u['fax_number'];
			$unit->email = $u['email_address'];
			$unit->address1 = $u['physical_address_1'];
			$unit->address2 = $u['physical_address_2'];
			$unit->city = $u['physical_address_city'];
			$unit->state = $u['physical_address_state'];
			$unit->zip = $u['physical_address_postal_code'];
			$unit->mailingaddress1 = $u['mailing_address_1'];
			$unit->mailingaddress2 = $u['mailing_address_2'];
			$unit->mailstop = $u['mailstop'];
			$unit->mailingcity = $u['mailing_address_city'];
			$unit->mailingstate = $u['mailing_address_state'];
			$unit->mailingzip = $u['mailing_address_postal_code'];

			// Some units don't have county data
			$county_data = $u['counties'][0];
			if ( array_key_exists( 'county_name', $county_data ) ) {
				$unit->county = $county_data[0]['county_name'];
			} else {
				$unit->county = null;
			}

			array_push( $parsed_units, $unit );
		}

		return $parsed_units;

	}

	protected function parse_people( $raw_people ) {

		$parsed_people = array();

		foreach ( $raw_people as $p ) {
			$person = new \stdClass();

			$person->firstname = $p['first_name'];
			$person->middleinitial = $p['middle_initial'];
			$person->lastname = $p['last_name'];
			$person->preferredname = $p['preferred_name'];
			$person->emailaddress = $p['email_address'];
			$person->website = $p['directory_profile'][0]['_links'][0]['website'];
			$person->picture = $p['directory_profile'][0]['_links'][0]['picture'];
			$person->cv = $p['directory_profile'][0]['_links'][0]['link_cv'];
			$person->specializations = $this->parse_specializations( $p['specializations'] );
			$person->profile = $p['directory_profle'][0]['_links'][0]['website'];
			$person->links = $p['directory_profle'][0]['_links'];
			$person->department = $p['positions'][0]['unit_name'];
			$person->title = $p['positions'][0]['position_title'];

			array_push( $parsed_people, $person );
		}

		return $parsed_people;

	}

	protected function parse_specializations( $data ) {

		if ( empty( $data ) ) {
			return false;
		}

		$parsed = array();
		foreach ( $data as $s ) {
			array_push( $parsed, strtolower($s) );
		}

		return $parsed;

	}

}