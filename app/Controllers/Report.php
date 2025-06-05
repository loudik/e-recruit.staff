<?php
namespace App\Controllers;
use App\Models\Md_report;

class Report extends BaseController
{
    protected $Md_report; 
    public function __construct()
    {
        $this->Md_report = new Md_report();
    }
    public function fn_report()
    {         
       $this->data['title'] = 'Report';
      return view('admin/vw_reports', $this->data);
    }

    public function fn_getreport()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');

        $data = $this->Md_report->fn_getreport($start, $end);

        return $this->response->setJSON([
            'response' => 'success',
            'data'     => $data
        ]);
    }

    public function logoBase64()
    {
      $base64 = $this->getLogoBase64();
      return $this->response->setJSON(['base64' => $base64]);
    }



  }