<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/login.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div class="logo">
      <picture>
         <source srcset="../images/headercell.png" media="(max-width:768px)">
         <source srcset="../images/header.png" media="(max-width:1500px)">
         <img class="logo-image" src="../images/header.png" alt="hobbit hole" style="width: 100%;">
      </picture>
    </div>

  <div class="nav">
    <li><a href="../html/hours.html">Hours</a></li>
    <li><a href="../html/contact.html">Contact</a></li>
    <li><a href="../html/help.html">Help</a></li>
    <li><a href="form.php">Login</a></li>
  </div>

<?php
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  if (isset($_POST['isbn'])   &&
      isset($_POST['book_status']))
  {

    $stmt = $conn->prepare("UPDATE book SET book_status=? WHERE isbn=?");

    $book_status = get_post($conn, 'book_status');
    $isbn = get_post($conn, 'isbn');

    $stmt->bind_param("ss", $book_status, $isbn);

    $stmt->execute();

    if(!$stmt->error)
     {
       echo "UPDATED record successfully.<br><br>";
     }
    else
     {
       echo "UPDATE failed".$stmt->error;
     }

   }

   echo '<form action="status.php" method="post">';

   echo'<p1>Update Book Status</p1><br>';

   echo '<div class="input"><p2>ISBN: <input type="text" name="isbn"></input></div><br></p2>';

   echo '<div class="input2"><p2>Book Status: <select name="book_status" style="display: block" class="dropdown-content">';
   echo '<option value="Available"> Available </option>';
   echo '<option value="Borrowed"> Borrowed </option>';
   echo '<option value="Repair"> Repair </option>';
   echo '<option value="Lost"> Lost </option>';
   echo '</select><br></p2></div>';

   echo '<p1><input type="submit" class="button" value="SUBMIT"></p1>';
  
   echo '</form>';

   $result->close();
   $conn->close();

  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>

<footer class="footer">
  <ul class="nav">
    <li><a href="../html/hours.html">Hours</a></li>
    <li><a href="../html/contact.html">Contact</a></li>
    <li><a href="../html/help.html">Help</a></li>
    <li><a href="form.php">Login</a></li>
  </ul>
</footer>

</body>
</html>