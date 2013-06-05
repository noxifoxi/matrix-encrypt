<?php
class MatrixCrypt {
	private $key = '';
	private $table = [];

	public function __construct() {
	}

	public function makeKey(array $cryptMatrix) {
		ksort($cryptMatrix);
		foreach ($cryptMatrix as $char => $matrix) {
			$o = $this->matrix2oct($matrix);
			$this->key .= $char.$o;
			$this->table[$char] = $o;
		}
	}

	public function encode($string) {
		$output = '';
		foreach(str_split($string) as $c) {
			if(isset($this->table[$c]))
				$output .= $this->table[$c];
			else {
				for($i = 0; $i < 3; $i++)
					$output .= $c;
			}
		}
		return $output;
	}

	public function decode($string) {
		$output = '';
		foreach(str_split($string, 3) as $c) {
			if(in_array($c, $this->table))
				$output .= array_search($c, $this->table);
			else {
				if($c{0} == $c{1} && $c{1} == $c{2})
					$output .= $c{0};
				else
					return;
			}
		}
		return $output;
	}

	public function setKey($key) {
		// TODO: make table
		$this->key = $key;
	}

	public function getKey() {
		return $this->key;
	}

	public function getImage($string) {
		// get the image
		foreach(str_split($string, 3) as $c) {
			$this->oct2matrix($c); //
		}
	}

	private function matrix2oct(array $array) {
		$oct = '';
		for($i = 0; $i < sizeof($array); $i += 3) {
			$oct .=  (int)$array[$i] + (int)$array[$i+1] * 2 + (int)$array[$i+2] * 4;
		}
		return $oct;
	}

	private function oct2matrix($oct) {
		$a = [];
		for($i = 0; $i < strlen($oct); $i++) {
			$o = (int)$oct{$i};

			for($j = 0; $j < 3; $j++, $o /= 2) {
				$a[] = $o % 2;
			}
		}
		return $a;
	}
}

header('Content-Type: text/plain; charset=utf-8');

$a = new MatrixCrypt();
$a->makeKey(['a' => [1, 0, 1, 0, 0, 0, 1, 0, 0], 'o' => [1, 0, 1, 0, 0, 0, 1, 1, 0], 'l' => [1, 1, 1, 0, 0, 0, 0, 0, 1], 'n' => [1, 0, 0, 0, 0, 1, 0, 1, 1], ' ' => [0, 1, 0, 0, 0, 0, 0, 1, 0], 'E' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'F' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'G' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'H' => [1, 1, 0, 0, 0, 1, 0, 1, 1], 'I' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'J' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'K' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'L' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'M' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'N' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'O' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'P' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'Q' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'R' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'S' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'T' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'U' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'V' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'W' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'X' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'Y' => [1, 1, 0, 0, 0, 1, 0, 0, 1], 'Z' => [1, 1, 0, 0, 0, 1, 0, 0, 1]]);

$e = $a->encode('Hallo na');
echo $e."\n";
echo $a->decode($e);

