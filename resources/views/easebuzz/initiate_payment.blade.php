@extends('layouts.app')

@section('content')



<form method="POST" action="{{url('/')}}/initiate-payment">
    {{csrf_field()}}
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="phone" placeholder="Phone" required><br>
    <input type="number" name="amount" placeholder="Amount" required><br>



    
    <button type="submit">Pay Now</button>
</form>






@endsection