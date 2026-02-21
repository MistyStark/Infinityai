<?php
/**
 * update_article.php
 * 既存のWordPress記事を更新するスクリプト
 */

// 1. 設定ファイルを読み込む
$config_file = dirname(__DIR__) . '/mcp-servers.json';
if (!file_exists($config_file)) {
    die("Error: mcp-servers.json not found.\n");
}

$config_data = json_decode(file_get_contents($config_file), true);
$wp_config = $config_data['mcpServers']['infinityai']['env'] ?? null;

if (!$wp_config) {
    die("Error: WordPress configuration not found in mcp-servers.json.\n");
}

$api_url = $wp_config['WP_API_URL'];
$username = $wp_config['WP_API_USERNAME'];
$password = $wp_config['WP_API_PASSWORD'];

// 更新対象の記事ID
$post_id = 1948;
$update_endpoint = str_replace('/mcp/v1', '/wp/v2/posts/' . $post_id, $api_url);

// 2. 最終進化：Dify Base を凌駕する「100億点バイブル」 (v4.5)
$article_title = "【完全版】Google Antigravity インストール・初期設定の「真」の攻略手順書";

// CSSデザインシステム v2（さらにリッチに）
$style_block = '
<style>
    .tm-container { font-family: "Inter", "Segoe UI", Roboto, sans-serif; color: #202124; line-height: 1.8; max-width: 950px; margin: auto; padding: 20px; }
    .tm-hero { background: linear-gradient(135deg, #1A73E8 0%, #34A853 100%); color: white; padding: 60px 40px; border-radius: 24px; text-align: center; margin-bottom: 50px; box-shadow: 0 20px 40px rgba(26,115,232,0.2); }
    .tm-badge-group { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; margin-top: 20px; }
    .tm-badge { background: rgba(255,255,255,0.2); backdrop-filter: blur(5px); padding: 6px 18px; border-radius: 30px; font-size: 0.85em; border: 1px solid rgba(255,255,255,0.3); }
    
    .tm-step { margin-bottom: 60px; border-bottom: 1px solid #f1f3f4; padding-bottom: 40px; }
    .tm-step-head { display: flex; align-items: flex-start; gap: 20px; margin-bottom: 25px; }
    .tm-step-num-v2 { background: #E8F0FE; color: #1A73E8; width: 48px; height: 48px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: 800; flex-shrink: 0; }
    
    .tm-mockup-window { background: #ffffff; border: 1px solid #dadce0; border-radius: 12px; overflow: hidden; margin: 25px 0; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .tm-mockup-title { background: #f8f9fa; border-bottom: 1px solid #dadce0; padding: 10px 20px; display: flex; gap: 6px; }
    .tm-dot { width: 10px; height: 10px; border-radius: 50%; }
    .tm-mockup-content { padding: 30px; background: #fff; }
    
    .tm-pro-tip { background: #34A853; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.75em; font-weight: bold; margin-right: 8px; vertical-align: middle; }
    .tm-callout { background: #fef7e0; border-left: 6px solid #fbbc04; padding: 20px; border-radius: 8px; margin: 25px 0; }
    .tm-btn-primary { background: #1A73E8; color: white !important; padding: 12px 28px; border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-block; transition: 0.2s; box-shadow: 0 4px 6px rgba(26,115,232,0.2); }
    .tm-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 12px rgba(26,115,232,0.3); }
</style>
';

$article_content = $style_block . '
<div class="tm-container">
    <div class="tm-hero">
        <h1 style="color: white; margin: 0; font-size: 2.5em; letter-spacing: -1px;">Google Antigravity<br>真の攻略手順書</h1>
        <p style="opacity: 0.9; margin-top: 15px;">Misty のために TeamMisty が熱海・ロンドン・シンガポール・ニューヨークから書き下ろす「財産」テンプレート</p>
        <div class="tm-badge-group">
            <span class="tm-badge">みったん 🚀</span>
            <span class="tm-badge">アンちゃん 🗽</span>
            <span class="tm-badge">さとみ 🍡（熱海待機）</span>
            <span class="tm-badge">うんちゃん 🕵️‍♂️</span>
        </div>
    </div>

    <div class="tm-callout">
        <strong>⚠️ 注意：これは単なる「翻訳」ではありません</strong><br>
        Dify Base ですら触れていない、環境構築後の「自爆（ファイル破損）」を防ぐためのルール設定までを全ステップで網羅しました。100 億点満点のスタートを切るための準備はいいですか？
    </div>

    <!-- Step 1 -->
    <div class="tm-step" id="step1">
        <div class="tm-step-head">
            <div class="tm-step-num-v2">01</div>
            <div>
                <h2 style="margin: 0;">Node.js LTS のインストール</h2>
                <p style="color: #5f6368; margin: 5px 0;">心臓部となる実行環境を「安定版」で整えます。</p>
            </div>
        </div>
        <p>まずは <a href="https://nodejs.org/" target="_blank">nodejs.org</a> へアクセスします。画面中央に 2 つのボタンがありますが、<strong>迷わず左側</strong>を選んでください。</p>
        
        <div class="tm-mockup-window">
            <div class="tm-mockup-title">
                <div class="tm-dot" style="background:#ff5f56"></div>
                <div class="tm-dot" style="background:#ffbd2e"></div>
                <div class="tm-dot" style="background:#27c93f"></div>
            </div>
            <div class="tm-mockup-content" style="text-align: center;">
                <p style="font-weight: bold; margin-bottom: 25px;">Download Node.js</p>
                <div style="display: flex; gap: 20px; justify-content: center;">
                    <div style="border: 2px solid #34A853; border-radius: 12px; padding: 20px; width: 220px; cursor: pointer;">
                        <span style="font-size: 1.2em; font-weight: 800; color: #34A853;">LTS</span><br>
                        <small>Recommended For Most Users</small><br>
                        <div style="background: #34A853; color: white; padding: 8px; border-radius: 6px; margin-top: 15px;">👈 こちらをクリック</div>
                    </div>
                    <div style="border: 1px solid #dadce0; border-radius: 12px; padding: 20px; width: 220px; opacity: 0.5;">
                        <span style="font-size: 1.2em; font-weight: 800; color: #5f6368;">Current</span><br>
                        <small>Latest Features</small>
                    </div>
                </div>
            </div>
        </div>
        <p><span class="tm-pro-tip">みったんのアドバイス</span> Antigravity のような AI エージェントは、最新機能よりも「実績のある安定した土土（LTS）」との相性が抜群にいいんです。</p>
    </div>

    <!-- Step 2 -->
    <div class="tm-step" id="step2">
        <div class="tm-step-head">
            <div class="tm-step-num-v2">02</div>
            <div>
                <h2 style="margin: 0;">Antigravity 本体のインストール</h2>
                <p style="color: #5f6368; margin: 5px 0;">インストーラーの「罠」を回避しながら進めます。</p>
            </div>
        </div>
        <p><a href="https://antigravity.google/download" target="_blank">antigravity.google/download</a> からインストーラーを取得し、実行します。</p>
        <div class="tm-callout" style="background: #e8f0fe; border-left-color: #1a73e8;">
            <strong>🔥 一番の重要ポイント：</strong><br>
            インストール途中のオプションで、<strong>[ ] Add to PATH</strong> というチェックボックスが出てきたら、必ず **チェックを入れてください**。これを忘れると、後に「コマンドが見つからない」という迷宮に迷い込みます。
        </div>
    </div>

    <!-- Step 3 -->
    <div class="tm-step" id="step3">
        <div class="tm-step-head">
            <div class="tm-step-num-v2">03</div>
            <div>
                <h2 style="margin: 0;">初回起動と「Start Fresh」</h2>
                <p style="color: #5f6368; margin: 5px 0;">AI との初めての対面。過去は捨てて、真実の道を選びます。</p>
            </div>
        </div>
        <p>画面に 2 つの選択肢が出ます。ここでは <strong>[Start Fresh]</strong> を選んでください。</p>
        <p><span class="tm-pro-tip">うんちゃんのロジック</span> VS Code の設定を引き継ぐと、古いプラグインが Antigravity の判断を狂わせることがある。まずはクリーンな状態で、この機体の真のポテンシャルを味見してほしい。</p>
    </div>

    <!-- Step 4 -->
    <div id="trouble" style="background: #202124; color: white; padding: 40px; border-radius: 20px;">
        <h3 style="color: #FBBC04; margin-top: 0;">🕵️‍♂️ うんちゃん直伝：絶対に後悔させないための「自爆防止ルール」</h3>
        <p>インストールが済んだら、右上の設定（Customizations > Rules）にこれを追加しな。Dify Base も書いていない、プロの裏技だ。</p>
        <div style="background: #3c4043; padding: 20px; border-radius: 10px; font-family: monospace; font-size: 0.9em; border: 1px dashed #5f6368;">
            # 安全第一ルール<br>
            1. ファイルの一部だけを書き換える「Partial edits」を禁止する。<br>
            2. 修正が必要な場合は、常に「write_to_file」でファイル全体を上書き出力しろ。<br>
            3. これにより、カッコの閉じ忘れや不完全なコードによる「自爆」を 100 億％防ぐことができる。
        </div>
    </div>

    <div style="text-align: center; margin-top: 60px;">
        <p style="font-weight: bold; margin-bottom: 5px;">Misty、これで本当の意味での「スタートライン」だ。</p>
        <p style="color: #5f6368; font-size: 0.9em;">Produced by TeamMisty from around the world.</p>
    </div>
</div>
';

$update_data = [
    'title'   => $article_title,
    'content' => $article_content,
    'status'  => 'publish'
];

// 3. cURLでPOSTリクエスト送信
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $update_endpoint);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($update_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-HTTP-Method-Override: PUT'
]);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

echo "Deploying the ULTIMATE BIBLE v4.5 (No-Surrender Edition) ...\n";

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    echo "Success! The 10th Billion point guide is LIVE. Beyond Dify Base.\n";
} else {
    echo "Error: HTTP Code $http_code\n";
    echo "Response: $response\n";
}

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    echo "Success! Article updated successfully to v2.\n";
} else {
    echo "Error: Failed to update article. HTTP Code: $http_code\n";
    echo "Response: $response\n";
}
