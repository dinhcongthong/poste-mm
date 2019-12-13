@extends('www.layouts.master')

@section('content')
<div class="container bg-white py-4 mb-4">
    <div class="col-12">
        <h2 class="border border-left-0 font-weight-bold border-right-0 border-top-0 border-dark col-12 col-lg-8 offset-lg-2">お問い合わせ</h2>
        <p class="col-12 col-lg-8 offset-lg-2">
            ※個人情報の取り扱いについて <br/>
            ご入力いただきましたお客さまの個人情報は、本お問い合わせに関する回答の目的に利用致しません。
        </p>
        <div class="col-12 col-lg-8 offset-lg-2 py-5 jumbotron">
            <form action="{{ route('post_contact_route') }}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="col-form-label text-right col-12 col-lg-3">お名前<br/><small>(Your name)</small></label> 
                    <div class="col-12 col-lg-9">
                        <input type="text" class="form-control" name="name" value="" required> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-12 col-lg-3">会社名前<br/><small>(Company name)</small></label> 
                    <div class="col-12 col-lg-9">
                        <input type="text" class="form-control" name="company" value="" placeholder="Option"> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-12 col-lg-3">電話番号<br/><small>(Phone number)</small></label> 
                    <div class="col-12 col-lg-9">
                        <input type="text" class="form-control" name="phone" value="" required> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-12 col-lg-3">メールアドレス<br/><small>(Email)</small></label> 
                    <div class="col-12 col-lg-9">
                        <input type="email" class="form-control" name="email" value="" required> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-12 col-lg-3">件名<br/><small>(Subject)</small></label> 
                    <div class="col-12 col-lg-9">
                        <input type="text" class="form-control" name="subject" value="" required> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-12 col-lg-3">お問合せ内容<br/><small>(Content)</small></label> 
                    <div class="col-12 col-lg-9">
                        <textarea class="form-control" rows="3" name="content" required></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-lg-9 offset-lg-3">
                        <button type="submit" class="btn btn-primary">送信</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection