<?php
require_once __DIR__ . '/config.php';

$page_id = 16;
echo "Fetching Page ID: $page_id\n";

$res = wp_api_request("/pages/$page_id", 'GET');
if ($res['code'] === 200) {
    $content = $res['body']['content']['rendered'];
    // 生のブロック形式（context=edit）も取得を試みる
    $res_edit = wp_api_request("/pages/$page_id?context=edit", 'GET');
    $raw_content = $res_edit['body']['content']['raw'] ?? $content;
    
    file_put_contents('live_main_page_rendered.html', $content);
    file_put_contents('live_main_page_raw.txt', $raw_content);
    echo "Saved content to live_main_page_rendered.html and live_main_page_raw.txt\n";
} else {
    echo "Error: " . $res['code'] . "\n";
    echo $res['raw'] . "\n";
}
