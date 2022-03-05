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

class ExportPage extends AbstractExport
{

    /**
     * @param array $pageIds
     * @return false|string
     * @throws FileSystemException
     */
    public  function exportPages(array $pageIds = []){
        $fileName = 'exported_pages-'.date('Y-m-d_H-i-s').'.csv';
        $pages = $this->resourceHelper->getPages($pageIds);
        if(!$pages){
            return false;
        }
        return $this->createFile($fileName, $pages);
    }

    public function getHeaders(): array
    {
        return [
            //'page_id',
            'title',
            'identifier',
            'content_heading',
            'content',
            'meta_title',
            'meta_keywords',
            'meta_description',
            'store_id',
            'is_active',
            'sort_order',
            'page_layout',
            'layout_update_xml',
            'custom_theme',
            'custom_root_template',
            'custom_layout_update_xml',
            'custom_theme_from',
            'custom_theme_to',
            'layout_update_xml',
            //'creation_time',
            //'update_time',
        ];
    }

}
