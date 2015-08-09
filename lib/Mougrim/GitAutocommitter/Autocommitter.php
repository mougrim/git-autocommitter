<?php
namespace Mougrim\GitAutocommitter;

/**
 * @package Mougrim\GitAutocommitter
 * @author  Mougrim <rinat@mougrim.ru>
 */
class Autocommitter
{
    private $gitHelper;
    private $logger;

    public function __construct(GitHelper $gitHelper)
    {
        $this->gitHelper = $gitHelper;
    }

    /**
     * @return \Logger
     */
    public function getLogger()
    {
        if ($this->logger === null) {
            $this->logger = \Logger::getLogger('autocommitter');
        }

        return $this->logger;
    }

    public function run($file)
    {
        if (!file_exists($file)) {
            $this->getLogger()->error("File to commit '{$file}' not exists");
            return;
        }
        if (!$this->gitHelper->isFileChanged($file)) {
            $this->getLogger()->info("File '{$file}' not changed");
            return;
        }
        $lastCommit = $this->gitHelper->getLastCommitMessage();
        $dateTime = new \DateTime();
        $currentDate = $dateTime->format("Y-m-d");
        if ($lastCommit === $currentDate) {
            $this->getLogger()->info("Already committed today: {$lastCommit}");
            return;
        }

        $this->gitHelper->add($file);
        $this->gitHelper->commit($currentDate);
        $this->getLogger()->info("Successful commit '{$currentDate}'");
    }
}
