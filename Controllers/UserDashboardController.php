<?php

namespace Controllers;

use DashboardView;
use Models\MemberModel;
require_once "Views/members/DashboardView.php";

require_once "models/MemberModel.php";

class UserDashboardController
{
    private MemberModel $data;
    private  $view;

    public function __construct()
    {
        $this->data = new MemberModel();
    }
    function display()
    {
        $this->view = new DashboardView();
        $this->view->afficherDashboard();
    }

    public function get_member($user_id)
    {
      return $this->data->getMember($user_id)  ;
    }


}