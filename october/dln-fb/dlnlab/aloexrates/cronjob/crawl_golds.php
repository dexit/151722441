<?php

include '../defines.php';

echo "==============================================================\n";
$time = time();
function dump_data($url) {
    $response = json_decode(file_get_contents($url));
    foreach ($response->data as $record) {
        echo $record->id . ',';
    }
    echo "\n";
}
try {
    $url = EXR_HOST . '/crawl/golds';
    echo "[REQUEST_feed] " . $url . "\n";
    dump_data($url);

} catch (Exception $ex) {
    var_dump($ex);
}
echo "Time request: " . (time() - $time) . "s\n";
echo "==============================================================\n";
die();

?>