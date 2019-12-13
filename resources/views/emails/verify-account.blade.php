POSTEユーザー登録<br/>
POSTE ご利用頂き誠に有難うございました。<br/><br/>

▼ 登録内容 (Registration contents)<br/>
● お名前: {{ $name }}<br/>
{{-- ● フリガナ: {{ $kataName }}<br/> --}}
● Birthday: {{ $birthday }}<br/>
● Gender: {{ $gender }}<br/>
● Phone number: {{ $phone }}<br/>

以下のリンクをアクセスすると会員の本登録となります。<br/><br/>
<a href="{{ route('get_active_account', ['token' => $token]) }}">Click here to active account</a><br/><br/>


▼ ご利用案内<br/>

ログイン方法<br/>
【１】POSTEへアクセスされた後、各「POSTE」ページ右上にある情報を入力しをログイン」ボタンを押してください。<br/>
【２】これでログインは完了です。<br/>
【３】POSTEのTOPページ右上にログイン情報が表示されている事を確認ください。<br/>
