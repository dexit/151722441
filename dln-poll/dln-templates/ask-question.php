<?php //get_header( 'question' ); ?>

<div id="qa-page-wrapper">
    <div id="qa-content-wrapper">
    <?php do_action( 'dln_before_content', 'ask-question' ); ?>
    
    <?php //the_dln_menu(); ?>
    
    <div id="ask-question">
    <?php dln_question_form(); ?>
    </div>
    
    <?php do_action( 'dln_after_content', 'ask-question' ); ?>
    </div>
</div><!--#dln-page-wrapper-->

<?php get_footer( 'question' ); ?>

