@extends('layouts.app')
@section('content')
<script>
    $(document).on('change','.nochange',function() {
        console.log('changed');
        console.log($(this).data('id'));
    });

    function enabledisable(id){
        if($('.nochange_'+id).is(":checked")){
            $('.reevaluated_marks_'+id).prop('disabled',true);
        }else{
            $('.reevaluated_marks_'+id).prop('disabled',false);
        }
    }
    function selectAll(){
        if($('#selectall').is(":checked")){
            $('.nochange').prop('checked',true);
        }else{
            $('.nochange').prop('checked',false);
        }
        $('.nochange').each(function(i){
            enabledisable($(this).data('id'));
        });
    }
</script>
<style>
    .edit{
        background:#ededed;
    }
</style>
@if (Session::has('messages') )
                <script>
                    $(document).ready(function () {
                    
                    //$.notify("{{Session::get('messages')}}", "success", { position:"right bottom" });
                    swal({
                        type: 'success',
                        title: '{{Session::get('messages')}}',
                        showConfirmButton: false,
                        timer: 1500
                        });
                    });
                    <?php Session::forget('messages'); ?>
                </script>
            @endif
    <div  class="container-fluid" style="background: ghostwhite;
        margin-top: -20px;
        padding: 10px 0;">
        <div  class="container">
            <div class="row">
                <div class="col-12">
                    <a href="{{url('reeevaluation')}}">Courses</a> | <a href="{{url('reeevaluation')}}/{{$subject->programme_id}}">{{$subject->programme->course_name}}</a> | {{$subject->scode}} - {{$subject->sname}}
                </div>
            </div>
        </div>
    </div>
    <div  class="container-fluid" style="background: beige;
        padding:  0;">
        <div  class="container">
            <div class="row">
                <div class="col-12">
                <h4>Reevaluation Applications 
                <form action="{{url('reeevaluation')}}/{{$subject->id}}/reevaluate" method="get" class="form-group float-right;" style="width:300px;float:right;">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search with Application Number">
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary"> Go </button>
                        </span>
                    </div>
                </form>
                </h4>

                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h5>Pass Mark: {{$subject->emin_marks}}, Max Mark: {{$subject->emax_marks}}</h5>
                
                <form action="{{url('reeevaluation')}}/{{$subject->id}}/reevaluate" method="get" class="form-group float-right" style="width:300px;float:right;">
                    {{ csrf_field() }}
                    <div class="input-group">
                        <select name="type" id="type" class="form-control" >
                            <option value="all" @if($type == 'all') selected @endif selected >All </option>
                            <option value="reevaluation" @if($type == 'reevaluation') selected @endif >Reevaluation </option>
                            <option value="retotalling" @if($type == 'retotalling') selected @endif >Retotalling </option>
                           {{-- <option value="photocopying" @if($type == 'photocopying') selected @endif >Photocopy </option> --}}
                        </select>
                        <select name="show" id="show"  class="form-control" >
                            <option value="1" @if($show==1) selected @endif>All</option>
                            <option value="2" @if($show==2) selected @endif>Pending</option>
                        </select>
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-sm btn-primary" style="padding:24px 10px!important;"> Go </button>
                        </span>
                    </div>
                </form>

                {{$reevaluation->appends(request()->input())->links()}}

                <form action="{{url('evaluationcenter/reevaluation/save')}}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <table class="table table-bordered table-striped table-hover">
                        <tr>
                            <td colspan="10">
                            <button style="margin-bottom:3px;" class="btn btn-sm btn-primary pull-right">Save</button>
                            </td>
                        </tr>
                        <tr>
                            <th class="center-text" rowspan="2">Examcenter Code</th>
                            <th class="center-text hidden" rowspan="2">Bundle Number</th>
                            <th class="center-text" rowspan="2">Dummy Number</th>
                            <th class="center-text" rowspan="2">Language</th>
                            <th class="center-text" rowspan="2">Mark Obtained</th>
                            <th class="center-text" rowspan="2">Reevaluation</th>
                            <th class="center-text" rowspan="2">Retotalling</th>
                            <th class="center-text hidden"  rowspan="2">Photocopy</th>
                            <th class="center-text" colspan="2">Mark - Reevaluation / Retotalling</th>
                        </tr>
                        <tr>
                            <td class="center-text"> <input type="checkbox" id="selectall" onClick="selectAll()" > &nbsp;Select All</td>
                            <th></th>
                        </tr>
                        
                        <?php $ids = ''; ?>
                        @foreach($reevaluation as $r)
                            <?php $ids .= $r->id . ','; ?>
                        @endforeach
                        <input type="hidden" value={{$ids}} name="ids">
                        @foreach($reevaluation as $r)
                            <tr>
                            
  <td class="center-text"> 
                                {{$r->code}}</td>
                                
                                <td class="center-text hidden">
                                    {{$r->bundle_number}}
                                </td>
                                <td class="center-text">
                                    {{$r->dummy_nu}}
                                </td>
                                <td>
                                    {{$r->language}}
                                </td>
                                <td class="center-text">
                                    {{$r->obtained_mark}}
                                </td>
                                
                                <td class="center-text">
                                    @if($r->reevaluation_applystatus == 1)
                                        <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                    @else
                                        <i class="fa fa-close" aria-hidden="true" style="color:red"></i>
                                    @endif
                                </td>
                                <td class="center-text">
                                    @if($r->retotalling_applystatus == 1)
                                        <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                    @else
                                        <i class="fa fa-close" aria-hidden="true" style="color:red"></i>
                                    @endif
                                </td>
                                <td class="center-text hidden">
                                    @if($r->photocopying_applystatus == 1)
                                        <i class="fa fa-check" aria-hidden="true" style="color:green"></i>
                                    @else
                                        <i class="fa fa-close" aria-hidden="true" style="color:red"></i>
                                    @endif
                                </td>
                                <td class="center-text edit">
                                    <input  type="checkbox" 
                                        name="nochange_{{$r->id}}" 
                                        data-id="{{$r->id}}"
                                        class="nochange nochange_{{$r->id}}" 
                                        @if(!($r->retotalling_applystatus == 1 ||$r->reevaluation_applystatus == 1 )) disabled @endif 
                                        onClick="enabledisable({{$r->id}})"
                                        @if($r->no_change == 1) checked @endif
                                    > No change </input>
                                </td>
                                <td class="center-text edit">
                                    <input type="number" 
                                        class="form-control reevaluated_marks_{{$r->id}}" 
                                        style="width:80px;" 
                                        max="{{$subject->emax_marks}}"
                                        name="reevaluated_marks_{{$r->id}}"
                                        value="{{$r->reevaluated_marks}}"
                                        @if(!($r->retotalling_applystatus == 1 || $r->reevaluation_applystatus == 1 )) disabled @endif  
                                        @if($r->no_change == 1) disabled @endif
                                        >
                                </td>
                            </tr>
                        @endforeach
                           <tr>
            <td colspan="10">
                <label><strong>Upload Folisheet Document</strong></label>
                <input type="file" name="folisheet" required class="form-control" accept=".pdf">
                <input type="hidden" name='subject_id' value="{{$r->subject_id}}">
            </td>
        </tr>
                        <tr>
                            <td colspan="10">
                            <button style="margin-bottom:3px;" class="btn btn-sm btn-primary pull-right">Save</button>
                            </td>
                        </tr>
               
                    </form>
                </table>
                         <tr>
                            <td>
<?php $evaluationcenter_id = \App\Evaluationcenter::where('user_id', Auth::user()->id)->first()->id;?>

@php
    $fileName = "RE27_{$evaluationcenter_id}_{$subject->id}.pdf";
    $filePath = public_path("files/markfiles/" . $fileName);
@endphp

@if(file_exists($filePath))
 <iframe 
    src="{{ asset('files/markfiles/' . $fileName) }}" 
    width="100%" 
    height="800px">
</iframe>
@else
    <span class="text-danger">File not uploaded</span>
@endif

                        </td>
                            
                            </tr>
            </div>
        </div>
    </div>
@endsection