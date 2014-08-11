<?php
session_start();

$username = htmlentities($_SESSION["username"]);
if (!isset($_SESSION["auth"]) || $_SESSION["auth"]!="true")
{
	echo "Login Error";
	exit();
}


if (isset($_POST["plan"])) {
	$plan = htmlentities($_POST["plan"]);
} else {
	header('Location: inpage.php');
	exit();
}

if (isset($_POST["a1"]) && !empty($_POST["a1"])) {
	$a1 = htmlentities($_POST["a1"]);
} else {
	header('Location: inpage.php');
	exit();
}



$err = "";
function unique($username, $plan, $ans){
	global $err;
	
	$con = mysqli_connect('localhost','guru','password','survey');
	if (mysqli_connect_errno())
	{
		return FALSE;
	}
	
	// See if user has logged in before
	if ($stmt = mysqli_prepare($con,"SELECT uid FROM t1 WHERE uid=?")){
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $exists);
		if(mysqli_stmt_fetch($stmt)==TRUE){
		// If he has,
			$err = "autherror";
			mysqli_close($con);
			return FALSE;
		}
		else
		{
			// Add his username to the table.
			if ($stmt = mysqli_prepare($con,"INSERT INTO t1 (uid) VALUES (?)")){
				mysqli_stmt_bind_param($stmt, "s", $username);
				mysqli_stmt_execute($stmt);
			}
			else{
				mysqli_close($con);
				return FALSE;
			}
			// Add his answer to the answers-table.
			if ($stmt = mysqli_prepare($con,"INSERT INTO t1answers (uid, plan, answer) VALUES (?,?,?)")){
				mysqli_stmt_bind_param($stmt, "sss", $username, $plan, $ans);
				mysqli_stmt_execute($stmt);
			}
			else{
				mysqli_close($con);
				return FALSE;
			}
			
			mysqli_close($con);
			return TRUE;
		}
	}
	else
	{
		mysqli_close($con);
		return FALSE;
	}
}

if (unique($username, $plan, $a1))
{
echo<<<HTML
<html>
<head><title>Submitted!</title></head>
<body>
Submitted!
<br/>
<a href="logout.php">Log Out</a>
</body>
</html>
HTML;
}
else
{
	if (empty($err))
		header("Location: inpage.php");
	else{
		if ($err=="autherror") 
			header("Location: index.php");
		else
			header("Location: inpage.php");
	}
	
}

?>

