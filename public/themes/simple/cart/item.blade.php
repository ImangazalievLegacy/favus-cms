<tr>
	<td class="thumbnail-wrap"><img src="{{ URL::to($item->getMainImage()) }}" class="thumbnail" alt="{{ $item->title }}"></td>
	<td class="title">{{ $item->title }}</td>
	<td class="price">{{ Currency::addSymbol($item->price, $item->currency) }}</td>
	<td><input type="text" size="3" value="{{ $item->quantity }}" class="quantity"></td>
	<td>{{ Currency::addSymbol($item->price, $item->currency) }}</td>
	<td><a href="#">X</a></td>
</tr>