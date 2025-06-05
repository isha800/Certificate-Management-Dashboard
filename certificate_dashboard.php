
<?php
include("db.php");
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['status']))
{
    $cert_id=$_POST['cert_id'];
    $status=$_POST['status'];
    $qry="UPDATE certificate_drafts SET status='$status' WHERE cert_id='$cert_id'";
    mysqli_query($con,$qry);
    header("Location:certificate_dashboard.php? success=1");
    exit();
 } 

?>
<?php
   if(isset($_GET['success'])):?>
  <script>
     
     history.replaceState(null,"",location.pathname);
  </script>
  <?php
    endif;
   ?>
<!doctype html>
<html lang="en">
    <head><meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <style>
      .su
     {
        width: 150px;
        padding:10px;
        border-radius:6px;
        color:white;
        cursor:pointer;
        background: rgb(19, 73, 155);
        font-size:17px;
        
     }
     h1
     {
        text-align:center;
        color:white;
        font-family:'New Times Roman';
        background-color:brown;
     }
     
      table
       {
        
        height:150px;
        border:0px solid;
        text-align:center;
        margin-left:auto;
        margin-right:auto;
        font-family:'New Times Roman';
        font-size:20px;
       } 
       table th
       {
        background-color:#808080;
        color:white;
       }
       .button
          {
            padding:15px ;
            font-size:16px;
            text-align:centre;
            background-color:red;
            color:white;
            border:none;
            border-radius:5px;
            text-decoration:none;
            cursor: pointer;
            text-align:left;
            margin-left:1160px;
          }  
        .ap
        {
          padding:6px 12 px;
          margin:2px;
          border:none;
          color:white;
          cursor:pointer;
          font_weight:bold;
          background-color:#28a745;
        }
        .status.pending
         {
          background-color:#FFF8DC;
          color:#B8860B;
          font-weight:bold;
          padding:4px 8px;
          border-radius:4px;
          }
          .status.approved
          {
          color:#66BB6A ;
          font-weight:bold;
          padding:4px 8px;
          border-radius:4px;
          }
          .status.declined
         {
          color:red;
          font-weight:bold;
          padding:4px 8px;
          border-radius:4px;
          }
          
          .App
          {
            padding:6px 12px;
            font-weight:bold;
            border:none;
            border-radius:4px;
            cursor:pointer;
            margin-right:5px;
            background-color:#66BB6A ;
            color:white;
          }
          .Dec
          {
            padding:6px 12px;
            font-weight:bold;
            border:none;
            border-radius:4px;
            cursor:pointer;
            margin-right:5px;
            background-color:red;
            color:white;
          }
       </style>
</head>
    <body>
        <a href="admin_dashboard.php"  class="button" name="logout">Back to Dashboard</a>
        <h1>Certificate Dashboard</h1><br><br><br><br><br><br>
        <form action="certificate_dashboard.php" method="POST">
        <table border="2">
            <tr>
              <th>CERT ID</th>
              <th>TITLE</th>
              <th>EXPIRY DATE</th>
              <th>CLIENT NAME</th>
              <th>STATUS</th>
              <th>ACTIONS</th>   
            </tr>
             <?php
                   
                   $query="SELECT * FROM certificate_drafts order by client_id ";
                   $result= mysqli_query($con,$query);
                  while($row=mysqli_fetch_assoc($result))
                  {
                     echo "<tr>";
                     echo "<td>{$row['cert_id']}</td>";
                     echo "<td>{$row['title'] }</td>";
                     echo "<td>{$row['expiry_date']}</td>";
                     echo "<td>{$row['name']}</td>";
                     $statusclass=strtolower($row['status']);
                     echo "<td class='status $statusclass' >{$row['status']}</td>";
                     echo "<td>";

                   if($row['status']=='Pending')
                   {

                    echo "
                    <form method='POST' action='certificate_dashboard.php' style='display:incline;'>
                    <input type='hidden'  name='cert_id' value='{$row['cert_id']}'>
                    <button type='submit' name='status' class='App' value='Approved'>Approved</button>
                    <button type='submit' name='status' class='Dec' value='Declined'>Declined</button>
                    </form>";
                   }
                   else
                   {
                    if($row['status']=='Declined')
                    {
                      $cert_id=$row['cert_id'];
                      mysqli_query($con,"update certificate_drafts set notification='on' where cert_id='$cert_id'");
                    }
                     echo "N/A";
                   }
                    echo"</td>";
                    echo"</tr>";
                  }
                    ?>
        </table>
        </form> 
</body>
</html>

