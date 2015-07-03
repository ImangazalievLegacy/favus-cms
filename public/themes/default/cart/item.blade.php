<li>
	<h3><a href="{{ URL::route('product.show', $item->url) }}">{{ $item->title }}</a></h3>
	<p>{{ $item->quantity }} шт.</p>
	<i>{{ $item->price }} {{ $item->currency }}</i>
</li>