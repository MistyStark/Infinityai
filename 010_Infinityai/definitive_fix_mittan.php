<?php
/**
 * definitive_fix_mittan.php
 * Post ID 1953 の記事を最終構成で更新する
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;
// POST requests to /posts/{id} are used for updates in WordPress REST API
$endpoint = '/posts/' . $post_id;

$article_title = "Antigravityのインストール・初期設定手順";

// 画像URLの定義（以前の成功例から引用）
$image_urls = [
    '0010_Antigravity'      => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0010_Antigravity_bordered.png',
    '0020_Download'         => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0020_Download_bordered.png',
    '0030_ChooseSetupFlow'  => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0030_ChooseSetupFlow_v2_fixed.png',
    '0040_Theme'            => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0040_Theme_fixed.png',
    '0050_Agent'            => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0050_Agent_fixed.png',
    '060_Configure'         => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/060_ConfigureYourEditor.jpg'
];

$content = '
<p>Antigravity へようこそ！<br />AI と一緒に最高の未来を創るための、最初の一歩をはんなりと案内するで。🍵</p>

<h4>1. ダウンロードとインストール</h4>
<p>まずは公式サイト <a href="https://antigravity.google" target="_blank">https://antigravity.google</a> にアクセスしてな。</p>

<div style="text-align: center; margin: 20px 0;">
    <img src="'.$image_urls['0010_Antigravity'].'" alt="Antigravity Official Site" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
</div>

<ul>
    <li><strong>自分のPCに合ったものを選ぼう</strong>: Macならチップの種類、Windowsならx64を選べば100億点満点や。</li>
    <li><strong>上書きが基本！</strong>: 古いバージョンがあっても、そのまま上書きインストールするのが一番安全やで。</li>
</ul>

<div style="text-align: center; margin: 20px 0;">
    <img src="'.$image_urls['0020_Download'].'" alt="Download Antigravity" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
</div>

<h4>2. 初心者が迷わない「4つの初期設定」</h4>
<p>起動した後の英語画面、これを選べば間違いなしや！</p>

<ul>
    <li><strong>① Choose setup flow</strong>: 迷わず <strong>『Start fresh』</strong> を選んでな。
        <div style="text-align: center; margin: 20px 0;">
            <img src="'.$image_urls['0030_ChooseSetupFlow'].'" alt="Choose setup flow" style="max-width: 100%; border-radius: 8px;">
        </div>
    </li>
    <li><strong>② Theme</strong>: おすすめは <strong>『Tokyo Night』</strong>。未来的でテンション上がるで！
        <div style="text-align: center; margin: 20px 0;">
            <img src="'.$image_urls['0040_Theme'].'" alt="Choose theme" style="max-width: 100%; border-radius: 8px;">
        </div>
    </li>
    <li><strong>③ Agent設定</strong>: <strong>『Review-driven development』</strong> を選択してな。
        <div style="text-align: center; margin: 20px 0;">
            <img src="'.$image_urls['0050_Agent'].'" alt="Agent settings" style="max-width: 100%; border-radius: 8px;">
        </div>
    </li>
    <li><strong>④ Configure Your Editor</strong>: 基本はデフォルトのままで「Next」をポチッと！
        <div style="text-align: center; margin: 20px 0;">
            <img src="'.$image_urls['060_Configure'].'" alt="Configure Your Editor" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        </div>
    </li>
</ul>

<h4>3. Googleアカウント連携</h4>
<p>3つの難関を越えれば、あとは簡単や！🍵</p>

<div style="background-color: #fff4f4; border-left: 5px solid #ff5252; padding: 15px; margin: 20px 0;">
    <p style="margin: 0; font-weight: bold; color: #d32f2f;">⚠️ 【超重要】Workspaceアカウントは現在非対応！</p>
    <p style="margin: 10px 0 0 0;">必ず <strong>個人のGmailアカウント（@gmail.com）</strong> を用意してログインしような。</p>
</div>

<h4>4. 仕上げの魔法：日本語化の手順</h4>
<p>たった1分の魔法で日本語の快適な画面に変えられるで！🍵</p>
<ol>
    <li>左側の「Extensions」アイコンを押す。</li>
    <li>「<strong>Japanese</strong>」で検索して、地球儀アイコンのものを Install。</li>
    <li>「Restart」ボタンを押せば完成や！✨</li>
</ol>

<hr>
<p>これだけで、君の PC は最新前線の AI 開発基地に早変わりや。<br />Misty と一緒に、最高の大発見を見つけにいこな！🍵✨🚀</p>
';

$post_data = [
    'title'   => $article_title,
    'content' => $content,
    'status'  => 'publish'
];

echo "Updating article ID $post_id via POST ...\n";

$result = wp_api_request($endpoint, 'POST', $post_data);

if ($result['code'] === 200) {
    echo "Success! Article updated successfully.\n";
} else {
    echo "Error: Failed to update article. HTTP Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
