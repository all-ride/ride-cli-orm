<?php

namespace ride\cli\command\orm;

use ride\application\orm\ApplicationListener;

use ride\cli\command\AbstractCommand;

use ride\library\orm\OrmManager;


/**
 * Command to delete all files in the entry log
 */
class OrmFilesDeleteCommand extends AbstractCommand {

    /**
     * Initializes the command
     * @return null
     */
    protected function initialize() {
        $this->setDescription('Delete files which are no longer used in the models');

        $this->addFlag('dry', 'Add flag to see the files which will be deleted without actually deleting them');
    }

    /**
     * Executes the command
     * @param ride\library\orm\OrmManager $orm
     * @param ride\application\orm\ApplicationListener $applicationListener
     * @param boolean $dry
     * @return null
     */
    public function invoke(OrmManager $orm, ApplicationListener $applicationListener, $dry = false) {
        $files = $applicationListener->deleteOldFiles($orm, $dry);

        if ($files) {
            foreach ($files as $file => $status) {
                $this->output->writeLine(($status ? '[V]' : '[ ]') . ' ' . $file);
            }
        } else {
            $this->output->writeErrorLine('No files to delete');
        }
    }

}
