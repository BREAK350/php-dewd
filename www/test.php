<?php
include_once 'reader.php';
include_once 'algorithm.php';
require_once 'view.php';

$in_func = 'u(t)';
$in_fi = 'exp(t)';
$in_t0 = '0';
$in_tn = '10';
$in_n = '100';

$y = eval_in_func ( $in_func, $in_fi, $in_t0, $in_tn, $in_n );
printTable ( $y );
/*
 * echo corrReplaceT ( $in_func ) . "<br>"; $diff_param = getDiffParam ( $in_func ); var_dump ( $diff_param ); echo "<br>"; echo changeDiffParam ( $in_func, $diff_param ); echo "<br>"; $diff_param = changeTInDiffParam ( $diff_param ); var_dump ( $diff_param ); echo "<br>"; var_dump ( evalDiffParam ( $diff_param, 1 ) ); echo "<br>"; echo createInitU ( $diff_param, 1 ); echo "<br>";
 */
?>