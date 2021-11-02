#!/usr/bin/env bash

DB_NAME=product_backend$DB_NAME_SUFFIX
ACTIVE_DB=${DB_NAME}_mirror_1

mysqldump -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_NAME" > product_backend.sql
mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "drop database ${DB_NAME}_mirror_1; drop database ${DB_NAME}_mirror_2; create database ${DB_NAME}_mirror_1; create database ${DB_NAME}_mirror_2; truncate table $DB_NAME.active_backend_database; insert into $DB_NAME.active_backend_database (name) value ('$ACTIVE_DB');"
mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" "${DB_NAME}_mirror_1" < product_backend.sql
mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" "${DB_NAME}_mirror_2" < product_backend.sql
rm product_backend.sql