@extends('www.layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>
                
                <div class="card-body">
                    @if($success) 
                    You account activated successfully.<br/>
                    <a href="{{ route('home') }}">Back to home page</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection