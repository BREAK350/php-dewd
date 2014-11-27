<?php
function getDiffParam($in_func) {
	$arr = array ();
	$i = 0;
	$length = strlen ( $in_func );
	
	while ( $i < $length ) {
		while ( $i < $length && $in_func [$i] != 'u' ) {
			$i ++;
		}
		if ($i < $length - 3 && $in_func [$i + 1] == '(') {
			$i += 2;
			$begin = $i;
			$br = 1;
			while ( $i < $length && $br != 0 ) {
				if ($in_func [$i] == '(') {
					$br ++;
				} else if ($in_func [$i] == ')') {
					$br --;
				}
				$i ++;
			}
			if ($br == 0) {
				$arr [] = substr ( $in_func, $begin, $i - $begin - 1 );
			}
		}
	}
	return $arr;
}
/*
 * Заміняє змінну t у виразі $str на @, не трогаючи такі функції, як tan і т.д.
 */
function corrReplaceT($str) {
	$length = strlen ( $str );
	$allow = true;
	for($i = 0; $i < $length; $i ++) {
		$ch = $str [$i];
		if ($ch == '(' || $ch == '+' || $ch == '-' || $ch == '*' || $ch == '/') {
			$allow = true;
		} else if ($ch == 't') {
			if ($allow) {
				if ($i == $length - 1) {
					$str [$i] = '@';
				} else {
					$next = $str [$i + 1];
					if ($next == ')' || $next == '+' || $next == '-' || $next == '*' || $next == '/') {
						$str [$i] = '@';
					}
				}
			}
		}
	}
	return $str;
}
/**
 * Міняє в $in_func усі u на відповідні u з номером.
 * Example: u(t)-u(t-2) -> return $u0-$u1;
 */
function changeDiffParam($in_func, $diff_param) {
	$res = $in_func;
	$n = count ( $diff_param );
	for($i = 0; $i < $n; $i ++) {
		$replace = '$u' . $i;
		$search = 'u(' . $diff_param [$i] . ')';
		$res = str_replace ( $search, $replace, $res );
	}
	return 'return ' . $res . ';';
}
/**
 * example, creates from 't-3' to 'return $t-3;'
 */
function changeTInStr($str) {
	$str = str_replace ( '@', '$t', corrReplaceT ( $str ) );
	$str = $str;
	return $str;
}
/**
 * example, creates from 't-3' to 'return $t-3;'
 */
function changeTInDiffParam($diff_param) {
	$n = count ( $diff_param );
	for($i = 0; $i < $n; $i ++) {
		$diff_param [$i] = 'return ' . changeTInStr ( $diff_param [$i] ) . ';';
	}
	return $diff_param;
}
/**
 * Повертає масив значень з $diff_param при $t
 */
function evalDiffParam($diff_param, $t) {
	$res = array ();
	$n = count ( $diff_param );
	for($i = 0; $i < $n; $i ++) {
		$res [$i] = eval ( $diff_param [$i] );
	}
	return $res;
}
/**
 * Створює рядок для ініціалізації змінних $u з номером.
 * Example: returns '$u0=2;$u1=3.5;';
 */
function createInitU($diff_param, $t) {
	$value = $diff_param;
	if ($t !== false) {
		$value = evalDiffParam ( $diff_param, $t );
	}
	$res = '';
	$n = count ( $diff_param );
	for($i = 0; $i < $n; $i ++) {
		$res .= '$u' . $i . '=' . $value [$i] . ';';
	}
	return $res;
}
function eval_in_t($func, $t) {
	return eval ( $func );
}
/**
 * Кожен параметр в нижньому регістрі, без пробілів.
 */
function eval_in_func($in_func, $in_fi, $in_t0, $in_tn, $in_n) {
	$y = array ();
	$diff_param = getDiffParam ( $in_func );
	$in_func = changeDiffParam ( $in_func, $diff_param ); // return $u0+$u1...
	$in_func = changeTInStr ( $in_func );
	$diff_param = changeTInDiffParam ( $diff_param ); // {return $t; return $t-2;...}
	$in_fi = 'return ' . changeTInStr ( $in_fi ) . ';'; // return return exp($t)...;
	                                                    // echo $in_func;
	$n = count ( $diff_param );
	$t = $in_t0;
	$h = ($in_tn - $in_t0) / $in_n;
	
	$value = evalDiffParam ( $diff_param, $t ); // значення параметрів
	for($d = 0; $d < $n; $d ++) {
		if ($value [$d] > $t) {
			return false;
		}
		$value [$d] = eval_in_t ( $in_fi, $value [$d] ); // а тепер це значення u з номером
	}
	$initU = createInitU ( $value, false );
	$y [0] = eval_in_t ( $in_fi, $value [$d] );
	$t += $h;
	$i = 1;
	while ( $i < $in_n ) {
		// echo "i=$i t=$t ";
		$value = evalDiffParam ( $diff_param, $t ); // значення параметрів
		                                            // var_dump ( $value );
		for($d = 0; $d < $n; $d ++) {
			if ($value [$d] > $t) {
				return false;
			}
			if ($value [$d] <= $in_t0) {
				$value [$d] = eval_in_t ( $in_fi, $value [$d] ); // а тепер це значення u
			} else { // лінійна інтерполяція
				$k = intval ( ($value [$d] - $in_t0) / $h );
				// echo $k . '<br>';
				if ($k < $i - 1) {
					$value [$d] = $y [$k] + ($value [$d] - ($in_t0 + $k * $h)) * ($y [$k + 1] - $y [$k]) / $h;
				} else {
					$value [$d] = $y [$i - 1];
				}
			}
		}
		// var_dump ( $value );
		$initU = createInitU ( $value, false );
		$y [$i] = $y [$i - 1] + $h * eval ( $initU . $in_func );
		
		$t += $h;
		$i ++;
		// echo "<br>";
	}
	return $y;
}
?>