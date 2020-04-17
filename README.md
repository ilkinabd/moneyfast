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
composer create-project yiisoft/yii2-app-basic /app
```

### Enter pa container and execute deamon
```sh
yii deamon
```
