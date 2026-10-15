<?php

use setasign\Fpdi\Fpdi;
use PhpOffice\PhpSpreadsheet\IOFactory;


class ReportbookController extends z_controller
{
    
    public function action_create(Request $req, Response $res)
    {
        $spreadsheet = IOFactory::load('webroot/assets/cost-report.xls');
        $sheet = $spreadsheet->getActiveSheet();
        $costReport = $sheet->toArray();

        array_shift($costReport);
        array_shift($costReport);
        array_pop($costReport);

        $costReportByDay = [];

        for ($i = 1; $i <= 5; $i++) {
            $costReportByDay[$i] = [
                "comment" => "",
                "hours" => 0,
            ];
        }

        foreach ($costReport as $costReportItem) {
            $day = date('w', strtotime($costReportItem[0]));
            $comment = $costReportItem[4];
            $hours = (float) $costReportItem[6];

            $costReportByDay[$day]["comment"] .= $comment . " ";
            $costReportByDay[$day]["hours"] += $hours;
        }




        if ($req->hasFormData()) {
                    $formResult = $req->validateForm([
                        (new FormField("name"))->required(),
                        (new FormField("provider"))->required(),
                        (new FormField("reportnumber"))->required(),
                        (new FormField("weekstart"))->required(),
                        (new FormField("weekend"))->required(),
                        (new FormField("year"))->required(),
                        (new FormField("day1")),
                        (new FormField("day2")),
                        (new FormField("day3")),
                        (new FormField("day4")),
                        (new FormField("day5")),
                        (new FormField("day1hours")),
                        (new FormField("day2hours")),
                        (new FormField("day3hours")),
                        (new FormField("day4hours")),
                        (new FormField("day5hours")),
                    ]);

            if ($formResult->hasErrors) {
                return $res->formErrors($formResult->errors);
            }

            $pdf = new Fpdi();

            $pdf->setSourceFile('webroot/assets/reportbook.pdf');
            $page = $pdf->importPage(1);

            $pdf->AddPage();
            $pdf->useTemplate($page);


            $pdf->SetFont('Arial', '', 8);

            $name = mb_convert_encoding($formResult->getValue("name"), 'Windows-1252', 'UTF-8');
            $provider = mb_convert_encoding($formResult->getValue("provider"), 'Windows-1252', 'UTF-8');

            $day1 = mb_convert_encoding($formResult->getValue("day1"), 'Windows-1252', 'UTF-8');
            $day1 = mb_strimwidth($day1, 0, 480, '...', 'Windows-1252');
            $day2 = mb_convert_encoding($formResult->getValue("day2"), 'Windows-1252', 'UTF-8');
            $day2 = mb_strimwidth($day2, 0, 480, '...', 'Windows-1252');
            $day3 = mb_convert_encoding($formResult->getValue("day3"), 'Windows-1252', 'UTF-8');
            $day3 = mb_strimwidth($day3, 0, 480, '...', 'Windows-1252');
            $day4 = mb_convert_encoding($formResult->getValue("day4"), 'Windows-1252', 'UTF-8');
            $day4 = mb_strimwidth($day4, 0, 480, '...', 'Windows-1252');
            $day5 = mb_convert_encoding($formResult->getValue("day5"), 'Windows-1252', 'UTF-8');
            $day5 = mb_strimwidth($day5, 0, 480, '...', 'Windows-1252');

            // Name
            $pdf->SetXY(121, 21);
            $pdf->Write(4, $name);

            // Ausbildungsabteilung
            $pdf->SetXY(121, 25.6);
            $pdf->Write(4, $provider);

            // Berichtsheftnummer
            $pdf->SetXY(50, 36.5);
            $pdf->Write(4, $formResult->getValue("reportnumber"));

            // Woche vom
            $pdf->SetXY(80, 36.5);
            $pdf->Write(4, $formResult->getValue("weekstart"));

            // Woche bis
            $pdf->SetXY(121, 36.5);
            $pdf->Write(4, $formResult->getValue("weekend"));

            // Ausbildungsjahr
            $pdf->SetXY(165, 36.5);
            $pdf->Write(4, $formResult->getValue("year"));

            // Tage mit Stunden
            $pdf->SetXY(28.5,52);
            $pdf->MultiCell(130, 4.85, $day1, 0, 'C');
            $pdf->SetXY(178,72);
            $pdf->Write(4, $formResult->getValue("day1hours"));

            $pdf->SetXY(28.5,77);
            $pdf->MultiCell(130, 4.85, $day2, 0, 'C');
            $pdf->SetXY(178,97);
            $pdf->Write(4, $formResult->getValue("day2hours"));

            $pdf->SetXY(28.5,102);
            $pdf->MultiCell(130, 4.85, $day3, 0, 'C');
            $pdf->SetXY(178,122);
            $pdf->Write(4, $formResult->getValue("day3hours"));

            $pdf->SetXY(28.5,127);
            $pdf->MultiCell(130, 4.85, $day4, 0, 'C');
            $pdf->SetXY(178,147);
            $pdf->Write(4, $formResult->getValue("day4hours"));

            $pdf->SetXY(28.5,152);
            $pdf->MultiCell(130, 4.85, $day5, 0, 'C');
            $pdf->SetXY(178,172);
            $pdf->Write(4, $formResult->getValue("day5hours"));

            $pdf->SetXY(177,191.8);
            $pdf->Write(4, ((float) $formResult->getValue("day1hours") + (float) $formResult->getValue("day2hours") + (float) $formResult->getValue("day3hours") + (float) $formResult->getValue("day4hours") + (float) $formResult->getValue("day5hours")));

            $pdf->Output('F', 'webroot/assets/berichtsheft_fertig.pdf');

            
            return $res->success();
        }

        return $res->render("reportbook/create", ["costReportByDay" => $costReportByDay]);
    }

}
