php -S localhost:8080 -t ../../web/ &
PID=$!
phpunit.phar
STATUS=$?
kill $PID
exit $STATUS
