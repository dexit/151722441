<?php

/**
 * Check current page is dln page
 * 
 * @param string $type
 */
function is_dln_page( $type = '' ) {
	static $flags;
	
	if ( ! $flags ) {
		$flags = array(
			'ask'        => (bool) get_query_var( 'dln_ask' ),
			'unanswered' => (bool) get_query_var( 'dln_unanswered' ),
			'edit'       => (bool) get_query_var( 'dln_edit' ),
			'user'       => 'dln_question' == get_query_var( 'post_type' ) && get_query_var( 'author_name' ),
			'single'     => is_singular( 'dln_question' ),
			'archive'    => is_post_type_archive( 'dln_question' ),
			'tag'        => is_tax( 'dln_question_tag' ),
			'category'   => is_tax( 'dln_question_category' )
		);
	}
	
	if ( empty( $type ) ) {
		$result = in_array( true, $flags );
	} else {
		$result = isset( $flags[ $type ] ) && $flags[ $type ];
	}
	
	return apply_filters( 'is_dln_page', $result, $type );
}

/**
 * Get the URL to a certain type of question page
 *
 * @param string $type The type of URL
 * @param int (optional) $id A question or tag id, depending on the type
 * @return string
 */
function dln_get_url( $type, $id = 0 ) {
	$base = get_post_type_archive_link( 'dln_question' );

	switch ( $type ) {
		case 'ask':
			$result = trailingslashit( $base ) . user_trailingslashit( DLN_SLUG_ASK );
			break;
		case 'unanswered':
			$result = trailingslashit( $base ) . user_trailingslashit( DLN_SLUG_UNANSWERED );
			break;
		case 'edit':
			$post = get_post( $id );
			if ( $post ) {
				$result = trailingslashit( $base ) . user_trailingslashit( DLN_SLUG_EDIT . '/' . $post->ID );
			}
			break;
		case 'delete':
			$post = get_post( $id );
			if ( $post ) {
				$result = add_query_arg( array(
					'dln_delete' => $post->ID,
					'_wpnonce' => wp_create_nonce( 'dln_delete' )
				), $base );
			}
			break;
		case 'user':
			if ( !$id ) {
				$id = get_current_user_id();
			}
			$user = get_userdata( $id );
			if ( $user ) {
				if ( defined( 'BP_VERSION' ) ) {

				}
				$result = trailingslashit( $base ) . user_trailingslashit( DLN_SLUG_USER . '/' . $user->user_nicename );
			}
			break;
		case 'single':
			$result = get_permalink( $id );
			break;
		case 'archive':
			$result = get_post_type_archive_link( 'dln_question' );
			break;
		case 'tag':
			$result = get_term_link( $id, 'dln_question_tag' );
			break;
		case 'category':
			$result = get_term_link( $id, 'dln_question_category' );
			break;
		default:
			return '';
	}

	return apply_filters( 'dln_get_url', $result, $type, $id );
}
