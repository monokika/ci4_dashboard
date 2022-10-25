<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;
use App\Libraries\Hash;


class Auth extends BaseController
{
    protected $helpers = ['url', 'form'];

    public function Index()
    {
        return view('auth/login');
    }
    public function login()
    {
        return view('auth/login');
    }

    public function Register()
    {
        return view('auth/register');
    }

    public function create(){
        // validate 요청
        $validation = $this->validate([
            'name' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => '이름을 넣어주세요.',
                ],
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => '이메일을 넣어주세요',
                    'valid_email' => '이메일이 유효하지 않습니다. 다시 확인해주세요.',
                    'is_unique' => '이메일이 이미 있습니다.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[5]|max_length[20]',
                'errors' => [
                    'required' => '패스워드를 넣어주세요.',
                    'min_length' => '비밀번호는 5자 이상이어야 합니다.',
                    'max_length' => '비밀번호는 20자 초과할 수 없습니다.',
                ],
            ],
            'cpassword' => [
                'rules'  => 'matches[password]',
                'errors' => [
                    'required' => '비밀번호 확인이 필요합니다',
                    'min_length' => '암호 확인의 길이는 5자 이상이어야 합니다.',
                    'max_length' => '암호 확인의 길이는 20자를 초과할 수 없습니다.',
                    'matches' => '비밀번호 확인은 비밀번호와 일치해야 합니다.',
                ],
            ],
        ]);

        if(!$validation){
          
            return  redirect()->to('auth/register')->with('validation', $this->validator)->withInput();

        }else{
            //Register user in database
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $values = [
               'name'=>$name,
               'email'=>$email,
               'password'=>Hash::make($password),
            ];

         
            $userModel = new UserModel();
            $query = $userModel->insert($values);
            if( !$query ){
                 return  redirect()->to('auth/register')->with('fail', '문제가 발생했습니다.\n관리자에게 문의하세요.');
            }else{
                  return  redirect()->to('auth/login')->with('success', '축하합니다. 성공적으로 등록되었습니다.');
            }
        }
    }


    public function check(){

        $validation = $this->validate([
            'email' => [
                'rules'  => 'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => '이메일을 넣어주세요.',
                    'valid_email' => '이메일을 확인하십시오. 유효하지 않은 것 같습니다.',
                    'is_not_unique' => '사용가능한 이메일 입니다.',
                ],
            ],
            'password' => [
                'rules'  => 'required|min_length[5]|max_length[20]',
                'errors' => [
                    'required' => '비밀번호를 넣어주세요.',
                    'min_length' => '비밀번호는 5자 이상이어야 합니다.',
                    'max_length' => '비밀번호는 20자 이내여야 합니다.',
                ],
            ],
        ]);

        if(!$validation){
            return  redirect()->to('auth/login')->with('validation', $this->validator)->withInput();
        }else{
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $userModel = new UserModel();
            $user_info = $userModel->where('email', $email)->first();
       
            $check_password = Hash::check($password, $user_info['password']);
            if( !$check_password ){
                return  redirect()->to('auth/login')->with('fail', '잘못된 비밀번호입니다. 다시입력하세요.')->withInput();
            }else{
                // $session_data = ['user' => $user_info];
                // session()->set('LoggedUser', $session_data);
                $user_id = $user_info['id'];
                session()->set('LoggedUser', $user_id);
                return  redirect()->to('user/home');

            }
        }
    }

    public function logout(){
         if( session()->has('LoggedUser') ){
            session()->remove('LoggedUser');
            return  redirect()->to('auth/login')->with('fail', 'You are now logged out.');
         }
    }
}