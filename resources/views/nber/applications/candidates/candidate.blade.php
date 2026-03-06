<div class="modal fade " id="myModal{{$c->id}}" role="dialog" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{$c->name}}</h4>
            </div>
            @include('common.candidates.view')
            <form id="frmStatusUpdate_{{$c->id}}" method="get">
                <div class="modal-footer">
                    <div class="form-group">
                        {{ Form::text('comment', null, ['class' => 'form-control', 'placeholder'=>'Comment/Reason']) }}
                    </div>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    @if($c->status_id != '4')
                        @if($c->status_id != '2')
                            <a href="javascript:update(2,{{$c->id}});" class="btn btn-success">Approve</a>
                        @endif
                        @if($c->status_id != '3')
                            <a href="javascript:update(3,{{$c->id}});" class="btn btn-danger">Reject</a>
                        @endif
                        @if($c->status_id != '1')
                            <a href="javascript:update(1,{{$c->id}});" class="btn btn-warning">Hold</a>
                        @endif
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

