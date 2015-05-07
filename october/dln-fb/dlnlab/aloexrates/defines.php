<?php
define('EXR_URL', 'https://www.google.com/finance/converter?a=1&from=%s&to=%s');
define('EXR_BASE', 'VND');
define('EXR_HOST', 'http://home.vivufb.com/api/v1');
define('EXR_BANKS', json_encode([
    'VCB' => 'http://www.vietcombank.com.vn/exchangerates/ExrateXML.aspx'
]));
define('EXR_GOLDS', json_encode([
    'SJC' => 'http://www3.sjc.com.vn/xml/tygiavang.xml'
]));
define('EXR_LIMIT_NTFS', 3);
define('EXR_LIMIT_WEEK', 1);
define('EXR_LIMIT_DEVICES', 1000);
define('EXR_MIN_MSG', '[THÔNG BÁO] Tỷ giá %s đang thấp nhất trong %d tuần qua! - %s');
define('EXR_MAX_MSG', '[THÔNG BÁO] Tỷ giá %s đang cao nhất trong %d tuần qua! - %s');
define('GOOGLE_API_KEY', '');
define('GOOGLE_GCM_URL', 'https://android.googleapis.com/gcm/send');