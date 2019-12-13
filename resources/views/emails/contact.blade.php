お名前: {{ $name }}<br/>
@isset($company)
会社名前: {{ $company }}<br/>
@endisset
電話番号: {{ $phone }}<br/>
メールアドレス: {{ $email }}<br/>
--------------------------------------<br/><br/>
お問合せ内容:<br/>
{{ $content }}