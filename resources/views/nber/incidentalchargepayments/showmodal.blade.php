<div id="showModal_{{ $inp->id }}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;</button>
                <h4 class="modal-title">
                </h4>
            </div>

            <div class="modal-body">
                <div class="container">
                    <div class="row form-horizontal" role="form">
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="remarks_{{ $inp->id }}">Verify Remarks:</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="remarks_{{ $inp->id }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-2">
                                <button class="btn btn-info btn-sm" id="updateButton_{{ $inp->id }}" type="button">Update Status</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
