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

        try {



            $env = 'lv';
            if ($env == 'lv') {
                $conn = new PDO("mysql:host=localhost;dbname=maldanat_downtimealert", 'maldanat_easyresume', 'easyresume');
            } else {
                $conn = new PDO("mysql:host=localhost;dbname=MAD", 'root', 'Rahul@7242');
            }



            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Something went wrong, please connect with the adminsitrator' . $e;
        }



        $test = $_POST['check'];





        if (isset($_POST['submit'])) {
            $folder1 = "";
            $folder2 = "";
            //Submit the template location and image to file and that location to directory
            $template_name = $_FILES['template']['name'];
            $temp_template_name = $_FILES['template']['tmp_name'];
            $thumbnail_name = $_FILES['thumbnail']['name'];
            $temp_thumbnail_name = $_FILES['thumbnail']['tmp_name'];

            // echo $thumbnail_name;
            // exit();
            $generate = rand(10, 100000000);
            $path2 = "../uploads/" . $generate . $template_name;
            $path3 = "../uploads/" . $generate . $thumbnail_name;

            $test1 = "../uploads/" . $generate . $template_name;
            $test2 =  "../uploads/" . $generate . $thumbnail_name;

            if (!file_exists($path2) && !file_exists($path3)) {
                if (move_uploaded_file($temp_template_name, $test1)) {
                    $folder1 = "uploads/" . $generate . $template_name;
                    if (move_uploaded_file($temp_thumbnail_name, $test2)) {
                        chmod($test1, 0777);
                        $folder2 = "https://rahulsaha.live/uploads/" . $generate . $thumbnail_name;

                        //Upload that documents to database
                        //$db = new database();
                        $sql = "INSERT into template_master(name,location,thumbnail) values('$template_name','$folder1','$folder2')";
                        try {
                            $sql_query = $conn->prepare($sql);
                            $sql_query->execute();
                        } catch (PDOException $e) {
                            echo "oops ! looks like something went wrong" . $e->getMessage();
                        }
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
            <label class="input-group-text" for="inputGroupFile01">Upload Template</label>
            <input type="file" class="form-control" id="inputGroupFile01" name="template">
        </div>
        <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupFile01">Upload Thumbnail</label>
            <input type="file" class="form-control" id="inputGroupFile01" name="thumbnail">
        </div>

        <!-- <input type="text" name="check[]" id="" placeholder="school1">
        <input type="text" name="check[]" id="" placeholder="school2"> -->

        <input type="submit" value="submit" name="submit">
    </form>
</body>

</html>