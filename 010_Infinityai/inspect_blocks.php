<?php
require_once __DIR__ . '/config.php';

$page_id = 16;
$res = wp_api_request("/pages/$page_id?context=edit", 'GET');
$raw = $res['body']['content']['raw'] ?? '';

echo "Block Scan for Page ID: $page_id\n";
echo "Total Length: " . strlen($raw) . " chars\n\n";

// ブロックの開始タグを抽出
preg_match_all('/<!-- wp:([^\s]+) (.*?) -->/', $raw, $matches, PREG_SET_ORDER);

$counts = [];
foreach ($matches as $index => $match) {
    $type = $match[1];
    $attrs = $match[2];
    $counts[$type] = ($counts[$type] ?? 0) + 1;
    
    // 特定の投稿に関連するキーワードがあるかチェック
    if (strpos($attrs, '1953') !== false || strpos($attrs, '1932') !== false || strpos($attrs, 'Antigravity') !== false) {
        echo "Match at block $index ($type): $attrs\n";
    }
}

echo "\n--- Block Counts ---\n";
foreach ($counts as $type => $count) {
    echo "$type: $count\n";
}

// 先頭と末尾のサンプルを表示
echo "\n--- Content Samples ---\n";
echo "Start: " . substr($raw, 0, 500) . "...\n";
echo "End: " . substr($raw, -500) . "...\n";
