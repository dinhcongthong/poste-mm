<form class="p-2 p-xl-3" id="ajax-form-login" action="{{ route('post_login') }}" method="POST">
    <input type="hidden" name="previous_url" value="{{ URL::current() }}">
    <input type="hidden" name="remember" value="1">
    @csrf
    <div class="form-row flex-nowrap mr-0">
        <div class="form-group col-8 m-0 pr-1 pr-lg-2">
            <input type="email" class="form-control mb-1 mb-lg-2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" name="email">
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
        </div>
        <button type="submit" class="btn btn-secondary btn-sm btn-block fw-bold text-truncate">ログイン</button>
    </div>
</form>
<a href="{{ route('register') }}" class="btn btn-danger btn-block text-truncate">新規登録はこちらから</a>
