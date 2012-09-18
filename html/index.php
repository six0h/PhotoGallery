<?php
session_start();
require_once('config.php');

if(isset($_GET['debug'])) {
	$debug = 1;
}

$photos = $db->select('photos');

$data = $session->read(session_id());
$session->write(session_id(), $data);

if($_GET['logout'] == 1) {
	unset($data);
	$session->destroy(session_id());
	header('Location: '.$_SERVER['PHP_SELF']);
}

if(isset($data['user_email']))
	$user = User::find_by_email($data['user_email']);


?>

<!DOCTYPE html>
<html>
<head>

	<title>Cody, Kate, and the Boys!</title>
	<meta charset="utf-8">

	<script src="js/html5shiv.js"></script>
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/fonts.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/jquery.fancybox.css">

</head>

<body>

<header>

	<div id="login-box">
		<h2>
		<?php
		if(isset($user)) { 
			($user->get_user_first_name() != '') ? $name = $user->get_user_first_name()
							: $name = $user->get_user_email();
			?>
			Welcome, <?=$name;?> (<a href="<?=$_SERVER['PHP_SELF']?>?logout=1">Logout</a>)</div>		
		<?php } else { ?>
			<a href="#login_modal" class="modal_link">Login</a> or <a href="#register_modal" class="modal_link">Register</a> to see the gallery.
		<?php } ?>
		</h2>
		<div id="register_modal" class="modal">
			<span class="modalarrow"></span>
			<h3>Register</h3>
			<form method="POST" action="ajax/login.php" id="register_form">
				<fieldset>
					<input type="text" name="register_email" id="register_email" value="E-Mail Address">
					<input type="password" name="register_password" id="register_password" value="Password">
				</fieldset>
				<fieldset>
					<a href="#">You can fill out the rest later.</a>
					<input type="submit" name="register" id="register" class="submit" value="Login">
				</fieldset>
			</form>
			<span class="close"><a href="#">Close</a></span>
		</div>
	</div>

	<h1>Cody & Kate</h1>
	<span>Featuring Jake and Fraser</span> 

	<br class="clear" />
	
</header>
<?php
if(isset($debug) && $debug == 1) {
	print_r($session);
	echo "<br>\r\n";
	print_r($data);
}

if(isset($user)) {
?>
<section id="gallery">

	<ul>
	<?php
		foreach($photos as $photo) {
			$photo_id = get_object_vars($photo['_id']);
			$id = $photo_id['$id']; ?>
			<li>
				<a href="uploads/full/<?php echo $id; ?>.jpg" rel="" class="pic"><img src="uploads/thumb/<?php echo $id; ?>.jpg" alt="<?php echo $photo['name']; ?>"></a>
				<?php if($user->is_admin() == 1) : ?>
					<a href="#edit" id="edit_<?php echo $id; ?>" class="edit_link">Edit</a>
				<?php endif; ?>
			</li>
		<?php
		}
	?>

	</ul> 

</section>
<?php
} else {
	echo "<div class='error'>You must login to view our Gallery</div>";
?>

	<div id="login_modal" class="modal">
		<span class="modalarrow"></span>
		<h3>Login</h3>
		<form method="POST" action="ajax/login.php" id="login_form">
			<fieldset>
				<input type="text" name="user_email" id="user_email" value="E-Mail Address">
				<input type="password" name="user_password" id="user_password" value="Password">
			</fieldset>
			<fieldset>
				<a href="#forgot">Forgot Your Password?</a>
				<input type="submit" name="user_login" id="user_login" class="submit" value="Login">
				<input type="hidden" name="session_id" id="session_id" value="<?=session_id();?>">
			</fieldset>
		</form>
		<span class="close"><a href="#">Close</a></span>
	</div>
<?php
}
?>
<script src="js/jquery-1.7.2.min.js"></script>
<script src="js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="js/jquery.form.js"></script>
<script src="js/jquery.fancybox.pack.js"></script>
<script src="js/_site.js"></script>
<?php
?>
</body>
</html>
