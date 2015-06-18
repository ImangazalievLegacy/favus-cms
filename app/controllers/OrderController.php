<?php

class OrderController extends BaseController {

	public function getMakeOrder()
	{
		$shippingMethods = Shipping::getMethods();
		$paymentMethods  = ['cash', 'bank_transfer']; 

		$data = ['shippingMethods' => $shippingMethods, 'paymentMethods' => $paymentMethods];

		if (!Auth::guest())
		{
			$userId = Auth::user()->id;

			$address = Address::getDefaultAddress($userId);

			if ($address !== null)
			{
				$data['address'] = $address;
			}
		}

		return View::make('order.make')->with($data);
	}

	public function postMakeOrder()
	{
		$userId       = -1;
		$addressId    = -1;

		if (Auth::guest())
		{
			$customerType = 'guest';
		}
		else
		{
			$customerType = 'user';
			$userId       = Auth::user()->id;

			$addresses = Address::getByOwnerId($userId);

			if ($addresses->count())
			{
				$addressId = (int) Input::get('address_id');
			}
			else
			{
				$addressId = Address::add(array(

					'owner_id'     => $userId,
					'fullname'     => $fullname,
					'phone_number' => $phoneNumber,
					'email'        => $email,

				), true);
			}
		}

		$productList = Cart::all();
		$total = Cart::getTotal();

		$fullname       = Input::get('fullname');
		$email          = Input::get('email');
		$phoneNumber    = Input::get('phone_number');
		$comment        = Input::get('comment');
		$shippingMethod = Input::get('shipping_method');
		$paymentMethod  = Input::get('payment_method');
		$ipAddress      = Request::ip();

		$data = array(

			'type'            => $customerType,
			'owner_id'        => $userId,
			'address_id'      => $addressId,
			'fullname'        => $fullname,
			'email'           => $email,
			'phone_number'    => $phoneNumber,
			'ip_address'      => $ipAddress,
			'product_list'    => $productList,
			'comment'         => $comment,
			'total'           => $total,
			'shipping_method' => $shippingMethod,
			'payment_method'  => $paymentMethod,
			'status'          => 'accepted',

	 	);

	 	try {

			$order = Order::add($data);

		} catch (InvalidDataException $e) {

			return Redirect::back()->with('global', $e->getMessage())->withInput($data)->withErrors($e->getErrors());
		}

		if ($order->save()) 
		{
			return Redirect::route('home')->with('global', 'Order is accepted');
		}
	}

}