<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resume in HTML</title>


    <style>
        @charset "utf-8";
        /* CSS Document */

        body,
        td,
        th {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        body {
            margin-left: 0px;
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 0px;
            padding: 0px;
        }


        td,
        th,
        tr {

            border: none;
            border-collapse: collapse;
            outline: none;
        }

        .details td {
            padding: 20px;
        }

        .profile {
            background-color: #313C4E;
        }

        .profile td {
            padding: 30px;
        }

        .profile img {
            border-radius: 50%;
        }

        .name {
            font-size: 25px;
        }

        .text-white {
            color: #ddd;
        }

        .bor-bottom {
            border-bottom: 2px solid #449399;
        }

        .text-blue {
            color: #449399;
        }

        .text-black,
        .skill {
            color: #444;
        }

        .left,
        .right {
            vertical-align: top;
        }
    </style>

</head>

<body>
    <table width="100%" border="0" align="center">
        <tr>

            <td>
                <table width="100%" border="0" class="bor" cellspacing="0" cellpadding="0">
                    <tr class="profile">
                        <td width="50%">
                            <img align="right" src=<?php echo  $personal[0]['image'] ?> height="100" />
                        </td>
                        <td width="50%">
                            <p align="right" class="name text-white"><strong><?php echo $name ?></strong></p><br />
                            <p align="right" class="text-white"><?php echo $personal[0]['phone'] ?></p>
                            <p align="right" class="text-white"><?php echo $email ?></p><br />
                            <p class="text-white"><?php echo $summery ?></p>
                        </td>
                    </tr>
                    <tr class="details">
                        <td width="50%" class="left">
                            <h2 class="bor-bottom text-blue" height="100">WORK EXPERIENCE</h2>
                            <?php foreach ($exp as $value) { ?>
                                <br>
                                <h3 class="text-black"><?php echo $value['j_title']; ?> at <?php echo $value['c_name']; ?></h3>
                                <p class="text-black"><?php
                                                        if ($value['present']) {
                                                            echo $value['s_year'] . "-" . "present";
                                                        } else {
                                                            echo $value['s_year'] . "-" . $value['e_year'];
                                                        }
                                                        ?></p>
                                <p class="text-black"><?php echo $value['responsibility']; ?></p>
                            <?php
                            }
                            ?>
                            <!-- <br>
                            <h3 class="text-black">Shining Tomorrow Foundation</h3>
                            <p class="text-black">02/21 - 04/21</p>
                            <p class="text-black">Description here</p> -->

                            <br />
                            <h2 class="bor-bottom text-blue" height="100">EDUCATIONS</h2>
                            <?php foreach ($edu as $value) {
                            ?>

                                <br>
                                <h3 class="text-black"><?php print $value['d_title'] ?></h3>
                                <p class="text-black"><?php
                                                        if ($value['present']) {
                                                            echo $value['s_year'] . "-" . "present";
                                                        } else {
                                                            echo $value['s_year'] . "-" . $value['e_year'];
                                                        }
                                                        ?></p>
                                <p class="text-black"><?php echo $value['e_summery']; ?></p>
                            <?php
                            }
                            ?>
                            <br />
                            <h2 class="bor-bottom text-blue" height="100"><?php echo $cus[0]['title']; ?></h2>
                            <?php foreach ($cus as $value) {
                            ?>

                                <br>
                                <h3 class="text-black"><?php echo $value['sub_title'] ?></h3>

                                <p class="text-black"><?php echo $value['description']; ?></p>
                            <?php
                            }
                            ?>


                        </td>
                        <td width="50%" class="right">
                            <h2 class="bor-bottom text-blue">SKILLS</h2>
                            <br>
                            <div>
                                <?php foreach ($skills as $value) {
                                ?>
                                    <span class="skill"><?php echo $value['s_name']; ?></span>
                                <?php }

                                ?>
                            </div>

                            <br />
                            <h2 class="bor-bottom text-blue" height="100">PROJECTS</h2>
                            <?php foreach ($pro as $value) { ?>
                                <br>
                                <h3 class="text-black"><?php echo $value['p_name']; ?></h3>
                                <span class="text-muted h6"> <?php echo $value['p_title']; ?></span>
                                <p class="text-black"><?php
                                                        if ($value['present']) {
                                                            echo $value['s_year'] . "-" . "present";
                                                        } else {
                                                            echo $value['s_year'] . "-" . $value['e_year'];
                                                        }
                                                        ?></p>
                                <p class="text-black"><?php echo $value['pr_summery']; ?></p>
                                <!-- <br>
                            <h3 class="text-black">Shining Tomorrow Foundation</h3>
                            <p class="text-black">02/21 - 04/21</p>
                            <p class="text-black">Description here</p> -->
                            <?php
                            }
                            ?>
                            <br />
                            <h2 class="bor-bottom text-blue">LANGUAGES</h2>
                            <?php foreach ($lan as $value) { ?>
                                <br>
                                <p class="text-black"><?php echo $value['l_name']; ?></p>
                            <?php
                            }
                            ?>
                            <br />
                            <h2 class="bor-bottom text-blue" height="100">HOBBIES</h2>
                            <?php foreach ($hob as $value) { ?>
                                <br>
                                <p class="text-black"><?php echo $value['h_name']; ?></p>
                            <?php
                            }
                            ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>