<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/member.css">
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

    <div class="left">
    <div class="title"><p3 style="text-align: center">Search Books</p3></div>

<?php
    require_once 'login.php';
    $conn = new mysqli($hn, $un, $pw, $db);
    if ($conn->connect_error) die($conn->connect_error);

    echo <<<_END
    <form method="post" action="all.php" >
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
    </br></br>

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
    </br></br>

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
    </br></br>

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
    </br></br>

<?php

  $result->close();

  echo'</div>';
  echo'<div class="right">';
  echo'<p3 style="text-align: center">Manage Account</p3><br>';

  echo'<form method="post" action="account.php" >';
  echo'<input type="hidden" name="email" value="'.$username.'"></input>';
  echo'<p1><input type="submit" value="Account Summary" class="button"></input></p1><br><br>';
  echo'</form>';

  echo'<form method="post" action="timesborrowed.php" >';
  echo'<input type="hidden" name="email" value="'.$username.'"></input>';
  echo'<p1><input type="submit" value="Times Borrowed" class="button"></input></p1>';
  echo'</form>';

?>

  </div>
  </div>
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
<div class="spacer"></div>

<footer class="footer">
  <ul class="nav">
    <li><a href="../html/hours.html">Hours</a></li>
    <li><a href="../html/contact.html">Contact</a></li>
    <li><a href="../html/help.html">Help</a></li>
  </ul>
</footer>

</body>
</html>