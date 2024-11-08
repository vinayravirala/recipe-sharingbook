async function getRecipes() {
  try {
    const response = await fetch("src/fetchRecipes.php");
    if (!response.ok) {
      throw new Error("Failed to fetch recipes");
    }
    const recipes = await response.json();
    return recipes;
  } catch (error) {
    console.error("Error fetching recipes:", error.message);
    return [];
  }
}
