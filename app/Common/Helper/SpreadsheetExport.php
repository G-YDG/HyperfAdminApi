<?php

namespace App\Common\Helper;

use Hyperf\Stringable\Str;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class SpreadsheetExport
{
    protected Spreadsheet $spreadsheet;

    protected int $sheetIndex = 0;

    private string $fileType = IOFactory::WRITER_XLSX;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }

    public function fillWorksheet($title, $headers, $rows, $headersStyle = null, $rowsStyle = null): static
    {
        $this->sheetIndex += 1;

        if ($this->sheetIndex == 1) {
            $worksheet = $this->spreadsheet->getActiveSheet();
        } else {
            $worksheet = $this->spreadsheet->createSheet();
        }

        // 设置工作表的标题名称
        $worksheet->setTitle($title);

        $sheetCellMap = $this->sheetCellMap();

        // 获取最大列值
        $maxColumnCell = $sheetCellMap[count($headers) - 1];

        // 设置首行单元格样式
        $worksheet->getStyle("A1:{$maxColumnCell}1")->applyFromArray($headersStyle ?? $this->getDefaultHeaderStyle());

        // 设置首行单元格内容
        foreach ($headers as $key => $value) {
            $worksheet->getColumnDimension($sheetCellMap[$key])->setWidth(25);
            $worksheet->setCellValue($sheetCellMap[$key] . 1, $value);
        }

        // 设置单元格样式
        $worksheet->getStyle("A2:{$maxColumnCell}" . count($rows) + 1)->applyFromArray($rowsStyle ?? $this->getDefaultRowsStyle());

        // 填充单元格内容
        $worksheet->fromArray($rows, null, 'A2');

        return $this;
    }

    /**
     * 单元格.
     * @return string[]
     */
    protected function sheetCellMap(): array
    {
        return ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
    }

    /**
     * 默认表头样式.
     * @return array
     */
    protected function getDefaultHeaderStyle(): array
    {
        return [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'fffbeeee'],
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'inside' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
    }

    /**
     * 默认表体样式.
     * @return array
     */
    protected function getDefaultRowsStyle(): array
    {
        return [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
                'inside' => [
                    'borderStyle' => Border::BORDER_THIN,
                ],
            ],
        ];
    }

    /**
     * 保存到服务器本地.
     * @param $filename
     * @return array
     */
    public function writeToLocal($filename): array
    {
        makeDir($this->getLocalFileBasePath());

        $fileName = $this->getFileName($filename);
        $filepath = $this->getLocalFilePath($fileName);

        $writer = @IOFactory::createWriter($this->spreadsheet, $this->getFileType());
        $writer->save($filepath);

        $this->spreadsheet->disconnectWorksheets();
        unset($this->spreadsheet);

        return [$filepath, $fileName];
    }

    /**
     * 设置文件名.
     *
     * @param string $filename
     * @return string
     */
    protected function getFileName(string $filename): string
    {
        return sprintf('%s_%s.' . Str::lower($this->getFileType()), $filename, date('Ymd_His'));
    }

    /**
     * @return string
     */
    public function getFileType(): string
    {
        return $this->fileType;
    }

    public function setFileType(string $fileType): static
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * 获取保存到本地的excel路径.
     * @return string
     */
    protected function getLocalFileBasePath(): string
    {
        return config('spreadsheet.local_file_path');
    }

    /**
     * 获取保存到本地的excel地址.
     * @param $fileName
     * @return string
     */
    protected function getLocalFilePath($fileName): string
    {
        return $this->getLocalFileBasePath() . DIRECTORY_SEPARATOR . $fileName;;
    }
}