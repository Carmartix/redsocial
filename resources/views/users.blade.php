@extends('layouts.app')

@section('content')

  	<list-users :user="{{auth()->user()}}"></list-users>

@endsection
