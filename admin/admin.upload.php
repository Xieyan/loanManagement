<?php
    require_once '../classes/membership.php';
    $mysql = new Mysql();

    if ( isset($_POST["submit"]) ) {
        if ( isset($_FILES["file"])) {

            //if there was an error uploading the file
            if ($_FILES["file"]["error"] > 0) {
                echo "Return Code: " . $_FILES["file"]["error"] . "<br />";

            }
            else {
                 //Print file details
                 echo "Upload: " . $_FILES["file"]["name"] . "<br />";
                 echo "Type: " . $_FILES["file"]["type"] . "<br />";
                 echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
                 echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

                //if file already exists
                 if (file_exists("upload/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
                 }
                 else {
                        //Store file in directory "upload" with the name of "uploaded_file.txt"
                $storagename = "uploaded_file.csv";
                move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $storagename);
                echo "Stored in: " . "upload/" . $_FILES["file"]["name"] . "<br />";
                }
            }
        } else {
                echo "No file selected <br />";
        }
    }

    if ( $file = fopen( "upload/" . $storagename , r ) ) {

    echo "File opened.<br />";

    $firstline = fgets ($file, 4096 );
        //Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
    $num = strlen($firstline) - strlen(str_replace(",", "", $firstline));

        //save the different fields of the firstline in an array called fields
    $fields = array();
    $fields = explode( ",", $firstline, ($num+1) );

    $line = array();
    $i = 0;

    //CSV: one line is one record and the cells/fields are seperated by ";"
    //so $dsatz is an two dimensional array saving the records like this: $dsatz[number of record][number of cell]
    while ( $line[$i] = fgets ($file, 4096) ) {

        $dsatz[$i] = array();
        $dsatz[$i] = explode( ",", $line[$i], ($num+1) );

        $i++;
    }

        echo "<table>";
        echo "<tr>";
    for ( $k = 0; $k != ($num+1); $k++ ) {
        echo "<td>" . $fields[$k] . "</td>";
    }
        echo "</tr>";

    foreach ($dsatz as $key => $number) {
        //new table row for every record
        echo "<tr>";
        foreach ($number as $k => $content) {
            //new table cell for every field of the record
            echo "<td>" . $content . "</td>";
        }
    }
    echo "</table>";
    //read csv file and write into forms database.
    foreach ($dsatz as $value){
        $formname = $value[0];
        //Did this form aleady exsit in our forms?
        $selectsql = "select id from forms where formname = '$formname'";
        $query = mysql_query($selectsql);
        $row = mysql_fetch_assoc($query);
        if (!$row){
            $author = $value[1];
            $header = $value[2];
            $sections = $value[3];
            $company = $value[4];
            $department = $value[5];
            $status = $value[6];

            //create a new item for this new form.
            $insertsql = "insert into forms(formname, author, header, sections, company, department, status) values ('$formname', '$author', '$header', '$sections', '$company', '$department', '$status')";
            if (mysql_query($insertsql)){
                echo "insert into forms successfully.";
                echo "</br>";
            }
            else {
                echo "Fail to insert into forms database.";
                echo "</br>";
            }
            //insert sections.
            $selectsql = "select id from forms where formname = '$formname'";
            $query = mysql_query($selectsql);
            $row = mysql_fetch_assoc($query);
            $formid = $row['id'];
            $sectionNo = $value[7];
            $sectionheader = $value[8];
            $content = $value[9];
            $viewerNums = 4;
            $sectionstatus = $value[10];

            //create sections for this form.
            $insertsql = "insert into sections(formid, sectionNo, header, content, viewerNums, status) values ('$formid', '$sectionNo', '$sectionheader', '$content', '$viewerNums', '$sectionstatus')";
            if (mysql_query($insertsql)){
                echo "insert into sections successfully.";
                echo "</br>";
            }
            else {
                echo "Fail to insert into sections database.";
                echo "</br>";
            }

        }
        else {
            echo "this form exsited already. form id is :";
            echo $row['id'];
            echo "</br>";
            $formid = $row['id'];
            $sectionNo = $value[7];
            $header = $value[8];
            $content = $value[9];
            $viewerNums = 4;
            $status = $value[10];

            //create sections for this form.
            $insertsql = "insert into sections(formid, sectionNo, header, content, viewerNums, status) values ('$formid', '$sectionNo', '$header', '$content', '$viewerNums', '$status')";
            if (mysql_query($insertsql)){
                echo "insert into sections successfully.";
                echo "</br>";
            }
            else {
                echo "Fail to insert into sections database.";
                echo "</br>";
            }

        }

    }


    }

?>