@if(!$pdf_list->isEmpty())
    <div class="pdf-grid text-center p-3">
        @foreach ($pdf_list as $item)
            <button type="button" class="btn btn-primary d-none d-md-inline-block" data-toggle="modal" data-target="#pdf-modal-{{ $loop->iteration }}">メニューを見る</button>
            <a class="btn btn-primary d-block d-md-none mb-4" href="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" target="_blank">メニューを見る</a>
            <div class="modal fade" id="pdf-modal-{{ $loop->iteration }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content bg-dark text-white">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">メニューを見る</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body p-0">
                            <div class="pdf-item" id="pdf-item-{{ $loop->iteration }}">
                                <iframe src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" type="application/pdf" width="100%" height="500"></iframe>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@if(!$menuList->isEmpty())
    <div id="menu-grid" class="d-grid x1 x3-lg g-2 g-lg-3 p-3 p-lg-4">
        @foreach ($menuList as $item)
            @if(!empty($item->name))
                <h4 class="menu-group text-danger">{{ $item->name }}</h4>
            @endif
            @foreach ($item->getDetail as $detail)
                <div class="btn btn-light p-2 d-flex">
                    <div class="col-3 p-0 bg-grey">
                        <div class="media-wrapper-1x1">
                            @if(!is_null($detail->getImage))
                                <img class="img-cover" src="{{ App\Models\Base::getUploadURL($detail->getImage->name, $detail->getImage->dir) }}" alt="{{ $article->name.',Menu,'.$detail->name }}">
                            @else
                                <img class="img-cover" src="{{ asset('images/poste/blank.svg') }}" alt="{{ $article->name.',Menu,'.$detail->name }}">
                            @endif
                        </div>
                    </div>
                    <div class="col-9 d-flex flex-wrap text-left">
                        <strong class="col-12 p-0 align-self-start">{{ $detail->name }}</strong>
                        <em class="col-12 p-0 align-self-end">{{ $detail->price }}</em>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
@endif
