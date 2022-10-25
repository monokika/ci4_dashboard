<?= $this->extend('layout/dashboard-layout'); ?>
<?= $this->section('content'); ?>
<div class="row">
     <div class="col-md-8">
          <div class="card">
             <div class="card-body">
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
                        <td> <a href="<?= route_to('user.profile') ?>"><?= ucfirst($userInfo['name']); ?></a></td>
                        <td><?= $userInfo['email']?></td>
                        <td><a href="<?= site_url('auth/logout') ?>">Logout</a></td>
                    </tr>
                    
                    </tbody>
                </table>
             </div>
          </div>
     </div>
</div>
   
<!-- <?= current_url(); ?><br />
<?= base_url('user/home'); ?> -->
<?= $this->endSection(); ?>