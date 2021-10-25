DOCKER_BUILD=docker build --target dev -t force-vendor/force-vendor:build .
DOCKER_RUN=docker run --rm -it --volume "$(PWD)":/var/www force-vendor/force-vendor:build

docker-build:
	$(DOCKER_BUILD)

install:
	$(DOCKER_RUN) composer install

update:
	$(DOCKER_RUN) composer update

dumpautoload:
	$(DOCKER_RUN) composer dumpautoload

#make dependency-install DEPENDENCY="codeception/codeception --dev"
dependency-install:
	$(DOCKER_RUN) composer require $(DEPENDENCY)

test:
	$(DOCKER_RUN) composer test

test-report:
	- $(DOCKER_RUN) composer test
	- firefox ./report/html-coverage/index.html

mutation-test:
	$(DOCKER_RUN) composer mutation-test

