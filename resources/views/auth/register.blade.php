@extends('www.layouts.master')

@section('stylesheets')
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>
    .bootstrap-datetimepicker-widget {
        z-index: 1220;
    }
</style>
@endsection

@section('content')
    <div class="container bg-white py-4">
        <div class="col-12 col-lg-8 offset-lg-2">
            <h2 class="border border-left-0 border-right-0 border-top-0 border-dark">会員登録画面</h2>

            <form action="{{ route('post_register') }}" method="POST">
                @csrf

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 w-100">
                            @foreach ($errors->all() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-light py-3 border border-light px-2 mb-4">

                    <div class="form-group row">
                        <label class="col-12 col-md-3 col-form-label text-right font-weight-bold">お名前<br/><small>(Name)</small></label>
                        <div class="col-12 col-md-9">
                            <input class="form-control" name="name" value="{{ $name }}" placeholder="" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-md-3 col-form-label text-right font-weight-bold">生年月日<br/><small>(Date of birth)</small></label>
                        <div class="col-12 col-md-9">
                            <input class="form-control" name="birthday" value="{{ $birthday }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-md-3 col-form-label text-right font-weight-bold">性別<br/><small>(Gender)</small></label>
                        <div class="col-12 col-md-9">
                            <select class="form-control select2-no-search" name="gender_id" required>
                                @foreach ($genderList as $item)
                                    <option value="{{ $item->id }}" {{ $genderId == $item->id ? 'selected' : '' }}>{{ $item->value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-md-3 col-form-label text-right font-weight-bold">メールアドレス<br/><small>(Email)</small></label>
                        <div class="col-12 col-md-9">
                            <input class="form-control" name="email" type="email" value="{{ $email }}" required>
                            <small>ここに登録されるメールアドレスは生活情報コンテンツを利用の際に必要となります。</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-md-3 col-form-label text-right font-weight-bold">パスワード<br/><small>(Password)</small></label>
                        <div class="col-12 col-md-9">
                            <input class="form-control" name="password" type="password" required>
                            <small>パスワードは必ず半角英数字５文字以上でお願いします。 </small>
                        </div>
                    </div>
                    <div class="form-group m-0 row">
                        <label class="col-12 col-md-3 col-form-label text-right font-weight-bold">パスワード（確認）<br/><small>(Confirm Password)</small></label>
                        <div class="col-12 col-md-9">
                            <input class="form-control" name="password_confirmation" type="password" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12 col-md-3 col-form-label text-right font-weight-bold">電話番号<br/><small>(Phone number)</small></label>
                        <div class="col-12 col-md-9">
                            <input class="form-control" name="phone" type="text" value="{{ $phone }}" required>
                            <small>ハイフン無しの半角英数字で入力お願い致します。（例）091277622 </small>
                        </div>
                    </div>
                </div>

                <div class="bg-light py-3 border border-light px-2 mb-4">
                    <div class="form-group m-0 row">
                        <label class="col-12 col-md-3 col-form-label text-right font-weight-bold">セキュリティコード<br/><small>(Security code)</small></label>
                        <div class="col-12 col-md-9">
                            <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                            <div class="clearfix mb-3"></div>
                            <a href="#">ユーザー登録に関するお約束を必ずお読みください</a>
                            <br/>
                            <div class="pretty p-default p-round mt-1">
                                <input type="checkbox" name="chkAgree" value="1" required />
                                <div class="state p-primary">
                                    <label>お約束事に同意する</label>
                                </div>
                            </div>
                            <br/>
                            <button type="submit" class="btn btn-success mt-2">会員登録</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    $('.select2-no-search').select2({
        minimumResultsForSearch: -1
    });

    $('input[name="birthday"]').datetimepicker({
        format: 'YYYY-MM-DD'
    });
</script>
@endsection
