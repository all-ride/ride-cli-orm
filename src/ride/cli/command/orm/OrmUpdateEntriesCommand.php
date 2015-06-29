<?php

namespace ride\cli\command\orm;

use ride\cli\command\AbstractCommand;

use ride\library\orm\OrmManager;

/**
 * Command to search for ORM models
 */
class OrmUpdateEntriesCommand extends AbstractCommand {

    /**
     * Initializes the command
     * @return null
     */
    protected function initialize() {
        $this->setDescription('Update all entries of a given model, changing only their dateModified');

        $this->addArgument('model', 'Model to update the entries from.', true);
    }

    /**
     * Executes the command
     * @param ride\library\orm\OrmManager $orm
     * @param string $model The name of the model
     * @return null
     */
    public function invoke(OrmManager $orm, $model) {
        $model = $orm->getModel($model);

        $entries = $model->find();

        foreach ($entries as $entry) {
            echo "Saving " . strtolower($model->getName()) . " entry with ID = " . $entry->getId() . ' ... ';
            $entry->setDateModified(time());
            $model->save($entry);
            echo "Done\n";
        }
    }

}
