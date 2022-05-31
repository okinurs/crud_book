<?php 
require 'functions.php';

if (isset($_POST["register"])){
    if ( registrasi($_POST) > 0 ){
        echo "<script>
            alert('New User Succesfully Added');
            </script>";
    }else{
        echo mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
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
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label" >Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" id="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password2" class="form-label">Confirm Password</label>
                        <input type="password" name="password2" class="form-control" placeholder="Confirm Password" id="password2" required>
                    </div>
   
                    <button type="submit" name="register" class="btn btn-primary">Sign Up</button>
                    </form>
            </div>
    </div>
    </div>
    
</body>
</html>