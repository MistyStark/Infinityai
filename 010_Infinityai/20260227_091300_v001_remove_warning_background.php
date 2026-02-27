<?php
/**
 * 20260227_091300_v001_remove_warning_background.php
 * Ver 2.0 プロトコル：警告文の背景色クラスをピンポイントで削除
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;

echo "Ver 2.0 Mission: Removing Warning Background from Article 1953...\n";

// 1. 最新のコンテンツをフェッチ
$get_res = wp_api_request("/posts/$post_id", 'GET');
if ($get_res['code'] !== 200) {
    die("Error: Failed to fetch latest content. Code: {$get_res['code']}\n");
}

$raw_content = $get_res['body']['content']['rendered'];

// 2. ピンポイント置換 (デグレード防止)
$old_tag = '<p class="has-pale-pink-background-color has-background">';
$new_tag = '<p>';

if (strpos($raw_content, $old_tag) === false) {
    die("Error: Target tag with background classes not found. Aborting to prevent degrade.\n");
}

$updated_content = str_replace($old_tag, $new_tag, $raw_content);

// 3. 更新リクエスト
$post_data = [
    'content' => $updated_content
];

echo "Updating article ID: $post_id with precision edit...\n";
$update_res = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($update_res['code'] === 200) {
    echo "========================================\n";
    echo "🍵 Success! Background color removed.\n";
    echo "URL: " . $update_res['body']['link'] . "\n";
    echo "========================================\n";
} else {
    echo "Error updating article. Code: {$update_res['code']}\n";
    echo "Response: {$update_res['raw']}\n";
}
