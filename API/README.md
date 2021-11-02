## Table of contents

- [General info](#general-info)
- [Technologies](#technologies)
- [Setup](#setup)
- [Login](#Login)
- [Registration](#Registration)
- [Forgot-Password](#Forgot-Password)
- [Login-Credentials](#Login-Credentials)
- [Logout](#Logout)

## General info

<b>

This repo consists of backend code for resume maker mobile applicaton.

</b>

## Technologies

Project is created with:

- php

## Setup

- download this file in local machine using git fetch command
- run the index.php file in local machine using local server
- change the db config file according to your database configuration

## Login

```
    Endpoint : baseurl/login

            OR

    Endpoint : baseurl/index.php/login

```

```
    Parameters :


          $  email
          $  password


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

```

Please be sure that the names of `Parameters` should be same as above

## Registration

```
    Endpoint : baseurl/signUp

            Or

    Endpoint : baseurl/index.php/signUp
```

```
    Parameters :

        $  username
        $  email
        $  phone
        $  password


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
```

Please be sure that the names of `Parameters` should be same as above

## Logout

```

    Endpoint : baseurl/Logout

          Or

    Endpoint : baseurl/index.php/Logout

```

```

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

```

## Login-Credentials

```

    Endpoint : baseurl/auth-cred

            Or

    Endpoint : baseurl/index.php/auth-cred

```

```
            Parameters :

                $ session_id


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

```

Please be sure that the names of `Parameters` should be same as above

Please make sure that the `error_reporting` is set to `-1` if you want to see errors.
