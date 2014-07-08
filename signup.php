<html>
<head>
  <title>PHP Sign In Form</title>
</head>
<body>
  <?php
  $filled = true;
  $name = $email = $pass = $about = "";
  $nameErr = $emailErr = $passErr = "";
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	if(!empty($_POST['uname']))
  	{
  		$name = test_input($_POST['uname']);
  		// check if name only contains letters and whitespace
     if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
       $nameErr = "Only letters and white space allowed"; 
     }
  	}
  	else
  	{
  		$nameErr = "Username Required";
  	}
  	if(!empty($_POST['uemail']))
  	{
  		$email = test_input($_POST['uemail']);
  		// check if e-mail address syntax is valid
     if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) {
       $emailErr = "Invalid email format";
  	}
  	else
  	{
  		$emailErr = "Email Required";
  	}
  	if(!empty($_POST['upass']) && !empty($_POST['ucpass']))
  	{
  		if($_POST['upass'] == $_POST['ucpass'])
  		{
  			if(strlen($_POST['upass'])<=15)
  			{
  				$pass = "";
  			}
  			else
  			{
  				$pass = "";
  				$passErr = "Password length should be below 16 characters";
  			}

  		}
  		else
  		{
  			$pass = "";
  			$passErr = "Passwords mismatch";
  		}
  	}
  	else
  	{
  		$passErr = "Password Required";
  	}
  }

  function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
  ?>
  <h1>Sign up Form<h1>
  <form method = "post" action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <table>
      <tr>
        <td><span style='font-size:1.2em;'>Username: </span></td>
        <td><input name ='uname' style="width:250px" type='text' <?php echo "value=$name"; ?>>
          <span style='font-size:0.6em;color:red;'>*<?php echo $nameErr; ?></span></td> 
        </tr>
        <tr>
          <td><span style='font-size:1.2em;'>Email Address: </span></td>
          <td><input name ='uemail' style="width:250px"  type='text' <?php echo "value=$email"; ?>>
            <span style='font-size:0.6em;color:red;'>*<?php echo $emailErr; ?></span></td> 
          </tr>
          <tr>
            <td><span style='font-size:1.2em;'>Enter Password: </span></td>
            <td><input name ='upass' style="width:250px"  type='password' <?php echo "value=$pass"; ?>>
              <span style='font-size:0.6em;color:red;'>*<?php echo $passErr; ?></span></td> 
            </tr>
            <tr>
              <td><span style='font-size:1.2em;'>ReEnter Password: </span></td>
              <td><input name ='ucpass' style="width:250px"  type='password' <?php echo "value=$pass"; ?>>
                <span style='font-size:0.6em;color:red;'>*<?php echo $passErr; ?></span></td> 
              </tr>
              <tr>
                <td><span style='font-size:1.2em;'>About You: </span></td>
                <td><textarea rows="4" style="width:250px;resize:none;" ><?php echo "$about"; ?></textarea></td> 
              </tr>
              <tr>
                <td ></td>
                <td ><button type="submit" value="submit" style="font-size:1em;margin-left:2em">Sign Up</button></td>
              </tr>
            </table>
          <form>
          <h2>Feedback Form</h2>
<?php
// display form if user has not clicked submit
if ($filled == true && !isset($_POST["submit"])) {
  $date = date("d/m/Y");
  //enter the signup time and details into the database
  echo "<h2>Data entered into the database</h2>"
  
} 
?>
          </body>
          </html>
