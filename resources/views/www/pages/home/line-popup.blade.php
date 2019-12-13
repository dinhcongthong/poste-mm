<div class="modal fade" tabindex="-1" role="dialog" id="line-modal">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="row">
                    <div class="col-12">
                        <img id="line-modal-img" class="img-fluid" src="{{ asset('images/poste/line-popup.png') }}">
                    </div>
                    <div class="col-12">
                        <div class="row no-gutters">
                            <div class="col-6">
                                <button style="font-size: 16px;" type="button" class="w-100 font-weight-bold px-1 py-2 btn btn-light border-0 rounded-0" data-dismiss="modal">
                                    受け取らない
                                </button>
                            </div>
                            <div class="col-6">
                                <a style="font-size: 16px;" class="w-100 font-weight-bold px-1 py-2 btn btn-success border-0 rounded-0" href="{{ env('LINE_URL') }}" target="_blank">
                                    受け取る
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<style>
    @media(min-width: 767.98px) {
        #line-modal .modal-dialog {
            position: absolute;
            right: 10px;
        }
    }
</style>
@if(!isset($_COOKIE['line-popup']))
@php 
setcookie('line-popup', '1', time()+60*30*24*30);
@endphp
@if(!isset($_GET['utm_source']) || $_GET['utm_source'] != 'line')
<script>
    $(document).ready(function() {
        $('img#line-modal-img').on('load', function() {
            $('#line-modal').modal('show');
        });
    });
</script>
@endif
@endif