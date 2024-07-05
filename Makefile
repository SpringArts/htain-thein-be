setup: build up

build:
	docker compose build --no-cache --force-rm
up:
	docker compose up -d
ps:
	docker compose ps
stop:
	docker compose stop
restart:
	docker compose restart
down:
	docker compose down
up:
	docker compose up -d

