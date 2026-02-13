# My E-Commerce Backend

A simple, secure Node.js API for e-commerce built with Express, PostgreSQL, and Stripe.

## Features
- User authentication with JWT and bcrypt
- PostgreSQL database integration
- Stripe payment processing
- Rate limiting and security headers
- CORS configuration
- RESTful API design

## Setup

### Prerequisites
- Node.js 14+ 
- PostgreSQL database
- Stripe account

### Local Development
1. Clone this repo
2. Run `npm install` to install dependencies
3. Copy `.env.example` to `.env` and configure your environment variables:
   ```
   DATABASE_URL=postgresql://user:pass@host:port/db
   JWT_SECRET=your-super-secret-jwt-key-here
   STRIPE_SECRET_KEY=sk_test_your-stripe-secret-key
   FRONTEND_URL=http://localhost:8080
   SUCCESS_URL=http://localhost:8080/success.html
   CANCEL_URL=http://localhost:8080/
   PORT=3000
   ```
4. Run the database schema in PostgreSQL:
   ```bash
   psql -d your_database < database-schema.sql
   ```
5. Start the server:
   ```bash
   npm start
   ```

### Deploy to Render
1. Create a new Web Service on Render
2. Connect your GitHub repository
3. Set the following environment variables in Render dashboard:
   - `DATABASE_URL` (PostgreSQL connection string from Render)
   - `JWT_SECRET` (generate a secure random string)
   - `STRIPE_SECRET_KEY` (from your Stripe dashboard)
   - `FRONTEND_URL` (your GitHub Pages URL)
   - `SUCCESS_URL` (your frontend success page URL)
   - `CANCEL_URL` (your frontend home page URL)
4. Deploy!

## API Endpoints

### Authentication
- `POST /register` - Register a new user
  - Body: `{ "email": "user@example.com", "password": "password123" }`
  - Response: `{ "message": "User registered" }`

- `POST /login` - Login and receive JWT token
  - Body: `{ "email": "user@example.com", "password": "password123" }`
  - Response: `{ "token": "jwt_token_here" }`

### Products
- `GET /products` - Fetch all products
  - Response: Array of product objects

### Orders
- `POST /orders` - Place an order (requires authentication)
  - Headers: `Authorization: Bearer <token>`
  - Body: `{ "productId": 1, "quantity": 2 }`
  - Response: `{ "url": "stripe_checkout_url" }`

## Security Features
- Password hashing with bcrypt
- JWT token authentication
- Rate limiting (100 requests per 15 minutes)
- Helmet.js security headers
- CORS protection
- Environment variable configuration

## Frontend
The repository includes sample HTML files (index.html, success.html) that can be deployed to GitHub Pages or any static hosting service.

## License
MIT
