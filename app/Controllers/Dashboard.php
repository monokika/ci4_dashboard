<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $usersModel = new \App\Models\UserModel();
        $loggedUserID = session()-> get('LoggedUser');
        $userInfo = $usersModel->find($loggedUserID);
        //echo json_encode($userInfo);
        $data = [
            'title' => 'Dashboard',
            'userInfo' => $userInfo
        ];
        return view('dashboard/index', $data);
    }

    function profile(){
        $usersModel = new \App\Models\UserModel();
        $loggedUserID = session()-> get('LoggedUser');
        $userInfo = $usersModel->find($loggedUserID);
        //echo json_encode($userInfo);
        $data = [
            'title' => 'Profile',
            'userInfo' => $userInfo
        ];
        return view('dashboard/profile', $data);
    }

}
