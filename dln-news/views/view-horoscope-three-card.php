<?php
if ( ! defined( 'WPINC' ) ) { die; }
?>
<script type="text/javascript">
(function ($) {
	$(document).on('ready', function () {

		//if ( typeof( $.fn.baraja ) == )
		var elm    = $('#dln_cards'),
			baraja = elm.baraja();


		$( '#dln_cards li' ).on( 'click', function( event ) {

			baraja.next();
		
		} );

		$('#card').on('click', function () {
			$(this).toggleClass('flipped');
		});
	});
})(jQuery);
</script>

 <style media="screen">

    #card {
      
    height: 200px;
    width: 200px;
      position: absolute;
      -webkit-transition: -webkit-transform 1s;
         -moz-transition: -moz-transform 1s;
           -o-transition: -o-transform 1s;
              transition: transform 1s;
      -webkit-transform-style: preserve-3d;
         -moz-transform-style: preserve-3d;
           -o-transform-style: preserve-3d;
              transform-style: preserve-3d;
    }

    #card.flipped {
      -webkit-transform: rotateY( 180deg );
         -moz-transform: rotateY( 180deg );
           -o-transform: rotateY( 180deg );
              transform: rotateY( 180deg );
    }

    #card figure {
    height: 200px;
    width: 200px;
      display: block;
      line-height: 260px;
      color: white;
      text-align: center;
      font-weight: bold;
      font-size: 140px;
      position: absolute;
      -webkit-backface-visibility: hidden;
         -moz-backface-visibility: hidden;
           -o-backface-visibility: hidden;
              backface-visibility: hidden;
    }

    #card .front {
      background: red;
    }

    #card .back {
      background: blue;
      -webkit-transform: rotateY( 180deg );
         -moz-transform: rotateY( 180deg );
           -o-transform: rotateY( 180deg );
              transform: rotateY( 180deg );
    }
  </style>
  
<div class="wrapper b-b">
	<i class="i i-search2 i-lg m-r-sm"></i><span class="h4 font-thin">Search</span>
</div>

<div class="row m-t">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="row dln-poker-wrapper">
			<div class="col-xs-4">
				<a href="#">
					<img class="thumb dln-pokers" src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" />
				</a>
			</div>
			<div class="col-xs-4">
				<a href="#">
					<img class="thumb dln-pokers" src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" />
				</a>
			</div>
			<div class="col-xs-4">
				<a href="#">
					<img class="thumb dln-pokers" src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" />
				</a>
			</div>
		</div>
		<div class="row m-t">
			<a href="#" class="btn btn-sm btn-danger">Xem bình giải</a>
		</div>
	</div>
	<div class="col-md-2">
	</div>
	
	<!-- <section class="col-md-12">
	    <div id="card">
	      <figure class="front">1</figure>
	      <figure class="back">2</figure>
	    </div>
  </section> -->
	
	<div class="dln-cards-wrapper">
		<ul id="dln_cards" class="dln-cards">
			<li><img src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" /></li>
			<li><img src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" /></li>
			<li><img src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" /></li>
			<li><img src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" /></li>
			<li><img src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" /></li>
			<li><img src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" /></li>
			<li><img src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" /></li>
			<li><img src="<?php echo DLN_NEW_PLUGIN_URL ?>/assets/images/pokers/back-side.png" /></li>
		</ul>
	</div>
</div>