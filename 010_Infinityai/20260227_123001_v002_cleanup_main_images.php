<?php
require_once __DIR__ . '/config.php';

/**
 * 20260227_123001_v002_cleanup_main_images.php
 * Main Site (Page ID 16) Cleanup Script - Fixed variable names
 */

$page_id = 16;
echo "Refreshing content for Page ID: $page_id...\n";

// 最新状態の取得
$res = wp_api_request("/pages/$page_id?context=edit", 'GET');
if ($res['code'] !== 200) {
    die("Error fetching page: " . $res['code'] . "\n");
}

$raw_content_full = $res['body']['content']['raw'];

// --- 修正ロジック ---
// 1. 最初のカラムブロック（紹介文）の部分だけ残す
$intro_pattern = '/<!-- wp:loos\/columns .*?<!-- \/wp:loos\/columns -->/s';
if (preg_match($intro_pattern, $raw_content_full, $matches)) {
    $header_content = $matches[0] . "\n\n";
} else {
    // 予備：カラムブロックがない場合は既定の紹介文を使用
    $header_content = "<!-- wp:paragraph -->\n<p><span class=\"swl-fz u-fz-l\">AIと創造性の境界を探るアーティスト。 <br>未来のアートを一緒に体験しましょう。</span></p>\n<!-- /wp:paragraph -->\n\n";
}

// 2. 「ええ感じ」の最新投稿リスト（クエリーループ）を追加
$modern_query_block = <<<EOT
<!-- wp:heading {"textAlign":"center","style":{"typography":{"fontStyle":"normal","fontWeight":"700"}},"fontSize":"large"} -->
<h2 class="wp-block-heading has-text-align-center" style="font-style:normal;font-weight:700;font-size:large">Latest Creations</h2>
<!-- /wp:heading -->

<!-- wp:query {"query":{"perPage":6,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"displayLayout":{"type":"flex","columns":3}} -->
<div class="wp-block-query">
<!-- wp:post-template -->
<!-- wp:post-featured-image {"isLink":true,"width":"100%","height":"200px"} /-->
<!-- wp:post-title {"isLink":true,"textAlign":"center","fontSize":"small"} /-->
<!-- wp:post-date {"textAlign":"center","fontSize":"x-small"} /-->
<!-- /wp:post-template -->
</div>
<!-- /wp:query -->

<!-- wp:spacer {"height":"50px"} -->
<div style="height:50px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->
EOT;

$final_content = $header_content . $modern_query_block;

function perform_deploy($id, $content_to_send) {
    $payload = [
        'content' => $content_to_send
    ];
    return wp_api_request("/pages/$id", 'POST', $payload);
}

if (isset($argv[1]) && $argv[1] === '--deploy') {
    echo "Deploying fixed changes to Page ID $page_id...\n";
    $deploy_res = perform_deploy($page_id, $final_content);
    echo "Status: " . $deploy_res['code'] . "\n";
    if ($deploy_res['code'] === 200) {
        echo "Success! MAIN site updated.\n";
    } else {
        echo "Failed! Response:\n";
        print_r($deploy_res['body']);
    }
} else {
    echo "--- PREVIEW (DRY RUN) ---\n";
    echo $final_content;
    echo "\n--- END PREVIEW ---\n";
    echo "Use --deploy to apply changes.\n";
}
