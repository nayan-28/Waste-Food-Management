<?php
    $db = mysqli_connect("localhost","root","","db_lr");

    if (isset($_POST['donationForm'])) {
        $user_id = session::get("id");
        $comment = $_POST['comment'];
        $procurement_number=$_POST['procurement_number'];
        $planned_price = $_POST['planned_price'];
        $procurement_type = $_POST['procurement_type'];
        $details_of_goods_and_work = $_POST['details_of_goods_and_work'];
        $date = date("d-m-Y");
        $stage = 2;
        $status = "unseen";
            $query = "INSERT INTO demand (comment,procurement_number,planned_price, procurement_type, details_of_goods_and_work, user_id, date, stage, status) VALUES ('$comment','$procurement_number','$planned_price', '$procurement_type', '$details_of_goods_and_work','$user_id', '$date', $stage, '$status')";
            $run = mysqli_query($db, $query);
            $msg =  "<div class='alert alert-success'><strong>Food Donation request sent.Wait for the confirmation</strong></div>";
            $budget_id = mysqli_insert_id($db);

            session::set("loginmgs", $msg);
            $_SESSION['status'] = "Data Inserted";
            $msg =  "<div class='alert alert-success'><strong>Your donation approve.The Food Team collect the food Shortly</strong></div>";
            header("Location: Donor.php");
        }
        else{
            $msg =  "<div class='alert alert-success'><strong>Sorry</strong></div>";
        }
?>

<div class="container">
    <form action="donate.php" method="POST">
        <table>
            <tr>
                <td>Contact Number</td>
                <td><input class="form-control" type="number" placeholder="Mobile" name="planned_price" required></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><input class="form-control" type="text" placeholder="Address" name="procurement_type" required></td>
            </tr>
            <tr>
                <td>City</td>
                <td>
                    <select class="form-select mt-2 d-inline" name="details_of_goods_and_work">
                        <option class="d-inline dropdown-menu" value="details_of_goods_and_work null">Select City</option>
                        <option>Bagerhat</option>
                        <option>Bandarban</option>
                        <option>Barguna</option>
                        <option>Barisal</option>  
                        <option>Bhola</option>
                        <option>Bogra</option>
                        <option>Brahmanbaria</option>
                        <option>Chandpur</option>
                        <option>Chapainawabganj</option> 
                        <option>Chittagong</option>
                        <option>Chuadanga</option> 
                        <option>Comilla</option> 
                        <option>Cox's Bazar</option>
                        <option>Dhaka</option>
                        <option>Dinajpur</option>
                        <option>Faridpur</option> 
                        <option>Feni</option>
                        <option>Gaibandha</option>
                        <option>Gazipur</option> 
                        <option>Gopalganj</option>
                        <option>Habiganj</option>
                        <option>Jamalpur</option>
                        <option>Jessore</option>
                        <option>Jhalokati</option> 
                        <option>Jhenaidah</option>
                        <option>Joypurhat</option>
                        <option>Khagrachhari</option>
                        <option>Khulna</option>
                        <option>Kishoreganj</option>
                        <option>Kurigram</option> 
                        <option>Kushtia</option>
                        <option>Lakshmipur</option>
                        <option>Lalmonirhat</option>
                        <option>Madaripur</option>
                        <option>Magura</option>
                        <option>Manikganj</option> 
                        <option>Meherpur</option>
                        <option>Moulvibazar</option>  
                        <option>Munshiganj</option> 
                        <option>Mymensingh</option>
                        <option>Naogaon</option>
                        <option>Narail</option>
                        <option>Narayanganj</option>
                        <option>Narsingdi</option>
                        <option>Natore</option>
                        <option>Netrakona</option>
                        <option>Nilphamari</option> 
                        <option>Noakhali</option>
                        <option>Pabna</option>
                        <option>Panchagarh</option>
                        <option>Patuakhali</option> 
                        <option>Pirojpur</option>
                        <option>Rajbari</option>
                        <option>Rajshahi</option> 
                        <option>Rangamati</option>
                        <option>Rangpur</option>
                        <option>Satkhira</option>
                        <option>Shariatpur</option> 
                        <option>Sherpur</option>
                        <option>Sirajganj</option>
                        <option>Sunamganj</option> 
                        <option>Sylhet</option>
                        <option>Tangail</option>
                        <option>Thakurgaon</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Items</td>
                <td>
                    <textarea class="form-control" name="procurement_number" cols="70" rows="4" placeholder="Items....." required></textarea>
                </td>
            </tr>
            <tr>
                <td>Food Details</td>
                <td>
                    <textarea class="form-control" name="comment" cols="70" rows="4" placeholder="Food quality and quantity....." required></textarea>
                </td>
            </tr>
            
        </table>
        <div class="mt-3"><strong>I am eagerly requesting to you to collect the food..........</strong></div>
        <div class="text-center mt-4 mb-5">
            <input type="submit" class="btn btn-primary" name="donationForm" value="Confirm">
        </div>  
    </form>
</div>