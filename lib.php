<?php

class Record
{
	private $arr = array();
	
	public function increment($key)
	{
		if(array_key_exists($key , $this->arr))
			$this->arr[$key]++;
		else
			$this->arr[$key]=1;
	}
	public function show()
	{
		foreach($this->arr as $key => $val)
			echo "<li>" . $key . " - " . $val . "</li>";
	}
}

class CountLog
{
	public static function increment($tree)
	{
		$y = null;
		if(file_exists('store'))
		{
			$x = file_get_contents('store');
			$y = unserialize($x);
		}
		else
			$y = new Record;
		$y->increment($tree);
		$s = serialize($y);
		file_put_contents('store', $s);
	}
	
	public static function display()
	{
		$y = null;
		if(file_exists('store'))
		{
			$x = file_get_contents('store');
			$y = unserialize($x);
		}
		else
			$y = new Record;
		$y->show();
	}
}

?>