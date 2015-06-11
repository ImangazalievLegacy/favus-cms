<?php

class Product extends Eloquent {

	protected $table = 'products';

	protected $fillable = array('title', 'description', 'price', 'old_price', 'url', 'category_id', 'article_number', 'currency', 'type', 'visible');

	public static function getByCategory($id)
	{
		if (is_array($id))
		{
			return Product::whereIn('category_id', $id)->paginate(5);
		}
		else
		{
			return Product::where('category_id', '=', $id)->paginate(5);
		}
	}

	public static function findByUrl($url)
	{
		return Product::where('url', '=', $url)->limit(1)->get()->first();
	}

	public function add($data)
	{
		$currencies = Currency::getCodes();

		$currencies = implode(',', $currencies);

		$rules = array(

			'title'          => 'required|max:256|min:10',
			'url'            => 'required|max:512|min:10|unique:products',
			'description'    => 'required|min:10',
			'category_id'    => 'required',
			'price'          => 'required|numeric',
			'old_price'      => 'numeric',
			'article_number' => 'required',
			'currency'       => 'required|in:' . $currencies,

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}

		if (!array_key_exists('old_price', $data))
		{
			$data['old_price'] = null;
		}

		$product = Product::create(array(
			
			'title'          => $data['title'],
			'url'            => $data['url'],
			'description'    => $data['description'],
			'category_id'    => $data['category_id'],
			'price'          => $data['price'],
			'old_price'      => $data['old_price'],
			'article_number' => $data['article_number'],
			'currency'       => $data['currency'],
			
		));

		return $product;
	}

}
