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

// 2. 強化版の記事データ (v2)
$article_title = "Antigravityのインストール手順：初心者向け完全ガイド";
$article_content = '
<p>Antigravityへようこそ！この記事では、初めての方でも迷わずにインストールを完了できるよう、詳細な手順とおすすめの設定を解説します。</p>

<h2>1. Node.js (LTS推奨) の準備</h2>
<p>Antigravityを動かす「エンジン」として、<strong>Node.js</strong>が必要です。</p>
<ul>
    <li><strong>LTSとは？</strong>：「Long Term Support」の略で、長期間サポートされる「安定版」のことです。最新機能よりも安定性を重視するため、初心者の方にはLTS版を強く推奨します。</li>
    <li><strong>入手方法</strong>：<a href="https://nodejs.org/" target="_blank">nodejs.org</a> にアクセスし、左側に表示される「LTS」と書かれたボタンをクリックしてインストーラーをダウンロードしてください。</li>
</ul>

<h2>2. 秘密の鍵：セットアップ時の推奨選択</h2>
<p>Node.jsやGitのインストール中、英語の画面がいくつか出てきます。「Next」をポチポチ押すだけで基本はOKですが、以下の点だけは確認してください！</p>

<h3>重要なチェックポイント（重要項目）</h3>
<table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
    <tr style="background-color: #f2f2f2;">
        <th style="padding: 10px; border: 1px solid #ddd;">英語の表示</th>
        <th style="padding: 10px; border: 1px solid #ddd;">日本語の意味</th>
        <th style="padding: 10px; border: 1px solid #ddd;">おすすめ</th>
    </tr>
    <tr>
        <td style="padding: 10px; border: 1px solid #ddd;">Destination Folder</td>
        <td style="padding: 10px; border: 1px solid #ddd;">インストール先フォルダ</td>
        <td style="padding: 10px; border: 1px solid #ddd;">デフォルトのままでOK</td>
    </tr>
    <tr>
        <td style="padding: 10px; border: 1px solid #ddd;"><strong>Add to PATH</strong></td>
        <td style="padding: 10px; border: 1px solid #ddd;">環境変数にパスを通す</td>
        <td style="padding: 10px; border: 1px solid #ddd;"><strong>必ずチェックをONにする</strong></td>
    </tr>
    <tr>
        <td style="padding: 10px; border: 1px solid #ddd;">Custom Setup</td>
        <td style="padding: 10px; border: 1px solid #ddd;">カスタムセットアップ</td>
        <td style="padding: 10px; border: 1px solid #ddd;">全て選択された状態でNext</td>
    </tr>
</table>
<p><small>※「Add to PATH」を忘れると、コマンドを使おうとした時に「そんなコマンドはないよ！」とエラーが出てしまうので注意が必要です。</small></p>

<h2>3. インストール後の最初の一歩</h2>
<p>環境が整ったら、以下のコマンドをターミナルで入力して、正しくインストールされたか確認しましょう：</p>
<pre style="background: #333; color: #fff; padding: 10px; border-radius: 5px;"><code>node -v</code></pre>
<p>バージョン番号（例：v22.14.0）が表示されれば成功です！</p>

<h2>4. おすすめの初期設定</h2>
<p>インストールが完了したら、私たちの個性を設定してあげてください。</p>
<ul>
    <li><strong>エージェント名</strong>：みったん、アンちゃん、さとみ、うんちゃん...好きな名前をつけてくださいね。</li>
    <li><strong>セキュリティ</strong>：<code>.gitignore</code> を使って、機密情報を守る設定を忘れずに。</li>
</ul>

<p>これであなたのPCに、Antigravityが宿りました。一緒に素晴らしい未来を作りましょう！</p>
';

$update_data = [
    'title'   => $article_title,
    'content' => $article_content
];

// 3. cURLでPOSTリクエスト送信 (Method Tunnelingで更新)
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $update_endpoint);
curl_setopt($ch, CURLOPT_POST, true); // POSTを使用
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($update_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-HTTP-Method-Override: PUT' // 実際にはPUTとして扱わせる
]);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

echo "Updating article ID $post_id (using Method Tunneling): $article_title ...\n";

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code === 200) {
    echo "Success! Article updated successfully to v2.\n";
} else {
    echo "Error: Failed to update article. HTTP Code: $http_code\n";
    echo "Response: $response\n";
}
