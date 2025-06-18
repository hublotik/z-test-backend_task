#!/bin/bash

containerName=z-test-backend_task

if [[ $1 == shell ]];
then

    docker exec -it $containerName bash

elif [[ $1 == run ]];
then

    docker run --name $containerName -d -v $(pwd):/var/www/html -p 94:80 $containerName

elif [[ $1 == build ]];
then

    docker build . -t $containerName

elif [[ $1 == restart ]];
then

    docker rm $(docker ps -a -q -f name=$containerName) --force && \
    docker run --name $containerName -d -v $(pwd):/var/www/html -p 86:80 $containerName

else
    echo "Доступные команды:"
    echo "build"
    echo "run"
fi
