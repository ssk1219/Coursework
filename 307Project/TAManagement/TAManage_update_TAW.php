<!-- Name: Sean Kim-->
<!-- Student ID: 260984342 -->

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="scroll_table.css">
    </head>
    <body>
        <?php
            $DB = new SQLite3("TAManage.sqlite");

            if($DB->lastErrorCode() != 0){
                echo "ERROR: Database connection failed!";
                echo $DB->lastErrorMsg();
            }

            $TAWtableName = $_POST['TAWtableName'];
            $courseNum = $_POST['courseNum'];
            $termAndYear = $_POST['termAndYear'];
            $profName = $_POST['profName'];
            $TAName = $_POST['TAName'];
            $addOrDelete = $_POST['addOrDelete'];

            if( $termAndYear=="" || $profName=="" || $TAName=="" || $addOrDelete=="" ){
                echo ('<script language="javascript"> 
                    alert("WARNING: Form Not Completed");
                    history.go(-1);
                    </script>');
                exit;
            }

            if ($addOrDelete == "Add"){
                $DB->exec("INSERT INTO '$TAWtableName' VALUES ('$termAndYear', '$courseNum', '$profName', '$TAName');");
            } else{ 
                $DB->exec("DELETE FROM '$TAWtableName' WHERE term_year_this_is_for='$termAndYear' AND prof_name='$profName' AND TA_name='$TAName';");
            }

            $DB = null;

            echo ('<script language="javascript"> alert("Wish List Updated!"); history.go(-1); </script>');
            exit;



            function update_item($item_value, $item_type, $user_email, $DB, $OHRtableName) {
                if ($item_value==""){
                } else {
                    $DB->exec( "UPDATE '$OHRtableName' SET $item_type='$item_value' WHERE name='$user_email';" );
                }
            }

        ?>
    </body>
</html>
