 <?php
 include('db.php');
 $id=$_GET['client_id'];
 $select="select * from certificate_drafts where client_id='$id' ";
 $data=mysqli_query($con,$select);
 $row=mysqli_fetch_assoc($data);
 ?>
 <!Doctype HTML>
 <html>
    <head><title>update</title>
    <style>
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
        </style>
</head>
<form action="" method="POSt">
 <table>
         <tr><h1>Update Certificate Draft</h1></tr>   
        <tr><td> Title:
             <input type="text"  value="<?php echo $row['title'] ?>" pattern="[A-Za-z\s]+" title="Only Letters are allowed" name="title" placeholder="certificate title" required></td>
        </tr>
        <tr><td> Certificate Description:
            <input name="des" value="<?php echo $row['description'] ?>"  pattern="[A-Za-z\s]+" title="Only Letters are allowed"placeholder="Certificate Description" size="50" required></td>
        </tr>

        <tr><td> Expiry Date:
            <input type="date" name="expiry_date"  value="<?php echo $row['expiry_date'] ?>"required ></td>
        </tr>
        <tr><td>Client Name:
            <input type="text" name="cname" value="<?php echo $row['name'] ?>" required>
        </td></tr>
                 <tr><td><button  type="submit"class="su" name="update_draft" >Update Draft</button></td></tr>
        </table>
    </form>
    </body>
</html>
<?php
if(isset($_POST['update_draft']))
{
 
 $tit=$_POST['title'];
 $dis=$_POST['des'];
 $date=$_POST['expiry_date'];
 $name=$_POST['cname'];
 $up="UPDATE  certificate_drafts set title='$tit',description='$dis', expiry_date='$date',name='$name',status='Pending', notification='off'  where client_id='$id' ";  
 $data=mysqli_query($con,$up);
 if($data)
 {
  ?>
  <script type="text/javascript">
    alert(" Data Updated Successfully!");
    window.open("certificate_dashboard.php");
    </script>
  <?php
 }
}
?>
