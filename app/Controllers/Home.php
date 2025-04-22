<?php

namespace App\Controllers;
use App\Models\Md_adminpanel;
// use App\Models\Md_home;

class Home extends BaseController
{

    public function __construct()
    {
        $this->Md_adminpanel = new Md_adminpanel();
    }
    public function index(): string
    {
        $data['jobs'] = $this->Md_adminpanel->fn_loadmanagejob();
        return view('layout/vw_dashboard', $data);
    }
}
