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
<div class="text-center container">
    <div class="container text-center mt-3" style="max-width: 450px; margin: 0, auto">
        <h4>Details</h4>
        <form action="" method="post">
            <table class="table table-striped table-bordered mt-3">
                <?php
                $db = mysqli_connect("localhost","root","","db_lr");
                $budget_id = mysqli_real_escape_string($db, $_GET['id']);
                $sql1 = "SELECT * FROM demand WHERE id='$budget_id' LIMIT 1";
                $result = $db->query($sql1);
                if ($result-> num_rows > 0) {
                    while ($row = $result-> fetch_assoc()) {
                        $user_id = $row['user_id'];
                        $sql2 = "SELECT * FROM tabel_user WHERE id = $user_id LIMIT 1";
                        $res2 =  $db->query($sql2);
                        $row2 = $res2->fetch_assoc();
                        $userName = $row2['name'];

                        $recommending_officer_id = $row['recommending_officer_id'];
                        $sql3 = "SELECT * FROM tabel_user WHERE id = $recommending_officer_id LIMIT 1";
                        $res3 = $db->query($sql3);
                        $row3 = $res3->fetch_assoc();

                        if($row['status'] == 'accepted')
                        {
                            $status = '<font class="text-success"> Food collecting team will shortly reach you.Thanks for your donation </font>';
                        }
                        else if($row['status'] == 'rejected')
                        {
                            $status = '<font class="text-danger"> Rejected </font>';
                        }
                        else
                        {
                            $status = '<font class="text-info"> Proccessing </font>';
                        }
    

                       $stage = array("", "", "VOLUNTEER", "FOOD TEAM", "", "", "", " ");

                        echo "<tr>
                                <td class='text-end table-active'>Full Name</td>
                                <td class='text-start'>".$userName."</td>
                            </tr>
                            <tr>
                                <td class='text-end table-active'>Conatct Number</td>
                                <td class='text-start'>".$row['planned_price']."</td>
                            </tr>
                            <tr>
                                <td class='text-end table-active'>Donation Date</td>
                                <td class='text-start'>".$row['date']."</td>
                            </tr>
                            <tr>
                                <td class='text-end table-active'>Address</td>
                                <td class='text-start'>".$row["procurement_type"]."</td>
                            </tr>
                            <tr>
                                <td class='text-end table-active'>City</td>
                                <td class='text-start'>".$row["details_of_goods_and_work"]."</td>
                            </tr>
                            <tr>
                                <td class='text-end table-active'>Food Item</td>
                                <td class='text-start'>".$row["procurement_number"]."</td>
                            </tr>
                            <tr>
                                <td class='text-end table-active'>Details</td>
                                <td class='text-start'>".$row["comment"]."</td>
                            </tr>
                            ";
                        if($row['status'] = "accepted")
                        {
                            if($row['status'] == "rejected")
                            {
                                echo "<tr>
                                    <td class='text-end table-active'></td>
                                    <td class='text-start'>".$stage[ (int)$row['stage'] ]."</td>
                                </tr>";
                            }
                            else
                            {
                                echo "<tr>
                                    <td class='text-end table-active'> Current Desk</td>
                                    <td class='text-start'>".$stage[ (int)$row['stage'] ]."</td>
                                </tr>";
                            }
                        }
                        echo "<tr>
                                <td class='text-end table-active'> Status</td>
                                <td class='text-start'>". $status ."</td>
                            </tr>";
                    }
                }
                else{
                    echo "0 result";
                }
                ?>
            </table>
        </form>
        <input class="btn btn-primary mb-5" type="button" value="Back" onclick="history.back(-1)" />
    </div>
<!-- Budget Statement End -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<?php include 'footer.php' ?>
</body>
</html>