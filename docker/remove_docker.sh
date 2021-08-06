#!/bin/bash

# include config
source ./config.sh

# include stop containers scripts
source ./stop_docker.sh

echo "Start removing images..."

for key in ${!imageNames[@]}; do
    docker rmi $(docker images --format="{{.Repository}} {{.ID}}" | grep "^${imageNames[${key}]} " | cut -d' ' -f2) -f
done

echo "Images is removed."