<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Category','cnt'],
<?php

  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  $query  = "SELECT category, count(category) as cnt FROM borrow, book_detail WHERE borrow.isbn=book_detail.isbn GROUP BY category";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed: " . $conn->error);
  
  $rows = $result->num_rows;

  for ($j = 0 ; $j < $rows ; ++$j)
            {
               $result->data_seek($j);
               $row = $result->fetch_array(MYSQLI_NUM);
   
               echo <<<_END
              ['$row[0]',$row[1]],
_END;

             }
  $result->close();
  $conn->close();

?>               
        ]);
          
        var options = {title: 'Percentage of Publications based on Category'};

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>
  <link rel="stylesheet" type="text/css" href="../css/charts.css">
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

    <form><div class="nav">
      <li><a onclick="history.back()">Main</a></li></form>
      <li><a href="form.php">Login</a></li> 
    </div>

<div id="piechart" style="width:900px; height:400px; display:block;"></div>

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