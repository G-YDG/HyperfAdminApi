<?php

declare(strict_types=1);
/**
 * This file is part of HyperfAdmin.
 *
 *  * @link     https://github.com/G-YDG/HyperfAdminApi
 *  * @license  https://github.com/G-YDG/HyperfAdminApi/blob/master/LICENSE
 */

namespace App\Common\Helper;

use Exception;
use Hyperf\Stringable\Str;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Exception\InvalidArgumentException;
use OpenSpout\Writer\CSV\Options as CsvOptions;
use OpenSpout\Writer\CSV\Writer as CsvWriter;
use OpenSpout\Writer\ODS\Options as OdsOptions;
use OpenSpout\Writer\ODS\Writer as OdsWriter;
use OpenSpout\Writer\XLSX\Options as XlsxOptions;
use OpenSpout\Writer\XLSX\Writer as XlsxWriter;

class SpreadsheetExport
{
    protected $writer = null;

    private string $fileType = 'xlsx';

    public function initFilePath($filename, $filepath = null): array
    {
        $filepath = $filepath ?? $this->getLocalFilePath();
        make_dir($filepath);

        $fileName = $this->getFileName($filename);
        $filePath = $this->getFilePath($fileName, $filepath);

        return [$fileName, $filePath];
    }

    /**
     * @param $headers
     * @return array
     * @throws InvalidArgumentException
     */
    public function initWriter($headers): array
    {
        $border = new Border(...[
            new BorderPart(Border::TOP, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::BOTTOM, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::LEFT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::RIGHT, Color::BLACK, Border::WIDTH_THIN, Border::STYLE_SOLID),
        ]);

        $defaultStyle = new Style();
        $defaultStyle->setFontSize(11);
        $defaultStyle->setBackgroundColor(Color::rgb(255, 238, 238));
        $defaultStyle->setCellAlignment(CellAlignment::CENTER);
        $defaultStyle->setBorder($border);

        $rowStyle = new Style();
        $rowStyle->setFontSize(11);
        $rowStyle->setCellAlignment(CellAlignment::RIGHT);
        $rowStyle->setBorder($border);

        $options = \Hyperf\Support\make($this->getOptions());
        if (method_exists($options, 'setColumnWidthForRange')) {
            $options->setColumnWidthForRange(20, 1, count($headers));
        }

        $writer = \Hyperf\Support\make($this->getWriter(), [$options]);

        return [$writer, $defaultStyle, $rowStyle];
    }

    public function writerHeaders($writer, $headers, $defaultStyle): void
    {
        $writer->addRow(Row::fromValues($headers, $defaultStyle));
    }

    public function writerRows($writer, $rows, $rowStyle): void
    {
        foreach ($rows as $row) {
            $writer->addRow(Row::fromValues($row, $rowStyle));
        }
    }

    /**
     * @param $headers
     * @param $rows
     * @param $filename
     * @param $filepath
     * @return array
     * @throws Exception
     */
    public function exportFile($filename, $headers, $rows, $filepath = null): array
    {
        [$fileName, $filePath] = $this->initFilePath($filename, $filepath);
        [$writer, $defaultStyle, $rowStyle] = $this->initWriter($headers);
        $writer->openToFile($filePath);
        $this->writerHeaders($writer, $headers, $defaultStyle);
        $this->writerRows($writer, $rows, $rowStyle);
        $writer->close();
        return [$filePath, $fileName];
    }

    /**
     * 获取本地文件路径.
     */
    protected function getLocalFilepath(): string
    {
        return config('spreadsheet.local_file_path');
    }

    /**
     * 设置文件名.
     */
    protected function getFileName(string $filename): string
    {
        return sprintf('%s_%s.' . Str::lower($this->getFileType()), $filename, date('Ymd_His'));
    }

    public function getFileType(): string
    {
        return $this->fileType;
    }

    /**
     * 设置文件类型.
     *
     * @return $this
     */
    public function setFileType(string $fileType): static
    {
        $this->fileType = $fileType;

        return $this;
    }

    /**
     * 获取文件路径.
     * @param mixed $fileName
     * @param mixed|null $filepath
     * @return string
     */
    protected function getFilePath(mixed $fileName, mixed $filepath = null): string
    {
        return $filepath . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getOptions(): string
    {
        return match ($this->getFileType()) {
            'xlsx' => XlsxOptions::class,
            'csv' => CsvOptions::class,
            'ods' => OdsOptions::class,
            default => throw new Exception('Unknown file type'),
        };
    }

    /**
     * @return string
     * @throws Exception
     */
    private function getWriter(): string
    {
        return match ($this->getFileType()) {
            'xlsx' => XlsxWriter::class,
            'csv' => CsvWriter::class,
            'ods' => OdsWriter::class,
            default => throw new Exception('Unknown file type'),
        };
    }
}
