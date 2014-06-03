<?php

namespace ride\cli\command\orm;

use ride\library\cli\command\AbstractCommand;
use ride\library\generator\GenericCodeGenerator;
use ride\library\orm\entry\generator\GenericEntryGenerator;
use ride\library\orm\entry\generator\ModelEntryGenerator;
use ride\library\orm\entry\generator\ProxyEntryGenerator;
use ride\library\orm\OrmManager;
use ride\library\system\file\browser\FileBrowser;

/**
 * Command to generate the model classes
 */
class OrmGenerateCommand extends AbstractCommand {

    /**
     * Instance of the ORM
     * @var ride\library\orm\OrmManager
     */
    protected $orm;

    /**
     * Constructs a new orm define command
     * @return null
     */
    public function __construct(OrmManager $orm, FileBrowser $fileBrowser, array $generators) {
        parent::__construct('orm generate', 'Generate the model classes');

        $this->orm = $orm;
        $this->fileBrowser = $fileBrowser;
        $this->generators = $generators;
    }

    /**
     * Executes the command
     * @return null
     */
    public function execute() {
        $sourcePath = $this->fileBrowser->getApplicationDirectory()->getChild('src');

        $modelRegister = $this->orm->getModelLoader()->getModelRegister();
        $models = $modelRegister->getModels();
        foreach ($models as $model) {
            $modelName = $model->getName();

            foreach ($this->generators as $generator) {
                $generator->generate($modelRegister, $modelName, $sourcePath);
            }
        }
    }

}
