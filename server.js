// server.js
const express = require("express");
const axios = require("axios");
require("dotenv").config();

const app = express();
const PORT = 3000;
const API_KEY = process.env.API_KEY;

// Serve static files from the public directory
app.use(express.static("public"));

// Route to fetch recipes
app.get("/api/recipes", async (req, res) => {
  try {
    const response = await axios.get(`https://api.spoonacular.com/recipes/random`, {
      params: {
        number: 10,
        apiKey: API_KEY,
      },
    });
    res.json(response.data.recipes);
  } catch (error) {
    console.error("Error fetching recipes:", error.message);
    res.status(500).json({ error: "Failed to fetch recipes" });
  }
});

// Start server
app.listen(PORT, () => {
  console.log(`Server is running on http://localhost:${PORT}`);
});
