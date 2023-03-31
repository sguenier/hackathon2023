# challenge-stack

## Getting Started
### Start the backend
1. Run `docker compose build --pull --no-cache`
2. Check variable in backend/.env : `DATABASE_URL="postgresql://symfony:ChangeMe@database:5432/app?serverVersion=13&charset=utf8"`
3. Run `docker compose up -d`
4. Run `docker compose exec php bin/console d:f:l` to load the fixtures
5. Open `http://localhost`

### Start the frontend
0. Install the latest `lts node`
1. Run `npm install`
2. Run `npm run dev`
