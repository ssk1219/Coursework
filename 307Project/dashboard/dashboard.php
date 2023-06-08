<?php 
session_start();

if (array_key_exists("email", $_SESSION)) {
    // $servername = "localhost"; // Change accordingly
    // $username = "xampp_starter"; // Change accordingly
    // $password = "qV[eoVIhLYT/uYgr"; // Change accordingly
    // $db = "xampp_starter"; // Change accordingly

    // Create connection
    $dir = 'sqlite:/home/2020/acanpo/public_html/307Project/comp307.sqlite'; 
    $conn  = new PDO($dir) or die("cannot open the database");

    // $conn = new mysqli($servername, $username, $password, $db);
    $sql = $conn->prepare("SELECT * FROM User WHERE email = ?");
    $sql->bind_param('s', $_SESSION['email']);
    $sql->execute();
    $result = $sql->get_result();
    $user = $result->fetch_assoc();

    $sql = $conn->prepare("SELECT UserType.userType FROM UserType INNER JOIN User_UserType 
            ON UserType.idx=User_UserType.userTypeId WHERE User_UserType.userId = ?");
    $sql->bind_param('s', $_SESSION['email']);
    $sql->execute();
    $result = $sql->get_result();
    $userTypes = $result->fetch_all();
    $conn->close();

    $username = $user[0] . ' ' . $user[1];

    echo '<div class="welcomeMessage">
                Welcome '. $user['firstName'] . '!</div>';
    if (in_array("sysop", $userTypes[0])) {
        echo '<div class = "section">
            <div class="title">
                <i class="fa fa-cog" aria-hidden="true" style="color: rgb(167, 37, 48)"></i>
                System operator
            </div>
            <ul>
                <li>
                    Manage user accounts
                </li>
                <li>
                    Add or remove professors or courses
                </li>
                <li>
                    Manage system manually or using a CSV file
                </li>
            </ul>
            
            <a class="option" onclick="menuItemSelected(\'system\')" href="../sysop_tasks/manage_users.html">
                Manage users
            </a>
            <a class="option" onclick="menuItemSelected(\'system\')" href="../sysop_tasks/importProf.html">
                Quick import prof/course
            </a>
        </div>';
    }
} else {
    echo '<div class="welcomeMessage">
                Logging out..
            </div>';
}
?>
