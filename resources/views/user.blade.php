@extends('layouts.app')

@section('content')

  <div class="row justify-content-center px-3">
		<div class="col-4">
			<profile v-bind:id="{{ $id }}"></profile>
		</div>
    <div class="col-8">
      <list-feeds v-bind:id="{{ $id }}"></list-feeds>
    </div>
  </div>

@endsection
