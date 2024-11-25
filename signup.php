<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sing up</title>
</head>

<body>

    <div class="container mt-6">
        <div class="row">
            <div class="col-6 mb-4">
                <label class="form-label">Username</label>
                <input type="text" id="username" class="form-control" placeholder="username">
            </div>
            <div class="col-6 mb-4">
                <label class="form-label">Password</label>
                <input type="text" id="Password" class="form-control" placeholder="Password">
            </div>
            <div class="col-12">
                <button type="button" class="btn btn-primary" onclick="register()">Registreer</button>
                <p class="alert alert-danger mt-3" id="errorMessage" style="display:none">Niet alle velden zijn ingevuld.</p>
            </div>
        </div>
    </div>    

</body>

</html>

<script src="./js/signup.js"></script>
