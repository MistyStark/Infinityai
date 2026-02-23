<?php
/**
 * fetch_articles.php
 * WordPressの最新記事を3件取得するスクリプト
 */

require_once __DIR__ . '/config.php';

// 記事を取得
$result = wp_api_request('/posts?per_page=3');

if ($result['code'] !== 200) {
    die("Error: Failed to fetch articles. HTTP Code: {$result['code']}\nResponse: {$result['raw']}\n");
}

$posts = $result['body'];

// 結果を表示
echo "--- Latest 3 Articles ---\n";
foreach ($posts as $post) {
    echo "Title:   " . $post['title']['rendered'] . "\n";
    echo "Full Content (HTML):\n";
    echo $post['content']['rendered'] . "\n";
    echo "-------------------------\n";
}
