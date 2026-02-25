<?php
/**
 * reposition_section_mittan.php
 * 「4. Configure Your Editor」をステップ2の画像の直後、ステップ3の直前に移動する
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;
$title = "Antigravityのインストール・初期設定手順";

// 元のバックアップ（一番不純物のない状態）から再スタート
$base_content = file_get_contents(__DIR__ . '/backup_1953.txt');

// 1. タイトルは「3つの初期設定」のままにする（元の意志を尊重）
$updated_content = $base_content;

// 2. 差し込むセクションを H4 として作成
$section_h4 = '
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
    <li><strong>Command Line（起動ツール）</strong>: パソコンの黒い画面（ターミナル）から、パパっとコマンド一つでAntigravityを呼び出せるようにする魔法の設定や。
        <ul>
            <li><strong>Install</strong>: ここはチェックを入れたままにするのが正解やで。</li>
        </ul>
    </li>
</ul>
<p>全部の設定を確認したら、右下の<strong>「Next」</strong>ボタンをはんなりとクリックして次へ進もか！🚀</p>
';

// 3. 挿入位置： 「3. 日本語化の手順」の直前
$search_mark = '<h4>3. 日本語化の手順</h4>';
$parts = explode($search_mark, $updated_content);

if (count($parts) === 2) {
    // ステップ3のヘッダーの直前に差し込む
    $updated_content = $parts[0] . $section_h4 . $search_mark . $parts[1];
    echo "Inserted section 4 at the ideal position (before step 3).\n";
} else {
    echo "Fatal Error: Step 3 anchor not found!\n";
    exit(1);
}

echo "Updating article ID: $post_id to reposition section...\n";

$post_data = [
    'title'   => $title,
    'content' => $updated_content,
    'status'  => 'publish'
];

$result = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($result['code'] === 200) {
    echo "Success! Article repositioned.\n";
} else {
    echo "Error: " . $result['code'] . "\n" . $result['raw'] . "\n";
}
