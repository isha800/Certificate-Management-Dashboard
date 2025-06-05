<?php
   
   error_reporting(E_ERROR);
   include("db.php");
?>
<?php
  
    if(isset($_POST['submit']))//add client
  {
    $name=$_POST['uname'];
    $email=$_POST['eid'];
    /*if(!filter_var($email,FILTER_VALIDATE_EMAIL))
      {
        echo"<font color='red'>Invalid email format!</font>";
       header("Location:manage_clients.php?success=1");
        exit();
    }*/
    $pass=password_hash($_POST['paswrd'],PASSWORD_DEFAULT);
    $qry="INSERT INTO users (name, email,password,role) VALUES ('$name','$email','$pass','client')";
    $run=mysqli_query($con ,$qry);
    if($run==true)
    {
        header("Location:manage_clients.php?success=1");
        exit();
    }
    
  }

?>
<?php
if(isset($_POST['delete']))
  {  
    $id=intval($_POST['id']);
    $qry="DELETE FROM users WHERE client_id=$id";
    $res =mysqli_query($con , $qry);
    if($res==true)
    {
        header("Location:manage_clients.php?delete=1");
        exit();
 }
 }
?>

<?php
   if(isset($_GET['success'])):?>
  <script>
     alert('Client added successfully!');
     history.replaceState(null,"",location.pathname);
  </script>
  <?php
    endif;
   ?>
<?php
   if(isset($_GET['delete'])):?>
  <script>
     alert('Client deleted successfully!');
     history.replaceState(null,"",location.pathname);
  </script>
  <?php
   endif;
  ?>

<doctype html>
<html lang="en">
    <head><meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>manage clients</title>
    <style>
   .ta th
    {
      background-color:#808080;
      color:white;
    }
    .ta 
    {
      height:20px;
      font-family:'Times new roman';
      font-size:20px;
      margin-left:auto;
      margin-right:auto;
    }
    
     h1
     {
        text-align:center;
        color:white;
        font-family:'Times new roman';
        background-color:brown;
     }
     .tab
     {
        
        height:250px;
        border:0px solid;
        text-align:center;
        margin-left:auto;
        margin-right:auto;
        font-family:'Times new roman';
        font-size:20px;
    }
     .su
     {
        width: 300px;
        padding:10px;
        border-radius:4px;
        color:white;
        cursor:pointer;
        background: rgb(19, 73, 155);
        font-size:18px;    
    }
     .but
        {
            padding:10px ;
            font-size:16px;
            text-align:center;
            background-color:red;
            color:white;
            border:none;
            border-radius:5px;
            text-decoration:none;
            cursor: pointer;
            text-align:left;
            margin-left:1160px;
        
            
        }
        .button
        {
           text-align:center;
           background-color:red;
           color:white;
           cursor: pointer;
           border:none;

        }

     </style>
</head>
<body>
    
    <a href="admin_dashboard.php"  class="but" name="logout">Back to Dashboard</a>
    <form method="POST" action="manage_clients.php">
    <table class="tab">
        <tr><h1>Manage Clients</h1></tr>
        <tr>
            <td> Client Name:
             <input type="text" pattern="[A-Za-z\s]+" title="Only Letters are allowed" name="uname" placeholder="Enter client name" size="35 " required></td>
        </tr>
        <tr>
            <td> Email Id:
             <input type="email" name="eid" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" tilte="Only gmail address allowed"  placeholder="Enter email "  size="35" required></td>
        </tr>
        <tr>
            <td> Password:
             <input type="password" name="paswrd" placeholder="Enter password "  size="35" required></td>
        </tr>
        <tr>
            <td><button type="submit"  name="submit"  class="su">Add Client</button></td>

        </tr>
    </table></form>
    
    <table class="ta" cellpadding="10px" cellspacing="0px" border="2px" >
       
            <tr>
                <th>Client_ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php
                   $query="SELECT * FROM users  WHERE  role='client'";
                   $result= mysqli_query($con,$query);
                   
               while($row=mysqli_fetch_assoc($result))
               {
                  echo "<tr>";
                  echo "<td>{$row['client_id']}</td>";
                  echo "<td>{$row['name']}</td>";
                  echo"<td>{$row['email']}</td>";
                  echo"<td>{$row['role']}</td>";
                        echo"<td>";
                        
                        echo "<form method='post' style='display:inline;'>
                            <input type='hidden' name='id' value='{$row ['client_id']}'>
                            <button type='submit' class='button' name='delete' onclick='return confirm(\"Are You Sure?\")'>Delete</button>
                        </form>";
                        echo "</td>";
                    echo"</tr>";
                        
               }
            ?>
        </table>
</body>
</html>





 