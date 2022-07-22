<?php
    include 'user.php';
    include 'header.php';
    session::checksession();

    $pageType = 'general';
    include 'individualSessionCheck.php';
?>
<?php
    $loginmgs = session::get("loginmgs");
    if (isset($loginmgs)) {
        echo $loginmgs;
    }
    session::set("loginmgs",NULL);
?>

<?php
    $conn = mysqli_connect('localhost', 'root', '', 'db_lr');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $id = session::get("id");
    $sql = "SELECT * FROM tabel_user WHERE id = $id ";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $sql = "SELECT type FROM tabel_user WHERE email = '$email' and verification_status = 1 and admin_verification_status = 1";
    $typeArray =  $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DONOR</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<?php
    if (isset($_GET['action']) && $_GET['action'] == "logout") {
        session::distroy();
    }
?>
<body>
    <?php
        include 'navbar.php';
    ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="text-center mt-3">DONOR INFORMATION</h2>
        </div>
        <div class="card mb-3" style="max-width: 700px; margin: 0 auto">
            <div class="row g-0">
                <div class="col-md-4">
                <img src="./Img/man.png" class="img-fluid rounded-start p-2">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">
                            <span class="pull-right">
                                <strong>
                                    <?php
                                        echo $name;
                                    ?>
                                </strong>
                            </span>
                        </h5>
                        <p class="card-text">
                        <div style="max-width: 450px; margin: 0 auto">
                            <div class="btn-group dropend dropdown mb-3">
                                <button class="btn btn-outline-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <b>DONOR</b> 
                                </button>
                            </div>
                        </div>
                        </p>
                        <a class="btn btn-warning" href="donate.php">
                       <b> DONATE FOOD</b></a>&nbsp;
                        <a class="btn btn-secondary" href="oldfoodDetails.php"><b>PREVIOUS DONATION</b></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include 'footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>    