# New WordPress project boilerplate

This boilerplate is to build Wordpress websites using Docker and xDebug

## Usage with VSCode

> Make sure Docker is running and the [PHP Debug](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug) extension for VSCode is installed


1. Run the docker instance
```sh
$ docker-compose up
```

2. Open http://localhost:8000

3. Open the debugger tab on the sidebar and run `Listen for XDebug`

4. Set anywhere in your PHP files a breakpoint

> Also can open http://localhost:8080 for manage databases
