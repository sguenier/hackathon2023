# challenge-stack

## Getting Started
### Start the backend
1. Run `docker compose build --pull --no-cache`
2. Check variable in backend/.env : `DATABASE_URL="postgresql://symfony:ChangeMe@database:5432/app?serverVersion=13&charset=utf8"`
3. `cd backend`
4. Run `docker compose up -d`
5. Run `docker compose exec php bin/console d:f:l` to load the fixtures
6. Open `http://localhost`

### Start the frontend
0. Install the latest `lts node`
1. `cd frontend`
2. Run `npm install`
3. Run `npm run dev`

Utilisateur à tester avec est l'utilisateur avec l'id 2:
- mail : mail2@mail.com
- mdp 1234566
