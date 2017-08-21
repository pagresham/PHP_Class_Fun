<?PHP
session_start();
include "header.php";
print_r($_POST);
// if(isset($_POST['submitanother'])) {
// 	print "set";
// 	// header("Location: anotherPage.php");
// } else {
// 	print "not set";
// 	// header("Location: index.php");
// }
?>

	<h3>Another Page</h3>
	<form method="post" action="">
		<input type="submit" name="submitanother">
	</form>
</div> <!-- End .container -->
</body>
</html>






