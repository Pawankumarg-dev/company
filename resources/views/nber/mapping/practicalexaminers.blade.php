@extends('layouts.downloadabletable')

@section('filter')
    <option value="mapped" @if($type=='mapped') selected @endif>Mapped</option>
    <option value="pending" @if($type=='pending') selected @endif>Pending</option>
@endsection

@include('nber.mapping.tables.practicalexaminers')


@section('sc')

<script src="{{ url('js/bootstrap-select.min.js') }}"></script>
<script>
    function addPE(id){
        $('#subjects_'+id+ ' sub_ul').attr('display','in-line');
        $('#formsubjects').html($('#subjects_'+id).html());
        $('#rci_code').html($('.rci_code_'+id).html());
        $('#myModal').modal('show');
        $('#formsubjects .cbox').removeClass('hidden');
        $('#formsubjects .terms').removeClass('hidden');
        $('#formsubjects .table-subjects').removeClass('hidden');
        $('#formsubjects .expand').removeClass('fa-plus');
        $('#formsubjects .expand-term').removeClass('fa-plus');
        $('#formsubjects .expand').addClass('fa-minus');
        $('#formsubjects .expand-term').addClass('fa-minus');
        $('#institute_id').val(id);
    }
    $(document.body).on("click", ".expand", function (event) {
        $(this).toggleClass('fa-plus fa-minus');
        $(this).parent().children('.terms').toggleClass('hidden');
    });
    $(document.body).on("click", ".expand-term", function (event) {
        $(this).toggleClass('fa-plus fa-minus');
        $(this).parent().children('.table-subjects').toggleClass('hidden');
    });
    $(document.body).on('click','input[type=checkbox]',function(event){
        //console.log($(this).is(':checked'));
        $(this).parent().find('input[type=checkbox]').attr('checked',$(this).is(':checked'));
    });
    $(document).ready(function () {
        $('select').selectpicker();
    });
    function addfaculty(){
        if($('#faculty_id').val() > 0){
           $('#peadd').submit();
        }else{
            swal('Please select a faculty');
        }
    }
</script>


<div id="myModal" class="modal fade" role="dialog">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <form id="peadd" action="{{ url('nber/practicalexaminer') }}" method="POST">
                {!! csrf_field() !!}

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Practical Examiner for <span id="rci_code"></span></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="contactperson" class="control-label">Faculty / Examiner</label>
                        <input type="hidden" name="institute_id" id="institute_id">
                        <select class="form-control" name="faculty_id" id="faculty_id" data-header="Select a faculty" data-live-search="true">
                            <option value="0" >Please select Faculty</option>
                            @foreach ($faculties as $f)
                                <option value="{{ $f->id }}" data-content="<b>{{ $f->name }}</b> <div class='small'>CRR No: {{ $f->crr_no }}, Qualification: {{ $f->qualification }}</div> 
                                    <div class='small'>  Address:  {{ $f->address }}  </div>
                                    <div class='small'>  Email:  {{ $f->email }} , Mobile: {{ $f->mobileno }} </div>
                                    <div class='small'>  Languages:  {{ $f->languagenonhtml }}  </div>
                                    " > 
                                    </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="contactperson" class="control-label">From Date</label>
                        <input type="date" name="start_date" id="start_date"  class="form-control">
                      <label for="contactperson" class="control-label">To Date</label>
                      <input type="date" name="end_date" id="end_date"  class="form-control">
                      
                    </div>
                     <div class="form-group">
                      <label for="contactperson" class="control-label">Subjects</label>
                    <div id="formsubjects">
                    </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" onclick="javascript:addfaculty()"   class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>

    </div>


</div>

<link rel="stylesheet" href="{{ url('css/bootstrap-select.min.css') }}">
<style>
.expand,
.expand-term {
    cursor: pointer;
}
.small{
    color:blue;
}
.plus,
.minus {
    display: inline-block;
    background-repeat: no-repeat;
    background-size: 16px 16px !important;
    width: 16px;
    height: 16px;
    /*vertical-align: middle;*/
}

.plus {
    /*     background-image: url(https://img.icons8.com/color/48/000000/plus.png); */
}

.minus {
    /* background-image: url(https://img.icons8.com/color/48/000000/minus.png); */
}

ul {
    list-style: none;
    padding: 0px 0px 0px 20px;
}

ul.inner_ul li:before {
    content: "├";
    font-size: 18px;
    margin-left: -11px;
    margin-top: -5px;
    vertical-align: middle;
    float: left;
    width: 8px;
    color: #41424e;
}

ul.inner_ul li:last-child:before {
    content: "└";
}

.inner_ul {
    padding: 0px 0px 0px 35px;
}
</style>

{{-- <script> 
    function addPE(id){
        $('#subjects_'+id+ ' sub_ul').attr('display','in-line');
        $('#formsubjects').html($('#subjects_'+id).html());
        $('#rci_code').html($('.rci_code_'+id).html());
        $('#myModal').modal('show');
    }

    $(document).ready(function () {
        
        $('select').selectpicker();
        $(".plus").click(function () {
            $(this).toggleClass("minus").siblings("ul").toggle();
            $(this).toggleClass("fa-minus");
        })
        $("input[type=checkbox]").click(function () {
            //alert($(this).attr("id"));
            //var sp = $(this).attr("id");
            //if (sp.substring(0, 4) === "c_bs" || sp.substring(0, 4) === "c_bf") {
                $(this).siblings("ul").find("input[type=checkbox]").prop('checked', $(this).prop('checked'));
            //}
        })
    
        $("input[type=checkbox]").change(function () {
            var sp = $(this).attr("id");
            if (sp.substring(0, 4) === "c_io") {
                var ff = $(this).parents("ul[id^=bf_l]").attr("id");
                if ($('#' + ff + ' > li input[type=checkbox]:checked').length == $('#' + ff + ' > li input[type=checkbox]').length) {
                    $('#' + ff).siblings("input[type=checkbox]").prop('checked', true);
                    check_fst_lvl(ff);
                }
                else {
                    $('#' + ff).siblings("input[type=checkbox]").prop('checked', false);
                    check_fst_lvl(ff);
                }
            }
    
            if (sp.substring(0, 4) === "c_bf") {
                var ss = $(this).parents("ul[id^=bs_l]").attr("id");
                if ($('#' + ss + ' > li input[type=checkbox]:checked').length == $('#' + ss + ' > li input[type=checkbox]').length) {
                    $('#' + ss).siblings("input[type=checkbox]").prop('checked', true);
                    check_fst_lvl(ss);
                }
                else {
                    $('#' + ss).siblings("input[type=checkbox]").prop('checked', false);
                    check_fst_lvl(ss);
                }
            }
        });
    
    })
    
    function check_fst_lvl(dd) {
        //var ss = $('#' + dd).parents("ul[id^=bs_l]").attr("id");
        var ss = $('#' + dd).parent().closest("ul").attr("id");
        if ($('#' + ss + ' > li input[type=checkbox]:checked').length == $('#' + ss + ' > li input[type=checkbox]').length) {
            //$('#' + ss).siblings("input[id^=c_bs]").prop('checked', true);
            $('#' + ss).siblings("input[type=checkbox]").prop('checked', true);
        }
        else {
            //$('#' + ss).siblings("input[id^=c_bs]").prop('checked', false);
            $('#' + ss).siblings("input[type=checkbox]").prop('checked', false);
        }
    
    }
    
    function pageLoad() {
        $(".plus").click(function () {
            $(this).toggleClass("minus").siblings("ul").toggle();
        })
        $(".fa-plus").click(function () {
            $(this).toggleClass("fa-minus").siblings("ul").toggle();
        })
        $(".fa-minus").click(function () {
            $(this).addClass("fa-plus");
            $(this).removeClass("fa-minus");
        })
    }
    </script>--}}
    @endsection