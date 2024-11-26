<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- style sheet-->
    <link rel="stylesheet" href="css\style.css">
</head>

<body>

    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100 mt-3">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Signup dabaj!</h3>

                            <div id="fout" class=""></div>

                            <div class="form-outline mb-4">
                                <input type="username" id="username" class="form-control form-control-lg" placeholder="username:" />
                            </div>

                            <div class="form-outline mb-4">
                                <input type="password" id="password" class="form-control form-control-lg" placeholder="Password:"/>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" type="submit" onclick="Signup()">Signup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<!-- dikke javascript -->
<script src="./js/signup.js"></script>

</html>