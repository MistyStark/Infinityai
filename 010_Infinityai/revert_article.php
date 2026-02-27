<?php
require_once __DIR__ . '/config.php';

$post_id = 1953;
$content = file_get_contents(__DIR__ . '/backup_1953.txt');
$title = "Antigravityのインストール・初期設定手順";

echo "Reverting article ID: $post_id to original state...\n";

$post_data = [
    'title'   => $title,
    'content' => $content,
    'status'  => 'publish',
    'slug'    => 'antigravityのインストール・初期設定手順'
];

$result = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($result['code'] === 200) {
    echo "\n" . str_repeat('=', 40) . "\n";
    echo "🍵 Restored! Article ID: $post_id is back to original.\n";
    echo "Link: " . $result['body']['link'] . "\n";
    echo str_repeat('=', 40) . "\n";
} else {
    echo "Error restoring article. Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
