@extends('landing.layouts.app')

@section('content')
    <propiedad :propiedad='@json($propiedad)'></propiedad>
@endsection
