<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>WEB - <?php echo $title; ?></title>
		<link href="<?php echo $web['link'] . 'assets/images/web.ico'; ?>" id="icono" rel="shortcut icon" type="image/x-icon" />
		<link href="<?php echo $web['link'] . 'assets/css/jquery.confirm.min.css'; ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo $web['link'] . 'assets/css/fontawesome/core.min.css'; ?>" rel="stylesheet" type="text/css" />
		<?php if($this->section('pre-css')) {
			echo $this->section('pre-css');
		} ?>
		<?php if(!empty($bootstrap)) { ?>
			<link href="<?php echo $web['link'] . 'assets/css/bootstrap.min.css'; ?>" rel="stylesheet" type="text/css" />
		<?php } ?>
		<link href="<?php echo $web['link'] . 'assets/css/utilidades.css'; ?>" rel="stylesheet" type="text/css" />
		<?php if($this->section('css')) echo $this->section('css'); ?>
		<script src="<?php echo $web['link'] . 'assets/js/jquery-3.3.1.min.js'; ?>"></script>
	</head>
	<body>
		<?php echo $this->section('content'); ?>
		<?php if(!empty($bootstrap)) : ?>
			<script src="<?php echo $web['link'] . 'assets/js/bootstrap.min.js'; ?>"></script>
		<?php endif; ?>
		<script src="<?php echo $web['link'] . 'assets/js/jquery.confirm.min.js'; ?>"></script>
		<?php if($this->section('js')) echo $this->section('js'); ?>
	</body>
</html>