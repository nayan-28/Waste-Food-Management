<!DOCTYPE html>
<html>
<head>
   <title></title>
     <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
        <div class= "container">
         <br>
         <h1 class ="text-white bg-dark text-center">
           ভাইস-চ্যান্সেলর মহোদয়ের মতামত 
         </h1>
         <br>
         <div class="table-responsive">
         <table class="table table-bordered table-striped table-hover text-center">
          <thead>
           <th>Id</th>
           <th>Username</th>
           <th>Picture</th>
          </thead>
          <tbody>
         
          <?php
           $con = mysqli_connect('localhost','root');
           mysqli_select_db($con,'displayupload');

           if(isset($_POST['submit']))
           {
             $username = $_POST['username'];
             $files = $_FILES['file'];
             
             print_r($username);
             echo "<br>";

             $filename= $files['name'];
             $filerror= $files['error'];
             $filetmp= $files['tmp_name'];

             $fileext= explode('.',$filename);
             $filecheck= strtolower(end($fileext));

             $fileextstred= array('png','jpg','jpeg');

            if(in_array($filecheck,$fileextstred)){

              $destinationfile = 'upload/'.$filename; 
              move_uploaded_file($filetmp,$destinationfile);
            
            $q = "INSERT INTO `imgupload`(`username`, `image`)
             VALUES ('$username','$destinationfile')";

             $query = mysqli_query($con,$q);


             $displayquery ="select * from imgupload" ;
             $querydisplay = mysqli_query($con,$displayquery);

             while($result =mysqli_fetch_array( $querydisplay)){

              ?>
              <tr>
              <td> <?php echo $result['id']; ?> </td>
              <td> <?php echo $result['username']; ?> </td>
              <td> <img src="<?php echo $result['image']; ?>" Height="100px" Width="100px"> </td>
              </tr>



              <?php
             }
            
            }

           }
          ?>
          </tbody>
         
         </table> 
         </div>
         
        </div>


</body>
</html>