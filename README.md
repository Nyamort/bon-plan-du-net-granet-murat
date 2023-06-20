## Getting Started

### Prerequisites
- Docker
- Docker-compose
- Git
### Installing
```bash
git clone https://github.com/Nyamort/bon-plan-du-net-granet-murat.git
cd bon-plan-du-net-granet-murat
docker-compose build
docker-compose up -d
docker exec -it bon-plan-du-net-php composer install
docker exec -it bon-plan-du-net-php php bin/console doctrine:migrations:migrate
docker exec -it bon-plan-du-net-php php bin/console doctrine:fixtures:load
docker exec -it bon-plan-du-net-php php bin/console cache:clear
docker exec -it bon-plan-du-net-php php bin/console lexik:jwt:generate-keypair
docker exec -it bon-plan-du-net-php npm install
docker exec -it bon-plan-du-net-php npm run build
```

## Informations
### Comptes utilisateurs
- demo@exemple.fr / password

### Web API
#### A la une
- method: GET
- url: http://localhost:8081/api/a-la-une
#### Login
- method: POST
- url: http://localhost:8081/api/login_check
- body:
```json
{
    "username": "your_email",
    "password": "your_password"
}
```
#### Favoris
- method: GET
- url: http://localhost:8081/api/private/favorites
- header:
- Authorization: Bearer your_token

