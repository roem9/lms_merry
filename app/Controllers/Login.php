<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use App\Models\MemberModel;
use App\Models\PengajarModel;

class Login extends BaseController
{
    public function index()
    {
        $session = session();

        // Check if remember me cookie exists
        if (isset($_COOKIE['cookie_admin'])) {
            // Retrieve the remember me token from the cookie
            $token = $_COOKIE['cookie_admin'];

            // Check if the token exists in the database
            $model = new AdminModel();
            $data = $model->where('cookie', $token)->first();

            if ($data) {
                // Set session data
                $ses_data = [
                    'username'       => $data['username'],
                    'id_admin'       => $data['id_admin'],
                    'logged_in'      => TRUE,
                    'level'          => 'admin'
                ];
                $session->set($ses_data);

                // Redirect to the "produk" page
                return redirect()->to(base_url('/home'));
            }
        } else if (isset($_COOKIE['cookie_member'])) {
            // Retrieve the remember me token from the cookie
            $token = $_COOKIE['cookie_member'];

            // Check if the token exists in the database
            $model = new MemberModel();
            $data = $model->where('cookie', $token)->first();

            if ($data) {
                // Set session data
                $ses_data = [
                    'nim'           => $data['nim'],
                    'id_member'       => $data['id_member'],
                    'logged_in'      => TRUE,
                    'level'          => 'member'
                ];
                $session->set($ses_data);

                // Redirect to the "produk" page
                return redirect()->to(base_url('/myProfile'));
            }
        } else if (isset($_COOKIE['cookie_pengajar'])) {
            // Retrieve the remember me token from the cookie
            $token = $_COOKIE['cookie_pengajar'];

            // Check if the token exists in the database
            $model = new MemberModel();
            $data = $model->where('cookie', $token)->first();

            if ($data) {
                // Set session data
                $ses_data = [
                    'nip'           => $data['nip'],
                    'id_pengajar'       => $data['id_pengajar'],
                    'logged_in'      => TRUE,
                    'level'          => 'pengajar'
                ];
                $session->set($ses_data);

                // Redirect to the "produk" page
                return redirect()->to(base_url('/myProfile'));
            }
        }

        $session->destroy();
        $data['title'] = 'Login';
        return view('pages/sign-in', $data);
    }

    public function auth()
    {
        $session = session();
        $model = new AdminModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember');

        $data = $model->where('username', $username)->first();
        if ($data) {
            $pass = $data['password'];
            $verify_pass = password_verify($password, $pass);
            if ($verify_pass) {
                $ses_data = [
                    'username'       => $data['username'],
                    'id_admin'       => $data['id_admin'],
                    'logged_in'      => TRUE,
                    'level'          => 'admin'
                ];
                $session->set($ses_data);

                // If "Remember Me" is checked, set a cookie
                if ($remember) {
                    // Generate a remember me token
                    $token = bin2hex(random_bytes(32));

                    // Store the token in the database
                    $model->update($data['id_admin'], ['cookie' => $token]);

                    // Set the remember me cookie
                    setcookie('cookie_admin', $token, time() + (30 * 24 * 60 * 60), '/');
                }

                return redirect()->to(base_url('/'));
            } else {
                $session->setFlashdata('msg', 'Password salah');
                return redirect()->to(base_url('/login'));
            }
        } else {
            $model = new MemberModel();
            $data = $model->where(['nim' => $username, 'hapus' => 0])->first();
            if ($data) {
                $pass = date('dmY', strtotime($data['tgl_lahir']));
                $verify_pass = ($password == $pass) ? true : false;

                if ($verify_pass) {
                    $ses_data = [
                        'nim'           => $data['nim'],
                        'id_member'       => $data['id_member'],
                        'logged_in'      => TRUE,
                        'level'          => 'member'
                    ];
                    $session->set($ses_data);

                    // If "Remember Me" is checked, set a cookie
                    if ($remember) {
                        // Generate a remember me token
                        $token = bin2hex(random_bytes(32));

                        // Store the token in the database
                        $model->update($data['id_member'], ['cookie' => $token]);

                        // Set the remember me cookie
                        setcookie('cookie_member', $token, time() + (30 * 24 * 60 * 60), '/');
                    }

                    return redirect()->to(base_url('/myProfile'));
                } else {
                    $session->setFlashdata('msg', 'Password salah');
                    return redirect()->to(base_url('/login'));
                }
            } else {
                $model = new PengajarModel();
                $data = $model->where(['nip' => $username, 'hapus' => 0])->first();
                if ($data) {
                    $pass = date('dmY', strtotime($data['tgl_lahir']));
                    $verify_pass = ($password == $pass) ? true : false;

                    if ($verify_pass) {
                        $ses_data = [
                            'nip'           => $data['nip'],
                            'id_pengajar'       => $data['id_pengajar'],
                            'logged_in'      => TRUE,
                            'level'          => 'pengajar'
                        ];
                        $session->set($ses_data);

                        // If "Remember Me" is checked, set a cookie
                        if ($remember) {
                            // Generate a remember me token
                            $token = bin2hex(random_bytes(32));

                            // Store the token in the database
                            $model->update($data['id_pengajar'], ['cookie' => $token]);

                            // Set the remember me cookie
                            setcookie('cookie_pengajar', $token, time() + (30 * 24 * 60 * 60), '/');
                        }

                        return redirect()->to(base_url('/p/myProfile'));
                    } else {
                        $session->setFlashdata('msg', 'Password salah');
                        return redirect()->to(base_url('/login'));
                    }
                } else {
                    $session->setFlashdata('msg', 'Username tidak ditemukan');
                    return redirect()->to(base_url('/login'));
                }
            }
        }
    }

    public function logout()
    {
        $session = session();

        // Check if the remember me cookie exists
        if (isset($_COOKIE['cookie_admin'])) {
            // Delete the remember me cookie by setting an expired time
            setcookie('cookie_admin', '', time() - 3600, '/');
        }

        if (isset($_COOKIE['cookie_member'])) {
            // Delete the remember me cookie by setting an expired time
            setcookie('cookie_member', '', time() - 3600, '/');
        }

        if (isset($_COOKIE['cookie_pengajar'])) {
            // Delete the remember me cookie by setting an expired time
            setcookie('cookie_pengajar', '', time() - 3600, '/');
        }

        $session->destroy();
        return redirect()->to(base_url('/login'));
    }
}
