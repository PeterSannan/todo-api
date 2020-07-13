
To be able to execute these apis, please do the following:
- Create the database on your local machine.
- Open .env file and enter you database information.
- Open terminal and change your current working directory to todo-api forlder and run this command: php artisan migrate, Now you should be able to see tables in your database.
- then run the project on your localserver you can use php -S localhost:8000 -t public
- Now you can start to use the API.

All the response are based JSON:API Specification for Building APIs , You can check their website for more details https://jsonapi.org/

Authentication are required for all the apis except login and register apis.

List of Apis:
--------------------------------------------------------------------------------------------------------------
POST  localhost:8000/api/register
- Params, all are required (with exemple):
- firstname:Peter
- lastname:Sannan
- gender:M (M or F)
- birthday:1990-12-20
- password:secret
- password_confirmation:secret
- mobile:78333222
- email:peter.sannan@gmail.com

Success Response:<br/>
Code: 201<br/>
<code>
- "data": {
        "type": "users",
        "id": 1,
        "attributes": {
            "email": "peter.sannan@gmail.com",
            "gender": "M",
            "birthday": "1990-12-20",
            "phone": "78333222",
            "created_at": "2020-07-12T10:03:25.000000Z"
        },
        "token": this token should be added in the header of all others apis ('Bearer ...')
}
</code>
<br/>
Error Response: <br/>
Code: 422 Unprocessable Entity <br/>
<code> "data": {
        "errors": {
            "status": "422",
            "title": "Validation Failed",
            "details": "The lastname field is required."
        }
    }
</code>
OR <br/>
Code: 401 UNAUTHORIZED
<code>
"data": {
        "errors": {
            "status": "401",
            "title": "Unauthorized",
            "details": "User Registration Failed!"
        }
    }
</code>
--------------------------------------------------------------------------------------------------------------
POST  localhost:8000/api/login
Params, all are required (with exemple):
email:peter.sannan@gmail.com
password:secret

Success Response:
Code: 200
"data": {
        "type": "users",
        "id": 1,
        "attributes": {
            "email": "peter.sannan@gmail.com",
            "gender": "M",
            "birthday": "1990-12-20",
            "phone": "78333222",
            "created_at": "2020-07-12T10:03:25.000000Z"
        },
        "token": this token should be added in the header of all others apis ('Bearer ...')
    }

Error Response:
Code: 422 Unprocessable Entity
    "data": {
        "errors": {
            "status": "422",
            "title": "Validation Failed",
            "details": "The email field is required."
        }
    }
 OR
Code: 401 UNAUTHORIZED
"data": {
        "errors": {
            "status": 401,
            "title": "Unauthorized",
            "details": "Email or Password is incorrect"
        }
    }
--------------------------------------------------------------------------------------------------------------

[!!!!(after that , the token should be added to header for all the requests like this:)]()
Authorization:Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXBpXC9sb2dpbiIsImlhdCI6MTU5NDU1NzE4MCwiZXhwIjoxNTk0NTYwNzgwLCJuYmYiOjE1OTQ1NTcxODAsImp0aSI6Ik1xTnBZSE1zYVlVQWhoUGMiLCJzdWIiOjEwLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.L-2MF6OyBX3WIB0EvaZHQea4FCEuMx03M6N85Jc_8Q8

--------------------------------------------------------------------------------------------------------------
POST   localhost:8000/api/logout    
no params.

Success Response:
Code: 200


GET localhost:8000/api/categories
no params

Sucess Response:
"data": [
        {
            "type": "Categories",
            "id": 1,
            "attributes": {
                "name": "Category1"
            }
        }
    ]



--------------------------------------------------------------------------------------------------------------
POST localhost:8000/api/categories
params:
name:category2

Sucess Response:
"data": {
        "type": "Categories",
        "id": 2,
        "attributes": {
            "name": "category2"
        }
    }
Error Response:
if name is not available in the body an invalid data will be thrown with status code 422


--------------------------------------------------------------------------------------------------------------
PUT localhost:8000/api/categories/2 (:id)
name:category2edit

Sucess Response:
"data": {
        "type": "Categories",
        "id": 2,
        "attributes": {
            "name": "category2edit"
        }
    }

 OR
 Error Response:
Code: 403 Forbidden (if the user authenticated different from user who created this category)
"data": {
        "errors": {
            "status": 403,
            "title": "Forbidden",
            "details": "You cannot access this category"
        }
}
OR
if name is not available in the body an invalid data will be thrown with status code 422

--------------------------------------------------------------------------------------------------------------
 Delete  localhost:8000/api/categories/2
 no params.

Success Response:
Code: 200
OR
 Error Response:
Code: 403 Forbidden (if the user authenticated different from user who created this category)
"data": {
        "errors": {
            "status": 403,
            "title": "Forbidden",
            "details": "You cannot access this category"
        }
}

--------------------------------------------------------------------------------------------------------------

GET localhost:8000/api/tasks
Filters Available (you can use multiple filter in same request by addin & between filters):
by authenticated user : localhost:8000/api/tasks
by day: localhost:8000/api/tasks?day=03-10-2020
by month localhost:8000/api/tasks?month=09-2020
by category(categoryid) localhost:8000/api/tasks?category=1 
by status localhost:8000/api/tasks?status=1 (1:Completed, 2:Snoozed, 3:Overdue)

Success Response:
Code: 200
"data": [
        {
            "type": "tasks",
            "id": 8,
            "attributes": {
                "name": "task3",
                "description": "tas4fddsfsdf",
                "datetime": "2020-05-03 23:33:00",
                "status": 1,
                "category": {
                    "type": "Categories",
                    "id": 1,
                    "attributes": {
                        "name": "testccc"
                    }
                }
            }
        },
        {
            "type": "tasks",
            "id": 9,
            "attributes": {
                "name": "task3",
                "description": "tas4fddsfsdf",
                "datetime": "2020-08-03 23:33:00",
                "status": 1,
                "category": {
                    "type": "Categories",
                    "id": 1,
                    "attributes": {
                        "name": "testccc"
                    }
                }
            }
        },
    ]
OR
 Error Response:
Code: 422  (if the value provided for filters are invalid)
"data": {
        "errors": {
            "status": 422,
            "title": "Invalid data",
            "details": "The given data is invalid"
        }
}

--------------------------------------------------------------------------------------------------------------

POST  localhost:8000/api/tasks
params: (all params are required except the description)
name:task1
description:task1
datetime:03-10-2020 23:33
status:2  (1:Completed, 2:Snoozed, 3:Overdue)
category_id:5

Success Response:
Code: 200
"data": {
        "type": "tasks",
        "id": 13,
        "attributes": {
            "name": "task1",
            "description": "task1",
            "datetime": "2020-10-03T23:33:00.000000Z",
            "status": "2",
            "category": {
                "type": "Categories",
                "id": 5,
                "attributes": {
                    "name": "testccc"
                }
            }
        }
    }

OR
Error Response:
Code: 422 Unprocessable Entity (if any parameters are invalid)
    "data": {
        "errors": {
            "status": "422",
            "title": "Validation Failed",
            "details": "The name field is required."
        }
    }
 OR

 Error Response:
Code: 403 Forbidden (if the user authenticated different from user who created this category)
"data": {
        "errors": {
            "status": 403,
            "title": "Forbidden",
            "details": "You cannot access this category"
        }
}

--------------------------------------------------------------------------------------------------------------

PUT  localhost:8000/api/tasks/7
params: (no required params, the attribute you would like to updated it, you have to send it)
name:task_upadate
description:task_update

Success Response:
Code: 200
"data": {
        "type": "tasks",
        "id": 7,
        "attributes": {
            "name": "task_update",
            "description": "task_update",
            "datetime": "2020-10-03T23:33:00.000000Z",
            "status": "2",
            "category": {
                "type": "Categories",
                "id": 5,
                "attributes": {
                    "name": "testccc"
                }
            }
        }
    }


Error Response:(if the user authenticated different from user who created this task)
"data": {
        "errors": {
            "status": 403,
            "title": "Forbidden",
            "details": "You cannot access this task"
        }
    }

Or
Code: 422 Unprocessable Entity (if any parameters are invalid)
    "data": {
        "errors": {
            "status": "422",
            "title": "Validation Failed",
            "details": "The name field is required."
        }
    }
 OR


Code: 403 Forbidden (if the user authenticated different from user who created this category)
"data": {
        "errors": {
            "status": 403,
            "title": "Forbidden",
            "details": "You cannot access this category"
        }
}


--------------------------------------------------------------------------------------------------------------


DELETE localhost:8000/api/tasks/7 
 no params.

Success Response:
Code: 200
OR
 Error Response:
Code: 403 Forbidden (if the user authenticated different from user who created this task)
"data": {
        "errors": {
            "status": 403,
            "title": "Forbidden",
            "details": "You cannot access this task"
        }
}
