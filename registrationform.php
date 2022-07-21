<?php
    include 'nav.php';
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTRATION</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <h3 class="display-4 text-center my-4"><b>REGISTRATION</b></h3>
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto">
        <?php
            if (isset($userRegi)) {
                echo $userRegi;
            }
        ?>
            <form action="" method="POST">
                <div class="form-group mt-3">
                    <label for="name">Full Name</label>
                    <input name="name" id="name" class="form-control" type="text" placeholder="Name">
                </div>
                <div class="form-group mt-3">
                    <label for="email">Email</label>
                    <input name="email" id="email" class="form-control" type="email" placeholder="Example@gmail.com">
                </div>
                <div class="form-group mt-3">
                    <label for="mobile">Contact Number</label>
                    <input name="mobile" id="mobile" class="form-control" type="number" placeholder="01XXXXXXXXX">
                </div>
                <div class="form-group mt-3">
                    <label for="pass">Password</label>
                    <input name="pass" id="pass" class="form-control" type="password" placeholder="*****">
                </div>
                <div class="form-group mt-3">
                    <select class="form-select mul-select" name="type">
                        <option class="dropdown-menu" value="type">Select</option>
                        <option value="general">Donor</option>
                        <option value="recommendingOfficer">Volunteer</option>
                        <option value="accountOfficer">Food Team</option>
                    </select>
                </div>
                <div class="form-group mt-3">
                    <a href="login.php">
                        <input name="submit" class="btn btn-primary mt-3" type="submit" value="SUBMIT">
                    </a>
                </div>
            </form>
        </div>
    </div>
<?php include 'footer.php' ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>