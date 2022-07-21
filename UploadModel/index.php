<!DOCTYPE html>
<html>
<head>
     <title> </title>
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
           ভাইস-চ্যান্সেলর মহোদয়ের মতামত প্রদান
         </h1>
         <h1 class ="text-white bg-dark text-center">
           বাজেট বিবরণ দেখুন
         </h1>
         <h1 class ="text-white bg-dark text-center">
          পরিচালক (হিসাব) দপ্তরের মতামত দেখুন
          </h1>
          <h1 class ="text-white bg-dark text-center">
          ট্রেজারার মহোদয়ের মতামত দেখুন
          </h1>
          <form action="upload.php" method="post" enctype="multipart/form-data" >

          <div class ="form-group">
          <label for="user"> Comment: </label>
          <input type="text" name="username" id="user" class="form-control">
          </div>

          <div class ="form-group">
          <label for="file"> Picure: </label>
          <input type="file" name="file" id="file" class="form-control">
          </div>

          <input type="submit" name="submit" value="Submit" class="btn btn-success">

          </from>
       </div>

</body>
</html>