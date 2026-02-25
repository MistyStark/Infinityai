<?php
/**
 * deploy_article.php
 * 画像のアップロードと記事の投稿を一括して行う
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/upload_media.php';

echo "Starting deployment process...\n";

// 1. 画像のアップロード
$images = [
    '0010_Antigravity.png'      => 'Main Visual',
    '0020_Download.png'         => 'Download Page',
    '0030_ChooseSetupFlow.png'  => 'Setup Flow',
    '0040_Theme.png'            => 'Theme Selection',
    '0050_Agent.png'            => 'Agent Policy Settings'
];

$image_urls = [];
foreach ($images as $filename => $title) {
    echo "Uploading image: $filename ($title) ...\n";
    $path = __DIR__ . '/0020_/0010_Image/' . $filename;
    $res = upload_to_wp($path, $title);
    if ($res['code'] === 201) {
        $image_urls[$filename] = $res['body']['source_url'];
        echo "Uploaded: " . $image_urls[$filename] . "\n";
    } else {
        echo "Warning: Failed to upload $filename. Proceeding with placeholders.\n";
        $image_urls[$filename] = "#placeholder_" . $filename;
    }
}

// 2. 記事内容の構築 (HTML形式)
$article_title = "【完全図解】Google Antigravityの導入ガイド！AIと創る未来の開発環境を手に入れよう";

$content = '
<p>想像してみてください。あなたが頭の中で思い描いたアイデアを、言葉にするだけでAIが瞬時にアプリやWebサイトに変えてくれる未来を。</p>
<p>2025年11月、Googleが発表したAI搭載の次世代エディター「<strong>Google Antigravity（アンティグラビティ）</strong>」は、まさにその未来を現実にする魔法のツールです。</p>

<div style="text-align: center; margin: 20px 0;">
    <img src="'.$image_urls['0010_Antigravity.png'].'" alt="Google Antigravity Main" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
</div>

<h2>ステップ1：公式サイトからダウンロード＆インストール</h2>
<h3>1. 自分のPCのスペックを確認する</h3>
<p>公式サイト（<a href="https://antigravity.google/download">https://antigravity.google/download</a>）にアクセスし、お使いのOSに合わせてインストーラーを選びましょう。</p>

<div style="text-align: center; margin: 20px 0;">
    <img src="'.$image_urls['0020_Download.png'].'" alt="Download Page" style="max-width: 100%; border-radius: 8px; border: 1px solid #ddd;">
</div>

<blockquote>
    <strong>【重要】Windowsユーザーの方へ</strong><br>
    エラーが出た場合は、アンインストールせず最新版を「上書きインストール」してください。
</blockquote>

<h2>ステップ2：初心者が迷う「3つの初期設定」の正解はコレ！</h2>

<h3>① Import Settings：どっちが正解？</h3>
<p>初心者は迷わず <strong>『Start fresh』</strong> を選択！</p>
<div style="text-align: center; margin: 20px 0;">
    <img src="'.$image_urls['0030_ChooseSetupFlow.png'].'" alt="Setup Flow" style="max-width: 100%; border-radius: 8px;">
</div>

<h3>② Theme：どっちが正解？</h3>
<p>おすすめは <strong>『Tokyo Night』</strong> または <strong>『Dark』</strong>！</p>
<div style="text-align: center; margin: 20px 0;">
    <img src="'.$image_urls['0040_Theme.png'].'" alt="Theme selection" style="max-width: 100%; border-radius: 8px;">
</div>

<h3>③ Agent Mode：どっちが正解？</h3>
<p>初心者は必ず <strong>『Review-driven development (推奨)』</strong> を選択！</p>
<div style="text-align: center; margin: 20px 0;">
    <img src="'.$image_urls['0050_Agent.png'].'" alt="Agent settings" style="max-width: 100%; border-radius: 8px;">
    <p style="font-size: 0.9em; color: #666;">※詳細設定（Policy）も「Manual」や「Always」にしておくと安心です。</p>
</div>

<h2>ステップ3：Googleアカウント連携と日本語化</h2>
<p>個人のGmailアカウント（@gmail.com）でログインしましょう（Workspaceは現在非対応です）。</p>
<p>完了後は拡張機能から「Japanese Language Pack」をインストールして日本語化すれば完璧です！</p>

<hr>
<p>さあ、最新のAIエディターであなたのアイデアを形にしましょう！</p>
';

// 3. WordPressに投稿
$post_data = [
    'title'   => $article_title,
    'content' => $content,
    'status'  => 'draft' // 最初は下書きで
];

echo "Pushing final article to WordPress...\n";
$result = wp_api_request('/posts', 'POST', $post_data);

if ($result['code'] === 201) {
    echo "\n" . str_repeat('=', 40) . "\n";
    echo "🎉 SUCCESS: Article deployed successfully!\n";
    echo "Post ID: " . $result['body']['id'] . "\n";
    echo "Draft Link: " . $result['body']['link'] . "\n";
    echo str_repeat('=', 40) . "\n";
} else {
    echo "Error deploying article. Check log for details.\n";
}
