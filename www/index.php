<?php
require_once 'reader.php';
require_once 'algorithm.php';
require_once 'view.php';
$show_result = isset ( $_GET ['submit'] );

if ($show_result) {
	$arr = readFromGET_createArray ();
	extract ( $arr );
	$y = eval_in_func ( $in_func, $in_fi, $in_t0, $in_tn, $in_n );
	$show_result = ($y !== false);
}
?>
<html>

<head>

<link rel="stylesheet" href="style/bootstrap.min.css">
<link rel="stylesheet" href="style/style.css">
<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<meta charset="utf-8">
<title>Диференціальні рівняння із запізненням</title>

</head>

<body>

	<div class="container">

		<div class="row" id="header">
			<div class="span12">
				<h1>Диференціальні рівняння із запізненням</h1>
			</div>
		</div>
		<!-- end row -->

		<div class="row" id="content">

			<div class="span5">

				<form class="form-horizontal" action="" name="defd">

					<h3>Дані для задачі</h3>
					<div class="control-group">
						<label class="control-label">du(t)/dt=</label>
						<div class="controls">
							<input type="text" name="in_func" id="inputFunc"
								placeholder="u(t)" value="<?php echo $in_func;?>">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">fi(t)=</label>
						<div class="controls">
							<input type="text" name="in_fi" id="inputFi" placeholder="exp(t)"
								value="<?php echo $in_fi;?>">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">t<sub>0</sub>=
						</label>
						<div class="controls">
							<input type="text" name="in_t0" id="inputT0" placeholder="0"
								value="<?php echo $in_t0;?>">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">t<sub>N</sub>=
						</label>
						<div class="controls">
							<input type="text" name="in_tn" id="inputTN" placeholder="10"
								value="<?php echo $in_tn;?>">
						</div>
					</div>

					<div class="control-group">
						<label class="control-label">N=</label>
						<div class="controls">
							<input type="text" name="in_n" id="inputN" placeholder="100"
								value="<?php echo $in_n;?>">
						</div>
					</div>

					<div class="control-group">
						<div class="controls">
							<button type="submit" name="submit" class="btn">Побудувати</button>
						</div>
					</div>

				</form>

			</div>
			<!-- end span6 -->

			<div class="span6">Опис методу ...</div>
			<!-- end span6 -->
		</div>
		<!-- end row -->
		<div class="row" id="solution">
			<div class="span12">
				<h3>Розв'язок</h3>
			</div>
		</div>
		<!-- end row -->
		<div class="row solution">
			<div class="span3">
			<?php if($show_result){?>
				<table border="1"
					class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th>x</th>
							<th>y</th>
						</tr>
					</thead>
					<tbody>
					<?php $n = ($in_n<=10)?($in_n):(10);?>
					<?php $h = ($in_tn - $in_t0)/$in_n;?>
					<?php for($i=0;$i<$n;$i++){?>
						<tr>
							<td><?php echo $in_t0+$i*$h;?></td>
							<td><?php echo $y[$i];?></td>
						</tr>
					<?php }?>
					<?php if($in_n>20){?>
						<tr>
							<td>...</td>
							<td>...</td>
						</tr>
					<?php }?>
					<?php $i = ($in_n>20)?($in_n-10):(10);?>
					<?php for(;$i<$in_n;$i++){?>
						<tr>
							<td><?php echo $in_t0+$i*$h;?></td>
							<td><?php echo $y[$i];?></td>
						</tr>
					<?php }?>
					</tbody>
				</table>
			<?php }?>
			</div>
			<!-- end span3 -->
			<div class="span8">
			<?php if ($show_result) {?>
			<?php require_once 'create_image.php';?>
				<img class="img-polaroid alt=" " src="image.png">
			<?php }?>
			</div>
			<!-- end span8 -->
		</div>
		<!-- end row -->
	</div>
	<!-- end container -->

</body>
</html>