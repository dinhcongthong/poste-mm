@extends('www.pages.job-searching.master')

@section('jobsearching-content')
<h3 class="title">削除・変更 </h3>
<p class="text-center p-alert">
    ＊投稿の内容を確認し、POSTE運営事務局の判断により不適切と判断した場合は投稿を承認しない場合がございますのでご了承ください＊
</p>
<div id="data-table">
    @include('www.pages.job-searching.list-table')
</div>
@endsection