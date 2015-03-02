<?php

namespace ride\cli\command\orm;

use ride\cli\command\AbstractCommand;

use ride\library\orm\OrmManager;

/**
 * Command to search for ORM models
 */
class OrmModelSearchCommand extends AbstractCommand {

    /**
     * Initializes the command
     * @return null
     */
    protected function initialize() {
        $this->setDescription('Show an overview of the defined models');

        $this->addArgument('query', 'Query to search the models', false);
    }

    /**
     * Executes the command
     * @param ride\library\orm\OrmManager $orm
     * @param string $query Query to search the models
     * @return null
     */
    public function invoke(OrmManager $orm, $query = null) {
        $models = $this->orm->getModelLoader()->getModels(true);

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
