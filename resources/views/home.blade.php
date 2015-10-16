@extends('layouts.master')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 welcome">
				<h1>Welcome</h1>
				<ul class="list-unstyled">
					<li><i class="fa fa-arrow-right"></i> If the page is centered and styled <em>Bootstrap</em> loaded correctly</li>
					<li><i class="fa fa-arrow-right"></i> If the arrows are showing to the left of these items Font Awesome loaded correctly</li>
					<li><i class="fa fa-arrow-right"></i> <span class="blue">If this text is blue not black then JQuery loaded correctly.</span></li>
					<li><i class="fa fa-arrow-right"></i> If {{ Helpers::format_timestamp(time()) }} is todays date then the Helpers PHP class is working.</li>
					<li><i class="fa fa-arrow-right"></i> If monkeys {{ config('myapp.monkeys') }} then the custom config file loaded correctly.</li>
				</ul>
			</div>
		</div>
	</div>
@stop

@section('page_js')
	<script>
		$(document).ready(function(){
			$('.blue').css('color', 'blue');
		});
	</script>
@stop