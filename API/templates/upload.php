<?php
require_once '../include/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>upload</title>
</head>

<body>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        echo "hello world";


        $test = $_POST['check'];





        if (isset($_POST['submit'])) {
            $folder1 = "";
            $folder2 = "";
            //Submit the template location and image to file and that location to directory
            $template_name = $_FILES['template']['name'];
            $temp_template_name = $_FILES['template']['tmp_name'];
            $thumbnail_name = $_FILES['thumbnail']['name'];
            $temp_thumbnail_name = $_FILES['thumbnail']['tmp_name'];

            $path2 = "../uploads/" . $template_name;
            $path3 = "../uploads/" . $thumbnail_name;

            $test1 = "../uploads/" . $template_name;
            $test2 =  "../uploads/" . $thumbnail_name;

            if (!file_exists($path2) && !file_exists($path3)) {
                if (move_uploaded_file($temp_template_name, $test1)) {
                    $folder1 = "uploads/" . $template_name;
                    if (move_uploaded_file($temp_thumbnail_name, $test1)) {
                        $folder2 = "http://localhost/Backend/API/uploads/" . $thumbnail_name;

                        //Upload that documents to database
                        $db = new database();
                        $sql = "INSERT into template_master(name,location,thumbnail) values('$template_name','$folder1','$folder2')";


                        $db->query($sql);
                        $db->close_connection();
                    }
                } else {
                    echo "no directory";
                }
            } else {
                echo "file is already there with this name";
            }
        } else {
            echo "no";
        }
    }
    ?>
    <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?> method="post" enctype="multipart/form-data">
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupFile01">Upload</label>
            <input type="file" class="form-control" id="inputGroupFile01" name="template">
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupFile01">Upload</label>
            <input type="file" class="form-control" id="inputGroupFile01" name="thumbnail">
        </div>

        <input type="text" name="check[]" id="" placeholder="school1">
        <input type="text" name="check[]" id="" placeholder="school2">

        <input type="submit" value="submit" name="submit">
    </form>
</body>

</html>