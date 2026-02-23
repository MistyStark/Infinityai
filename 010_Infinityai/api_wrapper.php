<?php
/**
 * api_wrapper.php
 * WordPressの最新記事をJSON形式で提供するAPIラッパー
 */

require_once __DIR__ . '/config.php';

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// 記事を取得
$result = wp_api_request('/posts?per_page=3');

if ($result['code'] !== 200) {
    http_response_code($result['code']);
    echo json_encode([
        'error' => 'Failed to fetch articles',
        'http_code' => $result['code'],
        'response' => $result['body']
    ]);
    exit;
}

// 結果をそのままJSONとして出力
echo $result['raw'];
