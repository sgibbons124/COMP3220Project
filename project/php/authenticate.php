<?php 

  require_once 'login.php';
  $connection = new mysqli($hn, $un, $pw, $db);

  if ($connection->connect_error) die($connection->connect_error);

  $rec_un = $_REQUEST['userid'];
  $rec_pw = $_REQUEST['password'];

  if(isset($_REQUEST['userid']) && isset($_REQUEST['password']))
  {
    $un_temp = mysql_entities_fix_string($connection, $rec_un);
    $pw_temp = mysql_entities_fix_string($connection, $rec_pw);
    $query = "SELECT * FROM member_detail WHERE email ='$un_temp'";
    $result = $connection->query($query);
    if (!$result) die($connection->error);  

    elseif ($result->num_rows)
    {
        $row = $result->fetch_array(MYSQLI_NUM);
        $result->close();    

        if ($pw_temp == $row[3]) 
        {
           session_start();
           $_SESSION['username'] = $un_temp;
           $_SESSION['password'] = $pw_temp; 

           $query = "SELECT * FROM member_detail WHERE email ='$un_temp'";
           $result = $connection->query($query);
           if (!$result) die($connection->error); 
           $row = $result->fetch_array(MYSQLI_NUM);
           $id = $row[0];
           $result->close();

           $query = "SELECT * FROM member WHERE member_id = $id";
           $result = $connection->query($query);
           if (!$result) die($connection->error); 
           $row = $result->fetch_array(MYSQLI_NUM);
           $position = $row[3];
           $result->close();

           if ($position == "Student")
           {
              header('Location:member.php');
           }
           else if ($position == "Professor")
           {
              header('Location:member.php');
           }   
            else if ($position == "Librarian")
           {
              header('Location:staff.php');
           } 
        }
		
        else die("Invalid username/password combination");
     }
     else die("Invalid username/password combination");
  }

  else
  {
    header('Location:form.php');    
    $connection->close();
  }
  
    $connection->close();
  function mysql_entities_fix_string($connection, $string)
  {
    return htmlentities(mysql_fix_string($connection, $string));
  }	

  function mysql_fix_string($connection, $string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connection->real_escape_string($string);
  }

?>