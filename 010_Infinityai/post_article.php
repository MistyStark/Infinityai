<?php
/**
 * post_article.php
 * WordPressに新しい記事を投稿するスクリプト
 */

require_once __DIR__ . '/config.php';

// 記事データを作成
$article_title = "Antigravityのインストール手順 (Refactored)";
$article_content = '
<h2>Antigravityとは？</h2>
<p>Antigravityは、Misty Starlit（ミスティ）によって設計された、強力なエージェントAIです。</p>
<p>リファクタリング後のスクリプトからのテスト投稿です。</p>
';

$post_data = [
    'title'   => $article_title,
    'content' => $article_content,
    'status'  => 'draft' // テスト用なので下書きで投稿
];

echo "Posting article: $article_title ...\n";

$result = wp_api_request('/posts', 'POST', $post_data);

if ($result['code'] === 201) {
    echo "Success! Article posted successfully.\n";
    echo "Post ID: " . $result['body']['id'] . "\n";
    echo "Link:    " . $result['body']['link'] . "\n";
} else {
    echo "Error: Failed to post article. HTTP Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
