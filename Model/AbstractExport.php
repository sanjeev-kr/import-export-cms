<?php
/**
 * Copyright 2022 Sanjeev Kumar
 * NOTICE OF LICENSE
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0

 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @category  Sanjeev
 * @package   Sanjeev_ImportExportCms
 * @copyright Copyright (c) 2022
 * @license   http://www.apache.org/licenses/LICENSE-2.0
 */

namespace Sanjeev\ImportExportCms\Model;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;

abstract class AbstractExport
{
    protected  $csvProcessor;

    protected $directoryList;

    protected $resourceHelper;

    public  function __construct(
        \Magento\Framework\File\Csv $csvProcessor,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Sanjeev\ImportExportCms\Model\ResourceModel\Helper $resourceHelper
    ){
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        $this->resourceHelper = $resourceHelper;
    }

    /**
     *
     * @param string $fileName
     * @return string
     * @throws FileSystemException
     */
    protected function getFilePath(string $fileName): string
    {
        return $this->directoryList->getPath(DirectoryList::VAR_DIR) . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * @param string $fileName
     * @param $data
     * @return string
     * @throws FileSystemException
     */
    protected function createFile(string $fileName, $data): string
    {
        $headers = $this->getHeaders();
        $content = [];
        array_push($content, $headers);
        foreach ($data as $row){
           $values = $this->mapHeadeRow($headers, $row);
           array_push($content, $values);
        }
        $filePath =  $this->getFilePath($fileName);
        $this->csvProcessor->setEnclosure('"')
            ->setDelimiter(',')
            ->appendData($filePath, $content);
        return $filePath;
    }

    public function mapHeadeRow($cols, $row){
        $values = [];
        $i = 0;
        foreach($cols as $key){
            $values[$i] = $row[$key] ?? $row[$key];
            $i++;
        }
        return $values;
    }

    abstract public function getHeaders();

}
