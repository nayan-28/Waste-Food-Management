<?php
    include 'user.php';
    include 'header.php';
    session::checksession();
?>
<?php
    $loginmgs = session::get("loginmgs");
    if (isset($loginmgs)) {
        echo $loginmgs;
    }
    session::set("loginmgs",NULL);
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
    <title> Details</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
<!-- Budget Statement Start -->
<!-- Recommending Officer Statement Start -->
<div class="container text-center mt-4" style="max-width: 500px; margin: 0, auto">
    <h4>VOLUNTEER APPROVAL DETAILS<b></b></h4>
    <form action="" method="post">
    <table class="table table-striped table-bordered mt-3">
        <?php
            $db = mysqli_connect("localhost","root","","db_lr");
            $budget_id = mysqli_real_escape_string($db, $_GET['id']);
            $sql1 = "SELECT * FROM demand WHERE id='$budget_id'";
            $result = $db->query($sql1);
            if ($result-> num_rows > 0) {
                while ($row = $result-> fetch_assoc()) {
                    $user_id = $row['user_id'];
                    $sql2 = "SELECT * FROM tabel_user WHERE id = $user_id LIMIT 1";
                    $res2 =  $db->query($sql2);
                    $row2 = $res2->fetch_assoc();
                    $userName = $row2['name'];

                    //recommending_officer_id to recommending_officer_name
                    $recommending_officer_id = $row['recommending_officer_id'];
                    $sql3 = "SELECT * FROM tabel_user WHERE id = $recommending_officer_id LIMIT 1";
                    $res3 = $db->query($sql3);
                    $row3 = $res3->fetch_assoc();

                    //recomending_officer_opinion
                    $budget_id = $row['id'];
                    $sql4 = "SELECT * FROM recommendingofficeropinion WHERE budget_id = $budget_id";
                    $result4 = $db->query($sql4);
                    $row4 = $result4->fetch_assoc();
                    if($row4['recommend'] == "yes"){
                        $show3 = "APPROVED";
                    }
                    if($row4['recommend'] == "no"){
                        $show3 = "REJECTED";
                    }
                    echo "<tr>
                            <td class='text-end table-active'>S.L</td>
                            <td class='text-start'>".$row["id"]."</td>
                        </tr>
                        <tr>
                            <td class='text-end table-active'>DONOR NAME</td>
                            <td class='text-start'>".$userName."</td>
                        </tr>
                        <tr>
                            <td class='text-end table-active'>STATUS</th>
                            <td class='text-start'>".$show3."</td>
                        </tr>
                        
                        <tr>
                            <td class='text-end table-active'>APPROVED STATUS</th>
                            <td class='text-start'>".$row4["date"]."</td>
                        </tr>
                        <tr>
                            <td class='text-end table-active'>MEESSAGE</th>
                            <td class='text-start'>".$row4["comment"]."</td>
                        </tr>";
                }
            }
            else{
                echo "0 result";
            }
        ?>
    </table>
    </form>
</div>
<?php include 'foodDetails.php' ?>;
<!-- Recommending Officer Statement End -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>   
</body>
</html>