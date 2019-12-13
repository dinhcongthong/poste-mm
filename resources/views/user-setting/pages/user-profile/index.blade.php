@extends('user-setting.layouts.masterGlobal')

@section('content')
<div class="g-col-3">
    <h2 class="text-info">Profile Information</h2>
    <hr>
    @foreach ($errors as $item)
    <div class="alert alert-danger mb-3 w-100 error">';
        <ul class="mb-0">
            <li>{{ $item }}</li>;
        </ul>
    </div>
    @endforeach
    <form id="user-form" action="{{ route('post_user_profile_edit_route') }}" method="POST">
        @if($errors->any())
        @foreach ($errors->all() as $item)
        <div class="alert alert-danger mb-3 w-100 error">
            <ul class="mb-0">
                <li>{{ $item }}</li>
            </ul>
        </div>
        @endforeach
        @endif
        @csrf
        <div class="form-group row">
            <label for="name" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" class="form-control" value="{{ getUsername(Auth::user()) }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" readonly>
            </div>
        </div>
        <div class="form-group row">
            <label for="password" class="col-sm-2 col-form-label">New Password: </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" id="password">
            </div>
        </div>
        <div class="form-group row">
            <label for="password_confirm" class="col-sm-2 col-form-label">Verify New Password: </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password_confirm" id="password_confirm">
            </div>
        </div>
        <div class="form-group row">
            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="phone" id="phone" value="{{ Auth::user()->phone }}">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Gender</label>
            <div class="col-sm-10 radio">
                <div class="radio">
                    <label><input type="radio" name="gender_id" value="1" {{ Auth::user()->gender_id == 1 ? 'checked' : '' }}> Male</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="gender_id" value="2"  {{ Auth::user()->gender_id != 1 ? 'checked' : '' }}> Female</label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-2 col-form-label">Birthday</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="birthday" id="birthday" value="{{ Auth::user()->birthday }}">
            </div>
        </div>
        <div class="w-100">
            <button class="btn btn-info" type="submit">Save</button>
            <a href="{{ route('get_user_setting_index_route') }}" class="btn btn-secondary text-light">Back </a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $('input[name="birthday"]').datetimepicker({
        format: 'YYYY-MM-DD'
    });
</script>
@endsection
