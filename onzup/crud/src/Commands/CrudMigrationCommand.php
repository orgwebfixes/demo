<?php

namespace Onzup\Crud\Commands;

use Illuminate\Console\GeneratorCommand;

class CrudMigrationCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crud:migration
                            {name : The name of the migration.}
                            {--schema= : The name of the schema.}
                            {--pk=id : The name of the primary key.}
                            {--stubtype= : Type of stub.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new migration.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Migration';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('stubtype')) {
            config(['crudgenerator.default' => $this->option('stubtype')]);
        }

        return __DIR__ . '/../stubs/' . config('crudgenerator.default') . '/migration.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace($this->laravel->getNamespace(), '', $name);
        $datePrefix = date('Y_m_d_His');

        return database_path('/migrations/') . $datePrefix . '_create_' . $name . '_table.php';
    }

    /**
     * Build the model class with the given name.
     *
     * @param  string  $name
     *
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());

        $tableName = $this->argument('name');
        $className = 'Create' . ucwords($tableName) . 'Table';

        $schema = $this->option('schema');
        $fields = explode(',', $schema);

        $data = array();

        if ($schema) {
            $x = 0;
            foreach ($fields as $field) {
                $fieldArray = explode(':', $field);
                $data[$x]['name'] = trim($fieldArray[0]);
                //split size
                $temp = explode('(', trim($fieldArray[1]));
                $data[$x]['type'] = trim($temp[0]);
                $data[$x]['size'] = isset($temp[1]) ? trim(str_replace(')', '', $temp[1])) : 0;
                $x++;
            }
        }

        $schemaFields = '';
        foreach ($data as $item) {
            if ($item['size'] != 0) {
                $schemaFields .= "\$table->" . $item['type'] . "('" . $item['name'] . "'," . $item['size'] . ")";
            } else {
                $schemaFields .= "\$table->" . $item['type'] . "('" . $item['name'] . "')";
            }
            if (strpos($item['name'], '_id') != 0) {
                $schemaFields .= "->index('" . $item['name'] . "')";
            }
            $schemaFields .= ";\n";
        }
        //     switch ($item['type']) {
        //         case 'char':
        //             $schemaFields .= "\$table->char('" . $item['name'] . "');\n";
        //             break;

        //         case 'date':
        //             $schemaFields .= "\$table->date('" . $item['name'] . "');\n";
        //             break;

        //         case 'datetime':
        //             $schemaFields .= "\$table->dateTime('" . $item['name'] . "');\n";
        //             break;

        //         case 'time':
        //             $schemaFields .= "\$table->time('" . $item['name'] . "');\n";
        //             break;

        //         case 'timestamp':
        //             $schemaFields .= "\$table->timestamp('" . $item['name'] . "');\n";
        //             break;

        //         case 'text':
        //             $schemaFields .= "\$table->text('" . $item['name'] . "');\n";
        //             break;

        //         case 'mediumtext':
        //             $schemaFields .= "\$table->mediumText('" . $item['name'] . "');\n";
        //             break;

        //         case 'longtext':
        //             $schemaFields .= "\$table->longText('" . $item['name'] . "');\n";
        //             break;

        //         case 'json':
        //             $schemaFields .= "\$table->json('" . $item['name'] . "');\n";
        //             break;

        //         case 'jsonb':
        //             $schemaFields .= "\$table->jsonb('" . $item['name'] . "');\n";
        //             break;

        //         case 'binary':
        //             $schemaFields .= "\$table->binary('" . $item['name'] . "');\n";
        //             break;

        //         case 'number':
        //         case 'integer':
        //             $schemaFields .= "\$table->integer('" . $item['name'] . "');\n";
        //             break;

        //         case 'bigint':
        //             $schemaFields .= "\$table->bigInteger('" . $item['name'] . "');\n";
        //             break;

        //         case 'mediumint':
        //             $schemaFields .= "\$table->mediumInteger('" . $item['name'] . "');\n";
        //             break;

        //         case 'tinyint':
        //             $schemaFields .= "\$table->tinyInteger('" . $item['name'] . "');\n";
        //             break;

        //         case 'smallint':
        //             $schemaFields .= "\$table->smallInteger('" . $item['name'] . "');\n";
        //             break;

        //         case 'boolean':
        //             $schemaFields .= "\$table->boolean('" . $item['name'] . "');\n";
        //             break;

        //         case 'decimal':
        //             $schemaFields .= "\$table->decimal('" . $item['name'] . "');\n";
        //             break;

        //         case 'double':
        //             $schemaFields .= "\$table->double('" . $item['name'] . "');\n";
        //             break;

        //         case 'float':
        //             $schemaFields .= "\$table->float('" . $item['name'] . "');\n";
        //             break;

        //         case 'ipAddress':
        //             $schemaFields .= "\$table->ipAddress('" . $item['name'] . "');\n";
        //             break;

        //         default:
        //             $schemaFields .= "\$table->string('" . $item['name'] . "');\n";
        //             break;
        //     }
        // }

        $primaryKey = $this->option('pk');

        $schemaUp = "
            Schema::create('" . $tableName . "', function(Blueprint \$table) {
                \$table->increments('" . $primaryKey . "');
                " . $schemaFields . "
                \$table->softDeletes();
                \$table->timestamps();
                \$table->integer('created_by')->default(0);
                \$table->integer('updated_by')->default(0);
                \$table->engine = 'InnoDB';
            });
            ";

        $schemaDown = "Schema::drop('" . $tableName . "');";

        return $this->replaceSchemaUp($stub, $schemaUp)
            ->replaceSchemaDown($stub, $schemaDown)
            ->replaceClass($stub, $className);
    }

    /**
     * Replace the schema_up for the given stub.
     *
     * @param  string  $stub
     * @param  string  $schemaUp
     *
     * @return $this
     */
    protected function replaceSchemaUp(&$stub, $schemaUp)
    {
        $stub = str_replace(
            '{{schema_up}}',
            $schemaUp,
            $stub
        );

        return $this;
    }

    /**
     * Replace the schema_down for the given stub.
     *
     * @param  string  $stub
     * @param  string  $schemaDown
     *
     * @return $this
     */
    protected function replaceSchemaDown(&$stub, $schemaDown)
    {
        $stub = str_replace(
            '{{schema_down}}',
            $schemaDown,
            $stub
        );

        return $this;
    }
}
