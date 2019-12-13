@extends('www.layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            @if(isset($error))
            <div class="alert alert-danger mb-4">
                {{ $error }}
            </div>
            @endif
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>
                
                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                    @endif
                    
                    {{ __('Before proceeding, please check your email for a verification link.') }}<br/>
                    {{ __('If you did not receive the email') }}, <a href="#" class="btn-resend">{{ __('click here to request another') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
<form class="d-none" id="form-resend" action="{{ route('post_resend') }}" method="POST">
    @csrf
</form>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
       $('.btn-resend').on('click', function() {
           $('#form-resend').submit();
       });
    });
</script>
@endsection