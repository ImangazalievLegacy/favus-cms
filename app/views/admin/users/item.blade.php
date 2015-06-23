<tr data-id="{{ $user->id }}">
	<td>{{ $user->id }}</td>
	<td>{{ $user->username }}</td>
	<td>{{ $user->email }}</td>
	
	@if ($user->isBlocked())
		
		<td>Заблокирован</td>
	
	@elseif ($user->isActive())

		<td>Активен</td>

	@else

		<td>Неактивен</td>

	@endif
</tr>