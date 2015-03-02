<?php

namespace ride\cli\command\orm;

use ride\cli\command\AbstractCommand;

use ride\library\orm\OrmManager;

/**
 * Command to define the models in the database
 */
class OrmDefineCommand extends AbstractCommand {

    /**
     * Initializes the command
     * @return null
     */
    protected function initialize() {
        $this->setDescription('Define the models in the database');
    }

    /**
     * Executes the command
     * @param ride\library\orm\OrmManager $orm
     * @return null
     */
    public function invoke(OrmManager $orm) {
        $orm->defineModels();
    }

}
