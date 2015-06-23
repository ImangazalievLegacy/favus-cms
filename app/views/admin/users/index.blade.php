@extends('admin.layout.main')

@section('title') Пользователи @stop

@section('head')
<script src="{{ URL::to('js/admin/users.js') }}"></script>
@stop

@section('content')

	<h2>Пользователи</h2>

	@if (isset($users) && count($users)>0)

		<table>
			<tr>
				<td>ID</td>
				<td>Никнейм</td>
				<td>E-mail:</td>
				<td>Статус</td>
			</tr>

			@foreach ($users as $user)

				@include('admin.users.item')

			@endforeach

		</table>

		{{ $users->links() }}

	@endif

@stop