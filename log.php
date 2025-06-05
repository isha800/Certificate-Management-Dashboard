
<?php
SESSION_START();
include("db.php");
if(isset($_POST['log']))
{
    $uid=$_POST['email'];
    $pwrd=$_POST['pass'];
    $q1="SELECT * FROM  admins  WHERE email='$uid' AND password='$pwrd'";
    $r1=mysqli_query($con,$q1);
    if(mysqli_num_rows($r1)==1)
    {
        $admin=mysqli_fetch_assoc($r1);
        $_SESSION['admin_id']=$admin['admin_id'];
        $_SESSION['role']='admin';
        echo"<script>
         alert('Admin login successful!');
         window.open('admin_dashboard.php','_self');
        </script>";
        exit();
    }
    $q2="select * from users where email='$uid' and password='$pwrd'";
    $r2=mysqli_query($con,$q2);
    if(mysqli_num_rows($r2)==1)
    {
        $client=mysqli_fetch_assoc($r2);
        $_SESSION['client_id']=$client['client_id'];
        $_SESSION['role']='client';
        echo"<script>
         alert('Client login successful!');
         window.open('client_dashboard.php','_self');
        </script>";
        exit();
    }
          echo"<script>
         alert('Invalid email or password');
         window.open('log.php','_self');
         </script>";
 }
    
?>
<!doctype html>
<html lang="en">
    <head><meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <title>admin and client login page</title>
    <style>
        *{
            box-sizing:border-box;
            margin:0;
            padding:0;
            font-family:'Time New Roman';
        }
    body{
        font-family:'Time New Roman';
        display:flex;
        justify-content:center;
        align-items:center;
        height: 100vh;
    }
    .heading
    {
       text-align:center;
       margin-bottom:40px;
    }
    label
    {
        display:block;
        margin:0px 0 0px;
        font-family:'Time New Roman';
    }
    .em
    {
        background-color:#fff;
        padding:20px ;
        text-align:left;
        boder-radius:10px;
        box-shadow:0 0 10px rgba(0, 0, 0, 0.1);
        width:100px;
    }

    .em
    {
      width:350px;
      height:300px;
      padding:10px;
      margin-bottom:20px;
      border:none;
      border-radius:8px;
    }
    .su 
    {
        width: 280px;
        padding:10px;
        border-radius:6px;
        color:white;
        cursor:pointer;
    }
    .su
    {
        text-align:center;
        color:white;
        font-family:'Time New Roman';
        font-size:16px;
        background-color: rgb(19, 73, 155);
    }
    h2
     {
        text-align:center;
        color:white;
        font-family:'Time New Roman';
        background-color:maroon;
        font-size:28px;
     }
    
    </style>
</head>
<body bgcolor='#fafafa'>
  <div class="heading" >
    <form action="log.php" method="POST" autocomplete="off">
          <div class="em">
                <h2> Certificate Management Dashboard</h2><br>
             &nbsp <label for="email" >Email</label>
             <input type="email" id="email" name="email"  placeholder="Enter your email address" 
              size="35"required><br><br>
             &nbsp <label for="password" >Password</label>
                <input type="password" id="password" name="pass"  placeholder="Enter your Password" 
                size="35"required><br><br><br>
                <button type="submit" name="log" class="su" >Log In </button>
            </div>

    </form>
  </div>
</body>
</html>
