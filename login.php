<?php 
session_start();

require 'functions.php';

// cek dulu cooki 
if ( isset($_COOKIE['id']) && isset($_COOKIE['key']) ){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // ambil username berdasar id
    $result = mysqli_query($conn, "SELECT username FROM tb_users WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // cek cooki dan username
    if ( $key === hash('sha256', $row['username'])){
        $_SESSION['login'] = true;
    }
   
}

if ( isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}



if (isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM tb_users WHERE username = '$username'");
    // cek username
    if (mysqli_num_rows($result) === 1){
        // cek password
        $row = mysqli_fetch_assoc($result);
        
       if ( password_verify($password, $row["password"])){
        //    set session
            $_SESSION["login"] = true;

            // cek cookie remember
            if ( isset($_POST['remember'])){
                // buat cookie

                setcookie('id', $row['id'], time() + 120);
                setcookie('key', hash('sha256', $row['username']), time() + 120);
            }


            header("Location: index.php");
            exit;
       }
    }
    $error = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    label {
        display: block;
        
    }
</style>
</head>


<body>
    <div class="container">
    <div class="col-md-4 col-md-offset-4">
            <div class="card-body">
            <?php if( isset ($error) ) :?>
    <p style="color: red; font-style: italic;"> username / password salah</p>
<?php endif; ?>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label" >Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" id="username" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" id="password" autocomplete="off"  required>
                    </div>
                    <div>
                    <div class="mb-2">
                        <input type="checkbox" name="remember" id="remember">     Remember Me
                        <label for="remember" class="form-label"></label>
                    </div>
                    </div>

                    <button type="submit" name="login" class="btn btn-warning">Log In</button>
                    </form>
            </div>
    </div>
    </div>
    
</body>
</html>