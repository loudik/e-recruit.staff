#!/usr/bin/env bash
set -e
docker compose down -v
docker compose up -d
echo "Database reset. Re-initialized using mysql/init/*.sql"
