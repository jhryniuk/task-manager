#!/usr/bin/env bash

docker build -t "task-manager" docker/php
docker-compose up