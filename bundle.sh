#!/bin/bash

folder_name="./custom-plugins/fictive_studios"
output_file="../../fictive_studios.zip"
cd custom-plugins/fictive_studios;

cp builder-url.php builder-url.php.bak
#
cp builder-url.prod.php  builder-url.php
#
zip -r $output_file ./
##
cp builder-url.php.bak  builder-url.php
##
rm builder-url.php.bak