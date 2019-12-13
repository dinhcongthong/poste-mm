
パスワードをりセットするためにリンク先のフォームを埋めてください： {{ URL::to('/password/reset/'.$token) }}.<br/>
このリンクは{{ Config::get('auth.reminder.expire', 60) }}分間のみ有効です。
