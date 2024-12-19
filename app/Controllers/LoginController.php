<?php

namespace App\Controllers;

use App\Models\LoginModel;
use CodeIgniter\Controller;

class LoginController extends Controller
{
    public function __construct()
    {
        helper('cookie');
    }

    public function display()
    {
        return view('home/login');
    }
    public function formPage()
    {
        return view('home/register');
    }
    public function create()
    {
        $response = ['status' => false, 'message' => '', 'errors' => []];

        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|alpha_space|min_length[3]',
            'lname' => 'required|alpha|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'gender' => 'required|in_list[Male,Female]',
            'mobile_number' => 'required|numeric|min_length[10]|max_length[15]',
            'city' => 'required|in_list[India,USA,UK,Landon]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            log_message('error', json_encode($validation->getErrors()));
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $validation->getErrors(),
            ]);
        }

        $userModel = new LoginModel();
        $data = $this->request->getPost();

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if ($userModel->insert($data)) {
            $response['status'] = true;
            $response['message'] = 'Registration successful!';
        } else {
            $response['message'] = 'Failed to register!';
        }

        return $this->response->setJSON($response);
    }

    public function login()
    {
        $response = ['status' => false, 'message' => ''];
        $request = $this->request;

        if ($request->isAJAX()) {
            $email = $request->getVar('email');
            $password = $request->getVar('password');

            $validationRules = [
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]',
            ];

            if (!$this->validate($validationRules)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors(),
                ]);
            }

            $loginModel = new LoginModel();
            $user = $loginModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                $session = session();
                $session->set([
                    'user_id' => $user['id'],
                    'username' => $user['username'],
                    'is_logged_in' => true,
                ]);

                set_cookie('user_email', $email, 3600);

                $response['status'] = true;
                $response['message'] = 'Login successful!';
            } else {
                $response['message'] = 'Invalid email or password!';
            }
        }

        return $this->response->setJSON($response);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        delete_cookie('user_email');
        return redirect()->to(base_url('login'));
    }
}
