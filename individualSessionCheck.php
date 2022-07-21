<?php
    $conn = mysqli_connect('localhost', 'root', '', 'db_lr');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $id = session::get("id");
    $sql = "SELECT * FROM tabel_user WHERE id = $id";
    $res = $conn->query($sql);
    $row = $res->fetch_assoc();
    $currentUserType = $row['type'];
    
    if($currentUserType != $pageType)
    {
        session::distroyOnly(); 
        $user = new user();
        $userLogin = $user->userSwitch($id, $pageType, $currentUserType);
        session::checksession();
    }
?>