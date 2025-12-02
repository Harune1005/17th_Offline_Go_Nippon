<?php

return [
    // register
    'register' => [
        'title' => 'アカウント作成',
        'name' => '氏名',
        'name_placeholder' => '氏名を入力してください',
        'name_error' => '氏名を入力してください。',
        'email' => 'メールアドレス',
        'email_placeholder' => 'メールアドレスを入力してください',
        'email_error' => 'メールアドレスを入力してください。',
        'country' => '国',
        'country_placeholder' => '国を選択してください',
        'password' => 'パスワード',
        'password_placeholder' => 'パスワードを入力してください',
        'password_error' => 'パスワードを入力してください。',
        'password_confirm' => 'パスワード確認',
        'password_confirm_placeholder' => 'パスワードを再入力してください',
        'submit' => '登録',
        'submit_google' => 'Googleでログイン',
        'to_signin' => 'すでにアカウントをお持ちの場合',
        'signin' => 'ログイン',
    ],

    // login
    'login' => [
        'title' => 'ログイン',
        'message_1' => 'おかえりなさい!',
        'message_2' => '引き続きご利用いただくために、ログインしてください。',
        'email' => 'メールアドレス',
        'email_placeholder' => 'メールアドレスを入力してください',
        'email_error' => 'メールアドレスが正しくない可能性があります。',
        'password' => 'パスワード',
        'password_placeholder' => 'パスワード',
        'password_error' => 'パスワードが正しくない可能性があります。',
        'submit' => 'ログイン',
        'submit_google' => 'Googleでログイン',
        'to_signup' => 'アカウントをお持ちでない場合',
        'signup' => '新規登録',
    ],

    // verify-email
    'verify_email' => [
        'title' => 'メールアドレス認証',
        'text' => '認証リンクをメールで確認してください',
        'text_2' => 'メールが届かない方はこちら',
        'request' => '再送信する',
    ],

    // select-interest
    'interest' => [
        'title' => '最大3つのカテゴリーを選択してください',
        'save' => '保存',
    ],

    // home
    'home' => [
        'search_placeholder' => '検索する',
        'prefecture' => '都道府県',
        'prefecture_placeholder' => '選択する',
        'category' => 'カテゴリー',
        'category_placeholder' => '選択する',
        'search' => '検索',
        'category_ranking_title' => 'カテゴリーランキング',
        'prefecture_ranking_title' => '都道府県ランキング',
        'sort_1' => '最新',
        'sort_2' => 'いいね数',
        'sort_3' => 'おすすめ',
        'sort_4' => 'フォロー中',
    ],

    // header
    'header' => [
        'create_post' => '投稿作成',
        'messages' => 'メッセージ',
        'favorite_post' => 'お気に入り投稿',
        'notification' => ' 通知',
        'analytics' => '分析',
        'logout' => 'ログアウト',
        'admin' => '管理',
        'profile' => 'プロフィール',
    ],

    // admin
    // user
    'user' => [
        'user' => 'ユーザー',
        'post' => 'ポスト',
        'category' => 'カテゴリー',
        'search_placeholder' => '名前で検索する',
        'search' => '検索',
        'avatar' => 'アバター',
        'name' => '名前',
        'country' => '国',
        'email' => 'メールアドレス',
        'created_at' => '作成日時',
        'status' => '状態',
        'active' => '有効',
        'deactive' => '無効',
        'a_modal_title' => 'ユーザーを有効化',
        'a_modal_text' => '本当にこのユーザーを有効にしますか',
        'cancel' => 'キャンセル',
        'activate' => '有効',
        'd_modal_title' => 'ユーザーを無効化',
        'd_modal_text' => '本当にこのユーザーを無効にしますか',
        'cancel' => 'キャンセル',
        'deactivate' => '無効',
    ],

    // post
    'post' => [

    ],

    // category
    'category' => [
        'placeholder' => 'カテゴリーを追加する',
        'add' => '追加',
        'name' => '名前',
        'count' => 'カウント',
        'update' => '最終更新日',
        'action' => '操作',
        'modal_title1' => 'カテゴリー編集',
        'modal_title2' => 'カテゴリー削除',
        'cancel' => 'キャンセル',
        'edit' => '編集',
        'delete' => '削除',
        'delete_text' => '本当にこのカテゴリーを削除しますか？',
    ],

    // show post
    'show_post' => [
        'edit' => '編集',
        'delete' => '削除',
        'currentry' => '¥',
        'hour' => '時間',
        'min' => '分',
        'comment_placeholder' => 'コメントを追加する',
        'no_comment' => 'コメントがまだありません。',
    ],

    // create post
    'create_post' => [
        'main_title' => 'ポスト作成',
        'title' => 'タイトル',
        'description' => '説明',
        'date' => '日程',
        'time' => '所要時間',
        'hour' => '時間',
        'min' => '分',
        'categories' => 'カテゴリー(最大3つ)',
        'prefecture' => '都道府県',
        'prefecture_placeholder' => '都道府県を選択',
        'cost' => '値段',
        '$' => '¥',
        'image' => '写真+動画(最大3つ)',
        'add' => '+ 追加',
        'cancel' => 'キャンセル',
        'button' => '投稿',
    ],

    // edit post
    'edit_post' => [
        'main_title' => 'ポスト編集',
        'title' => 'タイトル',
        'description' => '説明',
        'date' => '日程',
        'time' => '所要時間',
        'hour' => '時間',
        'min' => '分',
        'categories' => 'カテゴリー(最大3つ)',
        'prefecture' => '都道府県',
        'prefecture_placeholder' => '都道府県を選択',
        'cost' => '値段',
        '$' => '¥',
        'image' => '写真+動画(最大3つ)',
        'add' => '+ 追加',
        'cancel' => 'キャンセル',
        'button' => '更新',
    ],

    // favorite post
    'favorite' => [
        'search_placeholder' => '検索する',
        'prefecture' => '都道府県',
        'prefecture_placeholder' => '選択する',
        'category' => 'カテゴリー',
        'category_placeholder' => '選択する',
        'search' => '検索',
        'sort_1' => '最新',
        'sort_2' => '最古',
        'sort_3' => 'いいね数',
    ],

    // analytics
    'analytics' => [
        'title_1' => '~ 閲覧数 ~',
        'followers' => 'フォロワー',
        'non-followers' => '非フォロワー',
        'subtitle_1' => 'トップ投稿',
        'subtitle_2' => 'プロフィールアクティビティ',
        'visit' => 'プロフィール訪問数:',

        'title_2' => '~ 関心 ~',
        'subtitle_3' => '関心別',
        'like' => 'いいね:',
        'comment' => 'コメント:',
        'favorite' => 'お気に入り:',

        'title_3' => '~ フォロワー ~',
        'subtitle_4' => 'フォロワー推移',
        'subtitle_5' => '上位の国',
        'percent' => '% vs 前月',
    ],

    // profile
    'profile' => [
        'posts' => '投稿',
        'followers' => 'フォロワー',
        'following' => 'フォロー',
        'country' => '国名: ',
        'left_btn' => 'プロフィール編集',
        'right_btn' => 'お気に入り投稿一覧',
        'map_title1' => 'マップをクリック！',
        'map_title2' => '',
        'completed' => '達成！',
        'prefecture' => '都道府県',
        'following2' => 'フォロー中',
        'follow' => 'フォロー',
        'dm' => 'メッセージ',
        'no_post' => 'まだ投稿がありません',
    ],

    // follow following
    'follow' => [
        'search' => 'ユーザーを検索する',
        'btn' => '検索',
        'follower' => 'フォロワー',
        'following' => 'フォロー中',
        'follow' => 'フォロー',
        'recommend' => 'おすすめユーザー',
    ],

    // edit profile
    'edit_profile' => [
        'title' => 'プロフィール編集',
        'formats' => '対応形式: jpeg, jpg, png, gif',
        'size' => '最大ファイルサイズ: 1048Kb',
        'name' => '名前',
        'email' => 'メールアドレス',
        'country' => '国',
        'introduction' => '自己紹介',
        'interest' => '興味',
        'interest_sub' => '(最大3つまで)',
        'password' => 'パスワード変更',
        'password_placeholder' => '現在のパスワード',
        'new_password_placeholder' => '新しいパスワード',
        'confirm_password_placeholder' => '新しいパスワードの再確認',
        'cancel' => 'キャンセル',
        'save' => '保存',
    ],

    // map
    'map' => [
        'map_title1' => '都道府県をクリック！',
        'map_title2' => '',
        'completed' => '達成！',
        'prefecture' => '都道府県',
    ],

    // notification
    'notification' => [
        'title' => '通知一覧',
        'like_text' => 'があなたの投稿をいいねしました',
    ],

    // dm
    'dm' => [
        'title' => 'チャット',
        'search_placeholder' => 'ユーザーを検索する',
        'search' => '検索',
        'add_modal_title' => 'メッセージを送る相手を選択',
        'message' => 'メッセージ',
        'no_active' => 'アクティブな会話はありません',
        'text_1' => '会話を選択してチャットを開始してください。',
        'message_placeholder' => 'メッセージを入力',
        'send' => '送信',
        'delete' => '削除',
        'read' => '既読',
        'no_user' => 'ユーザーがいません',
    ],
];
