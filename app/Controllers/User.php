<?php

namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class User extends BaseController {
    
    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->orderBy('id', 'DESC')->findAll();
        return view('user_view', $data);
    }

    public function create(){
        return view('add_user');
    }

    public function store()
    {
        $userModel = new UserModel();
        $email_id = $this->request->getVar('email');
        $username = $this->request->getVar('username');
        $where = '(email="'.$email_id.'" or username = "'.$username.'")';
        $email_exists = $userModel->where($where)->findAll();
        if(count($email_exists) == '0'){
        //echo "<pre>";print_r(($email_exists));exit;
            $captcha_response = trim($this->request->getVar('g-recaptcha-response'));

            if($captcha_response != '')
            {
                $keySecret = '6Lf4CtEcAAAAANm9XNBimhzxz8CdVPn-lLIdQu80';

                $check = array(
                    'secret'        =>  $keySecret,
                    'response'      =>  $this->request->getVar('g-recaptcha-response')
                );

                $startProcess = curl_init();

                curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");

                curl_setopt($startProcess, CURLOPT_POST, true);

                curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));

                curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);

                curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);

                $receiveData = curl_exec($startProcess);

                $finalResponse = json_decode($receiveData, true);

                if($finalResponse['success'])
                {
                    $data = [
                        'fullname' => $this->request->getVar('fullname'),
                        'username'  => $this->request->getVar('username'),
                        'email'  => $this->request->getVar('email'),
                        'password'  => $this->request->getVar('password'),
                    ];
                    $userModel->insert($data);
                    return $this->response->redirect(site_url('/users-list'));
                }
                else
                {
                    $session = session();
                    $session->setFlashdata('message', 'Validation Fail Try Again');
                    return $this->response->redirect(site_url('/user-form'));
                }
            }
            else
            {
                $session = session();
                $session->setFlashdata('message', 'Validation Fail Try Again');
                return $this->response->redirect(site_url('/user-form'));
            }
        }
        else
        {
            $session = session();
            $session->setFlashdata('message', 'Record with username or emailid exists');
            return $this->response->redirect(site_url('/user-form')); 
        }
    }


}

?>