<?php
session_start();
header("cache_control: no-store,no-cache,must-revalidate ,max-age=0");
 header("cache-control:post-check=0, pre-check=0,false");
   header("pragma:no-cache");
   header("Expires:0");  
if(!isset($_SESSION['admin_id']))
{
    header("Location:log.php");
    exit();
}   
?>
<?php
include('db.php');
$query="select count(*) as total from certificate_drafts where notification ='on'";
$result=mysqli_query($con,$query);
$data=mysqli_fetch_assoc($result);
$notif_count=$data['total'];
?>   

<!doctype html>
<head>
    <title>Admin Dashboard </title>
    <style>
        body
        {
            font-family':'Times new roman',sans-serif;
            padding:20px;
        }
         h1
        {
        text-align:center;
        color:white;
        font-family:'Times new roman';
        background-color:#8B0000;
        }
        .dashboard-buttons
        {
            display:flex;
            flex-wrap:wrap;
            justify-content:center;
            gap:20px;
            margin-top:30px;
        }
        .button
        {
            padding:60px 60px;
            font-size:30px;
            text-align:centre;
            background-color:#007bff;
            color:white;
            boder:none;
            border-radius:5px;
            text-decoration:none;
            cursor: pointer;
        }
        .button:hover
        {
          background-color:#0056b3;
        }
        .badge
        {
            background-color:red;
            
            right:434px;
            color:white;
            position:absolute;
            font-size:12px;
            border-radius:50%;
            padding:4px 7px;
        }
        
        </style>
</head>
<body>
    <div style="text-align:right; padding:15px;">
    <a href="logout.php"  class="button" name="logout"
    style="background-color:red; color:white; padding:10px 20px; border-radius:5px; text-decoration:none;">log out</a></div>
     <h1> Welcome to Admin Dashboard &nbsp &nbsp
        <a href="certificate_dashboard.php" class="noti"><img src="bell.jpg" height="47" >
        <?php if ($notif_count>0): ?>
        <span class="badge">
            <?php echo $notif_count;?></span>
            <?php endif; ?>
         </a>
    </h1>
    <br>
    <div class="dashboard-buttons">
     <a href="manage_clients.php" class="button">Manage clients</a>
     <a href="create_draft.php" class="button">Create Certificate Draft</a>
     <a href="certificate_dashboard.php" class="button">Certificate Dashboard</a>
</div>
 
</body>
</html>


   