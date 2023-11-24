<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class Coverage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:coverage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatch event to code coverage notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = "coverage.txt";
        $lines = array();
        $fp = fopen($filename, "r");
        $report = array();

        if(filesize($filename) > 0){
            $content = fread($fp, filesize($filename));
            $lines = explode("\n", $content);
            fclose($fp);
        }
        $resume = [
            "date" => Carbon::createFromFormat('Y-m-d H:i:s', preg_replace("/\s+/", "", $lines[3])),
            "classes" => preg_replace("/\s+/", " ", $lines[6]),
            "classes_percent" => floatval(explode("%", explode(":", $lines[6])[1])[0]),
            "methods" => preg_replace("/\s+/", " ", $lines[7]),
            "methods_percent" => floatval(explode("%", explode(":", $lines[7])[1])[0]),
            "lines" => preg_replace("/\s+/", " ", $lines[8]),
            "lines_percent" => floatval(explode("%", explode(":", $lines[8])[1])[0]),
        ];
        for($i = 10; $i < count($lines) - 1; $i+=2) {
            $cov = explode("   ", $lines[$i+1]);
            array_push($report, [
                'class' => preg_replace("/\s+/", " ", $lines[$i]),
                'coverage' => [
                    "methods" => preg_replace("/\s+/", " ", $cov[0]),
                    "lines" => preg_replace("/\s+/", " ", $cov[1]),
                ],
            ]);
        }
        print_r([
            $resume,
            $report,
        ]);
        if ($resume['classes_percent'] <= 80)
            throw new \Exception('A cobertura de testes está baixa');
    }
}
