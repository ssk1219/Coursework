<!-- Name: Sean Kim-->
<!-- Student ID: 260984342 -->

<html>
    <body>
        <?php
            $DB = new SQLite3("TAManage.sqlite");

            if($DB->lastErrorCode() != 0){
                echo "ERROR: Database connection failed!";
                echo $DB->lastErrorMsg();
            }

            $OHRtableName = $_POST['OHRtableName'];
            $email = $_POST['email'];
            $OHRTime = $_POST['OHRTime'];
            $OHRLocation = $_POST['OHRLocation'];
            $OHRDuty = $_POST['OHRDuty'];

            if( $email=="" ){
                echo ('<script language="javascript"> 
                    alert("WARNING: Form Not Completed");
                    history.go(-1);
                    </script>');
                exit;
            }

            if (item_not_exists($email, 'name', $DB, $OHRtableName))
            {
                echo ('<script language="javascript"> 
                    alert("WARNING: Email Does Not Exist");
                    history.go(-1);
                    </script>');
                    
                exit;
            }

            update_item($OHRTime, 'officeHours', $email, $DB, $OHRtableName);
            update_item($OHRDuty, 'duty', $email, $DB, $OHRtableName);
            update_item($OHRLocation, 'officeLocation', $email, $DB, $OHRtableName);

            $DB = null;

            echo ('<script language="javascript"> alert("Office Hours Information Edited!"); history.go(-1); </script>');
            exit;

            function item_not_exists($item_value, $item_type, $DB, $OHRtableName) {
                $checkit = $DB->query( "SELECT * FROM '$OHRtableName' WHERE $item_type= '$item_value';" );
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


            function update_item($item_value, $item_type, $user_email, $DB, $OHRtableName) {
                if ($item_value==""){
                } else {
                    $DB->exec( "UPDATE '$OHRtableName' SET $item_type='$item_value' WHERE name='$user_email';" );
                }
            }

        ?>
    </body>
</html>
