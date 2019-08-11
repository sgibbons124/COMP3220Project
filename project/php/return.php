<!DOCTYPE html>
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

  if (isset($_POST['isbn']))
  {

    $stmt = $conn->prepare("UPDATE borrow SET return_date=? WHERE isbn=?");

    $enddate=strtotime("+12000 month");
    $return_date=date("Ymd",$enddate);

    $isbn = get_post($conn, 'isbn');
   
    $stmt->bind_param("ss", $return_date, $isbn);

    $stmt->execute();

    $query  = "UPDATE book SET book_status='Available' WHERE isbn='$isbn'";
    $result = $conn->query($query);
    if (!$result) echo "UPDATE failed: $query<br>" . $conn->error . "<br><br>";

    if(!$stmt->error)
     {
       echo "Update record successfully.<br><br>";
     }
    else
     {
       echo "UPDATE failed".$stmt->error;
     }

   }

   echo '<form action="return.php" method="post">';

   echo '<div class="input" ><p2>ISBN: <input type="text" name="isbn"><br></input></p2></div>';
   echo '<input type="submit" class="button" value="SUBMIT">';
  
   echo '</form>';

   $result->close();
   $conn->close();

  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>


</body>
</html>