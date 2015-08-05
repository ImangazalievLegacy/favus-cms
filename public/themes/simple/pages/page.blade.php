@extends('layout.main')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div id="breadcrumb">
			<span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
				<a href="{{ URL::route('home') }}" itemprop="url">
					<span itemprop="title">Home</span>
				</a>
			</span>
			—
			<a href="{{ Request::url() }}" class="active">{{ $page->title }}</a>
		</div>

		<h1>{{ $page->title }}</h1>
		
		<div class="wysiwyg">
			{{ $page->content }}	
		</div>
	</div>
</div>

@stop