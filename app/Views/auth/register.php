<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Ci 4 Authentication</title>
    <link rel="stylesheet" href="<?= base_url('dist/css/adminlte.min.css') ?>">

</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4 " style="margin-top: 70px">
            <h4>Sign Up - Ci 4 Authentication</h4>
            <hr>
           <form action="<?= route_to('create'); ?>" method="POST" autocomplete="off">
           <?php $validation = \Config\Services::validation(); ?>
           
               <?= csrf_field(); ?>
               <?php if( !empty( session()->getFlashdata('fail') ) ) : ?>
                   <div class="alert alert-danger"><?= session()->getFlashdata('fail'); ?></div>
               <?php endif ?>

               <?php if( !empty( session()->getFlashdata('success') ) ) : ?>
                   <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
               <?php endif ?>

               <div class="form-group mb-3">
                    <label class="fw-bold" for="">Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter your name" value="<?= set_value('name') ?>" >
                    <small class="text-danger"><?= isset($validation) ? display_error($validation, 'name') : '' ?></small>
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold" for="">Email</label>
                    <input type="text" name="email" class="form-control" placeholder="Enter your email" value="<?= set_value('email') ?>">
                    <small class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : '' ?></small>
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold" for="">New password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter new password" value="<?= set_value('password') ?>">
                    <small class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : '' ?></small>
                </div>
                <div class="form-group mb-3">
                    <label class="fw-bold" for="">Confirm Password</label>
                    <input type="password" name="cpassword" class="form-control" placeholder="ReType your password" value="<?= set_value('cpassword') ?>">
                    <small class="text-danger"><?= isset($validation) ? display_error($validation, 'cpassword') : '' ?></small>
                </div>
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <div>
                <a href="<?= route_to('login') ?>">I already have an account. Sign in now</a>
                </div>
           </form>
        </div>
    </div>
</div>
    
</body>
</html>