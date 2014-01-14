<?php

namespace pallo\cli\command\orm;

use pallo\library\cli\command\AbstractCommand;
use pallo\library\orm\OrmManager;

/**
 * Command to search for ORM models
 */
class OrmModelSearchCommand extends AbstractCommand {

    /**
     * Constructs a new orm command
     * @param pallo\library\orm\OrmManager $orm
     * @return null
     */
    public function __construct(OrmManager $orm) {
        parent::__construct('orm model', 'Show an overview of the defined models');

        $this->addArgument('query', 'Query to search the models', false);

        $this->orm = $orm;
    }

    /**
     * Executes the command
     * @return null
     */
    public function execute() {
        $models = $this->orm->getModelLoader()->getModels(true);

        $query = $this->input->getArgument('query');
        if ($query) {
            foreach ($models as $name => $model) {
                if (stripos($name, $query) !== false) {
                    continue;
                }

                unset($models[$name]);
            }
        }

        ksort($models);

        foreach ($models as $name => $model) {
            $this->output->writeLine($name. ': ' . get_class($model));
        }
    }

}