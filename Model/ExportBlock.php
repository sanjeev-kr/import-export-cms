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

use Magento\Framework\Exception\FileSystemException;

class ExportBlock extends AbstractExport
{

    /**
     * @param array $blockIds
     * @return false|string
     * @throws FileSystemException
     */
    public  function exportBlocks(array $blockIds = []){
        $fileName = 'exported_blocks-'.date('Y-m-d_H-i-s').'.csv';
        $blocks = $this->resourceHelper->getBlocks($blockIds);
        if(!$blocks){
            return false;
        }
        return $this->createFile($fileName, $blocks);
    }

    public function getHeaders(): array
    {
        return [
            //'block_id',
            'title',
            'identifier',
            'content',
            //'creation_time',
            //'update_time',
            'is_active',
            'store_id'
        ];
    }
}
