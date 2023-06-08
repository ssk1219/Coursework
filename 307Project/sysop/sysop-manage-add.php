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

            if($firstName=="" || $lastName=="" || $email=="" || $password==""){
                echo ('<script language="javascript"> 
                    alert("WARNING: Form Not Completed");
                    history.go(-1);
                    </script>');
                exit;
            }

            if (item_exists($email, 'email', $DB))
            {
                echo ('<script language="javascript"> 
                    alert("WARNING: Email Already Exists");
                    history.go(-1);
                    </script>');
                exit;
            }
            
            $resultw = $DB->exec("INSERT INTO User ('firstName', 'lastName', 'email', 'password') VALUES ('$firstName', '$lastName', '$email', '$password');");
            
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
            echo ('<script language="javascript"> 
            alert("User Added!");
            window.location.href="sysop_manage_user.html";
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
