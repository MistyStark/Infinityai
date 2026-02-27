<?php
require_once __DIR__ . '/config.php';

// WordPress のフロントページ設定を確認するエンドポイント（REST API 経由だと site settings が必要だが、投稿一覧の link からも推測可能）
// 単純に /posts か /pages のどちらかがトップを構成しているはず

echo "Checking site settings...\n";
$settings = wp_api_request('/settings', 'GET');
if (isset($settings['body'])) {
    echo "Front Page Type: " . ($settings['body']['show_on_front'] ?? 'unknown') . "\n";
    echo "Front Page ID: " . ($settings['body']['page_on_front'] ?? 'unknown') . "\n";
} else {
    echo "Settings access failed (requires high privileges). Checking manually via slugs...\n";
}
