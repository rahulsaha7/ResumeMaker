<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Resume in HTML</title>
    <!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
    <style>
        body,
        td,
        th {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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

        .profile td {
            padding: 30px;
        }

        .profile {
            text-align: center;
        }

        .profile img {
            display: block;
            margin: 0 auto;
        }

        .name {
            font-size: 25px;
            color: #449399;
            font-weight: bold;
        }

        .text-white {
            color: #ddd;
        }

        .bor-bottom {
            border-bottom: 2px solid #449399;
            width: 100%;
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
            height: 1400px;
        }

        .hr {
            width: 100%;
            color: #449399;
            height: 5px;
        }

        .skill {
            color: #ddd;
        }
    </style>

</head>

<body>
    <table width="100%" border="0" align="center">
        <tr>
            <td>
                <table width="100%" border="0" class="bor" cellspacing="0" cellpadding="0">
                    <tr class="details">
                        <td width="25%" class="left" bgcolor="#2C394A">
                            <img src=<?php echo  $personal[0]['image'] ?> height="100" />
                            <br /><br />
                            <p align="right" class="name"><?php echo $name ?></p><br />
                            <p align="right" class="text-white"><?php echo $personal[0]['phone'] ?></p>
                            <p align="right" class="text-white"><?php echo $email ?></p><br />
                            <p class="text-white"><?php echo $summery ?></p>
                            <br><br /><br />
                            <h2 class="text-blue">SKILLS</h2>
                            <hr class="hr">
                            <br>
                            <div>
                                <?php foreach ($skills as $value) {

                                ?>
                                    <br>

                                    <span class="skill"><?php echo $value['s_name']; ?></span>


                                <?php }

                                ?>
                            </div>

                            <br /><br /><br />
                            <h2 class="text-blue">LANGUAGES</h2>
                            <hr class="hr">
                            <br>
                            <?php foreach ($lan as $value) { ?>
                                <br>
                                <p class="text-white"><?php echo $value['l_name']; ?></p>
                            <?php
                            }
                            ?>
                            <br />
                            <br />
                            <br />
                            <h2 class="text-blue" height="100">HOBBIES</h2>
                            <hr class="hr">
                            <?php foreach ($hob as $value) { ?>
                                <br>
                                <p class="text-white"><?php echo $value['h_name']; ?></p>
                            <?php
                            }
                            ?>
                        </td>


                        <td width="75%" class="right">
                            <h2 class="text-blue" height="100">WORK EXPERIENCE</h2>
                            <hr class="hr">
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
                            <br /><br />
                            <h2 class="text-blue" height="100">EDUCATIONS</h2>
                            <hr class="hr">
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
                            <!-- <br>
                            <h3 class="text-black">Shining Tomorrow Foundation</h3>
                            <p class="text-black">02/21 - 04/21</p>
                            <p class="text-black">Description here</p> -->

                            <br />
                            <br /><br />
                            <h2 class="text-blue" height="100">PROJECTS</h2>
                            <hr class="hr">
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

                            <?php
                            }
                            ?>

                            <!-- <br>
                            <h3 class="text-black">Shining Tomorrow Foundation</h3>
                            <p class="text-black">02/21 - 04/21</p>
                            <p class="text-black">Description here</p> -->

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>