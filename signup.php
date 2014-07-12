<html>
<head>
  <title>PHP Sign In Form</title>
</head>
<body>
  <?php
  $filled = true;
  $name = $email = $pass = $about = "";
  $nameErr = $emailErr = $passErr = $genderErr = "";
  if($_SERVER["REQUEST_METHOD"] == "POST") 
  {
    $about = $_POST['about'];
    if(!empty($_POST['gender']))
    {
      $gender = test_input($_POST['gender']);
    }
    else
    {
      $filled = false;
      $genderErr = "Gender is Required";
    }
    if(!empty($_POST['uname']))
    {
      $name = test_input($_POST['uname']);
      // check if name only contains letters and whitespace
      if (!preg_match("/^[a-zA-Z0-9 ]*$/",$name)) 
      {
        $filled = false;
        $nameErr = "Only letters, numbers and white space allowed"; 
      }
    }
    else{
      $filled = false;
      $nameErr = "Username Required";
    }
    if(!empty($_POST['uemail']))
    {
      $email = test_input($_POST['uemail']);
      // check if e-mail address syntax is valid
      if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)) 
      {
        $filled = false;
        $emailErr = "Invalid email format";
      }
    }
    else{
      $filled = false;
      $emailErr = "Email Required";
    }
    if(!empty($_POST['upass']) || !empty($_POST['ucpass']))
    {
      if($_POST['upass'] == $_POST['ucpass'])
      {
        if(strlen($_POST['upass'])<=15){
          $pass = $_POST['upass'];
        }
        else{
          $pass = "";
          $filled = false;
          $passErr = "Password length should be below 16 characters";
        }
      }
      else
      {
        $filled = false;
        $passErr = "Passwords mismatch";
        if(empty($_POST['upass'])||empty($_POST['ucpass']))
        {
          $passErr = "Fill both the password fields";
        }
        $pass = "";

      }
    }
    else
    {
      $filled = false;
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
        <td><input name ='uname' maxlength="50" style="width:250px" type='text' <?php echo "value=$name"; ?>>
          <span style='font-size:0.6em;color:red;'>*<?php echo $nameErr; ?></span></td> 
        </tr> 
        <tr>
          <td><span style='font-size:1.2em;'>Email Address: </span></td>
          <td><input name ='uemail' maxlength="100" style="width:250px"  type='text' <?php echo "value=$email"; ?>>
            <span style='font-size:0.6em;color:red;'>*<?php echo $emailErr; ?></span></td> 
          </tr>
          <tr>
            <td><span style='font-size:1.2em;'>Enter Password: </span></td>
            <td><input name ='upass' style="width:250px"  type='password'>
              <span style='font-size:0.6em;color:red;'>*<?php echo $passErr; ?></span></td> 
            </tr>
            <tr>
              <td><span style='font-size:1.2em;'>ReEnter Password: </span></td>
              <td><input name ='ucpass' style="width:250px"  type='password'>
                <span style='font-size:0.6em;color:red;'>*<?php echo $passErr; ?></span></td> 
              </tr>
              <tr>
                <td>
                  <span style='font-size:1.2em;'>Gender: </span>
                </td>
                <td>
                  <input style='font-size:1.2em;' type='radio' name='gender' value='Male' <?php if (isset($gender) && $gender=="Male") echo "checked";?>>Male
                  <input style='font-size:1.2em;' type='radio' name='gender' value='Female' <?php if (isset($gender) && $gender=="Female") echo "checked";?>>Female
                  <input style='font-size:1.2em;' type='radio' name='gender' value='Other' <?php if (isset($gender) && $gender=="Other") echo "checked";?>>Other
                  <span style='font-size:0.6em;color:red;'>*<?php echo $genderErr; ?></span></td>
                </td>
              </tr>
              <tr>
                <td><span style='font-size:1.2em;'>About You: </span></td>
                <td><textarea maxlength="500" rows="4" style="width:250px;resize:none;" name="about" ><?php echo "$about"; ?></textarea>
                  <span style='font-size:0.7em;color:red;'>Maximum of 500 characters</span></td> 
                </tr>
                <tr>
                  <td colspan="2" align = "center"><button type="submit" value="submit" style="font-size:1em;" >Sign Up</button></td>
                </tr>
              </table>
            </form>
            <?php
            if($_SERVER["REQUEST_METHOD"] == "POST" && $GLOBALS['filled'] == true)
            {
              $date = date("Y/m/d");
            //create database connection to database Bullshit and upload into the table Customers with columns id, name, password, email, date, about
              $dbname = "a3643009_bullshi";
              $table = "customers";            
              $dbhost = 'mysql1.000webhost.com';
              $dbuser = 'a3643009_root';
              $dbpass = 'password123';
              $conn = mysql_connect($dbhost, $dbuser, $dbpass);
              if(! $conn )
              {
                die('Could not connect: ' . mysql_error());
              }
              //echo 'Connected successfully';

              $sql = "INSERT INTO `".$table."`(`name`, `password`, `email`, `date1`, `about`) VALUES ('".$name."','".$pass."','".$email."','".$date."','".$about."')";

              mysql_select_db($dbname);
              $retval = mysql_query( $sql, $conn );
              if(! $retval )
              {
                //die('Could not enter data: ' . mysql_error());
                die('This Email Id already exists, try another one');
              }
              mysql_close($conn);
              echo "Congratulations!!! your account has been created :-)\n";
              echo "<h3>Account created on ".substr($date, 8, 2)."/".substr($date, 5, 2)."/".substr($date, 0, 4)."</h3>";
              echo "<h3>Your Username is ".$name."</h3>";
              echo "<h3>Your Email Id is ".$email."</h3>";
              $about = str_replace("\n", "<br>", $about);
              echo "<h3> About You :<br> $about</h3>";              
            }
            ?>
          </body>
          </html>
