<?php namespace App\Controllers;

use App\Models\ValidateModel;
use CodeIgniter\Controller;

class Validation extends Controller {
    protected $session;
    protected $user;
    public function __construct() {
        $this->session = \Config\Services::session();
        $this->user = new ValidateModel();
    }
    public function login() {
        echo view('inc/header');
        echo view('login');
        echo view('inc/footer');
    }

    public function register() {
        echo view('inc/header');
        echo view('register');
        echo view('inc/footer');
    }

    public function do_register() {
        $user = new ValidateModel();
        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $mobile = $this->request->getPost('mobile');
        $password = $this->request->getPost('password');
        if (empty($name) || empty($email) || empty($mobile) || empty($password)) {
            $this->session->setFlashdata('error', 'All fields are required.');
            return redirect()->to('/register');
        }

        $existingUser = $this->user->where('email',$email)->orWhere('mobile',$mobile)->first();
        if($existingUser){
            $this->session->setFlashdata('error',"Email or Number is Already Exists");
            return redirect()->to('/register');

        }
        
            $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'mobile' => $mobile
        ];
    
        $result = $user->insert($data);
        if ($result) {
            return redirect()->to('/login')->with('success', 'User  Registered Successfully. Please log in.');
        } else {
            return redirect()->back()->with('error', 'Error in Registration');
        }
    }
    
    public function do_login() {
        $user = new ValidateModel();
       //
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        if (empty($email) || empty($password)) {
            return redirect()->to('/login');
        }
        $result = $user->where('email', $email)->first();
        if ($result) {
            if ($password === $result['password']) {
                $this->session->set('user',$result);
                $this->session->setFlashdata('message','Login Successfully...');
                return redirect()->to('/');
            }else {
                return $this->session->setFlashdata('error', 'Invalid Email or Password.');
                return redirect()->to('login');
        }
    } else {
        return $this->session->setFlashdata('error', 'Invalid Email or Password.');
        return redirect()->to('login');
    }
}
public function logOut() {
    $this->session->destroy();
    $this->session->setFlashdata('message', 'You have been logged out successfully.');
    return redirect()->to('/login');
}
    // public function dashboard(){
    //     echo view('/inc/header');
    //     return view('dashboard');
    // }
}
