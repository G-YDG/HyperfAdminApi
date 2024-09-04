<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\Common\Command;

use Hyperf\Command\Annotation\Command;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Stringable\Str;
use HyperfAdminGenerator\ControllerGenerator;
use HyperfAdminGenerator\MapperGenerator;
use HyperfAdminGenerator\RequestGenerator;
use HyperfAdminGenerator\ServiceGenerator;
use Qbhy\HyperfAuth\Annotation\Auth;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

#[Command]
class TemplateCommand extends HyperfCommand
{
    public function __construct()
    {
        parent::__construct('gen-template');

        $this->setDescription('Generate code template by table');
    }

    public function getArguments()
    {
        return [
            ['module', InputArgument::REQUIRED, 'The module that you want the code file to be generated.'],
            ['table', InputArgument::REQUIRED, 'Which table you want to generate code template.'],
        ];
    }

    public function getOptions()
    {
        return [
            ['pool', 'p', InputOption::VALUE_OPTIONAL, 'Which connection pool you want the Model use.', 'default'],
        ];
    }

    public function handle()
    {
        $module = $this->input->getArgument('module');
        $table = $this->input->getArgument('table');

        $this->modelGenerator();

        (new MapperGenerator($module, $table))->generator();

        (new ServiceGenerator($module, $table))->generator();

        (new RequestGenerator($module, $table, ['created_at', 'updated_at', 'deleted_at']))->generator();

        (new ControllerGenerator($module, $table, Auth::class, true))->generator();
    }

    protected function modelGenerator(): void
    {
        $this->call('gen:model', [
            'table' => $this->input->getArgument('table'),
            '--pool' => $this->input->getOption('pool'),
            '--path' => $this->getModelPath($this->input->getArgument('module')),
        ]);
    }

    protected function getModelPath($module): string
    {
        return 'app/' . Str::studly(trim($module)) . '/Model';
    }
}
