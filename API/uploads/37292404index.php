<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="crossorigin" />
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap" media="print" onload="this.media='all'" />
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&amp;family=Roboto:wght@300;400;500;700&amp;display=swap" />
    </noscript>
    <!-- <link href="./css/font-awesome/css/all.min.css?ver=1.2.0" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./css/aos.css?ver=1.2.0">
  <link href="./css/main.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <noscript>
        <style>
            * {
                box-sizing: border-box;
                padding: 0;
                margin: 0;
            }

            h4,
            h5,
            h6 {
                color: white;
            }

            span {
                display: inline-block;
                color: white;
            }

            .rows {
                width: 240px;
                min-width: 220px;
                max-width: 250px;
                height: 100vh;
                background-color: rgb(76, 86, 106);
            }

            .row2 {
                width: calc(100vw - 240px);
                min-width: calc(100vw - 220px);
                max-width: calc(100vw - 250px);
                height: 100vh;
            }

            .profile-image-holder {
                height: 200px;
                width: 200px;
                border-collapse: separate !important;
                perspective: 1px;
                border-radius: 50%;
            }

            .profile-image {
                height: 100%;
                width: 100%;
            }

            address.address-holder::before {
                content: "";
                width: 55px;
                height: 2px;
                background-color: white;
                display: block;
                margin-bottom: 10px;
            }

            section.education-holder::before {
                content: "";
                width: 55px;
                height: 2px;
                background-color: white;
                display: block;
                margin-bottom: 10px;
            }

            .title-header {
                height: 200px;
                width: 100vw;
                background-color: #E3E3E3;
            }

            .divider,
            section.summary::before {
                content: "";
                width: 55px;
                height: 2px;
                background-color: black;
                display: block;
                margin-bottom: 10px;
            }

            .profile,
            .position-name {
                color: black;
            }

            .company-name,
            .date {
                color: grey;
            }
        </style>
</head>

<body>

    <main class="container-fluid p-0 m-0">
        <table>

            <tbody>

                <tr>
                    <td class="rows h-100" height="100%">
                        <figure class="profile-image-holder ps-3 pe-3">
                            <img class="profile-image" src=<?php echo  $personal[0]['image'] ?> alt="profile picture">
                        </figure>
                        <h4 class="px-3">Contact</h3>


                            <address class="address-holder ps-3 pe-3 mt-2">


                                <div>
                                    <i class="fas fa-phone-alt"></i>
                                    <span class="ps-2"><?php echo $personal[0]['phone'] ?></span>
                                </div>
                                <div>
                                    <i class="far fa-envelope"></i>
                                    <span class="ps-2"><?php echo $email ?></span>
                                </div>

                            </address>

                            <h4 class="mt-5 ps-3"> Education </h4>
                            <section class="education-holder ps-3">
                                <?php foreach ($edu as $value) {
                                ?>
                                    <div class="edus mt-3">
                                        <h5><?php echo $value['d_title'] ?></h5>
                                        <h6><?php
                                            if ($value['present']) {
                                                echo $value['s_year'] . "-" . "present";
                                            } else {
                                                echo $value['s_year'] . "-" . $value['e_year'];
                                            }
                                            ?></h6>
                                        <span><?php echo $value['i_name']; ?></span>
                                    </div>

                                <?php

                                }
                                ?>


                            </section>

                            <section class="custom" style="visibility: hidden;">
                                <?php foreach ($skills as $value) {
                                ?>
                                    <p>a</p>

                                <?php
                                }


                                foreach ($skills as $value) {

                                ?>
                                    <p>a</p>
                                <?php
                                }
                                ?>


                            </section>

                    </td>
                    <td class="row2">
                        <header class=" ps-3">
                            <div class="container-fluid title-header ps-2">
                                <section class="text-center pt-5">
                                    <h1><?php echo $name ?></h1>
                                </section>



                            </div>

                        </header>

                        <main class="mt-3">
                            <h4 class="experience profile ps-3">Profile</h4>
                            <section class="summary ps-3">
                                <p><?php echo $summery ?></p>
                            </section>

                            <h4 class="profile ps-3 pt-3">Experience</h4>
                            <section class="summary ps-3">
                                <?php foreach ($exp as $value) { ?>
                                    <div class="pt-1">

                                        <h6 class="position-name"><b> <?php echo $value['j_title']; ?></b></h6>
                                        <span class="company-name float-left"><?php echo $value['c_name']; ?></span>
                                        <span class="date" style="display:block;"> <?php
                                                                                    if ($value['present']) {
                                                                                        echo $value['s_year'] . "-" . "present";
                                                                                    } else {
                                                                                        echo $value['s_year'] . "-" . $value['e_year'];
                                                                                    }
                                                                                    ?></span>
                                        <p class="summary">
                                            <?php echo $value['responsibility']; ?>
                                        </p>
                                    </div>
                                <?php
                                }
                                ?>

                            </section>

                            <h4 class="skills profile ps-3">Skills</h4>
                            <section class="summary ps-3">
                                <div class="pt-1">
                                    <?php foreach ($skills as $value) {
                                        $progress;
                                        if ($value['s_level'] == 'intermediate') {
                                            $progress = "60";
                                        } else if ($value['s_level'] == 'advanced') {
                                            $progress = "90";
                                        } else {
                                            $progress = "40";
                                        }

                                    ?>
                                        <h6 class="position-name"><b> <?php echo $value['s_name']; ?></b></h6>
                                        <progress id="file" value=<?php echo $progress ?> max="100">
                                        </progress>


                                    <?php
                                    }

                                    ?>

                                </div>
                            </section>
                        </main>

                    </td>
                </tr>
            </tbody>
        </table>

    </main>

    <script src="scripts/bootstrap.bundle.min.js?ver=1.2.0"></script>
    <script src="scripts/aos.js?ver=1.2.0"></script>
    <script src="scripts/main.js?ver=1.2.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>