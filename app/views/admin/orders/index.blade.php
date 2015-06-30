@extends('admin.layout.main')

@section('title') Заказы @stop

@section('head')
<link rel="stylesheet" href="{{ asset('/css/admin/orders.css') }}">
@stop

@section('footer')
<script src="{{ URL::to('js/admin/orders.js') }}"></script>
@stop

@section('content')

	@if (isset($orders) && count($orders)>0)

		<table class="table table-hover table-responsive">
			<tdead>
				<td>ID</td>
				<td>Номер заказа</td>
				<td>Полное имя</td>
				<td>E-mail</td>
				<td>Статус</td>
				<td>Время добавления</td>
				<td colspan="2">Действия</td>
			</tr>

			<tbody>
				@foreach ($orders as $order)

					@include('admin.orders.item')

				@endforeach
			</tbody>

		</table>

		{{ $orders->links() }}

	@endif

@stop