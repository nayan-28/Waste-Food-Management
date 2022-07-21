<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
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
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	$conn = mysqli_connect('localhost', 'root', '', 'db_lr');
	
	$limit = 8;
	$page = isset($_GET['page']) ? $_GET['page'] : 1;
    if($page < 1)
        $page = 1;
	$start = ($page - 1) * $limit;
    $user_id = session::get("id");

	$result = $conn->query("SELECT * FROM demand WHERE user_id='$user_id' ORDER BY id DESC LIMIT $start, $limit");
    $budgets = $result->fetch_all(MYSQLI_ASSOC);

	$result1 = $conn->query("SELECT count(id) AS id FROM demand WHERE user_id='$user_id'");
	$custCount = $result1->fetch_all(MYSQLI_ASSOC);
	$total = $custCount[0]['id'];
	$pages = ceil( $total / $limit );

	$Previous = $page - 1;
	$Next = $page + 1;
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
    <title>FOOD DONATION LIST</title>
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<body>
    <!-- Navbar Start -->
    <?php
        include 'navbar.php';
    ?>
    <!-- Navbar End -->
    
    <div class="panel-heading">
            <h3 class="text-center mt-3">FOOD DONATION LIST</h3>
    </div>
    <div class="container">
        <div style="margin: 0 auto">
            <form>
                <!-- Pagination Start -->
                <div class="row">
                    <div class="col-md-10">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination pagination-sm">
                                <li class="page-item <?php if($Previous == 0):?> disabled <?php endif; ?>">
                                    <a class="page-link" href="oldBudgetList.php?page=<?= $Previous; ?>" aria-label="Previous">
                                        <span class = "page-link" aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php for($i = 1; $i<= $pages; $i++) : ?>
                                        <li class="page-item <?php if($i == $page):?> active <?php endif; ?>">
                                            <a class="page-link" href="oldBudgetList.php?page=<?= $i; ?>"> 
                                                <span class = "page-link"> <?= $i; ?> </span>
                                            </a>
                                        </li>
                                <?php endfor; ?>
                                <li class="page-item <?php if($Next == $pages+1):?> disabled <?php endif; ?>">
                                    <a class="page-link" href="oldBudgetList.php?page=<?= $Next; ?>" aria-label="Next">
                                        <span class = "page-link" aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Pagination End -->

                <!-- Table Start -->
                <div style="height: 400px; overflow-y: auto;">
                    <table id="" class="table table-striped table-bordered">
                        <thead class="table-success text-center">
                            <tr>
                                <th>S.L</th>
                                <th>Full Name</th>
                                <th>Donation Date</th>
                                <th>Status</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $count = 0;
                                foreach($budgets as $budget) :
                                    if($budget['status'] == 'accepted')
                                    {
                                        $currentStatus = '<font class="text-success"> Approved </font>';
                                    }
                                    else if($budget['status'] == 'rejected')
                                    {
                                        $currentStatus = '<font class="text-danger"> Rejected </font>';
                                    }
                                    else
                                    {
                                        $currentStatus = '<font class="text-info"> Proccessing </font>';
                                    } ?>
                                <tr>
                                    <td class="text-center"><?= $count = $count+1; ?></td>
                                    <?php
                                        $user_id = $budget['user_id'];
                                        $sql = "SELECT * FROM tabel_user WHERE id = $user_id LIMIT 1";
                                        $res =  $conn->query($sql);
                                        $row = $res->fetch_assoc();
                                        $userName = $row['name'];
                                    ?>
                                    <td class="text-center"><?= $userName; ?></td>
                                    <td class="text-center"><?= $budget['date']; ?></td>
                                    <td class="text-center"><?= $currentStatus; ?></td>
                                    <td class="text-center">
                                        <a href="foodDetails.php?id=<?= $budget['id'];?>">   
                                            <span class="btn btn-outline-success btn-sm"> View </span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Table End -->
            </form>
        </div>
    </div>
<?php include 'footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

</body>
</html>