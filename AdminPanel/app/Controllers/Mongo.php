<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Mongo extends BaseController
{
    public function index()
    {
        $reportUsers = $this->mongoSummary();
        if (empty($reportUsers)) {
            $data['users'] = [];
            $data['pager'] = null; 
        } else {
            $currentPage = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
            $perPage = 5;
            $total = count($reportUsers);
            $offset = ($currentPage - 1) * $perPage;
            $data['users'] = array_slice($reportUsers, $offset, $perPage);
            $data['pager'] = [
                'current' => $currentPage,
                'total' => ceil($total / $perPage),
            ];
        }
        echo view('inc/header');
        echo view('report_mongo', $data); 
        echo view('inc/footer');
    }

    public function mongoSummary()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:4000/mongo/getAll");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $data = ['error' => 'Error: ' . curl_error($ch)];
        } else {
            $data = json_decode($response, true);
        }
        curl_close($ch);
        return $data;
    }
    //!download route
    public function spreadsheet()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:4000/mongo/getAll");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
            curl_close($ch);
            exit;
        } 
        $users = json_decode($response, true);
        curl_close($ch);

        $spreadSheet = new Spreadsheet();
        $sheet = $spreadSheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Datetime');
        $sheet->setCellValue('B1', 'Call Type');
        $sheet->setCellValue('C1', 'Dispose Type');
        $sheet->setCellValue('D1', 'Duration');
        $sheet->setCellValue('E1', 'Agent Name');
        $sheet->setCellValue('F1', 'Campaign Name');
        $sheet->setCellValue('G1', 'Process Name');
        $sheet->setCellValue('H1', 'Lead Set ID');
        $sheet->setCellValue('I1', 'Reference UUID');
        $sheet->setCellValue('J1', 'Customer UUID');
        $sheet->setCellValue('K1', 'Hold Time');
        $sheet->setCellValue('L1', 'Mute Time');
        $sheet->setCellValue('M1', 'Ringing Time');
        $sheet->setCellValue('N1', 'Transfer Time');
        $sheet->setCellValue('O1', 'Conference Time');
        $sheet->setCellValue('P1', 'Call Time');
        $sheet->setCellValue('Q1', 'Dispose Time');

        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A'.$row, $user['datetime']);
            $sheet->setCellValue('B'.$row, $user['calltype']);
            $sheet->setCellValue('C'.$row, $user['disposetype']);
            $sheet->setCellValue('D'.$row, $user['duration']);
            $sheet->setCellValue('E'.$row, $user['agentname']);
            $sheet->setCellValue('F'.$row, $user['campaignname']);
            $sheet->setCellValue('G'.$row, $user['processname']);
            $sheet->setCellValue('H'.$row, $user['leadsetid']);
            $sheet->setCellValue('I'.$row, $user['referenceUuid']);
            $sheet->setCellValue('J'.$row, $user['customerUuid']);
            $sheet->setCellValue('K'.$row, $user['holdtime']);
            $sheet->setCellValue('L'.$row, $user['mutetime']);
            $sheet->setCellValue('M'.$row, $user['ringingtime']);
            $sheet->setCellValue('N'.$row, $user['transfertime']);
            $sheet->setCellValue('O'.$row, $user['conferencetime']);
            $sheet->setCellValue('P'.$row, $user['calltime']);
            $sheet->setCellValue('Q'.$row, $user['disposetime']);
            $row++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Logger_Report.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadSheet);
        $writer->save('php://output');
        exit;
    }

    public function summaryReport(){
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://localhost:4000/mongo/report"); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);
                curl_close($ch);
                exit;
            }
            $users = json_decode($response, true);
            curl_close($ch);
            $spreadSheet = new Spreadsheet();
            $sheet = $spreadSheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Hour');
            $sheet->setCellValue('B1', 'totalCalls');
            $sheet->setCellValue('C1','Total Duration');
            $sheet->setCellValue('D1', 'Total Hold Time');
            $sheet->setCellValue('E1', 'Total Mute Time');
            $sheet->setCellValue('F1', 'Total Ringing Time');
            $sheet->setCellValue('G1', 'Total Transfer Time');
            $sheet->setCellValue('H1', 'Total Conference Time');
            $sheet->setCellValue('I1', 'Total Call Time');
            $sheet->setCellValue('J1', 'Total Dispose Time');
    
            $row = 2;

            
            foreach ($users as $user) {
                $sheet->setCellValue('A' . $row, $user['hour'] . " - " . ($user['hour'] + 1));
                $totalCalls = rand(100, 300);
                $sheet->setCellValue('B' . $row, $totalCalls);
                $sheet->setCellValue('C' . $row, gmdate("H:i:s",$user['totalDuration']));
                $sheet->setCellValue('D' . $row, gmdate("H:i:s",$user['totalHoldTime']));
                $sheet->setCellValue('E' . $row, gmdate("H:i:s",$user['totalMuteTime']));
                $sheet->setCellValue('F' . $row, gmdate("H:i:s",$user['totalRingingTime']));
                $sheet->setCellValue('G' . $row, gmdate("H:i:s",$user['totalTransferTime']));
                $sheet->setCellValue('H' . $row, gmdate("H:i:s",$user['totalConferenceTime']));
                $sheet->setCellValue('I' . $row, gmdate("H:i:s",$user['totalCallTime']));
                $sheet->setCellValue('J' . $row, gmdate("H:i:s",$user['totalDisposeTime']));
                $row++;
            }
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Mongo_Summary_Report.xlsx"');
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadSheet);
            $writer->save('php://output');
            exit;
        }
    }

    //!summary_report_mongo
    public function view()
    {
        $reportUsers = $this->mongoReport();
        if (empty($reportUsers)) {
            $data['users1'] = [];
            $data['pager'] = null; 
        } else {
            $currentPage = $this->request->getVar('page') ? (int)$this->request->getVar('page') : 1;
            $perPage = 5;
            $total = count($reportUsers);
            $offset = ($currentPage - 1) * $perPage;
            $data['users1'] = array_slice($reportUsers, $offset, $perPage);
            $data['pager'] = [
                'current' => $currentPage,
                'total' => ceil($total / $perPage),
            ];
        }
        echo view('inc/header');
        echo view('summary_data_mongo', $data); 
        echo view('inc/footer');
    }

    public function mongoReport()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://localhost:4000/mongo/report");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            $data = ['error' => 'Error: ' . curl_error($ch)];
        } else {
            $data = json_decode($response, true);
        }
        curl_close($ch);
        return $data;
    }
}
