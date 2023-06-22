<?php
require_once ("db_connection/conn.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Get membership card</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    
    <div class="container py-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3" style="background-image: url(<?= PROOT; ?>dist/media/bg-1.jpg); background-position: center; background-repeat: no-repeat; background-size: cover;">
          <div class="container-fluid py-5">
            <h1 class="display-2 fw-bold py-5"></h1>
          </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <h1 class="display-5 fw-bold">Get membership card</h1>
                        <p class="small text-muted">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis beatae pariatur ad voluptatum cum voluptates molestiae consequuntur sunt debitis voluptas omnis ipsam quod harum quos, nesciunt, tempora tempore sapiente ducimus.</p>
                        <a href="news/">go back</a>
                    </div>
                </div>
            
            <form>
          <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
          </div>
          <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
          </div>
          <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
          </div>

          <div class="form-floating mb-3">
      <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
</div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
    </div>



        <footer class="pt-3 mt-4 text-body-secondary border-top">
            &copy; 2023
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>