<?php

namespace App\Controllers;

use App\Models\CampaignModel;

class Campaign extends BaseController
{
    protected $campaignModel;

    public function __construct()
    {
        $this->campaignModel = new CampaignModel();
    }

    public function index()
    {
        $supervisor = $this->request->getGet('filterType1');
        $data = [];
        $data['allUsers'] = $this->campaignModel->find();
        if ($supervisor) {
            $query = $this->campaignModel;
            if (!empty($supervisor)) {
                $query = $query->where('supervisor', $supervisor);
            }
            $data['users'] = $this->campaignModel->where('supervisor',$supervisor)->orderBy('id', 'ASC')->paginate(5, 'group1');
        } else {
            $data['users'] = $this->campaignModel->orderBy('id', 'ASC')->paginate(5, 'group2');
        }
        $data['pager'] = $this->campaignModel->pager;
        
        echo view('inc/header', $data);
        echo view('campaign', $data);
        echo view('inc/footer');
    }

    public function saveCampaign()
    
    {
        $data = $this->request->getPost([
            'name', 'description', 'client', 'supervisor', 'status'
        ]);

        if (in_array('', $data, true)) {
            session()->setFlashdata("error", "All fields are required.");
            return redirect()->back()->withInput();
        }

        if ($this->campaignModel->save($data)) {
            session()->setFlashdata("success", "Campaign added successfully.");
        } else {
            session()->setFlashdata("error", "Failed to add campaign.");
        }

        return redirect()->to(base_url('campaign'));
    }

    public function getCampaign($id)
    {
        if (!is_numeric($id)) {
            return $this->response->setJSON(['error' => 'Invalid campaign ID.']);
        }

        $data = $this->campaignModel->find($id);

        if (!$data) {
            return $this->response->setJSON(['error' => 'Campaign not found.']);
        }

        return $this->response->setJSON($data);
    }

    public function updateCampaign()
    {
        $id = $this->request->getPost('updateId');
        $data = $this->request->getPost([
            'name', 'description', 'client', 'supervisor', 'status'
        ]);

        if (empty($id) || in_array('', $data, true)) {
            session()->setFlashdata("error", "All fields are required.");
            return redirect()->back()->withInput();
        }

        if ($this->campaignModel->update($id, $data)) {
            session()->setFlashdata("success", "Campaign updated successfully.");
        } else {
            session()->setFlashdata("error", "Failed to update campaign.");
        }

        return redirect()->to(base_url('campaign'));
    }

    public function deleteCampaign()
    {
        $id = $this->request->getPost('id');

        if (empty($id) || !$this->campaignModel->delete($id)) {
            return $this->response->setJSON(['error' => 'Failed to delete campaign.']);
        }

        return $this->response->setJSON(['success' => 'Campaign deleted successfully.']);
    }

    public function deleteAllCampaign()
    {
        $ids = $this->request->getPost('ids');

        if (empty($ids)) {
            return $this->response->setJSON(['error' => 'No campaigns selected.']);
        }

        $deletedCount = $this->campaignModel->whereIn('id', $ids)->delete();

        return $this->response->setJSON(['success' => "$deletedCount campaigns deleted successfully."]);
    }

    public function filterCampaign()
    {
        
            $supervisor = $this->request->getPost('filterType1');
            $query = $this->campaignModel;
            if ($supervisor) {
                $query = $query->like('supervisor', $supervisor);
            }
            // if ($role) {
            //     $query = $query->like('role', $role);
            // }
            $data = [
                'users' => $query->paginate(5),
                'pager' => $this->campaignModel->pager,
                'filterType1' => $supervisor, // Pass the filter values to the view
            ];
            return view('campaign', $data);
        }
}
