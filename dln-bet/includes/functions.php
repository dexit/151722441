<?php
/**
 * @version    $Id$
 * @package    ITPGBLDR
 * @author     InnoThemes Team <support@innothemes.com>
 * @copyright  Copyright (C) 2012 InnoThemes.com. All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.innothemes.com
 * Technical Support: Feedback - http://www.innothemes.com/contact-us/get-support.html
 */

class DLN_Bet_Helper_Functions {
	public static function localize_js() {
		return array(
			'ajaxurl'      => admin_url( 'admin-ajax.php' ),
			'adminroot'    => admin_url()
		);
	}
}
