<?php
/**
 * post_article.php
 * WordPressに新しい記事を投稿するスクリプト
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

// WordPress REST API (posts) の投稿用エンドポイントを構築
$posts_endpoint = str_replace('/mcp/v1', '/wp/v2/posts', $api_url);

// 2. 記事データを作成
$article_title = "Antigravityのインストール手順";
$article_content = '
<h2>Antigravityとは？</h2>
<p>Antigravityは、Misty Starlit（ミスティ）によって設計された、強力なエージェントAIです。技術開発、戦略立案、そして問題解決をサポートする「チーム・ミスティ」の中核として活動しています。</p>

<h2>ステップ1：インストールの準備</h2>
<p>Antigravityをローカル環境で動作させるためには、以下の環境が必要です：</p>
<ul>
    <li>Node.js (LTS推奨)</li>
    <li>Git</li>
    <li>PHP実行環境 (REST API連携用)</li>
</ul>

<h2>ステップ2：Antigravityの導入</h2>
<p>プロジェクトディレクトリで以下の手順を実行します：</p>
<ol>
    <li>リポジトリを同期し、ワークスペースを作成します。</li>
    <li><code>mcp-servers.json</code> を作成し、WordPress APIの資格情報を設定します。</li>
    <li><code>git init</code> でバージョン管理を開始します。</li>
</ol>

<h2>ステップ3：インストール後にやっておくべき設定</h2>
<p>インストールが完了したら、以下の設定を行うことを推奨します：</p>
<ul>
    <li><strong>アイデンティティ設定</strong>：エージェントの個性や役割（名探偵アンちゃん、マスターエンジニアみったん等）を定義します。</li>
    <li><strong>.gitignoreの設定</strong>：パスワードが含まれる <code>mcp-servers.json</code> をGitの追跡から除外します。</li>
    <li><strong>ダッシュボードの構築</strong>：ミッションの進捗を確認できるHTML/JSベースの環境を整えます。</li>
</ul>

<p>これで準備は完了です。面白いものをたくさん作っていきましょう！</p>
';

$post_data = [
    'title'   => $article_title,
    'content' => $article_content,
    'status'  => 'publish' // 公開状態で投稿
];

// 3. cURLでPOSTリクエスト送信
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $posts_endpoint);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

echo "Posting article: $article_title ...\n";

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 201) {
    $result = json_decode($response, true);
    echo "Success! Article posted successfully.\n";
    echo "Post ID: " . $result['id'] . "\n";
    echo "Link:    " . $result['link'] . "\n";
} else {
    echo "Error: Failed to post article. HTTP Code: $http_code\n";
    echo "Response: $response\n";
}
