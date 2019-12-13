@php
$pdf_info = explode('/', $business_item->pdf_url);
$dir = '';
if(count($pdf_info) > 1) {
    $file_name = $pdf_info[1];
    $dir = $pdf_info[0];
} else {
    $file_name = $pdf_info[0];
}
@endphp
<div class="company-pdf bg-secondary px-3 px-lg-4 py-3 py-lg-4 mb-3 mb-lg-4 rounded">
    <div class="text-center">
        <button id="btn-pdf" class="btn btn-light btn-lg rounded-pill" data-toggle="modal" data-target="#pdf-modal">PDF File</button>
    </div>
    <div class="modal fade" id="pdf-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">資料を見る</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-0">
                    <div class="pdf-item" id="pdf-item">
                        <iframe src="{{ App\Models\Base::getUploadURL($file_name, $dir) }}" type="application/pdf" width="100%" height="500"></iframe>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
