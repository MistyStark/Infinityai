<?php
/**
 * 20260227_091000_v001_update_workspace_warning.php
 * Ver 2.0 プロトコル：Google Workspace 警告文のピンポイント更新
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;

echo "Ver 2.0 Mission: Updating Workspace Warning for Article 1953...\n";

// 1. 最新のコンテンツをフェッチ
$get_res = wp_api_request("/posts/$post_id", 'GET');
if ($get_res['code'] !== 200) {
    die("Error: Failed to fetch latest content. Code: {$get_res['code']}\n");
}

$raw_content = $get_res['body']['content']['rendered']; // rendered を対象にする

// 2. ピンポイント置換 (デグレード防止)
$old_text = '<strong>注意点やで！</strong><br />Google Workspace アカウントを使っている場合は、管理者が AI の使用を制限している場合があるから気をつけてな。もしエラーが出たら管理者の人に相談してみてや。🍵';
$new_text = '実は今、Antigravityは Google Workspace アカウントには対応してないみたい。無理やり繋ごうとすると大事なアカウントに「お仕置き（BAN）」が下るっていう物騒な噂も飛び交ってるんでホンマに気をつけてな。';

if (strpos($raw_content, $old_text) === false) {
    echo "Warning: Exact string not found. Trying a truncated match...\n";
    // 微細なスペースやタグの差異を考慮して少し短くして再試行
    $old_text_short = 'Google Workspace アカウントを使っている場合は、管理者が AI の使用を制限している場合があるから気をつけてな。';
    if (strpos($raw_content, $old_text_short) !== false) {
        // 見つかった場合はその前後を上手く置換
        // ここでは安全のため、完全一致のみを本命とするため一旦 exit
        die("Error: Partial match found but not exact. Please review the live HTML structure manually.\n");
    }
    die("Error: Target text not found. Aborting to prevent degrade.\n");
}

$updated_content = str_replace($old_text, $new_text, $raw_content);

// 3. 更新リクエスト
$post_data = [
    'content' => $updated_content
];

echo "Updating article ID: $post_id with precision edit...\n";
$update_res = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($update_res['code'] === 200) {
    echo "========================================\n";
    echo "🍵 Success! Warning text updated.\n";
    echo "URL: " . $update_res['body']['link'] . "\n";
    echo "========================================\n";
} else {
    echo "Error updating article. Code: {$update_res['code']}\n";
    echo "Response: {$update_res['raw']}\n";
}
