## Docker enviroment setup

### Create docker network:
```sh
docker network create -d bridge --subnet 192.168.0.0/24 --gateway 192.168.0.1 dockernet
```

### Init containers 
```sh
cd pa/docker && docker-compose up -d
```

```sh
cd pb/docker && docker-compose up -d
```

### Install vendor in both php container 
```sh
docker exec -it <container_name> bash 
```
```sh
composer install
```

### Make migration in pb_php container 
```sh
docker exec -it <container_name> bash 
```
```sh
yii migrate
```

### Enter pa_php container and execute deamon
```sh
docker exec -it <container_name> bash 
```
```sh
yii deamon
```
