<?php

namespace ride\cli\command\orm;

use ride\cli\command\AbstractCommand;

use ride\library\orm\OrmManager;

use \Exception;

/**
 * Command to save all entries of a ORM model
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
        // lookup entries
        $model = $orm->getModel($model);
        $entries = $model->find();

        // check if dated entries
        $entry = reset($entries);
        if ($entry && !method_exists($entry, 'setDateModified')) {
            throw new Exception('Could not update entries from model ' . $model->getName() . ': no dated entries');
        }

        // save all entries
        foreach ($entries as $entry) {
            $this->output->write("Saving entry #" . $entry->getId() . ' ... ');

            $entry->setDateModified(time());

            try {
                $model->save($entry);

                $this->output->writeLine('V');
            } catch (Exception $exception) {
                $this->output->writeLine('X');
            }
        }
    }

}
