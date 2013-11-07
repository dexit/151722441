<?php if($need_header_footer):?>
<!--{subtemplate common/header}-->
<div class="container mt20">
	<!--{subtemplate pin/navmenu}-->
</div>
<?php endif;?>
<div id="waterfall_outer" data-fullscreen="0" class="container">
	<div class="span12 ml0" id="waterfall" data-pin-width="235" data-animated="0">
		<?php if($guide['show']):?>
		<!--{subtemplate pin/tags}-->
		<?php endif;?>
		<?php echo $tpl_waterfall; ?>
	</div>
</div>

<div class="container">
	<div id="loadingPins" class="span12 text_c"><img src="<?php echo base_url()?>themes/puzzing/img/puzzle32.gif"></div>
</div>
<div id="page-nav" class="mt20 container hide">
	<a id="page-next" href="<?php echo $nextpage_url; ?>"></a>
</div>
<div class="hide">
	<?php echo $pages;?>
</div>
<?php if($need_header_footer):?>
<!--{subtemplate common/footer}-->
<?php endif;?>