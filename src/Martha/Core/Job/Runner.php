<?php

namespace Martha\Core\Job;

use Martha\Core\Job\Trigger\TriggerAbstract;

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
            $this->dataDirectory = $config['build-directory'];
        }
    }

    public function run()
    {
        $jobId = $this->trigger->getChangeSet()->getNewestCommit()->getRevisionNumber();

        $workingDir = $this->buildDirectory .  '/jobs/' . $this->trigger->getRepository()->getName() . '/' . $jobId;

        if (!file_exists($workingDir)) {
            mkdir($workingDir, 0777, true);
        }

        if (!file_exists($workingDir . '/output')) {
            mkdir($workingDir . '/output');
        }


        $scm = \Martha\Scm\Provider\ProviderFactory::createForRepository($this->trigger->getRepository());

//$scm->cloneRepository($workingDir);
//$scm->checkout($jobId);

        if (!file_exists($workingDir . '/build.yml')) {
            throw new \Exception('No build.yml file found');
        }

        $yaml = new \Symfony\Component\Yaml\Yaml();
        $script = $yaml->parse($workingDir . '/build.yml');

        $status = [];

        foreach ($script['build'] as $commandIndex => $command) {
            //$command = 'cd ' . $workingDir . ' && ' . $command;

            $command = str_replace('${outputdir}', $workingDir . '/output', $command);

            echo "-- command: {$command}\n";

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
                echo 'Errors: ' . $errors . "\n";
            }

            echo "Output:\n{$output}\n";

            echo "Return: ";
            var_dump($return);
            echo "\n";

            $status[$commandIndex] = $return;
        }

        print_r($status);

//rmdir($workingDir);
    }
}
