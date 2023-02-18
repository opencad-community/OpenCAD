:: This script is used to export WAMP database automatically and move it over to the SQL folder within the root directory.

@echo off

:: Set the database name and backup file location
set dbName=oc_api
set backupFile=C:\wamp64\www\api\sql\%dbName%.sql

:: Export the database to the specified location
mysqldump -u root -p %dbName% > %backupFile%

:: Check if the backup was created
if exist %backupFile% (
  echo Database backup saved to %backupFile%
) else (
  echo Error creating database backup
)

pause
