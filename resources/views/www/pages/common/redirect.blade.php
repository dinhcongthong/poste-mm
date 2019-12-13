@extends('www.layouts.master')

@section('content')
<div class="container" style="min-height: 30vh;">
    <div class="bg-white mb-4 pb-2 pt-3 text-center">
        @empty(!$message)
        <p class="text-center">
            {!! $message !!}
        </p>
        @else
        <img class="img-fluid" src="{{ asset('images/poste/loader_1.gif') }}" alt="Rirect Page">
        <p id="second" class="text-center" style="font-size: 2.3rem; font-weight: bolder;">
            4
        </p>
        <p class="text-center" style="font-size: 2rem;">
            Redirecting....
        </p>
        <input type="hidden" name="url" value="{{ $href }}">
        @endempty
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        var url = $('input[name="url"]').val();
        if(url) {
            var sec = 3;
            
            var x = setInterval(function() {
                if(sec < 0) {
                    clearInterval(x);
                    window.location.href = url;
                } else {
                    $('#second').text(sec);
                    sec--;  
                }          
            }, 1000);
        }
    })
</script>
@endsection