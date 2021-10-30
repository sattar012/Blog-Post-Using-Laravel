@extends('layouts.app')
@section('title','Author Page')

@section('content')
<h1>
    Author Profile
</h1>

<P>Let me tell you about myself I am abdul Sattar</P>

{{--  <img src="/images/sattar.jpg" alt="Sattar" >  --}}
<img src="{{ asset('images/sattar.jpg') }}" alt="" width="30%">

@endsection