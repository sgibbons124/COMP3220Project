<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/staff.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<?php
  session_start();
  if (isset($_SESSION['username'])) // check whether logged-in/not
  {    
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    destroy_session_and_data(); 
?>
  <div class="header">
    <div class="logo">
      <picture>
         <source srcset="../images/headercell.png" media="(max-width:768px)">
         <source srcset="../images/header.png" media="(max-width:1500px)">
         <img class="logo-image" src="../images/header.png" alt="hobbit hole" style="width: 100%;">
      </picture>
    </div>

    <form><div class="nav">
      <li><a onclick="history.back()">Main</a></li></form>
      <li><a href="form.php">Login</a></li> 
    </div>
  </div>
  <div class="body">
<?php

    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);

    echo <<<_END
    <form method="post" action="all.php" >

    <div class="left">
    <p3 style="text-align: center">Queries</p3>

_END;

    $query  = "SELECT * FROM book_detail ORDER BY category, title";
    $result = $conn->query($query);
    if (!$result) die ("Database access failed: " . $conn->error);

    $rows = $result->num_rows;
    
    echo'<table><tbody><tr>';
    echo'<td><p1><input type="submit" value="Select All Books" class="button"></input></p1></td>';
?>
    </tr></tbody></table>  
    </form>
    </br>

<?php

    $result->close();

    echo <<<_END
    <form method="post" action="category.php" >
_END;

    $query  = "SELECT DISTINCT category FROM book_detail ORDER BY category";
    $result = $conn->query($query);
    if (!$result) die ("Database access failed: " . $conn->error);

    $rows = $result->num_rows;
    
    echo'<table><tbody><tr>';
    echo'<td><p1><input type="submit" value="Select Category" class="dropbtn"></input></p1></td>';
    echo'<td><select name="category" class="dropdown-content">';

    for ($j = 0 ; $j < $rows ; ++$j)
    {
      $result->data_seek($j);
      $row = $result->fetch_array(MYSQLI_NUM);

      echo <<<_END
      <option value="$row[0]"> $row[0] </option>
_END;
    }
?>
    </select>
    </td></tr></tbody></table>  
    </form>
    </br>

<?php

    $result->close();

    echo <<<_END
    <form method="post" action="author.php" >
_END;

    $query  = "SELECT DISTINCT author FROM book_detail ORDER BY author";
    $result = $conn->query($query);
    if (!$result) die ("Database access failed: " . $conn->error);

    $rows = $result->num_rows;

    echo'<table><tbody><tr>';
    echo'<td><p1><input type="submit" value="Select Author" class="dropbtn"></input></p1></td>';
    echo'<td><select name="author" class="dropdown-content">';

    for ($j = 0 ; $j < $rows ; ++$j)
    {
      $result->data_seek($j);
      $row = $result->fetch_array(MYSQLI_NUM);

      echo <<<_END
      <option value="$row[0]"> $row[0] </option>
_END;
    }
?>
    </select>
    </td></tr></tbody></table>  
    </form>
    </br>

<?php

    $result->close();

    echo <<<_END
    <form method="post" action="title.php" >
_END;

   $query  = "SELECT DISTINCT title FROM book_detail ORDER BY title";
   $result = $conn->query($query);
   if (!$result) die ("Database access failed: " . $conn->error);

   $rows = $result->num_rows;

    echo'<table><tbody><tr>';
    echo'<td><p1><input type="submit" value="Select Title" class="dropbtn"></input></p1></td>';
    echo'<td><select name="title" class="dropdown-content">';

    for ($j = 0 ; $j < $rows ; ++$j)
    {
      $result->data_seek($j);
      $row = $result->fetch_array(MYSQLI_NUM);

      echo <<<_END
      <option value="$row[0]"> $row[0] </option>
_END;
    }
?>
    </select>
    </td></tr></tbody></table>  
    </form>
    </br>

<?php

  $result->close();
?>

  </div>

  <div class="center">
  <p3 style="text-align: center">Management</p3>

   <form action = "borrow.php" method="post">
     <p2><input type="submit"  name="submit"  value="Borrow a Book" class="button"> </input> </p2><br> 
   </form>

   <form action = "return.php" method="post">
     <p2><input type="submit"  name="submit"  value="Return a Book" class="button"> </input> </p2><br> 
   </form>

   <form action = "status.php" method="post">
     <p2><input type="submit"  name="submit"  value="Book Status Update" class="button"> </input> </p2><br> 
   </form>

  </div>

  <div class="right">
  <p3 style="text-align: center">Reports</p3>
  <form action = "categoryrpt.php" method="post">
     <p2><input type="submit"  name="submit"  value="Categories Borrowed" class="button"> </input> </p2><br> 
   </form>

   <form action = "borrowrpt.php" method="post">
     <p2><input type="submit"  name="submit"  value="Borrowed by Member " class="button"> </input> </p2><br> 
   </form>

   <form action = "memberrpt.php" method="post">
     <p2><input type="submit"  name="submit"  value="Who Borrowed Most" class="button"> </input> </p2><br> 
   </form>

   <form action = "titlerpt.php" method="post">
     <p2><input type="submit"  name="submit"  value="Times Borrowed" class="button"> </input> </p2><br> 
   </form>


<?php
  $conn->close();

}
  else // not logged-in
    echo "Please <a href='authenticate.php'>click here</a> to log in.";
  
  function destroy_session_and_data()
  {
    $_SESSION = array();
    setcookie(session_name(), '', time() - 1, '/');
    session_destroy();
  }
  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>
  </div>
</div>
<div class="spacer"></div>

<div class="footer">
  <ul class="nav">
    <li><a href="../html/hours.html">Hours</a></li>
    <li><a href="../html/contact.html">Contact</a></li>
    <li><a href="../html/help.html">Help</a></li>   
  </ul>
</div>
</body>
</html>