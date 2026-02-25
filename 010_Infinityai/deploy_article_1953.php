<?php
/**
 * deploy_article_1953.php
 * Post ID 1953 の記事を更新するスクリプト
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;
$endpoint = '/posts/' . $post_id;

$article_title = "Antigravityのインストール・初期設定手順";
$article_content = file_get_contents(__DIR__ . '/update_1953_v2.html');

if ($article_content === false) {
    die("Error: Failed to read update_1953_v2.html\n");
}

$update_data = [
    'title'   => $article_title,
    'content' => $article_content,
    'status'  => 'publish'
];

echo "Updating article ID $post_id ...\n";

$result = wp_api_request($endpoint, 'PUT', $update_data);

if ($result['code'] === 200) {
    echo "Success! Article updated successfully.\n";
} else {
    echo "Error: Failed to update article. HTTP Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
