## JWT-AUTH Exception Handling In Laravel 8 
INTRODUCTION

JWT-AUTH -> (JSON Web Token Authentication For Laravel and Lumen).

JWT is mainly used for authentication. After a user logs in to an application, the application will create a JWT and send it back to the user. Subsequent requests by the user will include the JWT. The token tells the server what routes, services, and resources the user is allowed to access

We will be creating a basic Register and Login API where authorized users can fetch their information from the database with JWT implemented and then handle some exceptions. 
