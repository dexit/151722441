<?php
if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

class DLN_Helper_Google {
	
	private static $instance;
	
	public static function get_instance() {
		if( !self::$instance instanceof self ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	public function __construct() { }
	
	public function insert_google_map( $userId ) {
		$aItem  = Item::newInstance()->findByPrimaryKey($userId);
		
		$address = osc_sanitize_name( strip_tags( trim( Params::getParam('dln_address') ) ) );
		$lat     = strip_tags( trim( Params::getParam('dln_lat') ) );
		$long    = strip_tags( trim( Params::getParam('dln_long') ) );
		
		// Connect to google geolocation service for get country and city location
		$country = $city = '';
		if ( $lat && $long ) {
			try {
				$response  = file_get_contents( sprintf( 'https://maps.googleapis.com/maps/api/geocode/json?latlng=%s,%s&language=vi_VN', $lat, $long ) );
				$json_resp = json_decode( $response );
				$country_code = '';
					
				if ( isset( $json_resp->results[0]->address_components ) && is_array( $json_resp->results[0]->address_components ) ) {
					foreach ( $json_resp->results[0]->address_components as $i => $component ) {
						if ( ! empty( $component->types ) && in_array( 'country', $component->types ) ) {
							$country      = $component->long_name;
							$country_code = strtoupper( $component->short_name );
						}
						if ( ! empty( $component->types ) && in_array( 'administrative_area_level_1', $component->types ) ) {
							$city = $component->long_name;
						}
					}
				
					$country_id = $city_id = $region_id = '';
					if ( $country && $country_code ) {
						// Insert new country if not exists
						$mCountries = new Country();
						$exists     = $mCountries->findByCode( $country_code );
						if ( ! isset( $exists['s_name'] ) ) {
							$mCountries->insert( array(
									'pk_c_code' => $country_code,
									's_name'    => $country
							) );
							$country_id = $mCountries->dao->insertedId();
						} else {
							$country_id = isset( $exists['pk_c_code'] ) ? $exists['pk_c_code'] : '';
						}
						
						// Insert Un-register region
						$region_name = 'Undefined';
						$mRegion = new Region();
						$exists  = $mRegion->findByName( $region_name, $country_code );
						if ( ! isset( $exists['s_name'] ) ) {
							$data = array(
								'fk_c_country_code' => $country_code,
								's_name'            => $region_name
							);
							$mRegion->insert( $data );
							$region_id = $mRegion->dao->insertedId();
							RegionStats::newInstance()->setNumItems( $region_id, 0 );
						} else {
							$region_id = isset( $exists['pk_i_id'] ) ? $exists['pk_i_id'] : '';
						}
						
						if ( $city ) {
							// Insert new city if not exists
							$mCity     = new City();
							$exists    = $mCity->findByName( $city, $region_id );
							if ( ! isset( $exists['s_name'] ) ) {
								$mCity->insert( array(
									'fk_i_region_id'    => $region_id,
									's_name'            => $city,
									'fk_c_country_code' => $country_code
								) );
								$city_id = $mCity->dao->insertedId();
								CityStats::newInstance()->setNumItems( $city_id, 0 );
							} else {
								$city_id = isset( $exists['pk_i_id'] ) ? $exists['pk_i_id'] : '';
							}
						}
					}
				}
			} catch( Exception $e ) {
				var_dump( $e->getMessage() );die();
			}
			
		}
		
		User::newInstance()->update( array(
			's_address'    => $address,
			'd_coord_lat'  => $lat,
			'd_coord_long' => $long,
			's_country'    => $country,
			's_city'       => $city,
			'fk_i_region_id'    => $region_id,
			'fk_c_country_code' => $country_id,
			'fk_i_city_id'      => $city_id,
		), array( 'pk_i_id' => $userId ) );
		
		/*ItemLocation::newInstance()->update(
			array(
				's_address'    => $address,
				'd_coord_lat'  => $lat,
				'd_coord_long' => $long,
				's_country'    => $country,
				's_city'       => $city,
		), array( 'fk_i_item_id' => $itemId ) );*/
	}
	
	public function load_google_map() {
		DLN_Classified::get_view( 'field-google' );
	}
	
}