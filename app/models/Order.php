<?php

class Order extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'orders';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	protected $fillable = array('type', 'owner_id', 'address_id', 'fullname', 'email', 'phone_number', 'ip_address', 'product_list', 'comment', 'total', 'status', 'added_on');

	public static function add($data)
	{
		$shippingMethods = Shipping::getTitles();
		$paymentMethods  = ['cash', 'bank_transfer'];

		$shippingMethods = implode(',', $shippingMethods);
		$paymentMethods = implode(',', $paymentMethods);

		$rules = array(

			'fullname'       => ['required', 'string', 'regex:/[^ ]* [^ ]*/'],
			'email'           => 'required|email',
			'phone_number'    => 'required',
			'comment'         => 'max:200',
			'shipping_method' => 'required|in:' . $shippingMethods,
			'payment_method'  => 'required|in:' . $paymentMethods,
			
		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}

		$data['product_list'] = serialize($data['product_list']);
		$data['added_on'] = DB::raw('NOW()');

		return Order::create($data);
	}
}