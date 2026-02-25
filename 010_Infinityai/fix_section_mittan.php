<?php
/**
 * fix_section_mittan.php
 * 「4. Configure Your Editor」を独立した h4 セクションとして追加し直す
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;
$title = "Antigravityのインストール・初期設定手順";

// 元のバックアップ（追加前の状態）から再スタート
$base_content = file_get_contents(__DIR__ . '/backup_1953.txt');

// ミッタン流の新しいセクション（H4形式）
$new_section_h4 = '
<h4>4. Configure Your Editor（エディターの詳細設定やで）</h4>
<p>基本的にはデフォルトのままで「Next」をポチッと押せば問題あらへんけど、それぞれの意味をはんなりと説明しておくわな。🍵</p>
<ul>
    <li><strong>Keybindings（キー操作のモード）</strong>: 文字入力や操作のスタイルをどないするか決めるんや。
        <ul>
            <li><strong>Normal（おすすめ度100億点満点！）</strong>: いつものVS Codeと同じような感覚で使える画面や。迷わずこれを選んでな。</li>
            <li><strong>Vim</strong>: これはエンジニア特有の、ちょっと特殊なキー操作モードや。自信がない人は避けたほうが無難やで。</li>
        </ul>
    </li>
    <li><strong>Extensions（拡張機能のインストール）</strong>: Antigravityをもっと便利に使いこなすための、秘密の道具セットや！
        <ul>
            <li><strong>Install 7 Extensions</strong>: Pythonとか主要なプログラミング言語に対応するための機能が自動で入るんや。これでAIがもっと賢く、正確に動いてくれるようになるで。</li>
        </ul>
    </li>
    <li><strong>Command Line（起動ツールのインストール）</strong>: パソコンの黒い画面（ターミナル）から、パパっとコマンド一つでAntigravityを呼び出せるようにする魔法の設定や。
        <ul>
            <li><strong>Install</strong>: ここはチェックを入れたままにするのが正解やで。</li>
        </ul>
    </li>
</ul>
<p>全部の設定を確認したら、右下の<strong>「Next」</strong>ボタンをはんなりとクリックして次へ進もか！🚀</p>
';

$search_mark = '<h4>3. 日本語化の手順</h4>';
$split_content = explode($search_mark, $base_content);

if (count($split_content) === 2) {
    // 3. の直前に挿入
    $updated_content = $split_content[0] . $new_section_h4 . $search_mark . $split_content[1];
} else {
    echo "Error: Could not find anchor heading.\n";
    exit(1);
}

echo "Updating article ID: $post_id with clearer H4 section...\n";

$post_data = [
    'title'   => $title,
    'content' => $updated_content,
    'status'  => 'publish'
];

$result = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($result['code'] === 200) {
    echo "\n" . str_repeat('=', 40) . "\n";
    echo "🍵 Success! Section 4 is now a proper H4 section.\n";
    echo "Link: " . $result['body']['link'] . "\n";
    echo str_repeat('=', 40) . "\n";
} else {
    echo "Error updating article. Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
