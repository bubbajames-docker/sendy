# Quick reference
This is the unofficial Sendy docker repository.

<a href="https://sendy.co/?ref=Hcurv" title=""><img src="https://sendy.co/images/banners/728x90_var2.jpg" alt="Check out Sendy, a self hosted newsletter app that lets you send emails 100x cheaper via Amazon SES." width="728" height="90"/></a>

* Maintained by: [the Sendy Community](https://sendy.co/forum)

* Where to get help: [the Sendy Troubleshooting & Support Guide](https://sendy.co/troubleshooting), [the Sendy Community Forums](https://sendy.co/forum)

* License Required: [Purchasing details](https://sendy.co/?ref=Hcurv)

# Supported tags and respective Dockerfile links
* `4.1.0` `4.1` `latest`

# Quick reference (cont.)
* Where to file docker-related issues: [https://github.com/bubbajames-docker/sendy](https://github.com/bubbajames-docker/sendy)

* Where to file Send application issues: see [the Sendy Troubleshooting & Support Guide](https://sendy.co/troubleshooting)

# What is Sendy?
Sendy is a self-hosted email newsletter application that lets you send trackable emails via [Amazon Simple Email Service (SES)](http://aws.amazon.com/ses/). This makes it possible for you to send authenticated bulk emails at an insanely low price without sacrificing deliverability.

For more information and related downloads for Sendy Server and other products, please visit [Send.co](https://sendy.co/?ref=Hcurv).

<a href="https://sendy.co/?ref=Hcurv" title=""><img src="https://sendy.co/images/banners/125x125_var2.jpg" alt="Check out Sendy, a self hosted newsletter app that lets you send emails 100x cheaper via Amazon SES." width="125" height="125"/></a>

# How to use this image
Starting a Sendy instance is simple. 

```console
$ docker run -d \
  --name sendy \
  -e SENDY_FQDN=campaigns.example.com \
  -e MYSQL_HOST=db_sendy \
  -e MYSQL_PASSWORD=db_password \
  bubbajames/sendy:tag
```
... where `sendy` is the name you want to assign to your container, `campaigns.example.com` is your FQDN of Sendy server, `db_sendy` is your database server instance, `db_password` is the database user's password and `tag` is the tag specifying the Sendy version you want. See the list of tags above.

## Environment Varaibles   
### `SENDY_FQDN` (required)
The fully qualified domain name of your Sendy installation.  This must match the FQDN associated with your license.  You can [purchase a license here](https://sendy.co/?ref=Hcurv).   
### `MYSQL_HOST` (required) 
The MySQL server hosting your Sendy database.  
### `MYSQL_DATABASE` (optional)
The Sendy database name. Default: `sendy`.    
### `MYSQL_USER` (optional) 
Database user.  Default: `sendy`.   
### `MYSQL_PASSWORD` (required)
Database user's password. Not recommended for sensitive data! (see: Docker Secrets)

## Docker Secrets
As an alternative to passing sensitive information via environment variables, `_FILE` may be appended to the previously listed environment variables, causing the initialization script to load the values for those variables from files present in the container. In particular, this can be used to load passwords from Docker secrets stored in /run/secrets/\<secret_name> files. 

For example:

```console
$ docker run -d --name sendy -e MYSQL_PASSWORD_FILE=/run/secrets/mysql-root -d sendy
```

## Using `Dockerfile`
Pretty minimalistic `Dockerfile` as everything you need is already bundled.  Just provide environment variables or environment file.

```dockerfile
FROM bubbajames/sendy:4.1

# ... whatever you want here.   
```
### Start a Sendy instance
The following starts an instance specifying an environment file.

```console
$ docker run -d -name sendy --env_file sendy.env sendy
```

### Sample environment file
```ini
SENDY_FQDN=campaigns.example.com
MYSQL_HOST=db_sendy
MYSQL_DATABASE=sendy
MYSQL_USER=sendy
MYSQL_PASSWORD_FILE=/run/secrets/db_password
# MYSQL_PASSWORD=db_password
```

## Using `docker-compose`
Starts a Send instance and a MySQL database instance with mounted volume for persisted data between restarts.  Also uses Docker Secrets to avoid exposing sensitive data via 'inspect'.

The following `docker-compose.yml` is also available from image [repository](https://raw.githubusercontent.com/bubbajames-docker/sendy/master/docker-compose.yml).

```yaml
version: "3.7"

# Volumes for persisted data.
volumes: 
  data_sendy:
    labels: 
      co.sendy.description: "Data volume for Sendy Database."

# Secret files so they're not exposed via 'docker inspect'
secrets:
  db_password:
    file: secrets/db_password.txt
  db_root_password:
    file: secrets/db_root_password.txt      

services:
  # Database: MySQL
  db_sendy:
    hostname: db_sendy
    container_name: db_sendy
    image: mysql:5.6
    environment:
      MYSQL_ROOT_PASSWORD_FILE: /run/secrets/db_root_password
      MYSQL_DATABASE: sendy
      MYSQL_USER: sendy
      MYSQL_PASSWORD_FILE: /run/secrets/db_password
    secrets:
      - db_root_password
      - db_password      
    volumes: 
      - data_sendy:/var/lib/mysql

  # WebApp: Apache2+PHP+Sendy
  sendy:
    hostname: sendy
    container_name: sendy
    depends_on: 
      - db_sendy
    image: sendy:latest
    build: 
      context: .
    environment:
      SENDY_FQDN: campaigns.example.com
      MYSQL_HOST: db_sendy
      MYSQL_DATABASE: sendy
      MYSQL_USER: sendy
      MYSQL_PASSWORD_FILE: /run/secrets/db_password
    secrets:
      - db_password 
    ports:
      - 80:80
```
### Start the services
```console
$ docker-compose up -d
```
### Stop the services
```console
$ docker-compose down
```

# License

Please [see license](https://raw.githubusercontent.com/bubbajames-docker/sendy/master/LICENSE) in repository

As with all Docker images, these likely also contain other software that may be under other licenses (such as Bash, etc from the base distribution, along with any direct or indirect dependencies of the primary software being contained).

As for any pre-built image usage, it is the image user's responsibility to ensure that any use of this image complies with any relevant licenses for all software contained within.