@extends('layouts.app')

@section('content')

  <div class="row justify-content-center px-3">
		<div class="col-4">
			<profile v-bind:id="{{ $id }}" v-bind:auth="{{ auth()->user()->load('friends','imbox') }}"></profile>
		</div>
    <div class="col-8">
      <list-feeds v-bind:id="{{ $id }}" v-bind:auth="{{ auth()->user() }}"></list-feeds>
    </div>
  </div>

@endsection
