<?
    $host="mysql.strayhold.com";
	$username="gbh2_user";
	$password="straypwd";
	$database="attack";

	$cxn=mysqli_connect($host, $username, $password);
	@mysqli_select_db($cxn, $database) or die( "Unable to select database". mysqli_connect_error());
?>