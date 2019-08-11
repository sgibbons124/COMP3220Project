<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" type="text/css" href="../css/search.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div class="container">
  <div class="main">

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

<?php 
 
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  $query  = "SELECT borrow.isbn, title, author, category, year, count(borrow.isbn) FROM book_detail, borrow WHERE borrow.isbn=book_detail.isbn GROUP BY borrow.isbn ORDER BY count(borrow.isbn) desc";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);
  
  $rows = $result->num_rows;
  
  echo'<p1>How Often a Title Was Borrowed</p1>';

  echo <<<_END
  <form method="post" action="searchresults.php" id="test">
  <table>
   <thead>
     <tr>
       <th>ISBN</th>          
       <th>Title</th> 
       <th>Author</th>     
       <th>Category</th>     
       <th>Year</th>
       <th>Times Borrowed</th>     
     </tr>
   </thead>
   <tbody>
_END;
   
  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
   
    echo <<<_END
     <tr>
      <td> $row[0]</td>
      <td style="text-align: left"> $row[1]</td>
      <td> $row[2]</td>
      <td> $row[3]</td>
      <td> $row[4]</td>
      <td> $row[5]</td>
     </tr>
     </tbody>
     
_END;
 

}
  echo"</table>";
  echo"</form>";
  $result->close();
  $conn->close();

  
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
?>


  </div>
</div>

<footer class="footer">
  <ul class="nav">
    <li><a href="../html/hours.html">Hours</a></li>
    <li><a href="../html/contact.html">Contact</a></li>
    <li><a href="../html/help.html">Help</a></li>   
  </ul>
</footer>

</body>
</html>