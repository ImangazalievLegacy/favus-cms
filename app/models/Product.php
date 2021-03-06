<?php

use Illuminate\Support\MessageBag;

class Product extends Eloquent {

	protected $table = 'products';

	protected $fillable = array('title', 'description', 'images', 'main_image_id', 'price', 'old_price', 'url', 'category_id', 'article_number', 'currency', 'type', 'count', 'visible');

	public static function getAll()
	{
		return static::getByCategory(null);
	}

	public static function getByCategory($id)
	{
		$query = Product::where('visible', '=', true);

		if ($id !== null)
		{
			if (is_array($id))
			{
				$query = $query->whereIn('category_id', $id);
			}
			else
			{
				$query = $query->where('category_id', '=', $id);
			}
		}

		if (!Config::get('site/catalog.products.show-empty'))
		{
			$query = $query->where('count', '>', 0)->orWhere('count', '=', -1);
		}

		$perPage = Config::get('site/catalog.products.per-page');
		
		$products = $query->paginate($perPage);

		return $products;
	}

	public static function findByUrl($url)
	{
		if (Config::get('site/catalog.products.show-empty'))
		{
			return Product::where('visible', '=', true)->where('url', '=', $url)->limit(1)->get()->first();
		}
		else
		{
			return Product::where('visible', '=', true)->where('url', '=', $url)->where('count', '>', 0)->orWhere('count', '=', -1)->limit(1)->get()->first();
		}
	}

	public static function validate($data, $exclusion = null)
	{
		$currencies = Currency::getCodes();
		$currencies = implode(',', $currencies);

		$categoryIds = Category::lists('id');
		$categoryIds = implode(',', $categoryIds);

		$rules = array(

			'title'          => 'required|min:5|max:256',
			'url'            => 'required|min:5|max:512',
			'description'    => 'required|min:10',
			'category_id'    => 'required|in:' . $categoryIds,
			'price'          => ['required', 'regex:/[(0-9)+ ?+.?(0-9)*]+/'],
			'old_price'      => ['regex:/[(0-9)+ ?+.?(0-9)*]+/'],
			'article_number' => 'required',
			'currency'       => 'required|in:' . $currencies,
			'product_images' => 'array',
			'count'          => 'required|integer',
			'visible'        => 'required|boolean',
			'main_image_id'  => 'required_with:product_images|numeric',

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}

		if (is_numeric($exclusion))
		{
			$count = self::where('category_id', $data['category_id'])->where('url', $data['url'])->whereNotIn('id', [$exclusion])->count();
		}
		else
		{
			$count = self::where('category_id', $data['category_id'])->where('url', $data['url'])->count();
		}		

		if ($count > 0)
		{
			$errors = new MessageBag();

			$message = Lang::get('validation.unique');
			$message = str_replace(':attribute', 'URL', $message);

			$errors->add('url', $message);

			throw new InvalidDataException('Invalid Data', $errors);
		}
	}

	public static function add($data)
	{
		Product::validate($data);

		if (!array_key_exists('old_price', $data))
		{
			$data['old_price'] = null;
		}

		if (array_key_exists('product_images', $data))
		{
			$productImages = serialize($data['product_images']);
		}
		else
		{
			$productImages = null;
		}

		$data['price'] = trim(preg_replace('/\s*/', '', $data['price']));
		$data['old_price'] = trim(preg_replace('/\s*/', '', $data['old_price']));

		$data['main_image_id'] = (int) $data['main_image_id'];

		$product = Product::create(array(
			
			'title'          => $data['title'],
			'url'            => $data['url'],
			'description'    => $data['description'],
			'category_id'    => $data['category_id'],
			'price'          => $data['price'],
			'old_price'      => $data['old_price'],
			'article_number' => $data['article_number'],
			'currency'       => $data['currency'],
			'images'         => $productImages,
			'main_image_id'  => $data['main_image_id'],
			'count'          => $data['count'],
			'visible'        => $data['visible'],
			
		));

		return $product;
	}

	public static function destroy($id)
	{
		$data = ['id' => $id];

		$rules = array(

			'id' => 'required|numeric',

		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid ID', $validator->errors());
		}

		$product = Product::find($id);

		if ($product === null)
		{
			throw new NotFoundException("Product with id {$id} not found");
		}
		
		return (bool) $product->delete();
	}

	public static function change($id, $data)
	{
		$product = Product::find($id);

		if ($product === null)
		{
			throw new NotFoundException('Product not found');
		}

		if ($product->url == $data['url'])
		{
			Product::validate($data, $id);
		}
		else
		{
			Product::validate($data);
		}

		if (!array_key_exists('old_price', $data))
		{
			$data['old_price'] = null;
		}

		if (array_key_exists('product_images', $data))
		{
			$productImages = serialize($data['product_images']);
		}
		else
		{
			$productImages = null;
		}

		$data['price'] = trim(preg_replace('/\s*/', '', $data['price']));
		$data['old_price'] = trim(preg_replace('/\s*/', '', $data['old_price']));

		$updated = $product->update(array(
			
			'title'          => $data['title'],
			'url'            => $data['url'],
			'description'    => $data['description'],
			'category_id'    => $data['category_id'],
			'price'          => $data['price'],
			'old_price'      => $data['old_price'],
			'article_number' => $data['article_number'],
			'currency'       => $data['currency'],
			'images'         => $productImages,
			'main_image_id'  => $data['main_image_id'],
			'count'          => $data['count'],
			'visible'        => $data['visible'],
			
		));

		return $updated;
	}

	public function hasImages()
	{
		return $this->getImages() != false;
	}

	public function getImages()
	{
		return unserialize($this->images);
	}

	public function getMainImageId()
	{
		return (int) $this->main_image_id;
	}

	public function getMainImage()
	{
		$id = $this->getMainImageId();

		$images = $this->getImages();

		if (count($images) and array_key_exists($id, $images))
		{
			return $images[$id];
		}

		return null;
	}

	public function isVisible()
	{
		return (bool) $this->getAttribute('visible');
	}
}
