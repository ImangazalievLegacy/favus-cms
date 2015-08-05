<?php

abstract class Tree extends Eloquent {

	protected $fieldNames = ['parent_id' => 'parent_id', 'level' => 'level', 'position' => 'position'];

	/**
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public static function allNodes($withRoot = true)
	{
		$nodes = self::orderBy('position')->get();

		if (!$withRoot)
		{
			$nodes->shift();
		}

		return $nodes; 
	}

	/**
	 * @param array $extra additional values
	 * @param bool $truncate
	 */
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

	/**
	 * Returns the root of the tree
	 * 
	 * @return self
	 */
	public static function root()
	{
		return self::where('level', '=', 0)->get()->first();
	}

	/**
	 * Checks whether the current node is the root
	 * 
	 * @return self bool
	 */
	public function isRoot()
	{
		return $this->parentId() === null;
	}

	/**
	 * @param array $extra additional values
	 * @return self 
	 */
	public function addChild($extra)
	{
		$position = $this->getLastChildPosition();

		self::where('position', '>', $position)->increment('position');

		$params = array('parent_id' => $this->id, 'level' => $this->level + 1, 'position' => $position + 1);

		$params = array_merge($params, $extra);

		return self::create($params);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function childNodes()
	{
		$position = $this->getLastChildPosition();

		return self::orderBy('position')->where('position', '>=', $this->position)->where('position', '<=', $position)->get();
	}

	/**
	 * @return bool
	 */
	public function hasChild()
	{
		return self::where('parent_id', '=', $this->id)->count() > 0;
	}

	/**
	 * Removes the current node with descendants
	 * 
	 * @return int
	 */
	public function deleteNode()
	{
		$width = $this->getWidth();

		$affectedRows = self::where('position', '>=', $this->position)->where('position', '<', $this->position + $width)->limit($width)->delete();

		self::where('position', '>=', $this->position + $width)->decrement('position', $width);

		return $affectedRows;
	}

	/**
	 * @return self|null
	 */
	public function parentNode()
	{
		return self::where('id', '=', $this->parentId())->limit(1)->get()->first();
	}

	/**
	 * @return int
	 */
	public function parentId()
	{
		return (int) $this->parent_id;
	}

	/**
	 * @return bool
	 */
	public function isLeaf()
	{
		return !$this->hasChild();
	}

	/**
	 * @return self|null
	 */
	public function leftSibling()
	{
		return self::orderBy('position', 'desc')->where('position', '<', $this->position)->where('level', $this->level)->where('parent_id', $this->parentId())->limit(1)->get()->first();
	}

	/**
	 * @return self|null
	 */
	public function rightSibling()
	{
		return self::where('position', '>', $this->position)->where('level', $this->level)->where('parent_id', $this->parentId())->limit(1)->get()->first();
	}

	/**
	 * @return int
	 */
	public function childrenCount()
	{
		return $this->getWidth() - 1;
	}

	/**
	 * Returns the position of the last child of the current node
	 * 
	 * @return int
	 */
	public function getLastChildPosition()
	{
		$next = self::where('position', '>', $this->position)->where('level', '<=', $this->level)->limit(1)->get()->first();

		if ($next === null)
		{
			$position = self::where('position', '>', $this->position)->where('level', '>', $this->level)->max('position');

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

	/**
	 * @return self|null
	 */
	public function next()
	{
		return $this->rightSibling();
	}

	/**
	 * Returns the width of the current node
	 * 
	 * @return int
	 */
	public function getWidth()
	{
		return $this->getLastChildPosition() - $this->position + 1;
	}

	/**
	 * Returns the direct descendants of the current node
	 * 
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function directChildNodes()
	{
		return self::orderBy('position')->where('parent_id', '=', $this->id)->get();
	}

	/**
	 * @return string
	 */
	public function getFieldName($key)
	{
	    return $this->fieldNames[$key];
	}
	
	/**
	 * @return $this
	 */
	public function setFieldName($key, $value)
	{
	    $this->fieldNames[$key] = $value;
	    
	    return $this;
	}

	/**
	 * @return int
	 */
	public function setParentId($id)
	{
		return $this->update(['parent_id' => $id]);
	}

	/**
	 * Moves the current node
	 * 
	 * @param int $destination The ID of the new parent
	 * @param string|object $position The position of the node in the new parent
	 * @return int
	 */
	public function move($destination, $position = 'right')
	{
		if ($this->isRoot())
		{
			throw new Exception('Moving the root node of the impossible');
		}

		$width = $this->getWidth(); 

		if (is_numeric($destination))
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
				$leftPosition = $destination->getLastChildPosition();
			}
			else
			{
				$leftPosition = $destination->position;
			}
		}

		if (($destination->position > $this->position) and  ($destination->position < ($this->position + $width)))
		{
			throw new Exception('Moving in child node of the impossible');
		}

		$levelSkew = $destination->level - $this->level + 1;

		$childIds = self::orderBy('position')->where('position', '>=', $this->position)->limit($width)->lists('id');

		$this->setParentId($destination->id);

		if ($leftPosition > $this->position)
		{
			$from = $this->position + $width - 1;
			self::where('position', '>', $from)->where('position', '<=', $leftPosition)->decrement('position', $width);
			
			$positionSkew = $leftPosition - $this->position - $width + 1;
			self::whereIn('id', $childIds)->increment('position', $positionSkew);
		}
		elseif ($leftPosition < $this->position)
		{
			$from = $this->position;
			self::where('position', '>', $leftPosition)->where('position', '<', $from)->increment('position', $width);
			
			$positionSkew = $this->position - $leftPosition - 1;
			self::whereIn('id', $childIds)->decrement('position', $positionSkew);
		}

		self::whereIn('id', $childIds)->increment('level', $levelSkew);		
	}

}