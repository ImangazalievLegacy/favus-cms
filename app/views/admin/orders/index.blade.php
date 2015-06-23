@extends('admin.layout.main')

@section('title') Заказы @stop

@section('head')
<script src="{{ URL::to('js/admin/orders.js') }}"></script>
@stop

@section('content')

	<h2>Заказы</h2>

	@if (isset($orders) && count($orders)>0)

		<table>
			<thead>
				<th>ID</th>
				<th>Номер заказа</th>
				<th>Полное имя</th>
				<th>E-mail</th>
				<th>Итого</th>
				<th>Статус</th>
				<th>Время добавления</th>
			</tr>

			@foreach ($orders as $order)

				@include('admin.orders.item')

			@endforeach

		</table>

		{{ $orders->links() }}

	@endif

@stop