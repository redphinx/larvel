@extends('app')
@section('c1')
<title>About</title>
@section('navagation')
@section('c2')
<h1>About {{ $name }} design</h1>
<!-- @if ($name=='Tray Column')
	<p>found name</p>
@else
<p> {{$name}}s</p>
@endif --> 
@if(count($data))
<h3>About Information: </h3>
<ul>
@foreach ($data as $collected)
<li> {{$collected}}</li>
@endforeach 
@endif
</ul>
<p>

</p>
</body>
</html>
@stop