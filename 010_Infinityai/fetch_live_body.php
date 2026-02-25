<?php
require_once __DIR__ . '/config.php';
$post_id = 1953;
$result = wp_api_request("/posts/$post_id", 'GET');
if ($result['code'] === 200) {
    file_put_contents(__DIR__ . '/live_1953_body.html', $result['body']['content']['rendered']);
    echo "Saved live body to live_1953_body.html\n";
} else {
    echo "Error: " . $result['code'] . "\n";
}
