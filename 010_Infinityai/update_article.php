<?php
/**
 * update_article.php
 * 既存のWordPress記事を更新するスクリプト
 */

require_once __DIR__ . '/config.php';

// 更新対象の記事ID
$post_id = 1948;
$endpoint = '/posts/' . $post_id;

$article_title = "【完全版】Google Antigravity インストール・初期設定の「真」の攻略手順書 (v4.6)";
// (記事内容は以前のものを維持する想定だが、ここでは簡略化してテスト)
$article_content = "リファクタリング後の更新テストです。";

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
