# config-options-stock-m2
Magento 2 Products Configurable Options Stock Status v.1.0.0

Description
- simple Magento 2.x module to add an Out Of Stock label to Products Custom Option if the option is set as Out of Stock

Installation
- copy the module files into magento installation directory
- run 'php bin/magento setup:upgrade'
- run 'php bin/magento setup:di:compile'
- run 'php bin/magento setup:static-content:deploy'

Configurarion
- enable the module in magento backend 'Stores > Configuration > MageLine Extensions'
- configure Out of Stock custom options for specific products in magento backend 'Catalog > Products Custom Options > Manage Product Custom Options'
