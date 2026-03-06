<td>
            {{$heading}}
            <div class="dropdown">                            
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                               @if(Request::has($code))
                                @foreach($collection as $a)                                 
                                    @if($a->id==Request::input($code))
                                        @if($display!=null)
                                            @if($displayto!=null)
                                                {{ $a->$display->$displayto }}
                                            @else
                                                {{ $a->$display }}
                                            @endif
                                        @else
                                            {{$a}}
                                        @endif                                
                                    @endif
                                @endforeach
                               @else
                                All
                               @endif
                               <span class="caret"></span>
                            </a>
                           <ul class="dropdown-menu" role="menu">
                                @if(Request::has($code)) 
                                    <li><a href="{{ Request::url() }}?{{ http_build_query(Request::except('page',$code))}}">All</a></li>
                                @endif
                                @foreach($collection as $a) 
                                    <li>  
                                        @if(Request::has($code))      
                                            @if($a->id!=Request::input($code))                       
                                                <a href="{{ Request::url() }}?{{ http_build_query(Request::except('page',$code))}}&{{$code}}={{$a->id}}">
                                                    @if($display!=null)
                                                        @if($displayto!=null)
                                                            {{ $a->$display->$displayto }}
                                                        @else
                                                            {{ $a->$display }}
                                                        @endif
                                                    @else
                                                        {{$a}}
                                                    @endif  
                                                </a>
                                            @endif
                                        @else
                                            @if($display!=null)
                                                <a href="{{ Request::url() }}?{{ http_build_query(Request::except('page',$code))}}&{{$code}}={{$a->id}}">
                                                    @if($displayto!=null)
                                                        {{ $a->$display->$displayto }}
                                                    @else
                                                        {{ $a->$display }}
                                                    @endif
                                                @else
                                                    {{$a}}
                                                @endif  
                                             </a>    
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                           
                    </div> 
        </td>