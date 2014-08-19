
(function ($) {
	var emoticons_list = [
      	['🍀', '_2cd_vn', 'Four Leaf Clover'],
      	['🌷', '_2c7_vn', 'Tulip'],
      	['🌱', '_2c4_vn', 'Seedling'],
      	['🍂', '_2cf_vn', 'Fallen Leaf'],
      	['🍃', '_2cg_vn', 'Leaf Fluttering in Wind'],
      	['🌾' , '_2cc_vn', 'Ear of Rice'],
      	['🌹', '_2c9_vn', 'Rose'],
      	['🌴', '_2c5_vn', 'Palm Tree'],
      	['🍁', '_2ce_vn', 'Maple Leaf'],
      	['🌸', '_2c8_vn', 'CherryBlossom'],
      	['🌺', '_2ca_vn', 'Hibiscus'],
      	['💐', '_2e__vn', 'Bouquet Flower'],
      	['🌵', '_2c6_vn', 'Cactus'],
      	['🌻', '_2cb_vn', 'Sunflower'],
      	['🌟', '_2c3_vn', 'Glowing Star'],
      	['⭐', 'emoticon_white_star', 'White Star'],
      	['🌙', '_2c2_vn', 'Moon'],
      	['🌊', '_2c1_vn', 'Wave'],
      	['🌂', '_2c0_vn', 'Closed Umbrella'],
      	['🌀', '_2b__vn', 'Tornado'],
      	['☀', '_2h7_vn', 'Sun'],
      	['☁', '_2h8_vn', 'Cloud'],
      	['☔', '_2h9_vn', 'Umbrella  Rain'],
      	['✳', 'emoticon_snowflake', 'Snowflake'],
      	['⛄', '_2h3_vn', 'Snowman'],
      	['⚡', '_2h2_vn', 'Thunder'],
      	['🔥', '_1a-_vn', 'Fire'],
      	['👂', '_2dy_vn', 'Ear'],
      	['👃', '_2dz_vn', 'Nose'],
      	['👄', '_2d-_vn', 'Lips'],
      	['💋', '_2ez_vn', 'Kiss'],
      	
      	['💅', '_2ey_vn', 'Manicure'],
      	['👦', '_2eb_vn', 'Boy'],
      	['👧', '_2ec_vn', 'Girl'],
      	['👨', '_2ed_vn', 'Man'],
      	['👩', '_2ee_vn', 'Woman'],
      	['💑', '_2f0_vn', 'Couple with Heart'],
      	['🎏', '_2cv_vn', 'Crap Streamer'],
      	['👫', '_2ef_vn', 'Holding Hand'],
      	['🎎', '_2cu_vn', 'Japanese Dolls'],
      	['💃', '_2ex_vn', 'Dancer'],
      	['👮', '_2eg_vn', 'Police Office'],
      	['💂', '_2ew_vn', 'Guardsman'],
      	['👯', '_1c-_vn', 'W Bunny Ears'],
      	['👱', '_2ei_vn', 'Blonde'],
      	['👲', '_2ej_vn', 'Man with Gua Pi Mao'],
      	['👳', '_2ek_vn', 'Man with Turban'],
      	['👴', '_2el_vn', 'Old Man'],
      	['👵', '_2em_vn', 'Old Woman'],
      	['👶', '_2en_vn', 'Baby'],
      	['👷', '_2eo_vn', 'Construction Worker'],
      	['👸', '_2ep_vn', 'Princess'],
      	['👻', '_2eq_vn', 'Ghost'],
      	['👼', '_2er_vn', 'Angel'],
      	['👽', '_2es_vn', 'Alien'],
      	['👾', '_2et_vn', 'Martian'],
      	['👿', '_2eu_vn', 'Devil'],
      	['3:)', 'emoticon_devil_vn', 'Devil'],
      	['💀', '_2ev_vn', 'Skull'],
      	['🍉', 'emoticon_watermelon', 'Watermelon'],
      	['🍅', 'emoticon_tomato', 'Tomato'],
      	['🍆', 'emoticon_eggplant', 'Eggplant'],
      		
      	['🍊', '_2ch_vn', 'Orange'],
      	['🍎', '_2ci_vn', 'Red Apple'],
      	['🍓', '_2cj_vn', 'Strawberry'],
      	['🐍', '_2c__vn', 'Snake'],
      	['🐛', '_2d8_vn', 'Bug'],
      	['🐎', '_2d0_vn', 'Horse'],
      	['🐴', '_2dp_vn', 'Horse'],
      	['🐵', '_2dq_vn', 'Monkey'],
      	['🐔', '_2d3_vn', 'Chicken'],
      	['🐗', '_2d4_vn', 'Boar'],
      	['🐫', '_2dh_vn', 'Camel'],
      	['🐘', '_2d5_vn', 'Elephant'],
      	['🐨', '_2df_vn', 'Koala'],
      	['🐒', '_2d2_vn', 'Monkey'],
      	['🐑', '_2d1_vn', 'Sheep'],
      	['🐙', '_2d6_vn', 'Octopus'],
      	['🐚', '_2d7_vn', 'Seashell'],
      	['👀', '_2dx_vn', 'Eyes'],
      	['🐥', '_2dc_vn', 'Baby Bird'],
      	['🐦', '_2dd_vn', 'Bird'],
      	['🐧', '_2de_vn', 'Penguin'],
      	
      	['🐩', '_2dg_vn', 'Poodle'],
      	['🐟', '_2d9_vn', 'Fish'],
      	['🐠', '_2da_vn', 'Tropical Fish'],
      	['🐡', '_2db_vn', 'Blowfish'],
      	['🐬', '_2di_vn', 'Dolphin'],
      	['🐳', '_2do_vn', 'Whale'],
      	['🐭', '_2dj_vn', 'Mouse'],
      	['🐯', '_2dl_vn', 'Tiger'],
      	['🐱', '_2dn_vn', 'Cat'],
      	['🐶', '_491_vn', 'Dog'],
      	['🐷' , '_2dr_vn', 'Pig'],
      	['🐻' , '_2dv_vn', 'Bear'],
      	['🐹' , '_2dt_vn', 'Hamster'],
      	['🐺' , '_2du_vn', 'Wolf'],
      	['🐮' , '_2dk_vn', 'Cow'],
      	['🐰' , '_2dm_vn', 'Rabit'],
      	['🐸' , '_2ds_vn', 'Frog'],
      	['🐾' , '_2dw_vn', 'Paw Prints'],
      	['(^^^)', 'emoticon_shark_vn', 'Shark'],
      	
      	[':putnam:', 'emoticon_putnam_vn', 'Putnam'],
      	[':|]', 'emoticon_robot_vn', 'Robot'],
      	["<(\")", 'emoticon_penguin_vn', 'Penguin'],
      	['🎨', 'emoticon_paint', 'Paint'],
      	[':)', 'emoticon_smile_vn', 'Smile'],
      	[':P', 'emoticon_tongue_vn', 'Tongue'],
      	[';)', 'emoticon_wink_vn', 'Wink'],
      	[':D', 'emoticon_grin_vn', 'Grin'],
      	[':(', 'emoticon_frown_vn', 'Frown'],
      	[':*', 'emoticon_kiss_vn', 'Kiss'],
      	['>:(', 'emoticon_grumpy_vn', 'Grumpy'],
      	['8)', 'emoticon_glasses_vn', 'Glasses'],
      	['8|', 'emoticon_sunglasses_vn', 'Sunglasses'],
      	['>:O', 'emoticon_upset_vn', 'Upset'],
      	['o.O', 'emoticon_confused_vn', 'Confused'],
      	//['O.o', 'emoticon_confused_rev_vn'],
      	[':3', 'emoticon_colonthree_vn', 'Colonthree'],
      	[':O', 'emoticon_gasp_vn', 'Gasp'],
      	[':v', 'emoticon_pacman_vn', 'Pacman'],
      	['-_-', 'emoticon_squint_vn', 'Squint'],
      	[':/', 'emoticon_unsure_vn', 'Unsure'],
      	[":'(", 'emoticon_cry_vn', 'Cry'],
      	["O:)", 'emoticon_angel_vn', 'Angel'],
      	["^_^", 'emoticon_kiki_vn', 'Kiki'],
      	['😠' , '_2g9_vn', 'Angry Face'],
      	['😲' , '_2gm_vn', 'Drug Face'],
      	['😞' , '_2g8_vn', 'Disappointed'],
      	['😵' , '_2go_vn', 'Dizzy Face'],
      	['😰' , '_2gk_vn', 'Cold Sweat'],
      	['😒' , '_2g0_vn', 'Meh'],
      	['😍' , '_2f-_vn', 'Heart eyes'],
      	['😤' , '_2gd_vn'],
      	['😜' , '_2g6_vn', 'Winking Eye'],
      	['😝' , '_2g7_vn', 'Stuckout Tongue'],
      	['😘' , '_2g4_vn', 'Face Kiss'],
      	['😚' , '_2g5_vn', 'Kissing'],
      	['😷' , '_2gp_vn', 'Medical Mask'],
      	['😳' , '_2gn_vn', 'Flushed Face'],
      	['😃' , '_2fu_vn', 'Grin'],
      	['☺' , '_2h1_vn', 'Smiley'],
      	['😄' , '_2fv_vn'],
      	['😢' , '_2gb_vn', 'Crying Face'],
      	['😭', '_2gj_vn', 'Loudly Crying Face'],
      	['😨', '_2gf_vn'],
      	['😡', '_2ga_vn', 'Red Face'],
      	['😌', '_2fz_vn', 'Relieved'],
      	['😖', '_2g3_vn', 'Confounded Face'],
      	['😔', '_2g2_vn', 'Pensive'],
      	['😱', '_2gl_vn', 'Screaming'],
      	['😪', '_2gh_vn', 'Sleepy Face'],
      	['😏', '_2f__vn', 'Smirking'],
      	['😓', '_2g1_vn', 'Cold Sweat'],
      	['😉', '_2fx_vn', 'Winking'],
      	['😹', '_2gr_vn'],
      	['❤', '_2hc_vn', 'Big Heart'],
      	['💓', '_2f1_vn', 'Beating Heart'],
      	['💔', '_2f2_vn', 'Broken Heart'],
      	['💖', '_2f3_vn', 'Sparkling Heart'],
      	['💗', '_2f4_vn', 'Growing Heart'],
      	['💘', '_2f5_vn', 'Heart with Arrow'],
      	['💙', '_2f6_vn', 'Blue Heart'],
      	['💚', '_2f7_vn', 'Green Heart'],
      	['💛', '_2f8_vn', 'Yellow Heart'],
      	['💜', '_2f9_vn', 'Purple Heart'],
      	['💝', '_2fa_vn', 'Heart Ribbon'],
      	['💞', 'emoticon_spinning_hearts', 'Spinning Hearts'],
      	['💟', 'emoticon_white_heart', 'White Hearth'],
      	['💌', 'emoticon_love_letter', 'Love Letter'],
      	['🎁', '_2cn_vn', 'Present'],
      	['🎄', '_2cp_vn', 'Christmas Tree'],
      	['🎅', '_2cq_vn', 'Santa Claus'],
      	['🎈', '_2cr_vn', 'Balloon'],
      	['🎉', '_2cs_vn', 'Party Popper'],
      	['🎍', '_2ct_vn', 'PineDecoration'],
      	['💡', 'emoticon_idea', 'Idea'],
      	['🎓', '_2cx_vn', 'Graduation Cap'],
      	['🎐', '_2cw_vn', 'Wind Chime'],
      	['💣', 'emoticon_bomb', 'Bomb'],
      	['🎃', '_2co_vn', 'Halloween'],
      	['📞', '_2fm_vn', 'Phone'],
      	['📱', '_2fo_vn', 'Tablet'],
      	['📠', '_2fn_vn', 'Fax Machine'],
      	['🎥', 'emoticon_camera', 'Camera'],
      	['💻', '_2fh_vn', 'PC'],
      	['📺', '_2fq_vn', 'Television'],
      	['💽', '_2fi_vn', 'MiniDisc'],
      	['💾', '_2fj_vn', 'Floppy Disk'],
      	['💿', '_2fk_vn', 'Optical Disc'],
      	['📀', '_2fl_vn', 'DVD'],
      	['🎧', 'emoticon_music', 'Listening to Music'],
      	['🎤', 'emoticon_microphone', 'Microphone'],
      	['🎵', '_2cy_vn', 'Musical Note'],
      	['🎼', '_2c-_vn', 'Music'],
      	['💤', '_2fc_vn', 'Sleep'],
      	
      	['🍴', 'emoticon_lunch', 'Lunch'],
      	['🍦', 'emoticon_icecream', 'Icecream'],
      	['🍣', 'emoticon_sushi', 'Sushi'],
      	['🍝', 'emoticon_spaghetti', 'Spaghetti'],
      	['🍔', '_2ck_vn', 'Burger'],
      	['☕', '_2ha_vn', 'Coffee'],
      	['🍸', '_2cl_vn', 'Martini'],
      	['🍺', '_2cm_vn', 'Beer'],
      	[':poop:', '_2ff_vn', 'Poop'],
      	['🗽', 'emoticon_statue_of_liberty', 'Statue Of Liberty'],
      	['🎩', 'emoticon_top_hat', 'Top Hat'],
      	
      	['✨', '_2hb_vn', 'Sparkles'],
      	['🔔', '_2fr_vn', 'Bell'],
      	['🏆', 'emoticon_trophy', 'Trophy'],
      	
      	
      	['💢', '_2fb_vn', 'Anger Symbol'],
      	['🆚', 'emoticon_vs', 'VS'],
      	['🆒', 'emoticon_cool', 'Cool'],
      	['🚾', 'emoticon_wc', 'WC'],
      	
      	['💦', '_2fd_vn', 'Water'],
      	['💨', '_2fe_vn', 'Wind'],
      	['👊', '_2e4_vn', 'Fisted Hand'],
      	['☝', '_2h0_vn'],
      	['✌', '_2h6_vn', 'Peace'],
      	['👆', '_2e0_vn', 'Pointing Up'],
      	['👇', '_2e1_vn', 'Pointing Down'],
      	['👈', '_2e2_vn', 'Pointing Left'],
      	['👉', '_2e3_vn', 'Pointing Right'],
      	['👋', '_2e5_vn', 'Waving'],
      	['👏', '_2e9_vn', 'Clapping'],
      	['👌', '_2e6_vn', 'OK'],
      	['💪', '_2fg_vn', 'Strong Bicep'],
      	['👐', '_2ea_vn', 'Open Hand Sign'],
      	['☝', '_2g__vn', 'Number One'],
      	['✊', '_2h4_vn', 'Raised Fist'],
      	['✋', '_2h5_vn', 'Raising One Hand'],
      	['🙌', '_2gz_vn', 'Raising Both'],
      	
      	['👎', '_2e8_vn', 'Dislike'],
      	['👍', '_2e7_vn', 'Like'],
      	
      	['⚠', 'emoticon_warning', 'Warning'],
      	['⛔', 'emoticon_stop', 'Stop'],
      	['❎', 'emoticon_cross_mark', 'Cross Mark'],
      	['❕', 'emoticon_exclamation_mark', 'Exclamation Mark'],
      	['❔', 'emoticon_question_mark', 'Question Mark'],
      	
      	['♥', 'emoticon_heart_suit', 'Heart Suit'],
      	['♠', 'emoticon_spade_suit', 'Spade Suit'],
      	['♦', 'emoticon_diamond_suit', 'Diamond Suit'],
      	['♣', 'emoticon_club_suit', 'Club Suit'],
      	
      	['🏈', 'emoticon_football', 'Football'],
      	['⚽', 'emoticon_soccer', 'Soccer'],
      	['🏀', 'emoticon_basketball', 'Basketball'],
      	['⚾', 'emoticon_baseball', 'Baseball'],
      	['🎾', 'emoticon_tennis', 'Tennis'],
      	['🎱', 'emoticon_8_ball', '8 Ball'],
      	['⛳', 'emoticon_golf', 'Golf'],
      	['🎯', 'emoticon_bullseye', 'Bullseye'],
      	['🏁', 'emoticon_formula_1', 'Formula 1'],
      	
      	['💰', 'emoticon_money_bag', 'Money Bag'],
      	['💵', 'emoticon_dollar', 'Dollar'],
      	['💲', 'emoticon_dollar_sign', 'Dollar'],
      	['💎', 'emoticon_diamond', 'Diamond'],
      	['👙', 'emoticon_bikini', 'Bikini'],
      	['🎭', 'emoticon_teatre', 'Teatre'],
      	['🚬', 'emoticon_smoking', 'Smoking'],
      	['🚭', 'emoticon_no_smoking', 'No Smoking'],
      	['🔞', 'emoticon_18_plus', '18+'],
      	['📳', 'emoticon_mute', 'Mute'],
      	['🚲', 'emoticon_bike', 'Bike'],
      	['🚗', 'emoticon_car', 'Car'],
      	['⛵', 'emoticon_sailboat', 'Sailboat'],
      	['✈', 'emoticon_airplane', 'Airplane'],
      	['🚃', 'emoticon_tram', 'Tram']
      ];
	
	$(document).ready(function () {
		var wrapper = $('.dln-emoji-facebook');
		
		$.each(emoticons_list, function(key, data) {
			var emo = $('<span class="emo ' + data[1] + '" data-emoticon="' + data[0] + '"></span>');
			
			if (typeof data[2] != 'undefined') {
				$(emo).attr('title', data[2]);
			}
			$(emo).qtip({
				position: {
					my: 'bottom center',
					at: 'top center'
				},
				style: {
					classes: 'qtip-tipsy'
				},
				show: {
					delay: 0,
					effect: false
				},
				hide: {
					delay: 0,
					effect: false
				}
			});
			$(wrapper).append(emo);
		});
	});
})(jQuery);