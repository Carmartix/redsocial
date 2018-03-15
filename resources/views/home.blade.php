@extends('layouts.app')

@section('content')

  <div class="row justify-content-center px-3">
		<div class="col-3">
			<profile :auth="{{ auth()->user() }}" :id="{{ auth()->user()->id }}"></profile>
		</div>
    <div class="col-6">
      <list-feeds :auth="{{ auth()->user() }}" ></list-feeds>
    </div>
		<div class="col-3">
			<imbox></imbox>
			<list-friends></list-friends>
		</div>
  </div>

@endsection
