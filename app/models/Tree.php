<?php

abstract class Tree extends Eloquent {

	protected $attributeNames = ['parent_id' => 'parent_id', 'level' => 'level', 'position' => 'position'];

	public static function allNodes()
	{
		return self::orderBy('position')->get();
	}

	public static function createRoot($extra, $truncate = true)
	{
		if ($truncate)
		{
			self::truncate();
		}

		$params = array('parent_id' => null, 'level' => 0, 'position' => 1);

		$params = array_merge($params, $extra);

		return self::create($params);
	}

	public function root()
	{
		return self::where('level', '=', 0)->get()->first();
	}

	public function addChild($extra)
	{
		$position = $this->getLastElementPosition();

		self::where('position', '>', $position)->increment('position');

		$params = array('parent_id' => $this->id, 'level' => $this->level + 1, 'position' => $position + 1);

		$params = array_merge($params, $extra);

		return self::create($params);
	}

	public function childNodes()
	{
		$position = $this->getLastElementPosition();

		return self::orderBy('position')->where('position', '>=', $this->position)->where('position', '<=', $position)->get();
	}

	public function hasChild()
	{
		return $this->where('parent_id', '=', $this->id)->count() > 0;
	}

	public function deleteNode()
	{
		$next = $this->getNext();

		$width = $next->position - $this->position;

		if ($next === null)
		{
			self::where('position', '>=', $this->position)->delete();
		}
		else
		{
			$affectedRows = self::where('position', '>=', $this->position)->where('position', '<', $next->position)->delete();
		}

		self::where('position', '>=', $next->position)->decrement('position', $width);

		return $affectedRows;
	}

	public function parentNode()
	{
		return self::where('id', '=', $this->parent_id)->get()->first();
	}

	public function parentId()
	{
		return $this->parent_id;
	}

	public function isLeaf()
	{
		return !$this->hasChild();
	}

	public function leftSibling()
	{
		return self::orderBy('position', 'desc')->where('position', '<', $this->position)->where('level', $this->level)->limit(1)->get()->first();
	}

	public function rightSibling()
	{
		return self::where('position', '>', $this->position)->where('level', '<=', $this->level)->limit(1)->get()->first();
	}

	public function childrenCount()
	{
		return $this->getWidth();
	}

	public function getLastElementPosition()
	{
		$next = $this->getNext();

		if ($next === null)
		{
			$position = self::where('position', '>', $this->position)->max('position');

			if ($position == null)
			{
				$position = $this->position;
			}
		}
		else
		{
			$position = $next->position - 1;
		}

		return $position;
	}

	public function getNext()
	{
		return $this->rightSibling();
	}

	public function getWidth()
	{
		return $this->getLastElementPosition() - $this->position + 1;
	}

	public function directChildNodes()
	{
		return self::orderBy('position')->where('parent_id', '=', $this->id)->get();
	}

	public function move($destination, $position = 'right')
	{
		if ($this->level == 0)
		{
			throw new Exception('Moving the root node of the impossible');
		}

		$this->setParentId($destination->id);

		$width = $this->getWidth(); 

		if (($destination->position > $this->position) and  ($destination->position < ($this->position + $width)))
		{
			throw new Exception('Moving in child node of the impossible');
		}

		if (is_integer($destination))
		{
			$destination = self::find($destination);
		}

		if (is_object($position))
		{
			$leftPosition = $position->position;
		}
		elseif (is_integer($position))
		{
			$leftPosition = $position;
		} 
		else
		{
			if ($position == 'right')
			{
				$leftPosition = $destination->getLastElementPosition();
			}
			else
			{
				$leftPosition = $destination->position;
			}
		}

		$levelSkew = $destination->level - $this->level + 1;
		$from = $this->position + $width - 1;

		$childIds = self::orderBy('position')->where('position', '>=', $this->position)->limit($width)->lists('id');

		if ($leftPosition > $this->position)
		{
			self::where('position', '>', $from)->where('position', '<=', $leftPosition)->decrement('position', $width);
			$positionSkew = $leftPosition - $this->position - $width + 1;
			self::whereIn('id', $childIds)->increment('position', $positionSkew);
		}
		elseif ($leftPosition < $this->position)
		{
			self::where('position', '<', $from)->where('position', '>=', $leftPosition)->increment('position', $width);
			$positionSkew = $this->position - $leftPosition - 1;
			self::whereIn('id', $childIds)->decrement('position', $positionSkew);
		}

		self::whereIn('id', $childIds)->increment('level', $levelSkew);		
	}

}