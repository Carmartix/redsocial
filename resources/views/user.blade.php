@extends('layouts.app')

@section('content')

  <div class="row justify-content-center px-3">
		<div class="col-4">
			<profile :id="{{ $id }}"></profile>
		</div>
    <div class="col-8">
      <list-feeds :id="{{ $id }}"></list-feeds>
    </div>
  </div>

@endsection
