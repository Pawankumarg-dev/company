 <div class="modal fade " id="myModal{{$c->id}}" role="dialog" >
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{$c->name}}</h4>
        </div>
        @include('common.candidates.view')
        <div class="modal-footer">
          <?php $now = \Carbon\Carbon::now(); ?>
          @if($c->status_id != 2 || $c->status_id != 9 && (Auth::user()->id == 239184 || Auth::user()->id==87567 ||  Auth::user()->id==99540 || Auth::user()->id==87569 || Auth::user()->id==87568 || Auth::user()->id==88387))
        <form action="{{url('/nber/rejectcandidate')}}" method="post" >
            {{csrf_field()}}
            <div class="form-group pull-left" style="width:500px;">
								<input type="text" id="comment" name="comment" placeholder="Reason for pending"  class="form-control"  >
               {{--  @if( 
                  $c->approvedprogramme->programme->id==57 
                  || 
                  ($c->status_id != 9 && $c->approvedprogramme->enable_admission == 1 && $now->toDateString() <= \Carbon\Carbon::parse($c->approvedprogramme->enable_admission_till)->toDateString() )
                  ||
                  (!is_null(\App\Allapplicant::where('candidate_id',$c->id)->first()) && $c->status_id != 2 )
                ) --}}
                <button type="submit" class="btn btn-warning "  style="margin-top:5px;">Mark as Pending </button>
                {{-- @endif --}}
							</div>
            <input type="hidden" name="id" value="{{$c->id}}">
        </form>
        @endif

        @if($c->status_id != 9 && (Auth::user()->id == 239184 || Auth::user()->id==87567 ||  Auth::user()->id==99540 || Auth::user()->id==87569 || Auth::user()->id==87568 || Auth::user()->id==88387))
        <form action="{{url('/nber/discontinuecandidate')}}" method="post" >
            {{csrf_field()}}
            <div class="form-group pull-left" style="width:500px;">
                <button type="submit" class="btn btn-danger " style="margin-top:5px;">Mark as Discontinued </button>
							</div>
            <input type="hidden" name="id" value="{{$c->id}}">
        </form>
        @endif

        @if($c->status_id != 2 || $c->status_id != 9 && (Auth::user()->id == 239184 || Auth::user()->id==87567 ||  Auth::user()->id==99540 || Auth::user()->id==87569 || Auth::user()->id==87568 || Auth::user()->id==88387))


          <form action="{{url('/nber/verifycandidate')}}" method="post" >
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$c->id}}">    
            {{-- @if( 
              $c->approvedprogramme->programme->id==57 
              || 
              ($c->status_id != 9 && $c->approvedprogramme->enable_admission == 1 && $now->toDateString() <= \Carbon\Carbon::parse($c->approvedprogramme->enable_admission_till)->toDateString() )
              ||
                  (!is_null(\App\Allapplicant::where('candidate_id',$c->id)->first()) && $c->status_id != 2 )
              ) --}}
            <button type="submit" class="btn btn-success pull-right"> Approve</button>
            {{-- @endif --}}
          </form>
          @endif
          <button type="button"  class="btn btn-default pull-right" data-dismiss="modal" style="margin-right:20px;">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  