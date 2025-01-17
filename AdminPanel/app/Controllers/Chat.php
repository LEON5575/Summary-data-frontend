<?php

namespace App\Controllers;

use App\Models\CampaignModel;

class Chat extends BaseController
{
     public function index(){
        echo view('inc/headerChat');
        echo view('chat');
        echo view('inc/footer');
     }
}