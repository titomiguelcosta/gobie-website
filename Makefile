docker-purge-all: docker-purge-containers docker-purge-images

docker-purge-containers:
	docker rm --force $(shell docker ps -qa)

docker-purge-images:
	docker rmi --force $(shell docker images -qa)

docker-run:
	docker-compose -f docker/docker-compose.dev.yml up

deploy:
	php bin/dep deploy prod
