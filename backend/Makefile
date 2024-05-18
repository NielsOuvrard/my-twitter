##
## Makefile for backend tests
##

setupdb: cleandb createdb createexamples

createdb:
	mysql -h127.0.0.1 -uroot -ppassword -e 'CREATE DATABASE IF NOT EXISTS db;'
	mysql -h127.0.0.1 -uroot -ppassword db < ../database/create.sql

createexamples:
	mysql -h127.0.0.1 -uroot -ppassword db < ../database/test.sql

cleandb:
	mysql -h127.0.0.1 -uroot -ppassword db < ../database/drop.sql
	mysql -h127.0.0.1 -uroot -ppassword -e 'DROP DATABASE IF EXISTS db;'

resetserver: cleandb createdb createexamples

runserver:
	./run_local.sh

.PHONY: createdb createexamples cleandb runserver