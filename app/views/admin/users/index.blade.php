@extends('admin.layout.main')

@section('title') Пользователи @stop

@section('head')
<link rel="stylesheet" href="{{ asset('/css/admin/users.css') }}">
@stop

@section('footer')
<script src="{{ URL::to('js/admin/users.js') }}"></script>
@stop

@section('content')

	@if (isset($users) && count($users)>0)

		<table class="table table-hover table-responsive">
			<thead>
				<tr>
					<td>ID</td>
					<td>Никнейм</td>
					<td>E-mail:</td>
					<td>Статус</td>
					<td colspan="2">Действия</td>
				</tr>
			</thead>

			<tbody>
				@foreach ($users as $user)

					@include('admin.users.item')

				@endforeach
			</tbody>

		</table>

		{{ $users->links() }}

	@endif

@stop