<?php
namespace Mougrim\GitAutocommitter;

/**
 * @package Mougrim\GitAutocommitter
 * @author  Mougrim <rinat@mougrim.ru>
 */
class GitHelper
{
    private $shellHelper;

    public function __construct(ShellHelper $shellHelper)
    {
        $this->shellHelper = $shellHelper;
    }

    public function add($file)
    {
        $this->shellHelper->runCommand("git add " . escapeshellarg($file));
    }

    public function commit($message)
    {
        $this->shellHelper->runCommand("git commit --message=" . escapeshellarg($message));
    }

    public function isFileChanged($file)
    {
        $this->shellHelper->runCommand('git status --short', $output);
        foreach(explode("\n", $output) as $line) {
            list($status, $changedFile) = explode(" ", $line);
            if ($file === trim($changedFile)) {
                return true;
            }
        }
        return false;
    }

    public function getLastCommitMessage()
    {
        $this->shellHelper->runCommand('git log -1 --pretty=format:%s', $output);
        return trim($output);
    }
}
