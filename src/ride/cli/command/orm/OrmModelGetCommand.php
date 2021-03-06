<?php

namespace ride\cli\command\orm;

use ride\cli\command\AbstractCommand;

use ride\library\orm\definition\field\BelongsToField;
use ride\library\orm\definition\field\HasManyField;
use ride\library\orm\definition\field\HasOneField;
use ride\library\orm\definition\field\RelationField;
use ride\library\orm\OrmManager;

/**
 * Command to get the definition of a model
 */
class OrmModelGetCommand extends AbstractCommand {

    /**
     * Initializes the command
     * @return null
     */
    protected function initialize() {
        $this->setDescription('Get the definition of a model');

        $this->addArgument('name', 'Name of the model', true);
    }

    /**
     * Executes the command
     * @param ride\library\orm\OrmManager $orm
     * @param string $name Name of the model
     * @return null
     */
    public function invoke(OrmManager $orm, $name) {
        $model = $orm->getModel($name);

        $meta = $model->getMeta();
        $table = $meta->getModelTable();
        $fields = $table->getFields();
        $indexes = $table->getIndexes();
        $formats = $table->getFormats();
        $options = $table->getOptions();

        $this->output->writeLine($name . ':');
        $this->output->writeLine('- model class: ' . get_class($model));
        $this->output->writeLine('- data class: ' . $meta->getEntryClassName());

        $this->output->writeLine('- fields:');
        foreach ($fields as $field) {
            if ($field instanceof RelationField) {
                $isRelationField = true;

                if ($field instanceof HasManyField) {
                    $type = 'hasMany';
                } elseif ($field instanceof HasOneField) {
                    $type = 'hasOne';
                } else {
                    $type = 'belongsTo';
                }
            } else {
                $isRelationField = false;
                $type = $field->getType();
            }

            $this->output->write('    - ' . $field->getName() . ' (' . $type . ') [');
            if ($field->isPrimaryKey()) {
                $this->output->write('P');
            }
            if ($field->isAutoNumbering()) {
                $this->output->write('A');
            }
            if ($field->isIndexed()) {
                $this->output->write('I');
            }
            if ($field->isUnique()) {
                $this->output->write('U');
            }
            if ($field->isLocalized()) {
                $this->output->write('L');
            }
            $this->output->writeLine(']');

            if ($isRelationField) {
                $this->output->writeLine('        - relation: ' . $field->getRelationModelName());
            }

            $default = $field->getDefaultValue();
            if ($default) {
                $this->output->writeLine('        - default: ' . ($default === null ? 'null' : $default));
            }
        }

        if ($indexes) {
            $this->output->writeLine('- indexes:');
            foreach ($indexes as $index) {
                $indexOutput = '    - ' . $index->getName() . ' on ';
                $fields = array_keys($index->getFields());
                $lastField = array_pop($fields);

                if ($fields) {
                    $indexOutput .= implode(', ', $fields) . ' and ';
                }
                $indexOutput .= $lastField;

                $this->output->writeLine($indexOutput);
            }
        }

        if ($formats) {
            $this->output->writeLine('- data formats:');
            foreach ($formats as $name => $format) {
                $this->output->writeLine('    - ' . $name . ': ' . $format);
            }
        }

        if ($options) {
            $this->output->writeLine('- options:');
            foreach ($options as $name => $option) {
                $this->output->writeLine('    - ' . $name . ': ' . $option);
            }
        }

        $validationConstraint = $model->getValidationConstraint();
        if ($validationConstraint) {
            $this->output->writeLine('- validation constraint: ' . get_class($validationConstraint));
        }
//         $validators = $field->getValidators();
//         if ($validators) {
//             $this->output->write('        - validators:');
//             foreach ($validators as $validator) {
//                 $options = '';
//                 foreach ($validator->getOptions() as $key => $value) {
//                     $options .= ($options ? ', ' : '') . $key . ': ' . $value;
//                 }

//                 $this->output->write('            - ' . $validator->getName() . ': {' . $options . '}');
//             }
//         }
    }

}
