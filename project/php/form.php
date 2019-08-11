<html>

 <head>
   <link rel="stylesheet" type="text/css" href="../css/login.css"> </link> 
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

    <div class="nav">
      <li><a href="../html/hobbitonu.html">Return to Main</a></li> 
    </div>

</br></br>

<?php
echo <<<_END
   <form action = "authenticate.php" method="post">
     <p1>Login Form</p1><br>

     <div class="input"><p2><label for="userid">User ID:</label>
     <input type="text"  name="userid"  id="userid"> </input></p2> </div><br>
     <div class="input2"><p2><label for="password">Password:</label>
     <input type="password"  name="password"  id="password"> </input></div> <br>
     <input type="submit"  name="submit"  value="Submit" class="button"> </input> </p2><br> 
   </form>
_END
?>
</div>
</div>

<div class="spacer"></div>

<footer class="footer">
  <ul class="nav">
    <li><a >Return to Main</a></li>  
  </ul>
</footer>
</body>
</html>