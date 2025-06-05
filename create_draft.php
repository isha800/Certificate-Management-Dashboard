<?php
 include("db.php");
 ?>
<!doctype html>
<html lang="en">
    <head><meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <style>
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
        table
       {
        
        height:250px;
        border:0px solid;
        text-align:center;
        margin-left:auto;
        margin-right:auto;
        font-family:'Time New Roman';
        font-size:20px;
       } 
       h1
     {
        text-align:center;
        color:white;
        font-family:'Time New Roman';
        background-color:brown;
     }
     h2
     {
        text-align:center;
        color:white;
        font-family:'Time New Roman';
        background-color:green; 
     }
     .su
     {
        width: 280px;
        padding:10px;
        border-radius:3px;
        color:white;
        cursor:pointer;
        background: rgb(19, 73, 155);
        font-size:17px;
     }
     .review
     {
        text-align:center;
        color:white;
        font-family:'Time New Roman';
        background-color:rgb(19, 73, 155);
        cursor:pointer;
        font-size:17px;
       
     }


    </style>
</head>
    <body>
        <a href="admin_dashboard.php"  class="button" name="logout">Back to Dashboard</a>
        <form action="create_draft.php" method="POST">
        <table>
         <tr><h1>Create Certificate Draft</h1></tr>   
        <tr><td> Title:
             <input type="text" pattern="[A-Za-z\s]+" title="Only Letters are allowed" name="title" placeholder="certificate title" required></td>
        </tr>
        <tr><td> Certificate Description:
            <textarea name="description"  pattern="[A-Za-z\s]+" title="Only Letters are allowed"placeholder="Certificate Description" required></textarea></td>
        </tr>

        <tr><td> Expiry Date:
            <input type="date" name="expiry_date" required></td>
        </tr>
        <tr><td>Select Client:
            <select name="clid" required>
                <option>--select client--</option>
                <?php  $client_query="select client_id , name FROM users where role='client'";
                        $res=mysqli_query($con,$client_query);
                 while($row=mysqli_fetch_assoc($res))
                {

                    echo"<option value='{$row['client_id']}'>{$row['name']}</option>";
                   
                }
               
                ?>
                </select></td></tr>
        
        <tr><td><button type="submit"class="su" name="generate_draft">Create Draft</button></td>
        </tr></table>
    </form>
    </body>
</html>
<?php

if(isset($_POST['generate_draft']))
{   
    $uid=$_POST['clid'];
    $query="select name from users where client_id='$uid'";
    $re=mysqli_query($con ,$query);
    $row=mysqli_fetch_assoc( $re);
    $uname=$row['name'];
    $cid=uniqid("CERT-");
    $tit=$_POST['title'];
    $des=$_POST['description'];
    $date=$_POST['expiry_date'];
    echo "<h2> Draft Preview</h2>";
    echo "<center> <b><u>Client ID:</u></b>&nbsp&nbsp $uid <br><b><u>Client Name:</u></b>&nbsp&nbsp $uname<br>
      <b><u>Cert ID:</u></b>&nbsp&nbsp $cid<br><b><u>Title:</u></b>&nbsp&nbsp&nbsp$tit<br>
      <b><u>Description:</u></b>&nbsp&nbsp$des<br><b><u>Expiry Date:</u></b>&nbsp&nbsp&nbsp$date<br><b><u>Status:</u></b>&nbsp&nbsp <mark>Draft<mark></center><br><br>";
    echo "<form action='create_draft.php' method='POST'>";
    echo "<input type='hidden' name='cli' value='$uid'>";
    echo "<input type='hidden' name='client_name' value='$uname'>";
    echo "<input type='hidden' name='cert_id' value='$cid'>";
    echo "<input type='hidden' name='title' value='$tit'>";
    echo "<input type='hidden' name='description' value='$des'>";
    echo "<input type='hidden' name='expiry_date' value='$date'>";
    echo "<center><input type='submit'  class='review'name='submit_review' value='Submit for Review'></center>";
    echo "</form>";
}
if(isset($_POST['submit_review']))
{  
    $uid=$_POST['cli'];
    $cid=uniqid("CERT-");
    $tit=$_POST['title'];
    $des=$_POST['description'];
    $date=$_POST['expiry_date'];
    $cname=$_POST['client_name'];
    $qry="INSERT INTO certificate_drafts (client_id,cert_id,title,description,expiry_date,name,status) VALUES ('$uid','$cid','$tit','$des','$date','$cname','Pending')";
    $run=mysqli_query($con ,$qry);
    if($run)
    {
    
     header("Location:create_draft.php?success=1 & cid=$cid");                                                                                
        exit;
       
    }
    
}

?>
<?php
   if(isset($_GET['success']) && $_GET['success']==1)
   {
    echo "<center><h2> Certificate Submitted for Review </h2></enter>";
    echo "<center><b><u>Certificate ID:</b></u>&nbsp&nbsp" .htmlspecialchars($_GET['cid']). "<br>"."</center>";
    echo "<center><b><u>Status:</b></u>&nbsp&nbsp&nbsp&nbsp<mark> Pending</mark></center>"; 
   }
   ?>