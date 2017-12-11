@ECHO OFF
CLS
REM http://www.microsoft.com/resources/documentation/windows/xp/all/proddocs/en-us/percent.mspx?mfr=true
REM ECHO Starting to cropnail.
REM ECHO Running from: %~dp0
IF NOT EXIST %~dp0cropnail.php (
    ECHO Cropnail PHP file does not exist.
) ELSE (
	REM ECHO Cropnail PHP file found.
    php -f %~dp0cropnail.php %*
)