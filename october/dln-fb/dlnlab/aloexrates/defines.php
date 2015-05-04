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