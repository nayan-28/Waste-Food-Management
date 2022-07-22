<?php
    include 'header.php';
    include 'user.php';
?>
<?php
    $user = new user();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
        $userRegi = $user->userRegistration($_POST);
    }
?>
<?php
    if (isset($_GET['action']) && $_GET['action'] == "logout") {
        session::distroy(); 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link rel="stylesheet" href="CSS/Style.css">
  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

  <title>Waste Food Management System</title>
</head>
<body>
  <div>
    <?php include 'nav.php' ?>
  </div>
  <div class="container">
                                   <!-- Carouser -->

  <div class="container mt-5">
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="Img/img1.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="Img/img3.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="Img/img2.jpg" class="d-block w-100" alt="...">
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
  <div class="container mt-5">
    <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner my-1">
                <div class="carousel-item active">
                    <img src="./images/css/image1.jpg" class="d-block img-fluid" alt="images1">
                </div>
                <div class="carousel-item">
                    <img src="./images/css/image2.jpg" class="d-block img-fluid" alt="images2">
                </div>
                <div class="carousel-item">
                    <img src="./images/css/image3.jpg" class="d-block img-fluid" alt="images3">
                </div>
                <div class="carousel-item">
                    <img src="./images/css/image4.jpg" class="d-block img-fluid" alt="images4">
                </div>
                <div class="carousel-item">
                    <img src="./images/css/image5.jpg" class="d-block img-fluid" alt="images5">
                </div>
                <div class="carousel-item">
                    <img src="./images/css/image6.jpg" class="d-block img-fluid" alt="images5">
                </div>
                <div class="carousel-item">
                    <img src="./images/css/image7.jpg" class="d-block img-fluid" alt="images5">
                </div>
                <div class="carousel-item">
                    <img src="./images/css/image8.jpg" class="d-block img-fluid" alt="images5">
                </div>
            </div>
          </div>
    </div>
     <p>Almost 1 3rd of all food produced for human consumption ends up being thrown away.This accounts for almost 1.3 billion tons per year.Meanwhile, scores of people around the globe go hungry or are under-nourished.This Food Waste Management Website helps reduce wastage and feed the underprivileged.Besides the Website, there are two kinds of users in this system; The Donor and The Admin.Admin with leftovers can add a request with details about the food.The Donors can then approve the request and assign an employee to pick up the food.Think before waste your food, someone is starving.</p> 
  </div>
    <?php include 'footer.php' ?>
  </div>

  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
    -->

</body>

</html>