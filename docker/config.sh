#!/bin/bash
APP_EXTERNAL_PORT="8091"

# container names
declare -A containerNames
containerNames["PHP_CONTAINER_NAME"]=php-patterns-php-container
containerNames["NGINX_CONTAINER_NAME"]=php-patterns-nginx-container

# images name
declare -A imageNames
imageNames["PHP_IMAGE_NAME"]=php-patterns-php-image
imageNames["NGINX_IMAGE_NAME"]=php-patterns-nginx-image
