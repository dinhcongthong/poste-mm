<ul class="nav nav-pills nav-justified" role="tablist">
    <li class="nav-item">
        <a id="menu-list-tab" data-toggle="tab" role="tab" aria-controls="menu-list" aria-selected="true" class="flex-sm-fill text-sm-center nav-link active" href="#menu-list">Create Menu List</a>
    </li>
    <li class="nav-item">
        <a id="pdf-menu-tab" data-toggle="tab" role="tab" aria-controls="pdf-menu" aria-selected="false" class="flex-sm-fill text-sm-center nav-link" href="#pdf-menu">Upload Menu PDF File</a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane fade active show pt-4" id="menu-list" role="tabpanel" aria-labelledby="menu-list-tab">
        @include('www.pages.town.update.menu-form')
    </div>
    <div class="tab-pane fade pt-4" id="pdf-menu" role="tabpanel" aria-labelledby="pdf-menu-tab">
        <div id="pdf-list">
            @foreach ($pdf_menu_list as $item)
                <div class="pdf-item mb-4" id="pdf-item-{{ $item->id }}">
                    <iframe src="{{ App\Models\Base::getUploadURL($item->name, $item->dir) }}" width="100%" height="500"></iframe>
                    <a href="#" class="text-danger delete-pdf" data-id="{{ $item->id }}">Delete File</a>
                </div>
            @endforeach
        </div>
        <div id="add-pdf-area">
            @if(count($pdf_menu_list) == 0)
                <div class="w-100 text-center">
                    <label for="pdf-upload" class="custom-input-file">
                        Add PDF File
                    </label>
                    <input id="pdf-upload" type="file" name="add_pdf_menu" class="add-pdf-menu">
                </div>
                <input type="hidden" name="pdf_ids" value="">
            @endif
        </div>
        <p class="text-center">
            PDFのアップロードは10MBまで可能です。<br/>
            <strong>お持ちのファイルの容量が大きい場合、<a href="https://smallpdf.com/" target="_blank">”こちら”</a>のサイトから圧縮されることをおすすめします。</strong><br/>
            <strong>それでも圧縮できない場合、お手数ですが <a href="{{ URL::to('contact') }}" target="_blank">よりご連絡く</a>それでも圧縮できない場合、お手数ですが</strong><br/>
            ださい。
        </p>
    </div>
</div>
