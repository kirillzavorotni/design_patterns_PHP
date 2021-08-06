source config.sh

# run docker container command in the started containers
PHP_CONTAINER_NAME=${containerNames[PHP_CONTAINER_NAME]}

#docker exec -it $(docker ps -aqf name=${PHP_CONTAINER_NAME}) composer install
#docker exec -it $(docker ps -aqf name=${PHP_CONTAINER_NAME}) composer dump-autoload