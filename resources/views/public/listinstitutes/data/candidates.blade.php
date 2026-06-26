<h3 class="text-muted">
    <b>Students</b>
</h3>

<div class="container">
    <div class="row">

        @foreach($candidates as $candidate)

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card shadow-sm p-2" style="border-radius:10px;">

                    <div class="text-center">
                        <img 
                            onerror="handleError(this)"
                            src="{{ url('/files/enrolment/photos/'.$candidate->photo) }}"
                            class="img-fluid rounded"
                            style="height:120px; object-fit:cover;"
                        >
                    </div>

                    <div class="mt-2">
                        <b>{{ $candidate->name }}</b>

                        <div class="text-muted" style="font-size:12px;">
                            PRN: {{ $candidate->enrolmentno }} <br>
                         
                        </div>
                    </div>

                </div>
            </div>

        @endforeach

    </div>
</div>
