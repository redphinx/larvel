@extends('app')
@section('c1')
<title>Laravel</title>
@section('selectStyle') <!-- located in header section -->
<style>
html, body {
	height: 100%;
}

body {
	margin: 0;
	padding-Top: 0px;
	width: 100%;
	display: table;
	font-weight: 100;
	font-family: 'Lato';
}

.content {
	text-align: center;
	display: inline-block;
}

.title {
	font-size: 96px;
}

.chart div {
	font: 10px sans-serif;
	background-color: steelblue;
	text-align: right;
	padding: 3px;
	margin: 1px;
	color: white;
}
</style>

@section('c2')<!-- located in the body section -->
<table><tr><td>
	{!! Form::open(['url'=>'welcome']) !!}
	<div class="form-group">{!! Form::label('mass of vapor', 'mass of vapor:') !!}</td><td> 
	{!! Form::text('mov',44.32,['class' =>'form-control']) !!}</div>
	</td></tr><tr><td>
	<div class="form-group">{!! Form::label('vapor flow rate', 'vapor flow rate:') !!} </td><td>
	{!! Form::text('vfr',200,['class'=>'form-control']) !!}</div>
	</td></tr><tr><td>
	<div class="form-group">{!! Form::label('mass of liquid', 'mass of liquid:') !!}</td><td>
	{!! Form::text('mol',18.02,['class' =>'form-control']) !!}</div>
	</td></tr><tr><td>
	<div class="form-group">{!! Form::label('liquid flow rate', 'liquid flow rate:') !!} </td><td>
	{!! Form::text('lfr',180,['class' =>'form-control'])!!}</div>
	</td></tr><tr><td>
	<div class="form-group">{!! Form::label('pressure', 'pressure:') !!} </td><td>
	{!! Form::text('p',110,['class' =>'form-control']) !!}</div>
	</td></tr><tr><td>
	<div class="form-group">{!! Form::label('gas constant', 'gas constant:') !!}</td><td>
	{!! Form::text('r',8.314,['class' =>'form-control']) !!}</div>
	</td></tr><tr><td>
	<div class="form-group">{!! Form::label('surface tension', 'surface tensionure:') !!}</td><td>
	{!! Form::text('sigma',71.2,['class'=>'form-control']) !!}</div>
	</td></tr><tr><td>
	<div class="form-group">{!! Form::label('flooding factor', 'flooding factor:') !!} </td><td>
	{!! Form::text('f',0.576,['class' =>'form-control']) !!}</div>
	</td></tr><tr><td>
	<div class="form-group">{!! Form::label('density of liquid', 'density of liquid:') !!}</td><td>
	{!! Form::text('rou',955.7,['class' =>'form-control']) !!}</div>
	</td></tr><tr><td>
	<div class="form-group">{!! Form::label('Temperature', 'Temperature:') !!}</td><td>
	{!! Form::text('t',303.15,['class' =>'form-control']) !!}</div>
	</td></tr></table>
	<br>
	{!! Form::submit('Create Diagram',['class' => 'btn btn-primary form-control']) !!}
	{!! Form::close() !!}
	
	


	
<?php
// if (empty ( $message )) {
// echo "im null";
// } else {
// echo $message;
// }
?> 



	<script type="text/javascript">
	/* var velocity = [.010, .005],
    t0 = Date.now();
	time = Date.now()-t0;

    var p =d3.select("body").selectAll("p").data(["hello",t0]).text(String);
    p.enter().append("p")
    .text(String); */
        </script>
@stop
