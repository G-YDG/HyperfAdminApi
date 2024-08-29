.PHONY: up down restart log bash ps

app-name=hyperf-admin

up:
	docker-compose up -d
down:
	docker-compose down
restart:
	docker-compose restart
log:
	docker-compose logs -f -t --tail=100
bash:
	docker-compose exec $(app-name) sh
ps:
	docker-compose ps