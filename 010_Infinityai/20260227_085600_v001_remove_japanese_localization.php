<?php
/**
 * 20260227_085600_v001_remove_japanese_localization.php
 * Ver 2.0 プロトコル：最新のサーバー状態からピンポイントで「日本語化の手順」を削除する
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;

echo "Ver 2.0 Mission: Removing Japanese Localization from Article 1953...\n";

// 1. 最新のコンテンツをフェッチ
$get_res = wp_api_request("/posts/$post_id", 'GET');
if ($get_res['code'] !== 200) {
    die("Error: Failed to fetch latest content. Code: {$get_res['code']}\n");
}

$raw_content = $get_res['body']['content']['rendered']; // rendered content for matching

// 2. ピンポイント置換 (デグレード防止)
// サーバーから取得した生の HTML をデバッグ出力して、サーチ対象の正確な文字列を確認
echo "Content length: " . strlen($raw_content) . "\n";
// 削除対象の HTML 文言を特定
$target_section = '<h4 class="wp-block-heading">3. 日本語化の手順</h4>';
$next_section_old = '<h4 class="wp-block-heading">4. Googleアカウントでログイン</h4>';
$next_section_new = '<h4 class="wp-block-heading">3. Googleアカウントでログイン</h4>';

// 削除範囲を特定するために分割
$start_pos = strpos($raw_content, $target_section);
$end_pos = strpos($raw_content, $next_section_old);

if ($start_pos === false || $end_pos === false) {
    die("Error: Target sections not found in the live content. Aborting to prevent degrade.\n");
}

// target_section から next_section_old の直前までを削除し、next_section_old を new に変える
$before = substr($raw_content, 0, $start_pos);
$after = substr($raw_content, $end_pos);
$after_updated = str_replace($next_section_old, $next_section_new, $after);

$updated_content = $before . $after_updated;

// 3. 更新リクエスト
$post_data = [
    'content' => $updated_content
];

echo "Updating article ID: $post_id with precision edit...\n";
$update_res = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($update_res['code'] === 200) {
    echo "========================================\n";
    echo "🍵 Success! Pinpoint removal complete.\n";
    echo "URL: " . $update_res['body']['link'] . "\n";
    echo "========================================\n";
} else {
    echo "Error updating article. Code: {$update_res['code']}\n";
    echo "Response: {$update_res['raw']}\n";
}
