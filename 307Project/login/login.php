<!-- Aybala Bengi Canpolat
260909564 -->

<html>
        <body>
            <?php 

            $DB = new SQLite3("../comp307.sqlite", SQLITE3_OPEN_READWRITE);

            // Check connection
            if($DB->lastErrorCode() != 0){
                echo "ERROR: Database connection failed!";
                echo $DB->lastErrorMsg();
            }

            $email = $_POST['email'];

            $sql = $DB->query("SELECT * FROM User WHERE email='$email';" );

            // Check if user is registered
            if (item_exists($email, 'email', $DB)){
                 // retrieve password from database
                 $stmt = $DB->query("SELECT * FROM User WHERE email='$email';");
                 while($row = $stmt->fetchArray(SQLITE3_ASSOC)){         
                    $hashed_pass= $row['password'];
                
                     // check against the user input password
                     $login_success = password_verify($_POST['password'], $hashed_pass);

                     if ($login_success) {
                        session_start();
                        $_SESSION["email"] = $email;
                        echo "<script>function redirect() { 
                                window.location.replace('../dashboard/dashboard.html'); 
                            }</script>";
                    } else {
                        echo '<text>Password is incorrect. Try again.</text>';
                    }

                }   
            } else {
                echo '<text>Email is not registered.</text>';
                  return;

            }   

            function item_exists($item_value, $item_type, $DB) {
                $checkit = $DB->query( "SELECT * FROM user WHERE $item_type= '$item_value';" );
                $rows = 0; //set row counter to 0
                while($row = $checkit->fetchArray()) {
                    $rows += 1; //+1 to the counter per row in result
                }
                if($rows!=0) {
                    return true;
                } else {
                    return false;
                }
            }


        ?>
</body>
</html>