<?php

if ( ! defined( 'WPINC' ) ) { die; }

class DLN_Facebook_Helper {	
	
	public static function recursive_facebook_object( $name, $objects, &$result ) {
		if ( is_object( $objects ) ) {
			foreach ( $objects as $key => $value ) {
				self::recursive_facebook_object( $name . '_' . $key, $value, $result );
			}
		} else {
			$result[$name] = $objects;
		}
	}
	
	public static function update_fb_meta( $user_id, $works, $fbuid, $sub_name = '' ) {
		if ( $user_id ) {
			$arr_work_meta = array();
			if ( is_array( $works ) ) {
				foreach ( $works as $i => $work ) {
					$name = $fbuid . '_' . $sub_name . '_' . $i;
					self::recursive_facebook_object( $name, $work, $arr_work_meta );
				}
			} else {
				$name = $fbuid . '_' . $sub_name;
				self::recursive_facebook_object( $name, $works, $arr_work_meta );
			}
			
			foreach ( $arr_work_meta as $key => $value ) {
				update_user_meta( $user_id, $key, $value );
			}
		}
	}
	
	public static function update_fb_all_meta( $uid, $arr_data, $fb_uid ) {
		self::update_fb_meta( $uid, $arr_data->works, $fb_uid, 'work' );
		self::update_fb_meta( $uid, $arr_data->educations, $fb_uid, 'education' );
		self::update_fb_meta( $uid, $arr_data->location, $fb_uid, 'location' );
		self::update_fb_meta( $uid, $arr_data->hometown, $fb_uid, 'hometown' );
		self::update_fb_meta( $uid, $arr_data->birthday, $fb_uid, 'birthday' );
		self::update_fb_meta( $uid, $arr_data->bio, $fb_uid, 'bio' );
	}
	
}