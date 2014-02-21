<?php

namespace ride\cli\command\orm;

use ride\library\cli\command\AbstractCommand;
use ride\library\orm\OrmManager;

/**
 * Command to define the models in the database
 */
class OrmDefineCommand extends AbstractCommand {

    /**
     * Instance of the ORM
     * @var ride\library\orm\OrmManager
     */
    protected $orm;

    /**
     * Constructs a new orm define command
     * @return null
     */
    public function __construct(OrmManager $orm) {
        parent::__construct('orm define', 'Define the models in the database');

        $this->orm = $orm;
    }

    /**
     * Executes the command
     * @return null
     */
    public function execute() {
        $this->orm->defineModels();
    }

}