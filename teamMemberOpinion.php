<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    include 'user.php';
    include 'header.php';
    session::checksession();
    
    $pageType = 'accountOfficer';
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
    if (isset($_GET['action']) && $_GET['action'] == "logout") {
        session::distroy(); 
    }
?>

<?php
    $db = mysqli_connect("localhost","root","","db_lr");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $budget_id = mysqli_real_escape_string($db, $_GET['id']);
    if($budget_id){
        $sql = "SELECT * FROM demand WHERE id = $budget_id";
        $res =  $db->query($sql);
        $row = $res->fetch_assoc();
        $id = session::get("id");
        $sql2 = "SELECT * FROM tabel_user WHERE id = $id ";
        $res2 = $conn->query($sql2);
        $row2 = $res2->fetch_assoc();
        $account_officer_name = $row2['name'];
    }
?>

<?php

    if (isset($_POST['submit'])) {
        $budget_id = mysqli_real_escape_string($db, $_GET['id']);
        $accountofficer_id = session::get("id");
        $recommend =$_POST['recommend'];
        $pageNo = $_POST['pageNo'];
        $type = $_POST['type'];
        $date = $_POST['day'] .'-'. $_POST['month']  .'-'. $_POST['year'];
        $comment = $_POST['comment'];

        $query = "INSERT INTO accountsofficeropinion(budget_id,recommend, accountofficer_id, pageNo, type, date, comment) VALUES ('$budget_id','$recommend','$accountofficer_id','$pageNo', '$type', '$date', '$comment')";
        
        $run = mysqli_query($db, $query);
        
        if ($run) {
            if($recommend == 'yes'){
                $stage = 3;
                $status = 'accepted';
            }
            else{
                $stage = 2;
                $status = 'rejected';
            }

            $sql = "UPDATE demand SET stage = $stage, status = '$status' WHERE id = '$budget_id'";
            $run = mysqli_query($db, $sql);

            $msg =  "<div class='alert alert-success'><strong> Succesfully accepted donation </strong></div>";
            session::set("loginmgs", $msg);
            $_SESSION['status'] = "Data Inserted";
            header("Location: teamMemeberIndex.php");
        }
        else{
            $_SESSION['status'] = "Data Not Inserted";
            header("Location: teamMemeberIndex.php");
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>DETAILS</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
<input class="btn btn-primary mb-5" type="button" value="Back" onclick="history.back(-1)" />
    <div style="margin-top: 20px;" class="container text-center">
        <h3><strong>FOOD COLLECTION REQUEST</strong></h3>
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
                            $status = '<font class="text-success"> Food collecting team shortly reach you.Thanks for your donation </font>';
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
    </div>
<!-- Budget Statement End -->
<div>
<div style="margin-top: 20px;" class="container text-center">
        <h3><strong>VOLUNTEER OPINION</strong></h3>
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
                    //$recommending_officer_name = $row3['name'];

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
                            <td class='text-end table-active'>DONATION DATE</th>
                            <td class='text-start'>".$row4["date"]."</td>
                        </tr>
                        <tr>
                            <td class='text-end table-active'>MESSAGE FROM VOLUNTER</th>
                            <td class='text-start'>".$row4["comment"]."</td>
                        </tr>";
                }
            }
            else{
                echo "0 result";
            }
        ?>
    </table>
</div>
            <div style="max-width: 500px; float:left" class="mt-5 form-control">
                <label for="signature"><b>TEAM MEMBER</b></label>
                <div class="h4">
                    <?php
                        echo $account_officer_name;
                    ?>
                </div>
        <form action="" method="POST" >   
                <div class="mt-2">
                    <select name="day">
                        <option class="dropdown-menu" value="<?php echo $day = date("d"); ?>"> <?php echo $day = date("d"); ?></option>
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select>
                    <select name="month">
                        <option class="dropdown-menu" value="<?php echo $day = date("M"); ?>"> <?php echo $day = date("M"); ?> </option>
                        <option value="jan">Jan</option>
                        <option value="feb">Feb</option>
                        <option value="mar">Mar</option>
                        <option value="apr">Apr</option>
                        <option value="may">May</option>
                        <option value="jun">Jun</option>
                        <option value="jul">Jul</option>
                        <option value="aug">Aug</option>
                        <option value="sep">Sep</option>
                        <option value="oct">Oct</option>
                        <option value="nov">Nov</option>
                        <option value="dec">Dec</option>
                    </select>
                    <select name="year">
                        <option class="dropdown-menu" value="<?php echo $day = date("Y"); ?>"> <?php echo $day = date("Y"); ?> </option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>
                        <option value="2029">2029</option>
                        <option value="2030">2030</option>
                        <option value="2031">2031</option>
                        <option value="2032">2032</option>
                        <option value="2033">2033</option>
                        <option value="2034">2034</option>
                        <option value="2035">2035</option>
                    </select>
                </div>
            </div>
            <form action="" method="post">
            <div class="text-center my-4">
                <div class="btn btn-outline-success">
                    <input class="form-check-input" id="yes" name="recommend" value="yes" type="radio">
                    <label class="form-check-label" for="yes">COLLECT</label>
                </div>
            </div>
            <div style="max-width: 400px; margin-left: 800px" class="mt-5 form-control">
                <b>MESSAGE</b><br>
                <textarea class="form-control" name="comment" cols="60" rows="3" placeholder="Write..."></textarea>
            </div>
            <div class="text-center m-3">
                <input class="btn btn-success" name="submit" type="submit" value="Confirm">
            </div>
        </form>
    </div>
    <?php include 'footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>