<?php

namespace App\Controllers;

use App\Models\ValidateModel;

class Chat extends BaseController {
   protected $user;

   public function __construct() {
       $this->user = new ValidateModel();
   }

   public function index() {
       $users = $this->user->getAllUsers();
       $data['page'] = 'chat';
       $data['users'] = $users; 
       echo view('inc/header');
       echo view('chat', $data);
       echo view('inc/footer');
   }
}
