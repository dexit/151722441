<?php
 
function dln_question_form() {
	echo get_dln_question_form();
}

function get_dln_question_form() {
	if ( is_dln_page( 'edit' ) ) {
		$question = $wp_query->posts[0];
		
		if( ! current_user_can( 'edit_question', $question->ID ) )
			return;
		
		$question->tags = wp_get_object_terms( $question->ID, 'dln_question_tag', array( 'fields' => 'names' ) );
		
		$args = apply_filters( 'dln_category_args', array( 'fields' => 'ids' ) );
		
		$cats = wp_get_object_terms( $question->ID, 'dln_question_category', $args );
		$question->cat = empty( $cats ) ? false : reset( $cats );
	} else {
		$question = (object) array(
			'ID' => '',
			'post_content' => '',
			'post_title' => '',
			'tags' => array(),
			'cat' => false
		);
	}
	
	$out = '';
	
	$out .= '<form id="question-form" method="post" action="' . dln_get_url( 'archive' ) . '">';
	$out .= wp_nonce_field( 'dln_edit', "_wpnonce", true, false );
	
	$out .= '<input type="hidden" name="dln_action" value="edit_question" />';
	$out .= '<input type="hidden" name="question_id" value="' . esc_attr( $question->ID ) . '" />';
	
	$out .= '<table id="question-form-table">';
	$out .=	'<tr>';
	$out .=	'<td id="question-title-label">';
	$out .= '<label for="question-title">' . __( 'Title:', DLN_SLUG ) . '</label>';
	$out .=	'</td>';
	$out .=	'<td id="question-title-td">';
	$out .= '<input type="text" id="question-title" name="question_title" value="' . esc_attr( $question->post_title ) . '" />';
	$out .=	'</td>
		</tr>
	</table>';
	
	$out .= '<textarea name="question_content" class="wp32">' .esc_textarea( $question->post_content ) . '</textarea>';
	
	$out .= '<table id="question-taxonomies">
		<tr>
			<td id="question-category-td">';
	$out .= wp_dropdown_categories( array(
			'orderby' => 'name',
			'order' => 'ASC',
			'taxonomy' => 'dln_question_category',
			'selected' => $question->cat,
			'hide_empty' => false,
			'hierarchical' => true,
			'name' => 'question_cat',
			'class' => '',
			'show_option_none' => __( 'Select category...', DLN_SLUG ),
			'echo'	=> 0
	) );
	$out .= '</td>
			<td id="question-tags-label">
				<label for="question-tags">' . __( 'Tags:', DLN_SLUG ) . '</label>
			</td>
			<td id="question-tags-td">
				<input type="text" id="question-tags" name="question_tags" value="'. implode( ', ', $question->tags ) . '" />
			</td>
		</tr>
	</table>';
	
	$out .= get_the_dln_submit_button();
	$out .= '</form>';
	
	return $out;
}

function get_the_dln_submit_button() {
	global $qa_general_settings;
	if ( is_user_logged_in() || dln_visitor_can( 'immediately_publish_questions' ) ) {
		$button = __( 'Submit', DLN_SLUG );
	} elseif ( get_option( 'users_can_register' ) ) {
		$button = __( 'Register/Login and Submit', DLN_SLUG );
	} else {
		$button = __( 'Login and Submit', DLN_SLUG );
	}

	return '<input class="dln-edit-submit" type="submit" value="'. $button . '" />';

}
