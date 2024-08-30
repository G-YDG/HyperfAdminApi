<?php

declare(strict_types=1);

namespace App\Tools\Controller;

use App\Common\Helper\SpreadsheetExport;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use HyperfAdminCore\Abstracts\AbstractController;
use Psr\Http\Message\ResponseInterface;

#[Controller(prefix: 'tools/excel')]
class ExcelController extends AbstractController
{

    /**
     * 导出
     * @return ResponseInterface
     */
    #[GetMapping("export")]
    public function export(): ResponseInterface
    {
        $data = [
            [1, '用户' . rand(1, 100), date('Y-m-d H:i:s')],
            [2, '用户' . rand(1, 100), date('Y-m-d H:i:s')],
            [3, '用户' . rand(1, 100), date('Y-m-d H:i:s')],
            [4, '用户' . rand(1, 100), date('Y-m-d H:i:s')],
        ];
        $spreadsheetExport = make(SpreadsheetExport::class);
        $spreadsheetExport->fillWorksheet('用户信息', ['ID', '用户名', '创建时间'], $data);
        list($filepath, $filename) = $spreadsheetExport->exportFile('用户信息表格', sys_get_temp_dir());
        return $this->_download($filepath, $filename);
    }
}
