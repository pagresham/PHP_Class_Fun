<?PHP
if (isset($_POST['logout'])) {
	unset($_SESSION['username']);
	print "Balls";
	header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Php classe demo</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="container-fluid">
	<header>
		<div>
			<nav class="navbar navbar-default">
				<div class="container-fluid">
				    <div class="navbar-header">
				      <!-- <a class="navbar-brand" href="#">WebSiteName</a> -->
				    </div>
				    <ul class="nav navbar-nav">
				      <li><a href="index.php">Home</a></li>
					  <li><a href="elsewhere.php">Elsewhere</a></li>
				    </ul>
				    <ul class="nav navbar-nav navbar-right">
				    <?PHP if (isset($_SESSION['username'])) { ?>

						<li>
				    		<form class="navbar-form" method="post" action="index.php">
						      <button type="submit" name="logout" class="btn btn-default">LogOut</button>
						    </form>
				    	</li>
						<li><a>Welcome:  <?PHP echo " " . $_SESSION['username']; ?></a></li>

				    <?PHP } ?>	
				    </ul>
				 </div>
			</nav>			
		</div>
	</header>