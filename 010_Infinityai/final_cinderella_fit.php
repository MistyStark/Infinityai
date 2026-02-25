<?php
/**
 * final_cinderella_fit.php
 * 060_ConfigureYourEditor.jpg をアップロードし、完璧な位置に挿入する
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/upload_media.php';

$post_id = 1953;
$image_path = __DIR__ . '/0020_/0010_Image/060_ConfigureYourEditor.jpg';

echo "Uploading 060_ConfigureYourEditor.jpg ...\n";
$upload_res = upload_to_wp($image_path, 'Configure Your Editor');

if ($upload_res['code'] !== 201) {
    echo "Upload failed! Code: {$upload_res['code']}\n";
    echo $upload_res['raw'] . "\n";
    exit(1);
}

$image_url = $upload_res['body']['source_url'];
echo "Uploaded successfully: $image_url\n";

// 記事の更新
// 今回は「 definitive_fix_mittan.php 」で作成した 100億点バージョンをベースに、画像を追加する
// 最新のボディを持ってくるのが一番確実
$get_res = wp_api_request("/posts/$post_id", 'GET');
$content = $get_res['body']['content']['rendered'];

$search_text = '全部の設定を確認したら、右下の<strong>「Next」</strong>ボタンをはんなりとクリックして次へ進もか！🚀';
$image_html = '<p style="text-align: center; margin: 2rem 0;"><img decoding="async" src="'.$image_url.'" alt="Configure Your Editor" style="max-width:100%; height:auto; border-radius:8px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"></p>';

if (strpos($content, $search_text) !== false) {
    $updated_content = str_replace($search_text, $search_text . $image_html, $content);
    echo "Inserted image after the 'Next' button text.\n";
} else {
    echo "Error: Search text not found in live content!\n";
    // バックアップから再構築するか、適当な位置を探す
    $search_text_alt = '次へ進もか！🚀'; // 少し短くして再試行
    if (strpos($content, $search_text_alt) !== false) {
        $updated_content = str_replace($search_text_alt, $search_text_alt . $image_html, $content);
        echo "Inserted image after truncated search text.\n";
    } else {
         exit(1);
    }
}

$post_data = [
    'content' => $updated_content
];

echo "Updating article ID: $post_id for the final Cinderella Fit...\n";
$update_res = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($update_res['code'] === 200) {
    echo "========================================\n";
    echo "🍵 Cinderella Fit Complete! ✨\n";
    echo "Link: " . $update_res['body']['link'] . "\n";
    echo "========================================\n";
} else {
    echo "Error: " . $update_res['code'] . "\n";
}
