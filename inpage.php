<?php session_start(); ?>

<html>
<head><title>Survey</title></head>
<body>

<?php

// If the session variables haven't been set.
if (!isset($_SESSION["auth"]) || $_SESSION["auth"]!="true" || !isset($_SESSION["username"]))
{
	echo "Login Error";
	exit();
}

$username = htmlentities($_SESSION["username"]);

echo "Welcome " . $username . ",<br/>";

?>

<form action="submit.php" method="post">

<p/>
Both questions are compulsary.
<p/>
Do you agree with the changes proposed in the new internship policy?<br/>
<input type="radio" name="plan" value="yes"/> Yes<br/>
<input type="radio" name="plan" value="no"/> No<br/>


<br/>
Whether you agree or disagree, what are your suggestions regarding these policies? Please give appropriate reasons for any suggestion.
<br/>
<textarea name="a1" rows="6" cols="100"></textarea>

<br/>
<input type="submit" value="Submit"/>
</form>


<a href="logout.php">Log Out</a> without filling the form.


</body>
</html>
