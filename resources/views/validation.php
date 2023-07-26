<!DOCTYPE html>
<html lang="en">

<head>
    <title>Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <h2>Register</h2>
        <form action="./action.php" method="POST">
            <div class="form-group">
                <label for="email">First Name:</label>
                <input type="text" class="form-control" id="email" placeholder="Enter first name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="email">Last Name:</label>
                <input type="text" class="form-control" id="email" placeholder="Enter last name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd" required>
            </div>

            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>

</body>

</html>