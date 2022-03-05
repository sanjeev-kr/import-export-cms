# Sanjeev_ImportExportCms Magento 2 module

Sanjeev_ImportExportCms is a module for Magento 2. This module helps to import or export cms pages and/or cms blocks from admin interface.

## Install with Composer
```
composer require sanjeev-kr/import-export-cms
php bin/magento module:enable Sanjeev_ImportExportCms
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```

## Install Manually
- Download zip and extract
- Create a new directory Sanjeev/ImportExportCms in app/code directory and copy files from import-export-cms folder and paste files in Sanjeev/ImportExportCms directory.
- And run below commands

```
php bin/magento module:enable Sanjeev_ImportExportCms
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```
## How to export
- In mass action of Cms Pages and Cms Blocks Grids, you should see Export option. Select page(s) / block(s) and click on Export link to export cms pages or blocks in csv format.

## How to import
- In admin, Go to  Content > Import Cms Files. Select Import Type, upload valid csv file and press Import button.

