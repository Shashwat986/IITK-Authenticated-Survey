<?php
if (session_id() == '') {
    session_start();
}
else
{
	session_destroy();
	session_start();
}

// Code starts here

function login($username, $password){
	$ftp_server="webhome.cc.iitk.ac.in";
	//set up basic connection
	$conn_id = ftp_connect($ftp_server);
	// login with username and password
	$login_result = ftp_login($conn_id, $username, $password);
	ftp_close($conn_id);
	if($login_result){
		return TRUE;
	}
	else{
		return FALSE;
	}
}

function unique($username){
	$con = mysqli_connect('localhost','guru','password','survey');
	if (mysqli_connect_errno())
	{
		echo "!!!";
		return FALSE;
	}
	if ($stmt = mysqli_prepare($con,"SELECT uid FROM t1 WHERE uid=?")){
		mysqli_stmt_bind_param($stmt, "s", $username);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $exists);
		if(mysqli_stmt_fetch($stmt)==TRUE){
			mysqli_close($con);
			return FALSE;
		}
		else
		{
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

if (isset($_POST["uname"]) && ctype_alnum($_POST["uname"])) $username = $_POST["uname"]; else header('Location: index.php');
if (isset($_POST["pword"])) $password = $_POST["pword"]; else header('Location: index.php');

if (unique($username))
{
	if (login($username,$password))
	{
		$_SESSION["username"] = $username;
		$_SESSION["auth"] = "true";
		header('Location: inpage.php');
	}
	else
	{
		$msg = "Login Incorrect";
	}
}
else
{
	$msg = "Already participated in the survey.";
}
?>

<html>
<head><title>Error</title></head>
<body>
<?php
	echo $msg;
?>
<br/>
<a href="index.php">Back</a>
</body>
</html>
