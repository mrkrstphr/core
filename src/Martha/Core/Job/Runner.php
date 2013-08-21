<?php

namespace Martha\Core\Job;

use Symfony\Component\Yaml\Yaml;
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
    protected $buildDirectory;
    /**
     * @var string
     */
    protected $dataDirectory;

    /**
     * @var TriggerAbstract
     */
    protected $trigger;

    /**
     * @param TriggerAbstract $trigger
     * @param array $config
     */
    public function __construct(TriggerAbstract $trigger, array $config = [])
    {
        $this->trigger = $trigger;

        if (isset($config['data-directory'])) {
            $this->dataDirectory = $config['data-directory'];
        }

        if (isset($config['build-directory'])) {
            $this->buildDirectory = $config['build-directory'];
        }
    }

    /**
     * @throws \Exception
     */
    public function run()
    {
        $jobId = $this->trigger->getChangeSet()->getNewestCommit()->getRevisionNumber();

        $workingDir = $this->buildDirectory . '/' . $this->trigger->getRepository()->getName() . '/' . $jobId;
        $outputDir = $this->dataDirectory . '/' . $this->trigger->getRepository()->getName() . '/' . $jobId;

        if (!file_exists($workingDir)) {
            mkdir($workingDir, 0775, true);
        }

        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0775, true);
        }

        $scm = ProviderFactory::createForRepository($this->trigger->getRepository());
        $scm->cloneRepository($workingDir);
        $scm->checkout($jobId);

        if (!file_exists($workingDir . '/build.yml')) {
            throw new \Exception('No build.yml file found');
        }

        $yaml = new Yaml();
        $script = $yaml->parse($workingDir . '/build.yml');

        $status = [];

        foreach ($script['build'] as $commandIndex => $command) {
            $command = str_replace('${outputdir}', $outputDir, $command);

            $proc = proc_open(
                $command,
                [
                    '0' => ['pipe', 'r'],
                    '1' => ['pipe', 'w'],
                    '2' => ['pipe', 'w']
                ],
                $pipes,
                $workingDir
            );

            $errors = stream_get_contents($pipes[2]);
            $output = stream_get_contents($pipes[1]);
            fclose($pipes[2]);
            fclose($pipes[1]);

            $return = proc_close($proc);

            if ($errors) {

            }

            $status[$commandIndex] = $return;
        }

        // empty out the build directory:
        exec('rm -rf ' . $workingDir);
    }
}
