<?php get_header( 'question' ); ?>

<div id="qa-page-wrapper">
    <div id="qa-content-wrapper">
    <?php do_action( 'qa_before_content', 'ask-question' ); ?>
    
    <?php the_qa_menu(); ?>
    
    <div id="ask-question">
    <?php the_question_form(); ?>
    </div>
    
    <?php do_action( 'qa_after_content', 'ask-question' ); ?>
    </div>
</div><!--#qa-page-wrapper-->

<?php 
global $qa_general_settings;

if ( isset( $qa_general_settings["page_layout"] ) && $qa_general_settings["page_layout"] !='content' )	
	get_sidebar( 'question' ); 
?>

<?php get_footer( 'question' ); ?>

