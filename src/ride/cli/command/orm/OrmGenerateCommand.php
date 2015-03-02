<?php

namespace ride\cli\command\orm;

use ride\cli\command\AbstractCommand;

use ride\library\orm\OrmManager;
use ride\library\system\file\browser\FileBrowser;

/**
 * Command to generate the model classes
 */
class OrmGenerateCommand extends AbstractCommand {

    /**
     * Initializes the command
     * @return null
     */
    protected function initialize() {
        $this->setDescription('Generate the model classes');
    }

    /**
     * Executes the command
     * @param ride\library\orm\OrmManager $orm
     * @param ride\library\system\file\browser\FileBrowser $fileBrowser
     * @return null
     */
    public function invoke(OrmManager $orm, FileBrowser $fileBrowser) {
        $generators = $this->dependencyInjector->getAll('ride\\library\\orm\\entry\\generator\\EntryGenerator');

        $sourcePath = $fileBrowser->getApplicationDirectory()->getChild('src');

        $modelRegister = $orm->getModelLoader()->getModelRegister();
        $models = $modelRegister->getModels();
        foreach ($models as $model) {
            $modelName = $model->getName();

            foreach ($generators as $generator) {
                $generator->generate($modelRegister, $modelName, $sourcePath);
            }
        }
    }

}
