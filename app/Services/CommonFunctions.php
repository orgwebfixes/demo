<?php

namespace App\Services;

use PDFSnappy;
use Excel;

class CommonFunctions
{
    public function generatePDF($Data, $view, $module_title, $name)
    {
        view()->share('theme', config('srtpl.pdf'));
        view()->share('print', 'pdf');
        view()->share('module_title', $module_title);
        $pdf = PDFSnappy::loadView($view, $Data)
            ->setOption('disable-external-links', true)
            ->setOrientation('portrait')
            ->setOption('footer-right', 'Page [page]')
            ->setOption('footer-left', '[date] [time]');
        return $pdf;
    }

    public function generateCSV($Data, $view, $filename, $name)
    {
        view()->share('theme', config('srtpl.pdf'));
        view()->share('print', 'pdf');
        view()->share('module_title', $filename);
        $excel = Excel::create($filename, function ($excel) use ($filename, $view,$Data) {
            $excel->sheet('sheet1', function ($sheet) use ($view,$Data) {
                $sheet->loadView($view, $Data);
                $sheet->setOrientation('portrait');
            });
        })->export('csv');
        return;
    }
}
