<?php
/**
 * harmonize_baseline.php
 * アーティクルの構造を「究極のベースライン」として美しく整える
 */

require_once __DIR__ . '/config.php';

$post_id = 1953;
$title = "Antigravityのインストール・初期設定手順";

// 各セクションの画像URL（固定されているものを流用）
$image_urls = [
    '0010' => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0010_Antigravity_bordered.png',
    '0020' => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0020_Download_bordered.png',
    '0030' => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0030_ChooseSetupFlow_v2_fixed.png',
    '0040' => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0040_Theme_fixed.png',
    '0050' => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/0050_Agent_fixed.png',
    '0060' => 'https://infinityai.mistystark.com/wp-content/uploads/2026/02/060_ConfigureYourEditor.jpg'
];

// 究極のHTML構造（ミッタン口調 100億点満点バージョン）
$html = '
<p>Antigravity へようこそ！<br />AI と一緒に最高の未来を創るための、最初の一歩をはんなりと案内するで。🍵</p>

<h4>1. ダウンロードとインストール</h4>
<p>まずは公式サイト <a href="https://antigravity.google" target="_blank">https://antigravity.google</a> にアクセスしてな。</p>
<div style="text-align: center; margin: 20px 0;">
    <img src="'.$image_urls['0010'].'" alt="Antigravity Official Site" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
</div>

<ul>
    <li><strong>自分のPCに合ったものを選ぼう</strong>:
        <ul>
            <li>Mac の人は「リンゴマーク」からチップを確認（M1〜M4 なら Apple Silicon）。</li>
            <li>Windows の人は「x64」を選べば 100 億点満点や。</li>
        </ul>
    </li>
    <li><strong>上書きが基本！</strong>: 古いバージョンを持ってる人も、そのまま上書きインストールしてな。アンインストールは不要やで。</li>
</ul>
<div style="text-align: center; margin: 20px 0;">
    <img src="'.$image_urls['0020'].'" alt="Download Antigravity" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
</div>

<h4>2. 初心者が迷わない「4つの初期設定」</h4>
<p>起動した後の英語画面、これを選べば間違いなしや！</p>

<ul>
    <li><strong>① Choose setup flow</strong>:
        <p>ここは、迷わず <strong>『Start fresh』</strong> を選んでな。まっさらな状態で始めるのが一番スムーズや。</p>
        <ul style="font-size: 0.9em; color: #666;">
            <li><strong>Start fresh</strong>: まっさらな状態で新しくセットアップを始める（おすすめ度 100 億点満点！）</li>
            <li><strong>Import from...</strong>: 他のエディターの設定を引き継ぐモードや。</li>
        </ul>
        <div style="text-align: center; margin: 20px 0;">
            <img src="'.$image_urls['0030'].'" alt="Choose setup flow" style="max-width: 100%; border-radius: 8px;">
        </div>
    </li>
    
    <li><strong>② Theme</strong>: 好きなんでええけど、おすすめは <strong>『Tokyo Night』</strong>。未来的でテンション上がるで！
        <div style="text-align: center; margin: 20px 0;">
            <img src="'.$image_urls['0040'].'" alt="Choose theme" style="max-width: 100%; border-radius: 8px;">
        </div>
    </li>
    
    <li><strong>③ Agent設定</strong>:
        <p>ここはわからなければ <strong>『Review-driven development』</strong> を選択してな。AI が勝手に動く前に確認してくれるように促してくれるから、安心感が 100 億点満点や。右側の設定もわからんかったらデフォルトのままでOKやで！🍵</p>
        <div style="text-align: center; margin: 20px 0;">
            <img src="'.$image_urls['0050'].'" alt="Agent settings" style="max-width: 100%; border-radius: 8px;">
        </div>
    </li>
    
    <li><strong>④ Configure Your Editor（エディターの詳細設定やで）</strong>:
        <p>基本的にはデフォルトのままで「Next」をポチッと押せば問題あらへんけど、それぞれの意味をはんなりと説明しておくわな。</p>
        <ul>
            <li><strong>Keybindings</strong>: <strong>Normal</strong>（おすすめ度100億点満点！）を選んでな。</li>
            <li><strong>Extensions</strong>: <strong>Install 7 Extensions</strong> で、AIをもっと賢くしてあげよ。</li>
            <li><strong>Command Line</strong>: <strong>Install</strong> にチェックを入れて、ターミナルからも呼べるようにしよな。</li>
        </ul>
        <p>全部の設定を確認したら、右下の<strong>「Next」</strong>ボタンをはんなりとクリックして次へ進もか！🚀</p>
        <div style="text-align: center; margin: 20px 0;">
            <img src="'.$image_urls['0060'].'" alt="Configure Your Editor" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        </div>
    </li>
</ul>

<h4>3. 日本語化の手順</h4>
<p>やっぱり日本語が一番落ち着くもんな。🍵</p>
<ol>
    <li>左側の「四角いアイコン（Extensions）」を押す。</li>
    <li>「<strong>Japanese</strong>」で検索して、地球儀のアイコンのものを Install。</li>
    <li>右下の「Restart」ボタンを押せば、はんなりとした日本語画面の完成や！</li>
</ol>

<hr>
<p>これだけで、君の PC は最新前線の AI 開発基地に早変わりや。<br />Misty と一緒に、最高の大発見を見つけにいこな！🍵✨</p>
';

echo "Harmonizing article ID: $post_id to create the Perfect Baseline...\n";

$post_data = [
    'title'   => $title,
    'content' => $html,
    'status'  => 'publish'
];

$result = wp_api_request("/posts/$post_id", 'POST', $post_data);

if ($result['code'] === 200) {
    echo "========================================\n";
    echo "🍵 Baseline Harmonized! 100-Billion Points! ✨\n";
    echo "Link: " . $result['body']['link'] . "\n";
    echo "========================================\n";
} else {
    echo "Error: " . $result['code'] . "\n" . $result['raw'] . "\n";
}
