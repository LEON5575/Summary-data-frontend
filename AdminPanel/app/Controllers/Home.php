<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserModel();
    }

    public function index()
    {
        $role = $this->request->getGet('filterType1');
       
        $data = [];
        $data['allUsers'] = $this->user->find();
        if ($role) {
            $query = $this->user;
            if (!empty($supervisor)) {
                $query = $query->where('role', $role);
            }
            $data['users'] = $this->user->where('role',$role)->orderBy('id', 'ASC')->paginate(5, 'group1');
        } else {
            $data['users'] = $this->user->orderBy('id', 'ASC')->paginate(5, 'group1');
        }
        $data['pager'] = $this->user->pager;
        echo view('inc/header', $data);
        echo view('home', $data);
        echo view('inc/footer');
    }
    public function saveUser ()
    {
        $data = $this->request->getPost(['email', 'role']);
        
        if (in_array('', $data, true)) {
            session()->setFlashdata("error", "All fields are required.");
            return redirect()->back()->withInput();
        }

        if ($this->user->save($data)) {
            session()->setFlashdata("success", "User  added successfully.");
        } else {
            session()->setFlashdata("error", "Failed to add user.");
        }

        return redirect()->to(base_url('home'));
    }

    public function getUser ($id)
    {
        if (!is_numeric($id)) {
            return $this->response->setJSON(['error' => 'Invalid ID.']);
        }

        $data = $this->user->find($id);
        if (!$data) {
            return $this->response->setJSON(['error' => 'User  not found.']);
        }

        return $this->response->setJSON($data);
    }

    public function updateUser ()
    {
        $id = $this->request->getPost('updateId');
        $data = $this->request->getPost(['email', 'role']);
        
        if (empty($id) || in_array('', $data, true)) {
            session()->setFlashdata("error", "All fields are required.");
            return redirect()->back()->withInput();
        }

        if ($this->user->update($id, $data)) {
            session()->setFlashdata("success", "User  updated successfully.");
        } else {
            session()->setFlashdata("error", "Failed to update user.");
        }

        return redirect()->to(base_url('home'));
    }

    public function deleteUser ()
    {
        $id = $this->request->getPost('id');
        
        if (empty($id) || !$this->user->delete($id)) {
            return $this->response->setJSON(['error' => 'Failed to delete user.']);
        }

        return $this->response->setJSON(['success' => 'User  deleted successfully.']);
    }

    public function deleteAll()
    {
        $ids = $this->request->getPost('ids');
        
        if (empty($ids)) {
            return $this->response->setJSON(['error' => 'No users selected.']);
        }

        $deletedCount = $this->user->whereIn('id', $ids)->delete();
        return $this->response->setJSON(['success' => "$deletedCount users deleted successfully."]);
    }

    public function filterUser()
    {
        $email = $this->request->getGet('email');
        $role = $this->request->getGet('role');
        $query = $this->user;
        if ($email) {
            $query = $query->like('email', $email);
 }
        if ($role) {
            $query = $query->where('role', $role);
        }
        $roles = $this->user->findAll();
        $roleMapping = [];
        foreach ($roles as $roleData) {
            $roleMapping[$roleData['id']] = $roleData['Role'];
        }
        $data = [
            'users' => $query->paginate(5),
            'pager' => $this->user->pager,
            'roles' => $this->user->findAll(),
            'roleMapping' => $roleMapping,
            'filterEmail' => $email, // Pass the email filter value to the view
            'filterRole' => $role     // Pass the role filter value to the view
        ];
        return view('home', $data);
    }
}
