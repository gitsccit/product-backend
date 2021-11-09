#!/usr/bin/env bash

DB_NAME=product_backend$DB_NAME_SUFFIX
ACTIVE_DB=${DB_NAME}_mirror_1

DROP_COMMAND="DROP DATABASE IF EXISTS ${DB_NAME}_mirror_1; DROP DATABASE IF EXISTS ${DB_NAME}_mirror_2;"
DB_INIT_COMMAND="CREATE DATABASE IF NOT EXISTS ${DB_NAME}_mirror_1; CREATE DATABASE IF NOT EXISTS ${DB_NAME}_mirror_2; TRUNCATE TABLE $DB_NAME.active_backend_database; INSERT INTO $DB_NAME.active_backend_database (name) VALUE ('$ACTIVE_DB');"
MIRROR_1_EXISTS=$(mysqlshow -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" | grep -v Wildcard | grep -o "${DB_NAME}_mirror_1")
MIRROR_2_EXISTS=$(mysqlshow -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" | grep -v Wildcard | grep -o "${DB_NAME}_mirror_2")

if [[ $STAGING != 'true' ]]; then
    if [[ ($MIRROR_1_EXISTS == "${DB_NAME}_mirror_1") || ($MIRROR_2_EXISTS == "${DB_NAME}_mirror_2") ]]; then
        exit
    fi
fi

if [[ $STAGING == 'true' ]]; then
    DB_INIT_COMMAND="$DROP_COMMAND $DB_INIT_COMMAND"
fi
mysqldump -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" "$DB_NAME" --ignore-table="$DB_NAME.active_backend_database" > product_backend.sql
mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" -e "$DB_INIT_COMMAND"

mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" "${DB_NAME}_mirror_1" < product_backend.sql
mysql -h "$DB_HOST" -u "$DB_USERNAME" -p"$DB_PASSWORD" "${DB_NAME}_mirror_2" < product_backend.sql
rm product_backend.sql