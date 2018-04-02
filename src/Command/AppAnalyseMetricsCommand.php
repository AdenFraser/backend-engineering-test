<?php

declare(strict_types=1);

namespace App\Command;

use App\Analysis\AverageSpeed;
use App\Analysis\FirstPeriod;
use App\Analysis\LastPeriod;
use App\Analysis\MaxSpeed;
use App\Analysis\MedianSpeed;
use App\Analysis\MinSpeed;
use App\Analysis\SlowdownPeriods;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AppAnalyseMetricsCommand.
 */
class AppAnalyseMetricsCommand extends Command
{
    /**
     * @var string
     */
    protected static $defaultName = 'app:analyse-metrics';

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * Output Template Path.
     *
     * @var string
     */
    private static $outputPath = __DIR__.'/../../resources/output/default.output';

    /**
     * Array of Default Analysis Results to Output.
     *
     * @var array
     */
    private static $outputResults = [
        FirstPeriod::class,
        LastPeriod::class,
        AverageSpeed::class,
        MinSpeed::class,
        MaxSpeed::class,
        MedianSpeed::class,
    ];

    /**
     * Populated with Metric Data.
     *
     * @var array
     */
    private $dataset;

    /**
     * Configure the command.
     */
    protected function configure(): void
    {
        $this->setDescription('Analyses the metrics to generate a report.');
        $this->addOption('input', null, InputOption::VALUE_REQUIRED, 'The location of the test input');
    }

    /**
     * Detect slow-downs in the data and output them to stdout.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->input = $input;
        $this->output = $output;

        $this->loadDataset();

        $this->outputResults();

        $this->outputSlowdowns();
    }

    /**
     * Output the command results which are present every time.
     */
    private function outputResults(): void
    {
        $results = collect(self::$outputResults)
            ->map(function ($analysis) {
                return $this->result($analysis);
            });

        // Apply Results to Template.
        $output = sprintf($this->outputTemplate(), ...$results);

        // Explode Template lines and write output to console line-by-line.
        $this->output->writeln($this->explodeByLines($output));
    }

    /**
     * Output any slowdown periods for investigation, should they exist.
     *
     * @todo Defer the periods to investigate output to use slow-down.input template.
     */
    private function outputSlowdowns(): void
    {
        $slowdowns = $this->result(SlowdownPeriods::class);

        // If there were slowdowns, output them for investigation.
        if (count($slowdowns)) {
            $this->output->write('', true);
            $this->output->write('Investigate:', true);
            $this->output->write('', true);

            collect($slowdowns)
                ->each(function ($period) {
                    if (count($period) > 1) {
                        $this->output->writeln('    * The period between '.$period[0]->format('Y-m-d').' and '.$period[1]->format('Y-m-d'));
                        $this->output->writeln('      was under-performing.');
                        $this->output->write('', true);

                        return;
                    }

                    $this->output->writeln('    * The period of '.$period[0]->format('Y-m-d').' was under-performing.');
                    $this->output->write('', true);
                });
        }
    }

    /**
     * Returns the analysis result.
     *
     * @param  string $analysis
     *
     * @return mixed
     */
    private function result(string $analysis)
    {
        return (new $analysis($this->dataset))->result();
    }

    /**
     * Returns an array of all lines of data from the string output.
     *
     * @return array
     */
    private function explodeByLines(string $output): array
    {
        return explode("\r\n", $output);
    }

    /**
     * Load the Output Template.
     *
     * @return string
     */
    private function outputTemplate(): string
    {
        return file_get_contents(\realpath(self::$outputPath));
    }

    /**
     * Load the Dataset from the provided path.
     *
     * @todo #1 - Add check for file exists, inform the user of failure.
     *       #2 - Checks for valid JSON structure to ensure `metricData` exists.
     */
    private function loadDataset(): void
    {
        $source = $this->input->getOption('input');
        $data = json_decode(file_get_contents($source), true);

        $this->dataset = $data['data'][0]['metricData'];
    }
}
