const express = require('express');
const bcrypt = require('bcrypt');
const jwt = require('jsonwebtoken');
const { Pool } = require('pg');
const cors = require('cors');
const helmet = require('helmet');
const rateLimit = require('express-rate-limit');
const stripe = require('stripe')(process.env.STRIPE_SECRET_KEY);

const app = express();
app.use(express.json());
app.use(cors({ origin: process.env.FRONTEND_URL || 'http://localhost:8080' }));
app.use(helmet());
app.use(rateLimit({ windowMs: 15 * 60 * 1000, max: 100 }));

const pool = new Pool({
  connectionString: process.env.DATABASE_URL,
});

const jwtSecret = process.env.JWT_SECRET;

const authenticateToken = (req, res, next) => {
  const token = req.header('Authorization')?.split(' ')[1];
  if (!token) return res.status(401).json({ error: 'Access denied' });
  jwt.verify(token, jwtSecret, (err, user) => {
    if (err) return res.status(403).json({ error: 'Invalid token' });
    req.user = user;
    next();
  });
};

app.post('/register', async (req, res) => {
  const { email, password } = req.body;
  if (!email || !password || password.length < 6) return res.status(400).json({ error: 'Valid email and password (min 6 chars) required' });
  const hash = await bcrypt.hash(password, 10);
  try {
    await pool.query('INSERT INTO users (email, password_hash) VALUES ($1, $2)', [email, hash]);
    res.status(201).json({ message: 'User registered' });
  } catch (err) {
    res.status(500).json({ error: 'Registration failed (email may exist)' });
  }
});

app.post('/login', async (req, res) => {
  try {
    const { email, password } = req.body;
    const result = await pool.query('SELECT * FROM users WHERE email = $1', [email]);
    if (result.rows.length === 0) return res.status(400).json({ error: 'User not found' });
    const valid = await bcrypt.compare(password, result.rows[0].password_hash);
    if (!valid) return res.status(400).json({ error: 'Invalid password' });
    const token = jwt.sign({ id: result.rows[0].id }, jwtSecret, { expiresIn: '1h' });
    res.json({ token });
  } catch (err) {
    res.status(500).json({ error: 'Login failed' });
  }
});

app.get('/products', async (req, res) => {
  try {
    const result = await pool.query('SELECT * FROM products');
    res.json(result.rows);
  } catch (err) {
    res.status(500).json({ error: 'Failed to fetch products' });
  }
});

app.post('/orders', authenticateToken, async (req, res) => {
  try {
    const { productId, quantity } = req.body;
    if (!productId || !quantity || quantity < 1) return res.status(400).json({ error: 'Valid product and quantity required' });
    
    // Fetch product details from database
    const productResult = await pool.query('SELECT * FROM products WHERE id = $1', [productId]);
    if (productResult.rows.length === 0) return res.status(404).json({ error: 'Product not found' });
    
    const product = productResult.rows[0];
    const successUrl = process.env.SUCCESS_URL || 'http://localhost:8080/success.html';
    const cancelUrl = process.env.CANCEL_URL || 'http://localhost:8080/';
    
    const session = await stripe.checkout.sessions.create({
      payment_method_types: ['card'],
      line_items: [{ 
        price_data: { 
          currency: 'usd', 
          product_data: { name: product.name }, 
          unit_amount: Math.round(product.price * 100) 
        }, 
        quantity 
      }],
      mode: 'payment',
      success_url: successUrl,
      cancel_url: cancelUrl,
    });
    await pool.query('INSERT INTO orders (user_id, product_id, quantity, status) VALUES ($1, $2, $3, $4)', [req.user.id, productId, quantity, 'pending']);
    res.json({ url: session.url });
  } catch (err) {
    res.status(500).json({ error: 'Failed to create order' });
  }
});

app.listen(process.env.PORT || 3000, () => console.log('Server running on port', process.env.PORT || 3000));
