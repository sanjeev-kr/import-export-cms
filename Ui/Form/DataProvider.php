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

declare(strict_types=1);

namespace Sanjeev\ImportExportCms\Ui\Form;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Sanjeev\ImportExportCms\Ui\CollectionProviderInterface;
use Sanjeev\ImportExportCms\Ui\EntityUiConfig;

class DataProvider extends AbstractDataProvider
{

    /**
     * @return array
     */
    public function getData()
    {
        return [];
    }

    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {

    }
}
