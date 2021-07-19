<!DOCTYPE html>
<html <?php language_attributes();?>>
	<head>
		<?php get_head();?>
	</head>
	<body <?php body_class();?>>
		<?php include 'template-parts/header.php'; ?>
		<div id="wrapcontent">
			<?php include 'template-parts/content.php'; ?>
		</div>
		<?php include 'template-parts/footer.php'; ?>
	</body>
</html>