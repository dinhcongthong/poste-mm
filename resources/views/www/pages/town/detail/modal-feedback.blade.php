<div class="modal fade" id="feedback-modal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="padding: 10px;">
            <form action="#" method="POST" id="feedback-form">
                <input type="hidden" name="post_id" value="{{ $article->id }}">
                @csrf
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-pen mr-3"></i> Improve this listing </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    @if(!Auth::Check())
                        <div class="form-group">
                            <label class="font-weight-bold" for="feedback-name">Name: </label>
                            <input type="text" name="name" id="feedback-name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold" for="feedback-email">Email: </label>
                            <input type="email" name="email" id="feedback-email" class="form-control" required>
                        </div>
                    @else
                        <input type="hidden" name="name" value="{{getUsername(Auth::user())}}">
                        <input type="hidden" name="email" value="{{ isset(Auth::user()->email) ? Auth::user()->email : 'none' }}">
                    @endif
                    <div class="form-group mb-0">
                        <label class="font-weight-bold" for="content">Content</label>
                        <textarea class="form-control" name="content" rows="10" id="content"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="mail_feedback" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
