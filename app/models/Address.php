<?php

class Address extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'addresses';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array();

	protected $fillable = array('owner_id', 'fullname', 'country', 'city', 'province', 'zip_code', 'phone_number', 'email');

	public static function add($parameters, $default = true)
	{
		if (isset($parameters['owner_id']))
		{
			$ownerId = $parameters['owner_id'];
			
			$address = Address::create($parameters);
			$address->save();

			if ($default)
			{
				Address::setDefaultAddress($ownerId, $address);
			}
			else
			{
				$addresses = Address::getByOwnerId($ownerId);

				if ($addresses->count() == 1)
				{
					Address::setDefaultAddress($ownerId, $address);
				}
			}

			return $address->id;
		}

	}

	public static function getByOwnerId($ownerId)
	{
		return Address::where('owner_id', '=', $ownerId)->get();
	}

	public static function getDefaultAddress($ownerId)
	{
		$defaultAddressId = ExtendedUserInformation::getDefaultAddressId($ownerId);

		if ($defaultAddressId !== null)
		{
			return Address::find($defaultAddressId);
		}
		else
		{
			return Address::getByOwnerId($ownerId)->first();
		}
	}

	public static function setDefaultAddress($ownerId, $address)
	{
		$defaultAddressId = ExtendedUserInformation::setDefaultAddressId($ownerId, $address->id);
	}

}