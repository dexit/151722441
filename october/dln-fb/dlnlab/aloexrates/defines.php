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
define('EXR_PAGINATE', 10);
define('EXR_LIMIT_NTFS', 3);
define('EXR_LIMIT_WEEK', 1);
define('EXR_LIMIT_DEVICES', 1000);
define('EXR_CACHE_MINUTE', 5);
define('EXR_MIN_MSG', '[THÔNG BÁO] Tỷ giá %s đang thấp nhất trong %d tuần qua! - %s');
define('EXR_MAX_MSG', '[THÔNG BÁO] Tỷ giá %s đang cao nhất trong %d tuần qua! - %s');
define('GOOGLE_API_KEY', 'AIzaSyCXvqHCZTbpvvEXq_u360RjQ_aIQSJcvlo');
define('GOOGLE_GCM_URL', 'https://android.googleapis.com/gcm/send');
define('EXR_FB_RANGES', json_encode([
    'USD', 'GBP', 'EUR', 'Hồ Chí Minh|Vàng SJC 1L', 'Hồ Chí Minh|Vàng nhẫn SJC 99,99 5p,1c,2c,5c',
    'Hồ Chí Minh|Vàng nữ trang 99,99%', 'Hồ Chí Minh|Vàng nữ trang 99%', 'Hồ Chí Minh|Vàng nữ trang 75%'
]));