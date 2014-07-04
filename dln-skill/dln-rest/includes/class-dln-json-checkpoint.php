<?php

class DLN_JSON_CheckPoint {
	
	protected $servers;
	
	public function __construct( WP_JSON_ResponseHandler $server ) {
		header("Access-Control-Allow-Origin: *");
		$this->server = $server;
	}
	
	public function register_routes( $routes ) {
		$user_routes = array(
			'/check-point' => array(
				array( array( $this, 'get_check_points' ), WP_JSON_Server::READABLE ),
				array( array( $this, 'new_check_point' ), WP_JSON_Server::CREATABLE | WP_JSON_Server::ACCEPT_JSON ),
			),
			
			'/check-point/(?P<id>\d+)' => array(
				array( array( $this, 'get_check_point' ), WP_JSON_Server::READABLE )
			)
		);
		
		return array_merge( $routes, $user_routes );
	}
	
	function new_check_point( $data ) {
		if ( ! $data ) return;
		unset( $data['id'] );
		
		$result = $this->insert_check_point( $data );
		if ( $result instanceof WP_Error ) {
			return $result;
		}
		
		$response = json_ensure_response( $this->get_check_point( $result ) );
		$response->set_status( 201 );
		$response->header( 'Location', json_url( '/check_point/' . $result ) );
		return $response;
	}
	
	function insert_check_point( $data ) {
		if ( ! $data ) return;
		$post   = array();
		$update = ! empty( $data['id'] );

		if ( $update ) {
			$current_check_point = get_post( absint( $data['id'] ) );
			if ( ! $current_check_point ) {
				return new WP_Error( 'json_check_point_invalid_id', __( 'Invalid check point ID' ), array( 'status' => 400 ) );
			}
			$post['ID'] = absint( $data['id'] );	
		} else {
			// Defaults
			$post['post_author'] = 0;
			$post['post_password'] = '';
			$post['post_excerpt'] = '';
			$post['post_content'] = '';
			$post['post_title'] = '';
		}
		
		// Post type
		if ( ! empty( $data['type'] ) ) {
			// Changing post type
			$post_type = get_post_type_object( $data['type'] );
			if ( ! $post_type )
				return new WP_Error( 'json_invalid_post_type', __( 'Invalid post type' ), array( 'status' => 400 ) );
		
			$post['post_type'] = $data['type'];
		}
		elseif ( $update ) {
			// Updating post, use existing post type
			$current_post = get_post( $data['id'] );
			if ( ! $current_post )
				return new WP_Error( 'json_post_invalid_id', __( 'Invalid post ID.' ), array( 'status' => 400 ) );
		
			$post_type = get_post_type_object( $current_post->post_type );
		}
		else {
			// Creating new post, use default type
			$post['post_type'] = apply_filters( 'json_insert_default_post_type', 'post' );
			$post_type = get_post_type_object( $post['post_type'] );
			if ( ! $post_type )
				return new WP_Error( 'json_invalid_post_type', __( 'Invalid post type' ), array( 'status' => 400 ) );
		}
		
		// Post status
		if ( ! empty( $data['status'] ) ) {
			$post['post_status'] = $data['status'];
			switch ( $post['post_status'] ) {
				case 'draft':
				case 'pending':
					break;
				case 'private':
					//if ( ! current_user_can( $post_type->cap->publish_posts ) )
						//return new WP_Error( 'json_cannot_create_private', __( 'Sorry, you are not allowed to create private posts in this post type' ), array( 'status' => 403 ) );
					break;
				case 'publish':
				case 'future':
					//if ( ! current_user_can( $post_type->cap->publish_posts ) )
						//return new WP_Error( 'json_cannot_publish', __( 'Sorry, you are not allowed to publish posts in this post type' ), array( 'status' => 403 ) );
					break;
				default:
					if ( ! get_post_status_object( $post['post_status'] ) )
						$post['post_status'] = 'draft';
					break;
			}
		}
		
		// Post title
		if ( ! empty( $data['title'] ) ) {
			$post['post_title'] = $data['title'];
		}
		
		// Post date
		if ( ! empty( $data['date'] ) ) {
			$date_data = $this->server->get_date_with_gmt( $data['date'] );
			if ( ! empty( $date_data ) ) {
				list( $post['post_date'], $post['post_date_gmt'] ) = $date_data;
			}
		}
		elseif ( ! empty( $data['date_gmt'] ) ) {
			$date_data = $this->server->get_date_with_gmt( $data['date_gmt'], true );
			if ( ! empty( $date_data ) ) {
				list( $post['post_date'], $post['post_date_gmt'] ) = $date_data;
			}
		}
		
		// Post modified
		if ( ! empty( $data['modified'] ) ) {
			$date_data = $this->server->get_date_with_gmt( $data['modified'] );
			if ( ! empty( $date_data ) ) {
				list( $post['post_modified'], $post['post_modified_gmt'] ) = $date_data;
			}
		}
		elseif ( ! empty( $data['modified_gmt'] ) ) {
			$date_data = $this->server->get_date_with_gmt( $data['modified_gmt'], true );
			if ( ! empty( $date_data ) ) {
				list( $post['post_modified'], $post['post_modified_gmt'] ) = $date_data;
			}
		}
		
		// Post slug
		if ( ! empty( $data['name'] ) ) {
			$post['post_name'] = $data['name'];
		}
		
		// Author
		if ( ! empty( $data['author'] ) ) {
			// Allow passing an author object
			if ( is_object( $data['author'] ) ) {
				if ( empty( $data['author']->ID ) ) {
					return new WP_Error( 'json_invalid_author', __( 'Invalid author object.' ), array( 'status' => 400 ) );
				}
				$data['author'] = absint( $data['author']->ID );
			}
			else {
				$data['author'] = absint( $data['author'] );
			}
		
			// Only check edit others' posts if we are another user
			//if ( $data['author'] !== get_current_user_id() ) {
				//if ( ! current_user_can( $post_type->cap->edit_others_posts ) )
				//	return new WP_Error( 'json_cannot_edit_others', __( 'You are not allowed to edit posts as this user.' ), array( 'status' => 401 ) );
		
				$author = get_userdata( $data['author'] );
		
				if ( ! $author )
					return new WP_Error( 'json_invalid_author', __( 'Invalid author ID.' ), array( 'status' => 400 ) );
			//}
		
			$post['post_author'] = $data['author'];
		}
		
		// Post password
		//if ( ! empty( $data['password'] ) ) {
		//	$post['post_password'] = $data['password'];
		//	if ( ! current_user_can( $post_type->cap->publish_posts ) )
		//		return new WP_Error( 'json_cannot_create_passworded', __( 'Sorry, you are not allowed to create password protected posts in this post type' ), array( 'status' => 401 ) );
		//}
		
		// Content and excerpt
		//if ( ! empty( $data['content_raw'] ) ) {
		//	$post['post_content'] = $data['content_raw'];
		//}
		//if ( ! empty( $data['excerpt_raw'] ) ) {
		//	$post['post_excerpt'] = $data['excerpt_raw'];
		//}
		
		// Parent
		//if ( ! empty( $data['parent'] ) ) {
		//	$parent = get_post( $data['parent'] );
		//	$post['post_parent'] = $data['post_parent'];
		//}
		
		// Menu order
		//if ( ! empty( $data['menu_order'] ) ) {
		//	$post['menu_order'] = $data['menu_order'];
		//}
		
		// Comment status
		//if ( ! empty( $data['comment_status'] ) ) {
		//	$post['comment_status'] = $data['comment_status'];
		//}
		
		// Ping status
		//if ( ! empty( $data['ping_status'] ) ) {
		//	$post['ping_status'] = $data['ping_status'];
		//}
		
		// Post format
		if ( ! empty( $data['post_format'] ) ) {
			$formats = get_post_format_slugs();
			if ( ! in_array( $data['post_format'], $formats ) ) {
				return new WP_Error( 'json_invalid_post_format', __( 'Invalid post format.' ), array( 'status' => 400 ) );
			}
			$post['post_format'] = $data['post_format'];
		}
		
		// Pre-insert hook
		$can_insert = apply_filters( 'json_pre_insert_post', true, $post, $data, $update );
		if ( is_wp_error( $can_insert ) ) {
			return $can_insert;
		}
		
		// Post meta
		// TODO: implement this
		$post_ID = $update ? wp_update_post( $post, true ) : wp_insert_post( $post, true );
		
		if ( is_wp_error( $post_ID ) ) {
			return $post_ID;
		}
		
		// If this is a new post, add the post ID to $post
		if ( ! $update ) {
			$post['ID'] = $post_ID;
		}
		
		// Post meta
		if ( ! empty( $data['post_meta'] ) ) {
			$result = $this->handle_post_meta_action( $post_ID, $data['post_meta'] );
			if ( is_wp_error( $result ) ) {
				return $result;
			}
		}
		
		// Sticky
		if ( isset( $post['sticky'] ) )  {
			if ( $post['sticky'] )
				stick_post( $data['ID'] );
			else
				unstick_post( $data['ID'] );
		}
		
		do_action( 'json_insert_post', $post, $data, $update );
		
		return $post_ID;
	}
	
	function get_check_points( $filter = array(), $context = 'view', $type = 'post', $page = 1 ) {
		$query = array();
		
		// Validate post types and permissions
		$query['post_type'] = array();
		foreach ( (array) $type as $type_name ) {
			$post_type = get_post_type_object( $type_name );
			if ( ! ( (bool) $post_type ) || ! $post_type->show_in_json )
				return new WP_Error( 'json_invalid_post_type', sprintf( __( 'The post type "%s" is not valid' ), $type_name ), array( 'status' => 403 ) );
		
			$query['post_type'][] = $post_type->name;
		}
		
		global $wp;
		// Allow the same as normal WP
		$valid_vars = apply_filters('query_vars', $wp->public_query_vars);
		
		// Define our own in addition to WP's normal vars
		$json_valid = array('posts_per_page');
		$valid_vars = array_merge($valid_vars, $json_valid);
		
		// Filter and flip for querying
		$valid_vars = apply_filters('json_query_vars', $valid_vars);
		$valid_vars = array_flip($valid_vars);
		
		// Exclude the post_type query var to avoid dodging the permission
		// check above
		unset($valid_vars['post_type']);
		
		foreach ($valid_vars as $var => $index) {
			if ( isset( $filter[ $var ] ) ) {
				$query[ $var ] = apply_filters( 'json_query_var-' . $var, $filter[ $var ] );
			}
		}
		
		// Special parameter handling
		$query['paged'] = absint( $page );
		
		$post_query = new WP_Query();
		$posts_list = $post_query->query( $query );
		$response = new WP_JSON_Response();
		$response->query_navigation_headers( $post_query );
		
		if ( ! $posts_list ) {
			$response->set_data( array() );
			return $response;
		}
		
		// holds all the posts data
		$struct = array();
		
		$response->header( 'Last-Modified', mysql2date( 'D, d M Y H:i:s', get_lastpostmodified( 'GMT' ), 0 ).' GMT' );
		
		foreach ( $posts_list as $post ) {
			$post = get_object_vars( $post );
		
			// Do we have permission to read this post?
			//if ( ! $this->check_read_permission( $post ) )
			//	continue;
		
			$response->link_header( 'item', json_url( '/posts/' . $post['ID'] ), array( 'title' => $post['post_title'] ) );
			$struct[] = $this->prepare_post( $post, $context );
		}
		$response->set_data( $struct );
		
		return $response;
	}

	protected function handle_post_meta_action( $post_id, $data ) {
		foreach ( $data as $meta_array ) {
			if ( empty( $meta_array['ID'] ) ) {
				// Creation
				$result = $this->add_meta( $post_id, $meta_array );
			}
			else {
				// Update
				$result = $this->update_meta( $post_id, $meta_array['ID'], $meta_array );
			}
	
			if ( is_wp_error( $result ) ) {
				return $result;
			}
		}
	
		return true;
	}
	
	public function add_meta( $id, $data ) {
		$id = (int) $id;
	
		if ( empty( $id ) ) {
			return new WP_Error( 'json_post_invalid_id', __( 'Invalid post ID.' ), array( 'status' => 404 ) );
		}
	
		$post = get_post( $id, ARRAY_A );
		if ( empty( $post['ID'] ) ) {
			return new WP_Error( 'json_post_invalid_id', __( 'Invalid post ID.' ), array( 'status' => 404 ) );
		}
	
		if ( ! $this->check_edit_permission( $post ) ) {
			return new WP_Error( 'json_cannot_edit', __( 'Sorry, you cannot edit this post' ), array( 'status' => 403 ) );
		}
	
		if ( ! array_key_exists( 'key', $data ) ) {
			return new WP_Error( 'json_post_missing_key', __( 'Missing meta key.' ), array( 'status' => 400 ) );
		}
		if ( ! array_key_exists( 'value', $data ) ) {
			return new WP_Error( 'json_post_missing_value', __( 'Missing meta value.' ), array( 'status' => 400 ) );
		}
	
		if ( empty( $data['key'] ) ) {
			return new WP_Error( 'json_meta_invalid_key', __( 'Invalid meta key.' ), array( 'status' => 400 ) );
		}
	
		if ( ! $this->is_valid_meta_data( $data['value'] ) ) {
			// for now let's not allow updating of arrays, objects or serialized values.
			return new WP_Error( 'json_post_invalid_action', __( 'Invalid provided meta data for action.' ), array( 'status' => 400 ) );
		}
		if ( is_protected_meta( $data['key'] ) ) {
			return new WP_Error( 'json_meta_protected', sprintf( __( '%s is marked as a protected field.'), $data['key'] ), array( 'status' => 403 ) );
		}
	
		$meta_key = wp_slash( $data['key'] );
		$value = wp_slash( $data['value'] );
	
		$result = add_post_meta( $id, $meta_key, $value );
		if ( ! $result ) {
			return new WP_Error( 'json_meta_could_not_add', __( 'Could not add post meta.' ), array( 'status' => 400 ) );
		}
	
		$response = json_ensure_response( $this->get_meta( $id, $result ) );
		if ( is_wp_error( $response ) ) {
			return $response;
		}
		$response->set_status( 201 );
		$response->header( 'Location', json_url( '/posts/' . $id . '/meta/' . $result ) );
		return $response;
	}
	
	public function get_check_point( $id, $context = 'view' ) {
		$id = (int) $id;
	
		if ( empty( $id ) )
			return new WP_Error( 'json_post_invalid_id', __( 'Invalid post ID.' ), array( 'status' => 404 ) );
	
		$post = get_post( $id, ARRAY_A );
	
		if ( empty( $post['ID'] ) )
			return new WP_Error( 'json_post_invalid_id', __( 'Invalid post ID.' ), array( 'status' => 404 ) );
	
		//if ( ! $this->check_read_permission( $post ) )
			//return new WP_Error( 'json_user_cannot_read', __( 'Sorry, you cannot read this post.' ), array( 'status' => 401 ) );
	
		// Link headers (see RFC 5988)
	
		$response = new WP_JSON_Response();
		$response->header( 'Last-Modified', mysql2date( 'D, d M Y H:i:s', $post['post_modified_gmt'] ) . 'GMT' );
	
		$post = $this->prepare_post( $post, $context );
		if ( is_wp_error( $post ) )
			return $post;
	
		foreach ( $post['meta']['links'] as $rel => $url ) {
			$response->link_header( $rel, $url );
		}
		$response->link_header( 'alternate',  get_permalink( $id ), array( 'type' => 'text/html' ) );
	
		$response->set_data( $post );
		return $response;
	}
	
	protected function prepare_post( $post, $context = 'view' ) {
		// holds the data for this post. built up based on $fields
		$_post = array(
			'ID' => (int) $post['ID'],
		);
	
		$post_type = get_post_type_object( $post['post_type'] );
		//if ( ! $this->check_read_permission( $post ) )
			//return new WP_Error( 'json_user_cannot_read', __( 'Sorry, you cannot read this post.' ), array( 'status' => 401 ) );
	
		// prepare common post fields
		$post_fields = array(
			'title'        => get_the_title( $post['ID'] ), // $post['post_title'],
			'status'       => $post['post_status'],
			'type'         => $post['post_type'],
			'author'       => (int) $post['post_author'],
			'content'      => apply_filters( 'the_content', $post['post_content'] ),
			'parent'       => (int) $post['post_parent'],
			#'post_mime_type'    => $post['post_mime_type'],
			'link'          => get_permalink( $post['ID'] ),
		);
		$post_fields_extended = array(
			'slug'           => $post['post_name'],
			'guid'           => apply_filters( 'get_the_guid', $post['guid'] ),
			'excerpt'        => $this->prepare_excerpt( $post['post_excerpt'] ),
			'menu_order'     => (int) $post['menu_order'],
			'comment_status' => $post['comment_status'],
			'ping_status'    => $post['ping_status'],
			'sticky'         => ( $post['post_type'] === 'post' && is_sticky( $post['ID'] ) ),
		);
		$post_fields_raw = array(
			'title_raw'   => $post['post_title'],
			'content_raw' => $post['post_content'],
			'guid_raw'    => $post['guid'],
			'post_meta'   => $this->get_all_meta( $post['ID'] ),
		);
	
		// Dates
		$timezone = $this->server->get_timezone();
	
		$date = WP_JSON_DateTime::createFromFormat( 'Y-m-d H:i:s', $post['post_date'], $timezone );
		$post_fields['date'] = $date->format( 'c' );
		$post_fields_extended['date_tz'] = $date->format( 'e' );
		$post_fields_extended['date_gmt'] = date( 'c', strtotime( $post['post_date_gmt'] ) );
	
		$modified = WP_JSON_DateTime::createFromFormat( 'Y-m-d H:i:s', $post['post_modified'], $timezone );
		$post_fields['modified'] = $modified->format( 'c' );
		$post_fields_extended['modified_tz'] = $modified->format( 'e' );
		$post_fields_extended['modified_gmt'] = date( 'c', strtotime( $post['post_modified_gmt'] ) );
	
		// Authorized fields
		// TODO: Send `Vary: Authorization` to clarify that the data can be
		// changed by the user's auth status
		//if ( current_user_can( $post_type->cap->edit_post, $post['ID'] ) ) {
		//	$post_fields_extended['password'] = $post['post_password'];
		//}
	
		// Consider future posts as published
		if ( $post_fields['status'] === 'future' )
			$post_fields['status'] = 'publish';
	
		// Fill in blank post format
		$post_fields['format'] = get_post_format( $post['ID'] );
		if ( empty( $post_fields['format'] ) )
			$post_fields['format'] = 'standard';
	
		if ( ( 'view' === $context || 'view-revision' == $context ) && 0 !== $post['post_parent'] ) {
			// Avoid nesting too deeply
			// This gives post + post-extended + meta for the main post,
			// post + meta for the parent and just meta for the grandparent
			$parent = get_post( $post['post_parent'], ARRAY_A );
			$post_fields['parent'] = $this->prepare_post( $parent, 'embed' );
		}
	
		// Merge requested $post_fields fields into $_post
		$_post = array_merge( $_post, $post_fields );
	
		// Include extended fields. We might come back to this.
		$_post = array_merge( $_post, $post_fields_extended );
	
		if ( 'edit' === $context ) {
			//if ( current_user_can( $post_type->cap->edit_post, $post['ID'] ) ) {
				if ( is_wp_error( $post_fields_raw['post_meta'] ) ) {
					return $post_fields_raw['post_meta'];
				}
	
				$_post = array_merge( $_post, $post_fields_raw );
			//} else {
			//	return new WP_Error( 'json_cannot_edit', __( 'Sorry, you cannot edit this post' ), array( 'status' => 403 ) );
			//}
		} elseif ( 'view-revision' == $context ) {
			//if ( current_user_can( $post_type->cap->edit_post, $post['ID'] ) ) {
				$_post = array_merge( $_post, $post_fields_raw );
			//} else {
			//	return new WP_Error( 'json_cannot_view', __( 'Sorry, you cannot view this revision' ), array( 'status' => 403 ) );
			//}
		}
	
		// Entity meta
		$links = array(
			'self'            => json_url( '/posts/' . $post['ID'] ),
			'author'          => json_url( '/users/' . $post['post_author'] ),
			'collection'      => json_url( '/posts' ),
		);
	
		if ( 'view-revision' != $context ) {
			$links['replies'] = json_url( '/posts/' . $post['ID'] . '/comments' );
			$links['version-history'] = json_url( '/posts/' . $post['ID'] . '/revisions' );
		}
	
		$_post['meta'] = array( 'links' => $links );
	
		if ( ! empty( $post['post_parent'] ) )
			$_post['meta']['links']['up'] = json_url( '/posts/' . (int) $post['post_parent'] );
	
		return apply_filters( 'json_prepare_post', $_post, $post, $context );
	}
	
	public function get_all_meta( $id ) {
		$id = (int) $id;
	
		if ( empty( $id ) ) {
			return new WP_Error( 'json_post_invalid_id', __( 'Invalid post ID.' ), array( 'status' => 404 ) );
		}
	
		$post = get_post( $id, ARRAY_A );
	
		if ( empty( $post['ID'] ) ) {
			return new WP_Error( 'json_post_invalid_id', __( 'Invalid post ID.' ), array( 'status' => 404 ) );
		}
	
		//if ( ! $this->check_edit_permission( $post ) ) {
		//	return new WP_Error( 'json_cannot_edit', __( 'Sorry, you cannot edit this post' ), array( 'status' => 403 ) );
		//}
	
		global $wpdb;
		$table = _get_meta_table( 'post' );
		$results = $wpdb->get_results( $wpdb->prepare( "SELECT meta_id, meta_key, meta_value FROM $table WHERE post_id = %d", $id ) );
	
		$meta = array();
	
		foreach ( $results as $row ) {
			$value = $this->prepare_meta( $id, $row, true );
	
			if ( is_wp_error( $value ) ) {
				continue;
			}
	
			$meta[] = $value;
		}
	
		return apply_filters( 'json_prepare_meta', $meta, $id );
	}
	
	protected function prepare_meta( $post, $data, $is_raw = false ) {
		$ID    = $data->meta_id;
		$key   = $data->meta_key;
		$value = $data->meta_value;
	
		// Don't expose protected fields.
		if ( is_protected_meta( $key ) ) {
			return new WP_Error( 'json_meta_protected', sprintf( __( '%s is marked as a protected field.'), $key ), array( 'status' => 403 ) );
		}
	
		// Normalize serialized strings
		if ( $is_raw && is_serialized_string( $value ) ) {
			$value = unserialize( $value );
		}
	
		// Don't expose serialized data
		if ( is_serialized( $value ) || ! is_string( $value ) ) {
			return new WP_Error( 'json_meta_protected', sprintf( __( '%s contains serialized data.'), $key ), array( 'status' => 403 ) );
		}
	
		$meta = array(
			'ID'    => (int) $ID,
			'key'   => $key,
			'value' => $value,
		);
	
		return apply_filters( 'json_prepare_meta_value', $meta, $post );
	}
	
	protected function prepare_excerpt( $excerpt ) {
		if ( post_password_required() ) {
			return __( 'There is no excerpt because this is a protected post.' );
		}
	
		$excerpt = apply_filters( 'the_excerpt', apply_filters( 'get_the_excerpt', $excerpt ) );
	
		if ( empty( $excerpt ) ) {
			return null;
		}
	
		return $excerpt;
	}
}
