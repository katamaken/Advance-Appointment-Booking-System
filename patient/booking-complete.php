<?php
session_start();

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" or $_SESSION['usertype'] != 'p') {
        header("location: ../login.php");
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}

// Import database
include("../connection.php");
$sqlmain = "select * from patient where pemail=?";
$stmt = $database->prepare($sqlmain);
$stmt->bind_param("s", $useremail);
$stmt->execute();
$userrow = $stmt->get_result();
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];

if ($_POST) {
    if (isset($_POST["booknow"])) {
        $apponum = isset($_POST["apponum"]) ? $_POST["apponum"] : "";
        $appotime = isset($_POST["appotime"]) ? $_POST["appotime"] : "";
        $scheduleid = isset($_POST["scheduleid"]) ? $_POST["scheduleid"] : "";
        $date = isset($_POST["date"]) ? $_POST["date"] : "";
        $scheduleid = isset($_POST["scheduleid"]) ? $_POST["scheduleid"] : "";

        $sql2 = "INSERT INTO appointment (pid, apponum, appotime, scheduleid, appodate) VALUES (?, ?, ?, ?, ?)";
        $stmt2 = $database->prepare($sql2);
        $stmt2->bind_param("iiiss", $userid, $apponum, $appotime, $scheduleid, $date);
        $stmt2->execute();

        header("location: appointment.php?action=booking-added&id=" . $apponum . "&titleget=none");
    }
}
?>