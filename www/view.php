<?php
/*
 * function corrReplaceT($str) { $length = strlen ( $str ); for($i = 0; $i < $length; $i ++) { $ch = $str [$i]; if ($ch == 't') { if ($i == 0 || (isOperation ( $str [$i - 1] ) || $str [$i - 1] == '(')) { if ($i == $length - 1 || (isOperation ( $str [$i + 1] ) || $str [$i + 1] == ')')) { $str [$i] = '@'; } } } } return $str; } function isOperation($ch) { return $ch == '+' || $ch == '-' || $ch == '*' || $ch == '/'; }
 */
function printTable($y, $t0, $tn) {
	$n = count ( $y );
	$h = ($tn - $t0) / $n;
	echo "<table border>
			<tr>
				<th>x</th>
				<th>y</th>
			</tr>";
	for($i = 0; $i < $n; $i ++) {
		$x = $t0 + $i * $h;
		echo "<tr>
		<td>$x</td>
		<td>$y[$i]</td>
		</tr>";
	}
	echo "</table>";
}
?>