<script id="thumbnail-template" type="text/x-handlebars-template">
	<div class="col-xs-6 col-md-3">
		<a href="#" class="thumbnail">
			<img src="@{{src}}">
			<span class="delete">&times;</span>
		</a>
		<input type="hidden" name="product_images[]" value="@{{path}}">
	</div>
</script>

<script id="alert-template" type="text/x-handlebars-template">
	<div class="alert alert-@{{type}}" role="alert">@{{message}}</div>
</script>

<script id="help-block-template" type="text/x-handlebars-template">
	<span class="help-block text-@{{type}}"><p>@{{message}}</p></span>
</script>