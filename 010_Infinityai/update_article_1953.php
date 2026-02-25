<?php
/**
 * update_article_1953.php
 * 既存の記事 (ID: 1953) を最新の内容で更新する
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/upload_media.php';

echo "Mittan's Mission: Updating Article 1953...\n";

// すでにアップロード済みの画像のURLをハードコード（前回の実行結果より）
$image_urls = [
    '0010_Antigravity.png'      => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0010_Antigravity-1.png',
    '0020_Download.png'         => '#PLACEHOLDER_PLEASE_UPLOAD_MANUALLY',
    '0030_ChooseSetupFlow.png'  => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0030_ChooseSetupFlow.png',
    '0040_Theme.png'            => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0040_Theme.png',
    '0050_Agent.png'            => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0050_Agent.png'
];

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

<div style="background: #fff9c4; border: 1px dashed #fbc02d; padding: 20px; text-align: center; margin: 20px 0; border-radius: 8px;">
    <p style="margin: 0; font-weight: bold; color: #f57f17;">[ここにダウンロード画面のスクショを差し込んでな！]</p>
    <p style="font-size: 0.85em; margin-top: 5px;">※セキュリティの都合で自動アップロードできへんかったさかい、管理画面から <code>0020_Download.png</code> を手動でアップして、ここに貼り替えてな🌸</p>
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

$post_data = [
    'title'   => $article_title,
    'content' => $content,
    'status'  => 'publish' // 公開済みの記事を更新するので publish のままで
];

$post_id = 1953;
echo "Updating article ID: $post_id ...\n";

$result = wp_api_request("/posts/$post_id", 'POST', $post_data); // POST to existsing ID updates it

if ($result['code'] === 200) {
    echo "\n" . str_repeat('=', 40) . "\n";
    echo "🍵 Success! Article updated successfully by Mittan.\n";
    echo "Link: " . $result['body']['link'] . "\n";
    echo str_repeat('=', 40) . "\n";
} else {
    echo "Error updating article. Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
