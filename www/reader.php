<?php
function readFromPOST_createArray() {
	return readFromArray_createArray ( $_POST );
}
function readFromGET_createArray() {
	return readFromArray_createArray ( $_GET );
}
function readFromArray_createArray($arr) {
	$res = array ();
	$in_func = htmlspecialchars ( $arr ['in_func'] );
	$in_fi = htmlspecialchars ( $arr ['in_fi'] );
	$in_t0 = htmlspecialchars ( $arr ['in_t0'] );
	$in_tn = htmlspecialchars ( $arr ['in_tn'] );
	$in_n = htmlspecialchars ( $arr ['in_n'] );
	if (true) {
		$res ['in_func'] = $in_func;
		$res ['in_fi'] = $in_fi;
		$res ['in_t0'] = $in_t0;
		$res ['in_tn'] = $in_tn;
		$res ['in_n'] = $in_n;
		return $res;
	}
	return false;
}
?>