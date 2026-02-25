<?php
/**
 * final_fix_mittan.php
 * 「④ Configure Your Editor」を「ステップ2」の4つ目の項目として綺麗に取り込む
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;
$title = "Antigravityのインストール・初期設定手順";

// 元のバックアップ（一番不純物のない状態）から再スタート
$base_content = file_get_contents(__DIR__ . '/backup_1953.txt');

// 1. 「3つの初期設定」→「4つの初期設定」に書き換え
$updated_content = str_replace('3つの初期設定', '4つの初期設定', $base_content);

// 2. ④ 項目を作成（ミッタン口調）
$section_item_4 = '
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

// 3. 挿入位置を探す。Agent設定（③）の </li> の直後に入れたい。
// Original では </li> が 64行目あたり。</ul> の直前。
$search_mark = '右側もわからんかったらデフォルトのままでOKやで！</p>
</li>';

if (strpos($updated_content, $search_mark) !== false) {
    $updated_content = str_replace($search_mark, $search_mark . $section_item_4, $updated_content);
} else {
    // もし見つからなかったら、</ul> の直前に挿入するフォールバック
    $ul_end_mark = '</ul>
<p><img decoding="async" src="https://infinityai.mistystark.com/wp-content/uploads/2026/02/0050_Agent_fixed.png"';
    $updated_content = str_replace($ul_end_mark, $section_item_4 . $ul_end_mark, $updated_content);
}

echo "Updating article ID: $post_id with integrated section 4...\n";

$post_data = [
    'title'   => $title,
    'content' => $updated_content,
    'status'  => 'publish'
];

$result = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($result['code'] === 200) {
    echo "\n" . str_repeat('=', 40) . "\n";
    echo "🍵 Success! Integrated section 4 into step 2.\n";
    echo "Link: " . $result['body']['link'] . "\n";
    echo str_repeat('=', 40) . "\n";
} else {
    echo "Error updating article. Code: {$result['code']}\n";
    echo "Response: {$result['raw']}\n";
}
