#!/bin/bash

# include config
source ./config.sh

DOCKER_COMPOSE_COMMAND=''
for key in ${!containerNames[@]}; do
    DOCKER_COMPOSE_COMMAND+="${key}=${containerNames[${key}]} "
done
for key in ${!imageNames[@]}; do
    DOCKER_COMPOSE_COMMAND+="${key}=${imageNames[${key}]} "
done

DOCKER_COMPOSE_COMMAND+="APP_EXTERNAL_PORT=$APP_EXTERNAL_PORT DATABASE_EXTERNAL_PORT=$DATABASE_EXTERNAL_PORT "
DOCKER_COMPOSE_COMMAND+="docker-compose up -d"

echo "Start command: "
echo ${DOCKER_COMPOSE_COMMAND}

eval ${DOCKER_COMPOSE_COMMAND}

set -e

>&2 echo "Check $PHP_CONTAINER_NAME conteiner for available"

until curl http://localhost:"$APP_EXTERNAL_PORT"; do
  >&2 echo "Conteiner $PHP_CONTAINER_NAME is unavailable on http://localhost:"$APP_EXTERNAL_PORT" host"
  sleep 2
done

>&2 echo "Conteiner $PHP_CONTAINER_NAME is up on http://localhost:"$APP_EXTERNAL_PORT" host"

source ./run_in_container.sh
