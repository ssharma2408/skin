@extends('layouts.layout')

@section('page')
 
	<h1>Dashboard</h1>
 
@endsection
 
@section('content')
<!-- page-title stary -->
<div class="page-title mg-top-50">
	<div class="container">
		<a class="float-left" href="/">Home</a>
		<span class="float-right">My Clinic</span>
	</div>
</div>
<!-- page-title end -->
<!-- balance start -->
<div class="balance-area pd-top-40">
	<div class="container">
		<div class="section-title">			
			<h3 class="title">Reports</h3>			
		</div>			
	</div>
</div>
<!-- balance End -->
@endsection
 
@push('js')

@endpush