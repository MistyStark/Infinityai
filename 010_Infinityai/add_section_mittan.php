<?php
/**
 * add_section_mittan.php
 * ミッタン流に「④ Configure Your Editor」セクションを追加する
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;
$title = "Antigravityのインストール・初期設定手順";

// 元のコンテンツを取得
$original_content = file_get_contents(__DIR__ . '/backup_1953.txt');

// 挿入する新しいセクション（ミッタン口調）
$new_section = '
<li><strong>④ Configure Your Editor（エディターの詳細設定やで）</strong>:
<p>基本的にはデフォルトのままで「Next」をポチッと押せば問題あらへんけど、それぞれの意味をはんなりと説明しておくわな。🍵</p>
<ul>
    <li><strong>Keybindings（キー操作のモード）</strong>: 文字入力や操作のスタイルをどないするか決めるんや。
        <p><strong>Normal（おすすめ度100億点満点！）</strong>: いつものVS Codeと同じような感覚で使える画面や。迷わずこれを選んでな。</p>
        <p><strong>Vim</strong>: これはエンジニア特有の、ちょっと特殊なキー操作モードや。自信がない人は避けたほうが無難やで。</p>
    </li>
    <li><strong>Extensions（拡張機能のインストール）</strong>: Antigravityをもっと便利に使いこなすための、秘密の道具セットや！
        <p><strong>Install 7 Extensions</strong>: Pythonとか主要なプログラミング言語に対応するための機能が自動で入るんや。これでAIがもっと賢く、正確に動いてくれるようになるで。</p>
    </li>
    <li><strong>Command Line（起動ツールのインストール）</strong>: パソコンの黒い画面（ターミナル）から、パパっとコマンド一つでAntigravityを呼び出せるようにする魔法の設定や。
        <p><strong>Install</strong>: ここはチェックを入れたままにするのが正解やで。</p>
    </li>
</ul>
<p>全部の設定を確認したら、右下の<strong>「Next」</strong>ボタンをはんなりとクリックして次へ進もか！🚀</p>
</li>
';

$search_mark = '<h4>3. 日本語化の手順</h4>';
$split_content = explode($search_mark, $original_content);

if (count($split_content) === 2) {
    $before_3 = $split_content[0];
    $after_3 = $split_content[1];
    
    // 最後の </ul> の手前（初期設定リストの中）に挿入する
    $last_ul_pos = strrpos($before_3, '</ul>');
    if ($last_ul_pos !== false) {
        $updated_content = substr($before_3, 0, $last_ul_pos) . $new_section . substr($before_3, $last_ul_pos) . $search_mark . $after_3;
    } else {
        $updated_content = $before_3 . $new_section . $search_mark . $after_3;
    }
} else {
    echo "Error: Could not find anchor heading.\n";
    exit(1);
}

echo "Updating article ID: $post_id with Mittan's new section...\n";

$post_data = [
    'title'   => $title,
    'content' => $updated_content,
    'status'  => 'publish'
];

$result = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($result['code'] === 200) {
    echo "\n" . str_repeat('=', 40) . "\n";
    echo "🍵 Success! Mittan has added the new section.\n";
    echo "Link: " . $result['body']['link'] . "\n";
    echo str_repeat('=', 40) . "\n";
} else {
    echo "Error updating article. Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
