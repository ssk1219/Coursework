<!-- Name: Sean Kim-->
<!-- Student ID: 260984342 -->

<html>
    <body>
        <?php
            $DB = new SQLite3("../comp307.sqlite");

            if($DB->lastErrorCode() != 0){
                echo "ERROR: Database connection failed!";
                echo $DB->lastErrorMsg();
            }

            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if( $email==""){
                echo ('<script language="javascript"> 
                    alert("WARNING: Form Not Completed");
                    history.go(-1);
                    </script>');
                exit;
            }

            if (item_not_exists($email, 'email', $DB))
            {
                echo ('<script language="javascript"> 
                    alert("WARNING: Email Does Not Exist");
                    history.go(-1);
                    </script>');
                    
                exit;
            }
            update_item($firstName, 'firstName', $email, $DB);
            update_item($lastName, 'lastName', $email, $DB);
            update_item($password, 'password', $email, $DB);

            /*
            $DB->exec("INSERT INTO user VALUES ('John', 'Doe', 'jdoe@cs.mcgill.ca', 'whoamI');");
            
            $resultr = $DB->query("SELECT * FROM 'User';");
            while($row = $resultr->fetchArray(SQLITE3_ASSOC)){         
                echo $row["email"];
                echo " added to database!<br>";
            }            
            
            $isStudent = $_POST['isStudent'];
            $isProf = $_POST['isProf'];
            $isTA = $_POST['isTA'];
            $isAdmin = $_POST['isAdmin'];
            $isSysop = $_POST['isSysop'];

            */

            $DB = null;

           echo ('<script language="javascript"> alert("User Edited!"); window.location.href="sysop_manage_user.html"; </script>');
            exit;

            function item_not_exists($item_value, $item_type, $DB) {
                $checkit = $DB->query( "SELECT * FROM user WHERE $item_type= '$item_value';" );
                $rows = 0; //set row counter to 0
                while($row = $checkit->fetchArray()) {
                    $rows += 1; //+1 to the counter per row in result
                }
                if($rows==0) {
                    return true;
                } else {
                    return false;
                }
            }


            function update_item($item_value, $item_type, $user_email, $DB) {
                if ($item_value==""){
                } else {
                    $DB->exec( "UPDATE user SET $item_type='$item_value' WHERE email='$user_email';" );
                }
            }


        ?>
    </body>
</html>
