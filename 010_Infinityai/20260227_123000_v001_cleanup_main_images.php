<?php
require_once __DIR__ . '/config.php';

/**
 * 20260227_123000_v001_cleanup_main_images.php
 * Main Site (Page ID 16) Cleanup Script
 */

$page_id = 16;
echo "Refreshing content for Page ID: $page_id...\n";

// 最新状態の取得
$res = wp_api_request("/pages/$page_id?context=edit", 'GET');
if ($res['code'] !== 200) {
    die("Error fetching page: " . $res['code'] . "\n");
}

$raw_content = $res['body']['content']['raw'];

// --- 修正ロジック ---
// 1. 最初のカラムブロック（紹介文）の部分だけ残す
// "AIと創造性の境界を探るアーティスト" を含む最初の paragraph までの部分を特定
// それ以降の 49 個の投稿紹介グループを削除する

$intro_pattern = '/<!-- wp:loos\/columns .*?<!-- \/wp:loos\/columns -->/s';
if (preg_match($intro_pattern, $raw_content, $matches)) {
    $new_content = $matches[0] . "\n\n";
} else {
    // 予備：カラムブロックがない場合は最初の段落を試みる
    $new_content = "<!-- wp:paragraph -->\n<p><span class=\"swl-fz u-fz-l\">AIと創造性の境界を探るアーティスト。 <br>未来のアートを一緒に体験しましょう。</span></p>\n<!-- /wp:paragraph -->\n\n";
}

// 2. 「ええ感じ」の最新投稿リスト（クエリーループ）を追加
$new_content .= <<<EOT
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

// 差分の表示用
echo "--- NEW CONTENT PREPARED ---\n";
echo $new_content;
echo "\n--- END ---\n";

// ファイルに保存（実行前に確認するため）
file_put_contents('20260227_123000_v001_new_content.txt', $new_content);

function deploy_cleanup($page_id, $content) {
    $data = [
        'content' => $content
    ];
    return wp_api_request("/pages/$page_id", 'POST', $data);
}

// このスクリプト自体は、コマンドライン引数 '--deploy' があった時だけ実行するようにする（安全策）
if (isset($argv[1]) && $argv[1] === '--deploy') {
    echo "Deploying changes...\n";
    $result = deploy_cleanup($page_id, $content);
    echo "Status: " . $result['code'] . "\n";
    print_r($result['body']);
} else {
    echo "No --deploy flag provided. Dry run only.\n";
}
