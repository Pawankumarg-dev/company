@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <div class="panel-title">
                                    Details of Course Coordinator(s)
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <section class="hidethis">
                                            <ul class="breadcrumb">
                                                <li class="heading">Quick Links: </li>
                                                <li class="active">Course Coordinator(s)</li>
                                            </ul>
                                        </section>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        @if(Session::has('message'))
                                            <div class="row">
                                                {{--
                                                <div class="col-sm-6 col-sm-offset-3">
                                                    <div class="alert alert-{{ Session::get('status_class') }}  alert-dismissible fade in">
                                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                        <strong>{{ Session::get('message') }}!!!</strong>
                                                    </div>
                                                </div>
                                                --}}
                                                @php echo '<script> swal("Course Coordinator details", "Added Successfully!!!", "success") </script>'  @endphp
                                            </div>
                                        @endif

                                       <div class="panel panel-warning">
                                           <div class="panel-body">
                                               <div class="table-responsive">
                                                   <table class="table table-bordered table-condensed table-hover">
                                                       <tr>
                                                           <th class="right-text" colspan="8">
                                                               <a href="{{ url('/institute/coursecoordinators/create') }}" class="btn btn-sm btn-info">
                                                                   <span class="glyphicon glyphicon-plus"></span>
                                                                   Add Course Coordinator
                                                               </a>
                                                           </th>
                                                       </tr>

                                                       <tr>
                                                           <th width="5">S.No.</th>
                                                           <th>Name</th>
                                                           <th>Courses Handling</th>
                                                           <th>Contact No</th>
                                                           <th>Email Id</th>
                                                           <th>CRR No.</th>
                                                           <th>Presently Working Status</th>
                                                       </tr>

                                                       @if($coursecoordinators->count() != 0)
                                                           @php $sno = 1; @endphp
                                                           @foreach($coursecoordinators as $coursecoordinator)
                                                               <tr>
                                                                   <td>{{ $sno }} @php $sno++; @endphp</td>
                                                                   <td>{{ $coursecoordinator->name }}</td>
                                                                   <td>{{ $coursecoordinator->courses_handling }}</td>
                                                                   <td>
                                                                       Mob. No.: <b>{{ $coursecoordinator->mobile_number }}</b><br>
                                                                       WhatsApp No.: <b>{{ $coursecoordinator->whatsapp_number }}</b>
                                                                   </td>
                                                                   <td>
                                                                       {{ $coursecoordinator->email_address }}
                                                                   </td>
                                                                   <td>
                                                                       {{ $coursecoordinator->registration_number }}
                                                                   </td>
                                                                   <td>{{ $coursecoordinator->present_working_status }}</td>
                                                               </tr>
                                                           @endforeach
                                                       @else
                                                           <tr>
                                                               <td class="center-text bold-text red-text" colspan="8"><strong>NO RECORDS FOUND</strong></td>
                                                           </tr>
                                                       @endif
                                                   </table>
                                               </div>
                                           </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
