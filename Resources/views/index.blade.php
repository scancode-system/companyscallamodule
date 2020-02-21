@extends('dashboard::layouts.master')

@section('content')

<div class="card">
	<div class="card-body">
		{{ Form::open(['companyscalla.file']) }}

		{{ Form::button('Gerar', ['class' => 'btn btn-primary', 'type' => 'submit']) }}
		{{ Form::close() }}
	</div>
</div>

@endsection

@section('breadcrumb')
<li class="breadcrumb-item">
	<a href="{{ route('dashboard') }}">Dashboard</a>
</li>
<li class="breadcrumb-item">
	Scalla
</li>
@endsection
