#!/bin/bash
# Script to up containers, run database migrations

docker-compose up -d
docker exec codepix_api_baas php artisan migrate --seed
sleep 5 
docker exec codepix_api_baas php artisan message-broker:consume transactions_response
