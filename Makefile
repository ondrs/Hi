makefile_path := $(abspath $(lastword $(MAKEFILE_LIST)))
makefile_dir := $(dir $(makefile_path))

build:
	docker build . --tag ondrs/hi:latest

install:
	docker run -it --rm --name hi -v $(makefile_dir):/srv/app -w /srv/app ondrs/hi:latest composer install

bash:
	docker run -it --rm --name hi -v $(makefile_dir):/srv/app -w /srv/app ondrs/hi:latest bash
	
test:
	docker run -it --rm --name hi -v $(makefile_dir):/srv/app -w /srv/app ondrs/hi:latest /srv/app/vendor/bin/tester -j 40 ./tests