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
      $title = 'Report';
      return view('admin/vw_reports');
    }

    public function fn_getreport()
    {
      $start = $this->request->getGet('start'); // format: 2025-01
      $end   = $this->request->getGet('end');   // format: 2025-08

      $report = $this->Md_report->fn_getreport($start, $end);
      if (!empty($report)) {
        return $this->response->setJSON([
          'response' => 'success',
          'data'     => $report
        ]);
      } else {
        return $this->response->setJSON([
          'response' => 'error',
          'message'  => 'No candidates found.'
        ]);
      }
    }

  }