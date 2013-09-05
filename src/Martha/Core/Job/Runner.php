<?php

namespace Martha\Core\Job;

use Symfony\Component\Yaml\Yaml;
use Martha\Core\Domain\Entity\Build;
use Martha\Core\Job\Trigger\TriggerAbstract;
use Martha\Scm\Provider\ProviderFactory;

/**
 * Class Runner
 * @package Martha\Core\Job
 */
class Runner
{
    /**
     * @var string
     */
    protected $jobId;

    /**
     * @var string
     */
    protected $buildDirectory;

    /**
     * @var string
     */
    protected $dataDirectory;

    /**
     * @var string
     */
    protected $workingDir;

    /**
     * @var string
     */
    protected $outputDir;

    /**
     * @var string
     */
    protected $outputFile;

    /**
     * @var \Martha\Core\Job\Trigger\TriggerAbstract
     */
    protected $trigger;

    /**
     * @var \Martha\Core\Domain\Entity\Build
     */
    protected $build;

    /**
     * Set us up the class! Take the Trigger, Build and configuration to build the commit.
     *
     * @param TriggerAbstract $trigger
     * @param Build $build
     * @param array $config
     */
    public function __construct(TriggerAbstract $trigger, Build $build, array $config = [])
    {
        $this->trigger = $trigger;
        $this->build = $build;

        if (isset($config['data-directory'])) {
            $this->dataDirectory = $config['data-directory'];
        }

        if (isset($config['build-directory'])) {
            $this->buildDirectory = $config['build-directory'];
        }
    }

    /**
     * Kick off the build process and return whether the build was successful or not.
     *
     * @throws \Exception
     * @return boolean
     */
    public function run()
    {
        $this->jobId = $this->build->getId();

        $this->setupEnvironment();
        $this->checkoutSourceCode();

        $script = $this->parseBuildScript();

        $start = microtime(true);

        $this->log('Build started at: <strong>' . date('j M Y h:i:s A', $start) . '</strong>'. PHP_EOL);

        $status = [];

        foreach ($script['build'] as $commandIndex => $command) {
            $return = $this->runCommand($command);
            $status[$commandIndex] = $return;

            $this->log(''); // force a newline after each command
        }

        $end = microtime(true);
        $duration = $end - $start;

        $this->log(
            'Build completed at: <strong>' . date('j M Y h:i:s A', $end) . '</strong>' . PHP_EOL .
            'Build duration: <strong>' . $this->formatTime($duration) . '</strong>'
        );

        $this->cleanupBuild();

        $wasSuccessful = true;

        foreach ($status as $stepStatus) {
            $wasSuccessful = $wasSuccessful && $stepStatus == 0;
        }

        return $wasSuccessful;
    }

    /**
     * Log a message to the console output file.
     *
     * @todo Implement handling of type
     * @throws \Exception
     * @param string $message
     * @param string $type
     */
    protected function log($message, $type = 'standard')
    {
        if (!$this->outputFile) {
            throw new \Exception('Attempting to log before setting up log file');
        }

        file_put_contents($this->outputFile, $message . PHP_EOL, FILE_APPEND);
    }

    /**
     * Setup the directory structure needed for the build.
     *
     * @return $this
     */
    protected function setupEnvironment()
    {
        $this->workingDir = $this->buildDirectory . '/' .
            $this->trigger->getRepository()->getName() . '/' . $this->jobId;
        $this->outputDir = $this->dataDirectory . '/' .
            $this->trigger->getRepository()->getName() . '/' . $this->jobId;

        if (!file_exists($this->workingDir)) {
            mkdir($this->workingDir, 0775, true);
        }

        if (!file_exists($this->outputDir)) {
            mkdir($this->outputDir, 0775, true);
        }

        $this->outputFile = $this->outputDir . '/console.html';

        touch($this->outputFile);

        return $this;
    }

    /**
     * Checks out the source code for this commit.
     *
     * return $this
     */
    protected function checkoutSourceCode()
    {
        $scm = ProviderFactory::createForRepository($this->trigger->getRepository());
        $scm->cloneRepository($this->workingDir);
        //$scm->checkout($this->jobId); // todo fix me, won't work anymore

        return $this;
    }

    /**
     * Locates and parses the Yaml build script into an array and returns it.
     *
     * @throws \Exception
     * @return array
     */
    protected function parseBuildScript()
    {
        if (!file_exists($this->workingDir . '/build.yml')) {
            throw new \Exception('No build.yml file found');
        }

        $yaml = new Yaml();
        $script = $yaml->parse($this->workingDir . '/build.yml');

        return $script;
    }

    /**
     * Runs a specific command in the build process.
     *
     * @param string $command
     * @return int
     */
    protected function runCommand($command)
    {
        $command = str_replace('${outputdir}', $this->outputDir, $command);

        $this->log("<strong>$ {$command}</strong>");

        $proc = proc_open(
            $command,
            [
                '1' => ['file', $this->outputFile, 'a'],
                '2' => ['file', $this->outputFile, 'a'],
            ],
            $pipes,
            $this->workingDir
        );

        $return = proc_close($proc);

        return $return;
    }

    /**
     * Cleans up after the build, removing unnecessary files, etc.
     */
    protected function cleanupBuild()
    {
        file_put_contents($this->outputFile, $this->colorizeOutput(file_get_contents($this->outputFile)));

        // empty out the build directory:
        exec('rm -rf ' . $this->workingDir);
    }

    /**
     * Take the console output and turn any color sequences into span tags for colorization.
     *
     * @param string $text
     * @return string
     */
    protected function colorizeOutput($text)
    {
        $text = str_replace(
            ["\033[0;32m", "\033[31;31m", "\033[33;33m", "\033[0m"],
            ['<span class="success">', '<span class="error">', '<span class="info">', '</span>'],
            $text
        );

        return $text;
    }

    /**
     * Takes a number of seconds and formats it in the format of X hours, Y minutes, Z seconds.
     *
     * @param int $seconds
     * @return string
     */
    protected function formatTime($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds - ($hours * 3600)) / 60);
        $seconds = floor($seconds - ($minutes * 3600) + ($hours * 3600));

        $time = '';

        if ($hours > 0) {
            $time .= $hours . ' hour' . ($hours > 1 ? 's ' : ' ');
        }

        if ($minutes > 0) {
            $time .= empty($time) ? '' : ', ';
            $time .= $minutes . ' minute' . ($minutes > 1 ? 's ' : ' ');
        }

        if ($seconds > 0) {
            $time .= empty($time) ? '' : ', ';
            $time .= $seconds . ' second' . ($seconds > 1 ? 's ' : ' ');
        }

        return $time;
    }
}