#!/usr/bin/env bash
set -e
docker compose up -d
echo "App:        http://localhost:8090"
echo "phpMyAdmin: http://localhost:8091  (server: db, user: appuser, pass: apppass)"
