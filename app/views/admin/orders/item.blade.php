<tr data-id="{{ $order->id }}">
	<td>{{ $order->id }}</td>
	<td>{{ $order->number }}</td>
	<td>{{ $order->fullname }}</td>
	<td>{{ $order->email }}</td>
	<td>{{ $order->status }}</td>
	<td>{{ $order->added_on }}</td>
	<td>
		<a href="" class="btn btn-default change-order">
			<span class="fa fa-fw fa-pencil" aria-hidden="true"></span>
		</a>
		<a href="" class="btn btn-danger delete-order">
			<span class="fa fa-fw fa-trash-o" aria-hidden="true"></span>
		</a>
	</td>
</tr>