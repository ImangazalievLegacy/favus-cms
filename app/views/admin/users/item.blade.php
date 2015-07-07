<tr data-id="{{ $user->id }}">
	<td>{{ $user->id }}</td>
	<td>{{ $user->username }}</td>
	<td>{{ $user->email }}</td>
	
	@if ($user->isBlocked())
		
		<td><span class="label label-danger">Заблокирован</span></td>
	
	@elseif ($user->isActive())

		<td><span class="label label-success">Активен</span></td>

	@else

		<td><span class="label label-default">Неактивен</span></td>

	@endif
	<td>
		<a href="" class="btn btn-default change-user">
			<span class="fa fa-fw fa-pencil" aria-hidden="true"></span>
		</a>
		@if (Auth::user()->id != $user->id)
		
			<a href="" class="btn btn-danger delete-user">
				<span class="fa fa-fw fa-trash-o" aria-hidden="true"></span>
			</a>

		@endif
	</td>
</tr>