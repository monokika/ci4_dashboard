<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="<?= base_url('bootstrap/css/bootstrap.min.css') ?>">

</head>
<body>
    <div class="container">
        <div class="row vertical-center-row" style="margin-top:40px">
            <div class="col-md-4 col-md-offset-4">
                <h4 class="panel-title"><?= $title ?></h4><hr>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>이름</th>
                        <th>메일</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td> <a href="<?= route_to('dashboard/profile') ?>"><?= ucfirst($userInfo['name']); ?></a></td>
                        <td><?= $userInfo['email']?></td>
                        <td><a href="<?= site_url('auth/logout') ?>">Logout</a></td>
                    </tr>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>                
</body>
</html>