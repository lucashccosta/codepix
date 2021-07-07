#!/bin/bash
# Script to up containers, run database migrations, run command to listen rabbitmq

docker-compose up -d --build
docker exec codepix_api_baas php artisan migrate --seed
sleep 20 
docker exec codepix_api_baas nohup php artisan message-broker:consume transactions_response > /dev/null 2>&1 &
