<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select a course</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <select name="course_id" id="course_id"  class="form-control" >
                        @foreach ($courses as $course )
                            <option value={{ $course->id }}>{{ $course->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" onclick="javascript:redirect()" class="btn btn-danger" >Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModel(){
        $('#myModal').modal('show');
    }
    function redirect(){
        var course = $("#course_id").val();
        window.location.replace("{{ url('nber/eligiblecandidates/supplementary') }}/"+course);
    }
</script>