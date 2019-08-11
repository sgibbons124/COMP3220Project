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

  if (isset($_POST['isbn'])   &&
      isset($_POST['member_id']))
  {

    $stmt = $conn->prepare("INSERT INTO borrow(isbn, member_id, issue_date, due_date) VALUES(?, ?, ?, ?)");

    $isbn = get_post($conn, 'isbn');
    $member_id = get_post($conn, 'member_id');

    $enddate=strtotime("+12000 month");
    $enddate2=strtotime("+12001 month");

    $issue_date=date("Ymd",$enddate);
    $due_date=date("Ymd",$enddate2);

    $stmt->bind_param("ssss", $isbn, $member_id, $issue_date,  $due_date);

    $stmt->execute();

    $query  = "UPDATE book SET book_status='Borrowed' WHERE isbn='$isbn'";
    $result = $conn->query($query);

    if(!$stmt->error)
     {
       echo "Inserted record successfully.<br><br>";
     }
    else
     {
       echo "INSERT failed".$stmt->error;
     }

   }

   echo '<form action="borrow.php" method="post">';

   echo'<p1>Borrow a Book</p1>';

   echo '<div class="input" ><p2>ISBN: <br><input type="text" name="isbn"></input></p2></div><br>';
   echo '<div class="input2" ><p2>Member ID:  <br><input type="text" name="member_id"></input></p2></div><br>';

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