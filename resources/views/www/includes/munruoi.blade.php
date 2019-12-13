<div id="mun-ruoi">
    <a href="{{ env('POSTE_LINE_URL') }}" target="_blank">
        <img src="{{ asset('images/poste/munruoi.png') }}" alt="POSTE LINE" class="img-fluid">
    </a>
</div>

<style>
    body {
        position: relative;
    }

    #mun-ruoi {
        position: fixed;
        border: 3px solid #fff;
        border-radius: 50%;
        box-shadow: 3px 3px 3px #aeaeae;
        width: 80px;
        top: calc(100vh - 100px);
        right: 1rem;
        z-index: 1000;
    }

    @media(min-width: 992px) {
        #mun-ruoi {
            width: 100px;
            top: calc(100vh - 193px);
            right: 20px;
        }
    }
</style>
