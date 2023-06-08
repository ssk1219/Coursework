<!-- Aybala Bengi Canpolat
260909564 -->

<html>
        <body>
            <?php
            $DB = new SQLite3("../comp307.sqlite", SQLITE3_OPEN_READWRITE);

            if($DB->lastErrorCode() != 0){
                echo "ERROR: Database connection failed!";
                echo $DB->lastErrorMsg();
            }

            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $userTypes = $_POST['user-types'];  //assume that this is an array
            // $userTypes = json_decode($userTypes, true);  // convert JSON to array of account types
            $studentID = $_POST['studentID'];
            $semester = $_POST['semester'];
            $courses = $_POST['courses'];


            // Check if all required fields are filled.
            if($firstName=="" || $lastName=="" || $email=="" || $password==""){
                echo ('<script language="javascript"> 
                    alert("WARNING: Form Not Completed");
                    history.go(-1);
                    </script>');
                exit;
            }
        

            //Check if the email is already registered
            if (item_exists($email, 'email', $DB)){
                echo ('<script language="javascript"> 
                alert("WARNING: Email Already Registered");
                history.go(-1);
                </script>');
                exit;
            }

            // Update the User table
            $resultw = $DB->exec("INSERT INTO User ('firstName', 'lastName', 'email', 'password') VALUES ('$firstName', '$lastName', '$email', '$hashed_pass');");
    
            // Get the user type indexes and update the User_UserType table
            foreach ($userTypes as &$type) {
                $stmt = $DB->query("SELECT * FROM UserType WHERE userType='$type';" );
                while($row = $stmt->fetchArray(SQLITE3_ASSOC)){         
                    $idx= $row['idx'];
                    $stmtw = $DB->exec("INSERT INTO User_UserType (userId, userTypeId) VALUES ('$email', '$idx');");
                }    
            }


            if (in_array("student", $userTypes)) {
                echo "IS STUDENT";
            }else{
                echo "NOT STUDENT";
            }
      









            // close db connection
            $DB = null;
            echo ('<script language="javascript"> 
            alert("User Registered!");
            window.location.href="../dashboard/dashboard.html";
            </script>');
            exit;
            
            
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