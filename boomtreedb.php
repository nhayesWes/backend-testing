<!-- 
  COMP 333: Software Engineering
  Nigel Hayes (nchayes@wesleyan.edu) 

  To reach the php page, head to this link: http://localhost:8080/[INSERRT PHP FILE]
-->

<!DOCTYPE HTML>
<html lang="en">
<head>
  <!-- This is the default encoding type for the Html Form post submission. 
  Encoding type tells the browser how the form data should be encoded before 
  sending the form data to the server. 
  https://www.logicbig.com/quick-info/http/application_x-www-form-urlencoded.html-->
  <meta http-equiv="Content-Type" content="application/x-www-form-urlencoded"/>
  <title>Music Database - Boomtree</title> 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
  <link rel = "stylesheet" href="oreo.css">
</head>

<body>
  <!-- 
    PHP code for retrieving data from the database.
  -->
  <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "music-db";

    // Create server connection.
    // The MySQLi Extension (MySQL Improved) is a relational database driver 
    // used in the PHP scripting language to provide an interface with MySQL 
    // databases (https://en.wikipedia.org/wiki/MySQLi).
    // Instances of classes are created using `new`.
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check server connection.
    // -> is used to call a method or access a property the instance of a class,
    // in our case the connection conn we created calls the built in connect_error
    // method available to all connections.
    // Note the difference to =>, which is used for arrow functions, a more 
    // concise syntax for anonymous functions (which we will also see in JavaScript).
    // See https://stackoverflow.com/questions/14037290/what-does-this-mean-in-php-or/14037320.
    if ($conn->connect_error) {
      // Exit with the error message.
      // . is used to concatenate strings.
      die("Connection failed: " . $conn->connect_error);
    }

    // `isset` — Function to determine if a variable is declared and is different than null.
    // Generally, check out the PHP documentation. It is really good.
    // E.g., https://www.php.net/manual/en/function.isset.php
    // $_REQUEST is a PHP super global variable which is used to collect data 
    // after submitting an HTML form.
    // https://www.w3schools.com/PHP/php_superglobals_request.asp
    // Some predefined variables in PHP are "superglobals", which means that 
    // they are always accessible, regardless of scope - and you can access them 
    // from any function, class or file without having to do anything special.
    // https://www.w3schools.com/PHP/php_superglobals.asp
    if(isset($_REQUEST["register"]))
    {
      // Variables for the output and the web form below.
      $out_value = "";
      $REGuser = $_REQUEST['username'];
      $password = $_REQUEST['password'];

      // The following is the core part of this script where we connect PHP
      // and SQL.
      // Check that the user entered data in the form.
      if(!empty($REGuser) && !empty($password))
      {
        // If so, prepare SQL query with the data.
        $sql_query = "SELECT * FROM users_table WHERE username = ('$REGuser')";
        // Send the query and obtain the result.
        // mysqli_query performs a query against the database.
        $result = mysqli_query($conn, $sql_query);

        // mysqli_fetch_assoc returns an associative array that corresponds to the 
        // fetched row or NULL if there are no more rows.
        // Probably does not make much of a difference here, but, e.g., if there are
        // multiple rows returned, you can iterate over those with a loop.
        $row = mysqli_fetch_assoc($result);

        if ($row == NULL)
        {
          $sql_query = "INSERT INTO `users_table`(`username`, `password`) VALUES ('$REGuser','$password')";
          mysqli_query($conn, $sql_query);
          $REGuser = "Your username and passowrd has been registered!";
        }
        else
        {
          $REGuser = "The following username has been taken already: " . $row['username'];
        }
      }
      else 
      {
        $REGuser = "Please input a username and password!";
      }
    }


    if(isset($_REQUEST["retrieve"]))
    {
      // Variables for the output and the web form below.
      $out_value = "";
      $RETRuser = $_REQUEST['username'];

      // The following is the core part of this script where we connect PHP
      // and SQL.
      // Check that the user entered data in the form.
      if(!empty($RETRuser))
      {
        // If so, prepare SQL query with the data.
        $sql_query = "SELECT * FROM ratings_table WHERE username = ('$RETRuser')";
        // Send the query and obtain the result.
        // mysqli_query performs a query against the database.
        $result = mysqli_query($conn, $sql_query);

        // mysqli_fetch_assoc returns an associative array that corresponds to the 
        // fetched row or NULL if there are no more rows.
        // Probably does not make much of a difference here, but, e.g., if there are
        // multiple rows returned, you can iterate over those with a loop.

        if ($result == NULL)
        {
          $RETRuser = "This user has not rated any songs yet!";
        }
        else 
        {
          $rateList = "";
          while ($row = mysqli_fetch_assoc($result))
          {
            $rateList = $rateList . $row["song"] . " was rated: " . $row["rating"] . "\r\n";
          }
          $RETRuser = $rateList;
        }
      }
      else 
      {
        $RETRuser = "Please input a username!";
      }
    }

    $conn->close();
  ?>

  <!-- 
    HTML code for the form by which the user can query data.
    Note that we are using names (to pass values around in PHP) and not ids
    (which are for CSS styling or JavaScript functionality).
    You can leave the action in the form open 
    (https://stackoverflow.com/questions/1131781/is-it-a-good-practice-to-use-an-empty-url-for-a-html-forms-action-attribute-a)
  -->

  <div class="wrapper">
    <h1>Boomtree DB</h1>
    <h2>Registration</h2>
    <div>
      <form method="GET" action="">
        <label for="name">Username:</label>
        <input type="text" name="username" placeholder="Enter Your Username" id="name" /><br>

        <label for="password">Password:</label>
        <input type="password" name="password" placeholder="Enter Your Password" id="password" /><br>
        <input type="submit" name="register" value="Register">

        <p>
            <?php 
              if(!empty($REGuser))
              {
                echo $REGuser;
              }
            ?>
        </p>
      </form>
    </div>
      

    <h2>Retrieve Songs By Username</h2>

    <div>
      <form method="GET" action="">
        <label for="name">Username:</label>
        <input type="text" name="username" placeholder="Enter Your Username" id="name" /><br>
        <input type="submit" name="retrieve" value="Retrieve">

        <p>
            <?php 
              if(!empty($RETRuser))
              {
                echo nl2br($RETRuser);
              }
            ?>
        </p>
      </form>
    </div>

  </div>

</body>
</html>