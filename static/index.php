
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Better Limited</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <script src="./script/w3.js"></script>
    <link rel="shortcut icon" href="./main.ico" type="image/x-icon">
    
</head>
<body class="bg-white">
<?php 
$is_try_login = ! empty($_POST);
require_once("./php/http_helper.php");
require_once("./php/conn.php");

$conn;
if ($is_try_login)
{
    $username = $_POST["UserName"];
    $password = $_POST["Pwd"];
}


?>
<!-- <?php 

        try 
        {
            $conn = get_db_connection();
        }catch(Exception)
        {   
            redirect("./pages/404.html");
        }
    ?> -->
    <div class="d-flex align-items-center flex-column justify-content-center" style="height:100vh">
            <div class="d-block bg-light border rounded shadow p-1 mb-3" style="width:450px">
                <div class="text-lg-start p-3 text-black-50">
                    Welcome Back!
                </div>
                <div class="text-lg-start px-3 font-size h2">
                    Login to your account
                </div>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="Post" class="p-5">
                    <label for="UserName" class="form-label">User Name</label>
                    <input type="text" required class="rounded-pill form-control border-gray " style="padding: 0.5rem 1rem 0.5rem 1rem;" id="UserName" name="UserName" >
                    <div class="invalid-feedback">
                        No user found
                    </div>
                    <label for="Password" class="form-label mt-3">Password</label>
                    <input type="password" required class="form-control rounded-pill border-gray" style="padding: 0.5rem 1rem 0.5rem 1rem;" id="Password" name="Pwd">
                    <div class="invalid-feedback">
                        Your password is incorrect.
                    </div>
                    <button type="submit" class="btn btn-primary w-100 text-center mt-5 text-light shadow p-2 mb-3 rounded">Login</button>
                    <div class="text-info pe-auto">
                        contact It Team?
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>