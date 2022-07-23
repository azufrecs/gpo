#!/bin/bash 
#_hoy=$(date +"%Y.%m.%d") 

fecha=$(date +"%Y.%m.%d-%H%M")

# Creamos el Backup de todas las BD existentes.
mysqldump -ugpo -pgpo2012*/ --databases gpo > /var/www/html/gpo/salva_bd/gpo_$fecha.sql
