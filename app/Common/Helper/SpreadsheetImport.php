<?php

namespace App\Common\Helper;

use Exception;
use OpenSpout\Reader\CSV\Options;
use OpenSpout\Reader\CSV\Reader as CsvReader;
use OpenSpout\Reader\ODS\Reader as OdsReader;
use OpenSpout\Reader\XLSX\Reader as XlsxReader;
use Throwable;

class SpreadsheetImport
{
    private string $fileType = 'xlsx';

    /**
     * @throws Exception
     */
    public function importSheet($filepath, $formatHeaders = []): array
    {
        $headers = [];
        $importData = [];

        try {
            $reader = $this->getReader();
            $reader->open($filepath);
            $sheet = $reader->getSheetIterator()->current();
            $rows = $sheet->getRowIterator();
            foreach ($rows as $row) {
                $cellValues = $this->getCellValues($row->getCells());
                if ($rows->key() == 1) {
                    $headers = $this->formatHeaders($cellValues, $formatHeaders);
                } else {
                    $importData[] = $this->formatRowData($headers, $cellValues);
                }
            }
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        } finally {
            if (isset($reader)) {
                $reader->close();
            }
        }

        return $importData;
    }

    /**
     * @return CsvReader|OdsReader|XlsxReader
     * @throws Exception
     */
    protected function getReader(): CsvReader|OdsReader|XlsxReader
    {
        switch ($this->getFileType()) {
            case 'csv':
                $options = new Options();
                $options->ENCODING = 'GBK';
                return \Hyperf\Support\make(CsvReader::class, [$options]);
            case 'ods':
                return \Hyperf\Support\make(OdsReader::class);
            case 'xlsx':
                return \Hyperf\Support\make(XlsxReader::class);
            default:
                throw new Exception('Unknown file type');
        }
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

    protected function getCellValues($cells): array
    {
        $data = [];
        foreach ($cells as $cell) {
            $data[] = $cell->getValue();
        }
        return $data;
    }

    protected function formatHeaders($cellValues, $formatHeaders): array
    {
        if (empty($formatHeaders)) {
            return array_flip($cellValues);
        }

        $headers = [];
        foreach ($cellValues as $key => $cellValue) {
            $cellValue = trim($cellValue);
            if (isset($formatHeaders[$cellValue])) {
                $headers[$formatHeaders[$cellValue]] = $key;
            }
        }
        return $headers;
    }

    protected function formatRowData($headers, $rowData): array
    {
        $newData = [];
        foreach ($headers as $header => $index) {
            $newData[$header] = $rowData[$index] ?? '';
        }
        return $newData;
    }

    /**
     * @throws Exception
     */
    public function chuckImportSheet(int $count, callable $callback, string $filepath, $formatHeaders = []): bool
    {
        $importData = [];
        $headers = [];

        try {
            $reader = $this->getReader();
            $reader->open($filepath);

            $sheet = $reader->getSheetIterator()->current();

            $index = 1;
            foreach ($sheet->getRowIterator() as $key => $row) {
                $cellValues = $this->getCellValues($row->getCells());
                if ($key == 1) {
                    $headers = $this->formatHeaders($cellValues, $formatHeaders);
                } else {
                    $importData[] = $this->formatRowData($headers, $cellValues);
                }
                $index++;
                if ($index == $count) {
                    if ($callback($importData) === false) {
                        return false;
                    }
                    $importData = [];
                    $index = 1;
                }
            }

            if (!empty($importData)) {
                $callback($importData);
            }
            unset($importData);
        } catch (Throwable $exception) {
            throw new Exception($exception->getMessage());
        } finally {
            if (isset($reader)) {
                $reader->close();
            }
        }
        return true;
    }
}