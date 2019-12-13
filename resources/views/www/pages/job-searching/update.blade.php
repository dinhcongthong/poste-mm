@extends('www.pages.job-searching.master')

@section('jobsearching-content')
<h3 class="title">お仕事探し完了画面 </h3>

<div class="form">
    <form action="{{ empty($article_slug) ? route('post_job_searching_add_route') : route('post_job_searching_edit_route', $article_slug) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        @if($errors->any())
        <div class="form-group">
            <div class="alert alert-danger">
                <ul class="mb-0 w-100">
                    @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">会社名</label>
            <div class="col-12 col-sm-10">
                <input class="form-control" name="name" value="{{ $name }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">職種</label>
            <div class="col-12 col-sm-10">
                <select class="form-control" name="category_id" required>
                    <option value="">職種...</option>
                    @foreach ($job_searching_category_list as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $category_id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">雇用人種</label>
            <div class="col-12 col-sm-10">
                <select class="form-control" name="nationality_id" required>
                    <option value="">雇用人種...</option>
                    @foreach ($job_searching_employee_list as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $nationality_id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">雇用形態</label>
            <div class="col-12 col-sm-10">
                <select class="form-control" name="type_id" required>
                    <option value="">雇用形態...</option>
                    @foreach ($job_searching_type_list as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $type_id ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">募集人数</label>
            <div class="col-12 col-sm-10">
                <input type="number" class="form-control" min="0" name="quantity" value="{{ $quantity }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">募集資格</label>
            <div class="col-12 col-sm-10">
                <textarea class="form-control" id="requirement-content" name="requirement">{{ $requirement }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">仕事内容</label>
            <div class="col-12 col-sm-10">
                <textarea class="form-control" id="textarea-content" name="content">{{ $content }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">場所</label>
            <div class="col-12 col-sm-10">
                <input class="form-control" name="address" value="{{ $address }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">給与(ドル)</label>
            <div class="col-12 col-sm-10">
                <input type="text" class="form-control" min="0" name="salary" value="{{ $salary }}" required>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">備考</label>
            <div class="col-12 col-sm-10">
                <textarea class="form-control" id="textarea-other-content" name="other_info"> {{ $other_info }}</textarea>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-12 col-sm-10 offset-sm-2">
                <div class="seperate my-1"></div>
                <h3 class="font-weight-bold sub-title-form">連絡先情報</h3>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">メールアドレス</label>
            <div class="col-12 col-sm-10">
                <input class="form-control" name="email" type="email" value="{{ $email }}">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">電話番号/その他</label>
            <div class="col-12 col-sm-10">
                <input class="form-control" name="phone" type="tel" {{ $phone }}>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-12 col-sm-2 col-form-label font-weight-bold text-sm-right">電話番号掲載</label>
            <div class="col-12 col-sm-10 d-flex flex-wrap flex-items-center">
                <div class="pretty pretty p-default p-round p-thick mt-1 p-smooth">
                    <input type="checkbox" name="show_phone_num" value="1" />
                    <div class="state p-primary-o">
                        <label>掲載する</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-12 col-sm-10 offset-sm-2">
                <div class="bg-accept p-4">
                    <p class="m-0">ご利用にあたっての<a href="{{ route('get_term_of_use_route')}}" target="_blank">お約束事</a></p>
                    <div class="pretty pretty p-default p-round p-thick p-smooth mt-2">
                        <input type="checkbox" name="accept" value="1" required />
                        <div class="state p-primary-o">
                            <label>お約束事に同意する</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-primary btn-lg">サイトに公開する</button>
        </div>
    </form>
</div>
@endsection