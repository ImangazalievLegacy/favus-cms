<?php

class Address extends Eloquent {

	protected $table = 'addresses';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	protected $fillable = array('owner_id', 'fullname', 'country', 'city', 'province', 'zip_code', 'phone_number', 'email');

	public static function add($data, $default = true)
	{
		$rules = array(


			'owner_id'     => 'required|number',
			'fullname'     => 'required',
			'email'        => 'required|email',
			'phone_number' => 'required',
			
		);

		$validator = Validator::make($data, $rules);

		if ($validator->fails()) 
		{
			throw new InvalidDataException('Invalid Data', $validator->errors());
		}

		$ownerId = $data['owner_id'];
			
		$address = Address::create($data);
		$address->save();

		if ($default)
		{
			Auth::user()->setDefaultAddressId($address->id);
		}
		else
		{
			$addresses = Address::getByOwnerId($ownerId);

			if ($addresses->count() == 1)
			{
				User::setDefaultAddress($ownerId, $address);
			}
		}

		return $address;
	}

	public static function getByOwnerId($ownerId)
	{
		return Address::where('owner_id', '=', $ownerId)->get();
	}

}