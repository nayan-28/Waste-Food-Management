<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    include_once 'session.php';
    include 'database.php';
    include ('smtp/PHPMailerAutoload.php');

class user{
    private $db;
    public function __construct(){
        $this->db = new database();
    }
/*----------------------------------------
        user registration start
------------------------------------------*/
    public function userRegistration($data)
    {
        $name   = $data['name'];
        $email  = $data['email'];
        $mobile = $data['mobile'];
        $pass   = md5($data['pass']);
        $type   = $data['type'];
        $verification_status = false;

        $chk_email = $this->emailAndTypeCheck($email, $type);

        if ($name == "" or $email == "" or $mobile == "" or $pass == "" or $type == "") {
            $mgs = "<div class='alert alert-danger'><strong>Error!</strong> Field must not be Empty</div>";
            return $mgs;
        }

        if (strlen($name)<3) {
            $mgs = "<div class='alert alert-danger'><strong>Error!</strong> User name is too Short!</div>";
            return $mgs;
        }

        if ($chk_email == true) {
            $mgs = "<div class='alert alert-danger'><strong>Error! </strong>The email address is already exists with this role!</div>";
            return $mgs;
        }

        $sql = "INSERT INTO tabel_user (name, email, mobile, pass, type) VALUES(:name, :email, :mobile, :pass, :type)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':name',$name);
        $query->bindValue(':email',$email);
        $query->bindValue(':mobile',$mobile);
        $query->bindValue(':pass',$pass);
        $query->bindValue(':type',$type);
        $result = $query->execute();

        if ($result) {
            $conn = mysqli_connect('localhost', 'root', '', 'db_lr');
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM tabel_user WHERE email = '$email' and type = '$type'";
            $res =  $conn->query($sql);
            $row = $res->fetch_assoc();
            $id = $row['id'];
            $str = $row['id'] . $email . $name . $type;
            $verification_id = hash('md5', $str);
            $sql = "UPDATE tabel_user set verification_id='$verification_id' where id='$id'";
            $conn->query($sql);
            $conn->close();

            $mailHtml = "Please confirm your registration by clicking the button bellow : <br><a href='http://localhost/P/verification.php?verification_id=$verification_id'><input name='submit' class='btn btn-primary mt-4' type='submit' value='Verify your account'></a>";
            
            if($this->smtp_mailer($email, 'account Verification', $mailHtml) == true)
            {
                $msg = "<div class='alert alert-success'><strong>Success! </strong>We've sent you a confirmation email.</div>";
                return $msg;
            }
            else
            {
                return "Cannot send mail";
            }
        }
        else{
            $msg = "<div class='alert alert-danger'><strong>Error!</strong> Sorry! There have been problem inserting your details!</div>";
            return $msg;
        }
    }

    public function smtp_mailer($to, $subject, $msg){
        $mail = new PHPMailer(); 
        $mail->IsSMTP(); 
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true; 
        $mail->SMTPSecure = 'tls'; 
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; 
        $mail->IsHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Username = "wastefoodmanagement.just@gmail.com";
        $mail->Password = "hfkhmcmtnkvlukbx";
        $mail->SetFrom("wastefoodmanagement.just@gmail.com");
        $mail->Subject = $subject;
        $mail->Body = $msg;
        $mail->AddAddress($to);
        $mail->SMTPOptions=array('ssl'=>array(
            'verify_peer'=>false,
            'verify_peer_name'=>false,
            'allow_self_signed'=>false
        ));

        if(!$mail->Send()){
            return false;
        }else{
            return true;
        }
    }

    public function emailCheck($email){
        $sql = "SELECT email FROM tabel_user WHERE email = :email";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':email',$email);
        $query->execute();
        if ($query->rowCount()>0) {
            return true;
        }
        else{
            return false;
        }
    }

    public function emailAndTypeCheck($email, $type){
        $sql = "SELECT * FROM tabel_user WHERE email = :email and type = :type";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':email',$email);
        $query->bindValue(':type',$type);
        $query->execute();
        if ($query->rowCount()>0) {
            return true;
        }
        else{
            return false;
        }
    }
/*----------------------------------------
        user registration end
------------------------------------------*/

/*----------------------------------------
            user login start
------------------------------------------*/

public function getLoginUser($email,$pass){
    $sql = "SELECT * FROM tabel_user WHERE email = :email AND pass = :pass LIMIT 1";
    $query = $this->db->pdo->prepare($sql);
    $query->bindValue(':email',$email);
    $query->bindValue(':pass',$pass);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result;
}

public function userLogin($data){
    $email  = $data['email'];
    $pass   = md5($data['pass']);

    $conn = mysqli_connect('localhost', 'root', '', 'db_lr');

    $chk_email = $this->emailCheck($email);

    

    if ($email == "" or $pass == "") {
        $mgs = "<div class='alert alert-danger'><strong>Error!</strong>Field must not be Empty</div>";
        return $mgs;
    }

    if ($chk_email == false) {
        $mgs = "<div class='alert alert-danger'><strong>Error!</strong>The email address not exist!</div>";
        return $mgs;
    }

    $sql = "SELECT * FROM tabel_user WHERE email = '$email'";
    $res =  $conn->query($sql);
    $row = $res->fetch_assoc();
    $verification_status = $row['verification_status'];
    $admin_verification_status = $row['admin_verification_status'];
    if ($verification_status == false) {
        $mgs = "<div class='alert alert-danger'><strong>Error!</strong> Email is not verified yet.</div>";
        return $mgs;
    }
    if ($admin_verification_status == false) {
        $mgs = "<div class='alert alert-danger'><strong>Error!</strong> Admin Verification in progress.</div>";
        return $mgs;
    }



    $result = $this->getLoginUser($email, $pass);
    if ($result) {
        session::init();
        session::set("login", true);
        session::set("id", $result->id);
        session::set("name", $result->name);
        session::set("loginmgs", "<div class='alert alert-success'><strong>Successfully login</strong></div>");
        if ($row['type']=='general') {
            header("Location: Donor.php");
        }
        if ($row['type']=='recommendingOfficer') {
            header("Location: volunterIndex.php");
        }
        if ($row['type']=='accountOfficer') {
            header("Location: teamMemeberIndex.php");
        }
        if ($row['type']=='admin') {
            header("Location: adminIndex.php");
        }
    }
    else{
        $mgs = "<div class='alert alert-danger'><strong>Error!</strong> Email or Password is invalid!</div>";
        return $mgs;
    }
}
/*----------------------------------------
            user login End
------------------------------------------*/



/*----------------------------------------
            Switch user start
------------------------------------------*/
public function userSwitch($id, $type, $currentType){
    $conn = mysqli_connect('localhost', 'root', '', 'db_lr');

    $sql = "SELECT * FROM tabel_user WHERE id = $id";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    $email = $row['email'];
    $name = $row['name'];

    $sql = "SELECT * FROM tabel_user WHERE email = '$email' AND type = '$type'";
    $res = $conn->query($sql);
    if(mysqli_num_rows($res) == 0)
    {
        session::init();
        session::set("login", true);
        session::set("id", $id);
        session::set("name", $name);
        header("Location: accessDenied.php");
    }
    else{
        $row = $res->fetch_assoc();
        $id = $row['id'];

        session::init();
        session::set("login", true);
        session::set("id", $id);
        session::set("name", $name);
        session::set("loginmgs", "<div class='alert alert-success'><strong>Success!</strong> Account has been switched.</div>");
    }
}
/*----------------------------------------
            Switch user End
------------------------------------------*/

    public function getuserdata(){
        $sql = "SELECT * FROM tabel_user ORDER BY id ASC";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
    public function getuserbyid($id){
        $sql = "SELECT * FROM tabel_user  WHERE id = :id LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id',$id);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    public function updateUserData($id, $data){
        $name   = $data['name'];
        $mobile = $data['mobile'];

        if ($name == "" or $mobile == "") {
            $mgs = "<div class='alert alert-danger'><strong>Error!</strong>Field must not be Empty</div>";
            return $mgs;
        }

        $sql = "UPDATE  tabel_user set 
                    name    = :name,
                    mobile  = :mobile
                WHERE id    = :id";

        $query = $this->db->pdo->prepare($sql);

        $query->bindValue(':name',$name);
        $query->bindValue(':mobile',$mobile);
        $query->bindValue(':id', $id);
        $result = $query->execute();
        if ($result) {
            session::set('name', $name);
            $mgs = "<div class='alert alert-success'><strong>Success</strong> User data updated seccessfully.</div>";
            return $mgs;
        }
        else{
            $mgs = "<div class='alert alert-danger'><strong>Error!</strong>Sorry! User data not updated!</div>";
            return $mgs;
        }
    }
    /*----------------------------------------
            Admin Verification Update
    ----------------------------------------*/
    public function updateAdminVerificationStatus($id){
        $sql = "UPDATE tabel_user SET admin_verification_status = 1 WHERE id= :id LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id',$id);
        $result = $query->execute();
        if ($result) {
            $mgs = "<div class='alert alert-success'><strong>Success</strong> User data updated seccessfully.</div>";
            return $mgs;
        }
        else{
            $mgs = "<div class='alert alert-danger'><strong>Error!</strong>Sorry! User data not updated!</div>";
            return $mgs;
        }
    }
    /*----------------------------------------
            Admin Verification Remove
    ----------------------------------------*/
    public function updateAdminVerificationRemove($id){
        $sql = "UPDATE tabel_user SET admin_verification_status = 0 WHERE id= :id LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id',$id);
        $result = $query->execute();
        if ($result) {
            $mgs = "<div class='alert alert-success'><strong>Success</strong> User data updated seccessfully.</div>";
            return $mgs;
        }
        else{
            $mgs = "<div class='alert alert-danger'><strong>Error!</strong>Sorry! User data not updated!</div>";
            return $mgs;
        }
    }
    /*----------------------------------------
            Admin Verification Delete
    ----------------------------------------*/
    public function updateAdminVerificationDelete($id){
        $sql = "DELETE FROM tabel_user WHERE id= :id LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id',$id);
        $result = $query->execute();
        if ($result) {
            $mgs = "<div class='alert alert-success'><strong>Success</strong> User data delete seccessfully.</div>";
            return $mgs;
        }
        else{
            $mgs = "<div class='alert alert-danger'><strong>Error!</strong>Sorry! User data not delete!</div>";
            return $mgs;
        }
    }
}

?>