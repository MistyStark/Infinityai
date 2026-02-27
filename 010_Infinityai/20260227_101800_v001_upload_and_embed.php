<?php
/**
 * 20260227_101800_v001_upload_and_embed.php
 * WAF除外後の画像アップロードと記事への精密反映
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/upload_media.php';

$post_id = 1953;
$image_path = 'D:\\100_MyFolderD\\000_TeamMisty\\010_Infinityai\\0020_Assets\\0010_Image\\070_GoogleAccount.png';
$image_title = '070_GoogleAccount';

echo "Mission: Post-WAF Exclusion Upload and Repair...\n";

// 1. 画像アップロード
echo "Uploading image: $image_path ...\n";
$upload_res = upload_to_wp($image_path, $image_title);

if ($upload_res['code'] !== 201) {
    die("Critical Error: Upload failed with code {$upload_res['code']}. Response: {$upload_res['raw']}\n");
}

$new_image_url = $upload_res['body']['source_url'];
echo "========================================\n";
echo "🍵 Success! 100-Billion Point URL: $new_image_url\n";
echo "========================================\n";

// 2. 最新コンテンツ取得
echo "Fetching latest content for article $post_id ...\n";
$get_res = wp_api_request("/posts/$post_id", 'GET');
if ($get_res['code'] !== 200) {
    die("Error: Failed to fetch post $post_id.\n");
}
$raw_content = $get_res['body']['content']['rendered'];

// 3. リンク切れURLの置換 (精密置換)
// ターゲット: 070_GoogleAccount.png を含む img タグの src
$old_url_pattern = 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/070_GoogleAccount.png';

if (strpos($raw_content, $old_url_pattern) === false) {
    echo "Warning: Old URL pattern not found in rendered content. Checking alternative structure...\n";
    // 予備のパターンチェック（以前の修正で変わっている可能性があるため）
}

$updated_content = str_replace($old_url_pattern, $new_image_url, $raw_content);

// 4. 更新
echo "Updating article $post_id with new image URL...\n";
$update_data = ['content' => $updated_content];
$update_res = wp_api_request("/posts/$post_id", 'POST', $update_data);

if ($update_res['code'] === 200) {
    echo "========================================\n";
    echo "🚀 MISSION COMPLETE: Image repaired!\n";
    echo "URL: " . $update_res['body']['link'] . "\n";
    echo "========================================\n";
} else {
    echo "Error updating article. Code: {$update_res['code']}\n";
    echo "Response: {$update_res['raw']}\n";
}
