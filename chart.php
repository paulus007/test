<?php

    require_once('./vendor/autoload.php');
    require_once('./classes/test.php');

    use Pavelp\Test;
    use Amenadiel\JpGraph\Graph;
    use Amenadiel\JpGraph\Plot;

    $file_path = $_FILES['src_file']['tmp_name'];
    $window    = $_POST['window'];

    $weather = new Test\Weather();
    $weather->parseFile($file_path);
    $weather->calcSMA($window);

    if (count($weather->sma)) {
        $date   = [];
        $real_t = [];
        $sma_t  = [];
        foreach ($weather->sma as $ind => $val) {
            $date[]   = $val->date;
            $real_t[] = $val->real;
            $sma_t[]  = $val->sma;
        }

        $graph = new Graph\Graph(1000, 500);
        $graph->SetScale("linlin");
        $graph->SetBox(false);
        $graph->title->Set("Real and average daily temperature in Moscow for 2021");

        $graph->ygrid->Show();
        $graph->ygrid->SetLineStyle("solid");
        $graph->ygrid->SetColor('#E3E3E3');

        $real_line = new Plot\LinePlot($real_t);
        $graph->Add($real_line);
        $real_line->SetColor("#6600ff");
        $real_line->SetLegend('real');

        $sma_line = new Plot\LinePlot($sma_t);
        $graph->Add($sma_line);
        $sma_line->SetColor("#ff9966");
        $sma_line->SetLegend('average');

        $graph->Stroke();
    }

?>
