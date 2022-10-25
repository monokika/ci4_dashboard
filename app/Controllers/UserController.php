<?php

namespace App\Controllers;
use App\Models\UserModel;
//use CodeIgniter\I18n\Time;

class UserController extends BaseController
{
  
    public function __construct(){
        require_once APPPATH.'ThirdParty/ssp.php';
        $this->db = db_connect();
    }

    public function getuserModel()
    {
        $usersModel = new \App\Models\UserModel();
        $loggedUserID = session()-> get('LoggedUser');
        return $userInfo = $usersModel->find($loggedUserID);
    }

    public function index()
    {
        $userInfo = $this->getuserModel();
        
         $data = [
           'pageTitle'=>'Home',
           'userInfo' => $userInfo
        ];
          return view('dashboard/home', $data);
    }

    public function profile()
    {
        $userInfo = $this->getuserModel();
        $data = [
            'pageTitle'=>'profile',
            'userInfo' => $userInfo
        ];
        return view('dashboard/profile', $data);
    }

    public function countries(){
        $userInfo = $this->getuserModel();
        $data['pageTitle'] = 'Countries List';
        $data['userInfo'] = $userInfo;
        return view('dashboard/countries', $data);
    }

    public function addCountry(){
        $countryModel = new \App\Models\Country();
        $validation = \Config\Services::validation();
        $this->validate([
             'country_name'=>[
                 'rules'=>'required|is_unique[countries.country_name]',
                 'errors'=>[
                     'required'=>'Country name is required',
                     'is_unique'=>'This country is already exists',
                 ]
             ],
             'capital_city'=>[
                  'rules'=>'required',
                  'errors'=>[
                      'required'=>'Capital city is required'
                  ]
             ]
        ]);

        if($validation->run() == FALSE){
            $errors = $validation->getErrors();
            echo json_encode(['code'=>0, 'error'=>$errors]);
        }else{
             //Insert data into db
             //$datestring = '%Y-%m-%d %H:%i:%s';
             //$myTime = Time::now('Asia/Seoul', 'ko_KR',$datestring);
             
             $data = [
                 'country_name'=>$this->request->getPost('country_name'),
                 'capital_city'=>$this->request->getPost('capital_city')
                 //'created_at'=>$myTime,
             ];
             
             $query = $countryModel->insert($data);
             if($query){
                 echo json_encode(['code'=>1,'msg'=>'New country has been saved to database']);
                 
             }else{
                 echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
             }
        }
    }

    public function getAllCountries(){
        //DB Details
        $dbDetails = array(
            "host"=>$this->db->hostname,
            "user"=>$this->db->username,
            "pass"=>$this->db->password,
            "db"=>$this->db->database,
        );

        $table = "countries";
        $primaryKey = "id";

        $columns = array(
            array(
                "db"=>"id",
                "dt"=>0,
            ),
            array(
                "db"=>"country_name",
                "dt"=>1,
            ),
            array(
                "db"=>"capital_city",
                "dt"=>2,
            ),
            array(
                "db"=>"id",
                "dt"=>3,
                "formatter"=>function($d, $row){
                    return "<div class='btn-group'>
                                  <button class='btn btn-sm btn-primary' data-id='".$row['id']."' id='updateCountryBtn'>Update</button>
                                  <button class='btn btn-sm btn-danger' data-id='".$row['id']."' id='deleteCountryBtn'>Delete</button>
                             </div>";
                }
            ),
        );

        echo json_encode(
            \SSP::simple($_GET, $dbDetails, $table, $primaryKey, $columns)
        );
    }


    public function getCountryInfo(){
        $countryModel = new \App\Models\Country();
        $country_id = $this->request->getPost('country_id');
        $info = $countryModel->find($country_id);
        if($info){
            echo json_encode(['code'=>1, 'msg'=>'', 'results'=>$info]);
        }else{
            echo json_encode(['code'=>0, 'msg'=>'No results found', 'results'=>null]);
        }
    }

    public function updateCountry(){
        $countryModel = new \App\Models\Country();
        $validation = \Config\Services::validation();
        $cid = $this->request->getPost('cid');

        $this->validate([
            'country_name'=>[
                 'rules'=>'required|is_unique[countries.country_name,id,'.$cid.']',
                 'errors'=>[
                      'required'=>'Country name is required',
                      'is_unique'=>'This country is already exists'
                 ]
            ],
            'capital_city'=>[
                  'rules'=>'required',
                  'errors'=>[
                      'required'=>'Capital city is required'
                  ]
            ]
        ]);

        if($validation->run() == FALSE){
            $errors = $validation->getErrors();
            echo json_encode(['code'=>0,'error'=>$errors]);
        }else{
            //Update country
            $data = [
               'country_name'=>$this->request->getPost('country_name'),
               'capital_city'=>$this->request->getPost('capital_city'),
            ];
            $query = $countryModel->update($cid,$data);

            if($query){
                echo json_encode(['code'=>1, 'msg'=>'Country info have been updated successfully']);
            }else{
                echo json_encode(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }


    public function deleteCountry(){
        $countryModel = new \App\Models\Country();
        $country_id = $this->request->getPost('country_id');
        $query = $countryModel->delete($country_id);

        if($query){
            echo json_encode(['code'=>1,'msg'=>'Country deleted Successfully']);
        }else{
            echo json_encode(['code'=>0,'msg'=>'Something went wrong']);
        }
    }
    
}