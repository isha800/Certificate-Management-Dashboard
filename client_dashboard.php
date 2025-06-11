<?php
 session_start(); 
if(!isset($_SESSION['client_id'])&&!isset($_SESSION['admin_id']))
 {   
    header("Location:log.php");
    exit();
 }
 header("cache_control: no-store,no-cache,must-revalidate ,max-age=0");
 header("cache-control:post-check=0, pre-check=0,false");
   header("pragma:no-cache");
   header("Expires:0");  
?>
<?php
include("db.php");
if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['cert_id']) && isset($_POST['status']))
    {
        $cert_id=$_POST['cert_id'];
         $stat=$_POST['status'];

     if($stat=='Approved'|| $stat=='Declined')
     {
       $qry="UPDATE certificate_drafts SET status='$stat' WHERE cert_id='$cert_id'";
       mysqli_query($con,$qry);
       header("Location:client_dashboard.php?success=1");
      exit();
    
     }
    }
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
<?php //for notification
include('db.php');
$query="select count(*) as total from certificate_drafts where notification ='off' and status='Pending'";
$result=mysqli_query($con,$query);
$data=mysqli_fetch_assoc($result);
$notif_count=$data['total'];
?> 
<?php //mail and pdf
require('fpdf\fpdf.php');
include ('db.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if(isset($_POST['sub'])||isset($_POST['su']))
    {
     $cert_id=$_POST['cert'];
    //$query="select * from certificate_drafts where cert_id='$cert_id ' LIMIT 1";
    $query="select cd.* , u.email from certificate_drafts cd JOIN users u on cd.client_id=u.client_id where 
            cd.cert_id='$cert_id ' LIMIT 1";
    $result=mysqli_query($con,$query);
    if(mysqli_num_rows($result)==1)
    {
        $row=mysqli_fetch_assoc($result);
        $name=$row['name'];
        $title=$row['title'];
        $status=$row['status'];
        $des=$row['description'];
        $expiry=$row['expiry_date'];
         $email=$row['email'];
        $pdf=new FPDF();
        $pdf->AddPage();
        $pdf->settextcolor(0,0,128);
        $pdf->SetFont('Arial','BU',30);
        $pdf->cell(0,20,"$title",0,1,'C');
        $pdf->settextcolor(0,0,0);
        $pdf->SetFont('Arial','',20);
        $pdf->multicell(0,19,"$des",0,'C');
        //$pdf->cell(0,10,"$name",0,1,'C');
        if($status=='Approved')
        {
         try{
           $pdf->settextcolor(255,0,0);
          $pdf->setfont('Arial','',18);
          $pdf->sety(70);
          $pdf->cell(0,30,"Expiry Date:$expiry",0,1);
          $pdf->cell(0,10,'(This is your final approved certificate)',0,1);
          //send email
          $mail = new PHPMailer(true);
                          
           $mail->isSMTP();                                           
           $mail->Host='smtp.gmail.com';                    
           $mail->SMTPAuth   = true;                                 
          $mail->Username   = 'priyad77888@gmail.com';                     
          $mail->Password   = 'uwku aahp lcde ueih';                               
            //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->SMTPSecure ='ssl'; 
                      
            $mail->Port =465;   
          $mail->setFrom('priyad77888@gmail.com','certificate Admin');
          $mail->addAddress($email,$name);
          $filename="certificate.pdf";
          $pdf->output('F',$filename);
         $mail->addAttachment($filename);
         $mail->isHTML(true);                                  
    $mail->Subject = 'Your Approved Certificate';
    $mail->Body = ' Dear ' ."$name".',Your certificate has been approved and is attached.';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    //echo 'Email has been sent..';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

        }
        else
        { 
          $pdf->settextcolor(255,0,0);
          $pdf->setfont('Arial','',18);
          $pdf->sety(70);
          $pdf->cell(0,30,"Expiry Date:XX/XX/XXXX",0,1);
          $pdf->cell(0,10,'(This is a masked preview)',0,1);
        }
        $pdf->Ln(10);
        $file_path="uploads/masked/masked_$cert_id.pdf";
        $update_qry="update certificate_drafts set masked_pdf_path='$file_path' where cert_id='$cert_id '";
        mysqli_query($con,$update_qry);
        $pdf->output();

    }
    else
    {
        echo"certificate not found";
    }
  }
?>
<!doctype html>
<html lang="en">
    <head><meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
    <meta http-equiv="Cache-Control" content="no-store,no-cache,must-revalidate"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="0"/>  
    <style>
      h2 
      {
       text-align:center;
        color:white;
        font-family:'New Times Roman';
        background-color:brown;
        font-size:30px;
      }
      .button
        {
            padding:15px ;
            font-size:20px;
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
          .status.pending
        {
          background-color:#FFF8DC;
          color:#B8860B;
          font-weight:bold;
          padding:4px 8px;
          border-radius:4px;
          }
          .unmark ,.mark
          {
            padding:10px 10px;
            font-size:13px;
            text-align:centre;
            background-color:#007bff;
            color:white;
            border:none;
            border-radius:5px;
            text-decoration:none;
            cursor: pointer;
          }
       .badge
        {
            background-color:red;
            right:445px;
            color:white;
            position:absolute;
            font-size:12px;
            border-radius:50%;
            padding:4px 7px;
        }   
 </style>
</head>
    <body>
        <a href="logout.php"  class="button" name="logout">logout</a>
        <h2> Welcome to Client Dashboard  &nbsp &nbsp&nbsp&nbsp  
        <img src="bell.jpg" height="47" >
        <?php if ($notif_count>0): ?>
        <span class="badge">
            <?php echo $notif_count;?></span>
            <?php endif; ?>
        </h2><br><br><br><br><br>
        <form action="client_dashboard.php" method="post">
        <table border="2">
            <tr>
              <th>CERT ID</th>
              <th>TITLE</th>
              <th>STATUS</th>
              <th>ACTIONS</th> 
              <th>VIEW PDF</th>  
            </tr>
            <?php
                   $query="SELECT *  FROM certificate_drafts order by client_id   ";
                   $result= mysqli_query($con,$query);
                 while($row=mysqli_fetch_assoc($result))
               {
                   
                   echo "<tr>";
                   echo "<td>{$row['cert_id']}</td>";
                   echo "<td>{$row['title'] }</td>";
                    $statusclass=strtolower($row['status']);
                     echo "<td class='status $statusclass' >{$row['status']}</td>";
                   echo "<td>";
                   if($row['status']=='Pending')
                   {
                    echo " <form method='POST' action='client_dashboard.php' style='display:incline;'>";
                    echo "<input type='hidden' name='cert_id' value='{$row['cert_id']}'>";
                    echo "<button type='submit' name='status' class='App' value='Approved'>Approved</button>&nbsp&nbsp&nbsp";
                    echo "<button type='submit' name='status'  class='Dec'value='Declined'>Declined</button>";
                    echo "</from>";
                   }
                   else
                   {
                     echo "N/A";
                   }
                   echo"</td>";
                   if($row['status']=='Approved')
                    {
                     
                    echo "<td>";
                    echo "<form method='POST' action='client_dashboard.php'  target='_blank'>";
                    echo"<input type='hidden' name='cert' value='{$row['cert_id']}'>";
                    echo"<button type='submit' name='sub' class='unmark'>View Unmasked PDF</button> ";
                    echo"</form>";
                   echo"</td>";
                    }
                    else
                    {
                    if($row['status']=='Declined')
                    {
                    $cert_id=$row['cert_id'];
                    mysqli_query($con,"update certificate_drafts set notification='on' where cert_id='$cert_id'");
                    }
                    echo "<td>";
                    echo "<form method='POST' action='client_dashboard.php'  target='_blank'>";
                    echo"<input type='hidden' name='cert' value='{$row['cert_id']}'>";
                    echo"<button type='submit'name='su' class='mark'>View Masked PDF</button> ";
                    echo"</form>";
                    echo"</td>"; 
                    }
                    echo"</tr>";
                   
                }  
                   
                
             ?>
        </table>
        </form>
        
</body>
</html>
