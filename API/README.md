## Table of contents

- [General info](#general-info)
- [Technologies](#technologies)
- [Setup](#setup)

## General info

<b>

This repo consists of backend code for resume maker mobile applicaton.

</b>

## Technologies

Project is created with:

- php

<b>
For login
</b>

Endpoint : baseurl/login
Or
Endpoint : baseurl/index.php/login

    Header :

    Expected output format :

            For successfull operation


        {

            "status": true,
            "data": true,
            "message": "Login Successfull",
            "SessionData": {
            "userId": "1633934222",
            "username": "forrahul7@gmail.com"
             }
        }

            For unsucessfull operation

        {
            "status": true,
            "data": false,
            "message": "username doesn't exixst",
            "SessionData": null

        }

<b>
For registration
</b>

    Endpoint : baseurl/signUp

            Or

    Endpoint : baseurl/index.php/signUp

    Header :

    Expected output format :


            For sucessfull operation


                        {
                            "status": true,
                            "data": true,
                            "message": "Registration Successfull",
                            "SessionData": {
                            "userId": 1634971400,
                            "username": "forrahul9@gmail.com"
                            }
                        }



            For unsucessfull operation

                    {
                        "status": true,
                        "data": false,
                        "message": "Username already exist",
                        "SessionData": null

}

<b>For logout</b>

            Endpoint : baseurl/Logout

                        Or

            Endpoint : baseurl/index.php/Logout


            Header :


            For sucessfull operation

            {
                "status": true,
                "data": true,
                "message": "Logout successfull"
            }


            For unsucessfull operation

                {
                    "status": true,
                    "data": false,
                    "message": "Session is not set"
                }

<b>
    For Session Data
</b>

            Endpoint : baseurl/auth-cred

                    Or

            Endpoint : baseurl/index.php/auth-cred


            Header :


             For sucessfull operation

                {
                    "status": true,
                    "data": true,
                    "message": "Auth data is retrieved",
                    "SessionData": {
                    "userId": "1634971400",
                    "username": "forrahul9@gmail.com"
                    }

                }

            For unsucessfull operation


                        {
                            "status": true,
                            "data": false,
                            "message": "Session is not set",
                            "SessionData": null

                        }
