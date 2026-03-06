@extends('layouts.app')

@section('content')
<style>
    a.disabled {
        pointer-events: none;
        cursor: default;
        color: #ccc;
    }

    .tab-active {
        background: #fff;
        padding: 20px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .form-select, .btn {
        min-width: 200px;
    }

    .form-container {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    .instruction-text {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 15px;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12 form-container">
            <h4 class="mb-4 text-center">Select Your Preferred Language For Exam {{$candidate->approvedprogramme->institute->state->language_id}}</h4>

            <form action="{{ url('/') }}/update/candidate-data" method="POST">
                  {{ csrf_field() }}

                  <div class="form-group">
                        <label for="language_id">Language</label><br>
                        <small>The selected language will be applied to all exams.</small>
                        <select name="language_id" id="language_id" class="form-control">
                            <option value="0" selected>-- Please choose --</option>
                                <option value="2">Hindi</option>
                                <option value="1">English</option>

                            @foreach($languages as $l)
                                <option value="{{ $l->id }}">{{ $l->language }}</option>
                            @endforeach
                        </select>
                  </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
