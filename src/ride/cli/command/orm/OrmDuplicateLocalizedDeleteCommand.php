<?php

namespace ride\cli\command\orm;

use ride\cli\command\AbstractCommand;

use ride\library\orm\OrmManager;

use \Exception;

/**
 * Command to save all entries of a ORM model
 */
class OrmDuplicateLocalizedDeleteCommand extends AbstractCommand {

    /**
     * Initializes the command
     * @return null
     */
    protected function initialize() {
        $this->setDescription('Deletes all duplicate localized entry records.' . "\n\n" . 'Fixes the result of an ORM bug where it created 2 records for the same locale entry combination. Make a backup of your database first!');

        $this->addArgument('model', 'Name of a localized model', true);
    }

    /**
     * Executes the command
     * @param ride\library\orm\OrmManager $orm
     * @param string $model The name of the model
     * @return null
     */
    public function invoke(OrmManager $orm, $model) {
        $mapping = array();

        $locales = $orm->getLocales();
        foreach ($locales as $locale) {
            $mapping[$locale] = array();
        }

        $model = $orm->getModel($model);

        $query = $model->createQuery();
        $query->addOrderBy('{id} DESC');

        $localizedEntries = $query->query();
        foreach ($localizedEntries as $localizedEntry) {
            $locale = $localizedEntry->getLocale();
            $id = $localizedEntry->getEntry()->getId();

            if (!isset($mapping[$locale][$id])) {
                $mapping[$locale][$id] = true;

                continue;
            }

            $model->delete($localizedEntry);
        }
    }

}
