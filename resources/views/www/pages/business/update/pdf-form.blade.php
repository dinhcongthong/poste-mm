<input type="hidden" name="pdf_url" value="{{ $pdf_url }}">
<div class="divider mb-4"></div>
<div id="pdf-error-show alert alert-danger">
</div>
<div id="pdf-list" class="d-grid g-4">
    @if(!empty($pdf_url))
    <div class="pdf-item mb-4">
        <iframe src="{{ $pdf_url }}" width="100%" height="500"></iframe>
    </div>
    @else
    <p id="pdf-nothing" class="g-col-2 g-col-md-4 g-col-lg-8 m-0 text-center mb-0">No Data</p>
    @endif
</div>
<div class="divider my-4"></div>
<div class="w-100 text-center" id="btn-pdf-section">
    <a href="#" class="delete-pdf btn btn-danger {{ !empty($pdf_url) ? '' : 'd-none' }}">Delete File</a>
    <label for="pdf-upload" class="custom-input-file {{ !empty($pdf_url) ? 'd-none' : '' }}">
        Add PDF File
    </label>
    <input id="pdf-upload" type="file" name="add_pdf" class="add-pdf-input d-none">
    <p class="text-center text-danger m-0">
        ** Max size: 10MB **
    </p>
</div>
